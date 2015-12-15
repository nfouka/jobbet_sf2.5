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
use Symfony\Component\HttpFoundation\HttpExceptionInterface;
 
class ApiControllerTest extends WebTestCase
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
 
    public function testList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/sensio-labs/jobs.xml');
 
        $this->assertEquals('Erlem\JobeetBundle\Controller\ApiController::listAction', $client->getRequest()->attributes->get('_controller'));
        $this->assertTrue($crawler->filter('description')->count() == 32);
 
        $crawler = $client->request('GET', '/api/sensio-labs87/jobs.xml');
 
        $this->assertTrue(404 === $client->getResponse()->getStatusCode());
 
        $crawler = $client->request('GET', '/api/symfony/jobs.xml');
 
        $this->assertTrue(404 === $client->getResponse()->getStatusCode());
 
        $crawler = $client->request('GET', '/api/sensio-labs/jobs.json');
 
        $this->assertEquals('Erlem\JobeetBundle\Controller\ApiController::listAction', $client->getRequest()->attributes->get('_controller'));
        $this->assertRegExp('/"category"\:"Programming"/', $client->getResponse()->getContent());
 
        $crawler = $client->request('GET', '/api/sensio-labs87/jobs.json');
 
        $this->assertTrue(404 === $client->getResponse()->getStatusCode());
 
        $crawler = $client->request('GET', '/api/sensio-labs/jobs.yaml');
        $this->assertRegExp('/category\: Programming/', $client->getResponse()->getContent());
 
        $this->assertEquals('Erlem\JobeetBundle\Controller\ApiController::listAction', $client->getRequest()->attributes->get('_controller'));
 
        $crawler = $client->request('GET', '/api/sensio-labs87/jobs.yaml');
 
        $this->assertTrue(404 === $client->getResponse()->getStatusCode());
    }
}