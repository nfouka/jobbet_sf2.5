<?php
 
namespace Erlem\JobeetBundle\Tests\Controller;
 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
 
class AffiliateAdminControllerTest extends WebTestCase
{
    private $em;
    private $application;
 
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
 
        $this->application = new Application(static::$kernel);
 
        // drop the database
        $command = new DropDatabaseDoctrineCommand();
        $this->application->add($command);
        $input = new ArrayInput(array(
            'command' => 'doctrine:database:drop',
            '--force' => true
        ));
        $command->run($input, new NullOutput());
 
        // we have to close the connection after dropping the database so we don't get "No database selected" error
        $connection = $this->application->getKernel()->getContainer()->get('doctrine')->getConnection();
        if ($connection->isConnected()) {
            $connection->close();
        }
 
        // create the database
        $command = new CreateDatabaseDoctrineCommand();
        $this->application->add($command);
        $input = new ArrayInput(array(
            'command' => 'doctrine:database:create',
        ));
        $command->run($input, new NullOutput());
 
        // create schema
        $command = new CreateSchemaDoctrineCommand();
        $this->application->add($command);
        $input = new ArrayInput(array(
            'command' => 'doctrine:schema:create',
        ));
        $command->run($input, new NullOutput());
 
        // get the Entity Manager
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
 
        // load fixtures
        $client = static::createClient();
        $loader = new \Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader($client->getContainer());
        $loader->loadFromDirectory(static::$kernel->locateResource('@ErlemJobeetBundle/DataFixtures/ORM'));
        $purger = new \Doctrine\Common\DataFixtures\Purger\ORMPurger($this->em);
        $executor = new \Doctrine\Common\DataFixtures\Executor\ORMExecutor($this->em, $purger);
        $executor->execute($loader->getFixtures());
    }
 
    public function testActivate()
    {
        $client = static::createClient();
 
        // Enable the profiler for the next request (it does nothing if the profiler is not available)
        $client->enableProfiler();
        $crawler = $client->request('GET', '/login');
 
        $form = $crawler->selectButton('login')->form(array(
            '_username'      => 'admin',
            '_password'      => 'admin'
        ));
 
        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();
 
        $this->assertTrue(200 === $client->getResponse()->getStatusCode());
 
        $crawler = $client->request('GET', '/admin/erlem/jobeet/affiliate/list');
 
        $link = $crawler->filter('.btn.edit_link')->link();
        $client->click($link);
 
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
 
        // Check that an e-mail was sent
        $this->assertEquals(1, $mailCollector->getMessageCount());
 
        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];
 
        // Asserting e-mail data
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertEquals('Jobeet affiliate token', $message->getSubject());
        $this->assertRegExp(
            '/Your secret token is symfony/',
            $message->getBody()
        );
    }
}