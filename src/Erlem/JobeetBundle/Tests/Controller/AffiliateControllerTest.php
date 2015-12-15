<?php
 
namespace Erlem\JobeetBundle\Tests\Controller;
 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use Symfony\Component\DomCrawler\Crawler;
 
class AffiliateControllerTest extends WebTestCase
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
 
    public function testAffiliateForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/affiliate/new');
 
        $this->assertEquals('Erlem\JobeetBundle\Controller\AffiliateController::newAction', $client->getRequest()->attributes->get('_controller'));
 
        $form = $crawler->selectButton('Submit')->form(array(
            'affiliate[url]'   => 'http://sensio-labs.com/',
            'affiliate[email]' => 'fabien.potencier[at]example.com'
        ));
 
        $client->submit($form);
        $this->assertEquals('Erlem\JobeetBundle\Controller\AffiliateController::createAction', $client->getRequest()->attributes->get('_controller'));
 
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
 
        $crawler = $client->request('GET', '/en/affiliate/new');
        $form = $crawler->selectButton('Submit')->form(array(
            'affiliate[email]'        => 'not.an.email',
        ));
        $crawler = $client->submit($form);
 
        // check if we have 1 errors
        $this->assertTrue($crawler->filter('.error_list')->count() == 1);
        // check if we have error on affiliate_email field
        $this->assertTrue($crawler->filter('#affiliate_email')->siblings()->first()->filter('.error_list')->count() == 1);
    }
 
    public function testCreate()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/affiliate/new');
        $form = $crawler->selectButton('Submit')->form(array(
            'affiliate[url]'   => 'http://sensio-labs.com/',
            'affiliate[email]' => 'address[at]example.com'
        ));
 
        $client->submit($form);
        $client->followRedirect();
 
        $this->assertEquals('Erlem\JobeetBundle\Controller\AffiliateController::waitAction', $client->getRequest()->attributes->get('_controller'));
 
        return $client;
    }
 
    public function testWait()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/affiliate/wait');
 
        $this->assertEquals('Erlem\JobeetBundle\Controller\AffiliateController::waitAction', $client->getRequest()->attributes->get('_controller'));
    }
}