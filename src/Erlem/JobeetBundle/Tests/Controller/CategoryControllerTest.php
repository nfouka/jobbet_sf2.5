<?php
 
namespace Erlem\JobeetBundle\Tests\Controller;
 
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
 
class CategoryControllerTest extends WebTestCase
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
 
    public function testShow()
    {
        $kernel = static::createKernel();
        $kernel->boot();
 
        // get the custom parameters from app/config.yml
        $max_jobs_on_category = $kernel->getContainer()->getParameter('max_jobs_on_category');
        $max_jobs_on_homepage = $kernel->getContainer()->getParameter('max_jobs_on_homepage');
 
        $client = static::createClient();
 
        $categories = $this->em->getRepository('ErlemJobeetBundle:Category')->getWithJobs();
 
        // categories on homepage are clickable
        foreach($categories as $category) {
            $crawler = $client->request('GET', '/en/');
 
            $link = $crawler->selectLink($category->getName())->link();
            $crawler = $client->click($link);
 
            $this->assertEquals('Erlem\JobeetBundle\Controller\CategoryController::showAction', $client->getRequest()->attributes->get('_controller'));
            $this->assertEquals($category->getSlug(), $client->getRequest()->attributes->get('slug'));
 
            $jobs_no = $this->em->getRepository('ErlemJobeetBundle:Job')->countActiveJobs($category->getId()); 
 
            // categories with more than $max_jobs_on_homepage jobs also have a "more" link                 
            if($jobs_no > $max_jobs_on_homepage) {
                $crawler = $client->request('GET', '/en/');
                $link = $crawler->filter(".category_" . $category->getSlug() . " .more_jobs a")->link();
                $crawler = $client->click($link);
 
                $this->assertEquals('Erlem\JobeetBundle\Controller\CategoryController::showAction', $client->getRequest()->attributes->get('_controller'));
                $this->assertEquals($category->getSlug(), $client->getRequest()->attributes->get('slug'));
            }
 
            $pages = ceil($jobs_no/$max_jobs_on_category);
 
            // only $max_jobs_on_category jobs are listed 
            $this->assertTrue($crawler->filter('.jobs tr')->count() <= $max_jobs_on_category);
            $this->assertRegExp("/" . $jobs_no . " jobs/", $crawler->filter('.pagination_desc')->text());
 
            if($pages > 1) {
                $this->assertRegExp("/page 1\/" . $pages . "/", $crawler->filter('.pagination_desc')->text());
 
                for ($i = 2; $i <= $pages; $i++) {
                    $link = $crawler->selectLink($i)->link();
                    $crawler = $client->click($link);
 
                    $this->assertEquals('Erlem\JobeetBundle\Controller\CategoryController::showAction', $client->getRequest()->attributes->get('_controller'));
                    $this->assertEquals($i, $client->getRequest()->attributes->get('page'));
                    $this->assertTrue($crawler->filter('.jobs tr')->count() <= $max_jobs_on_category);
                    if($jobs_no > 1) {
                        $this->assertRegExp("/" . $jobs_no . " jobs/", $crawler->filter('.pagination_desc')->text());
                    }
                    $this->assertRegExp("/page " . $i . "\/" . $pages . "/", $crawler->filter('.pagination_desc')->text());
                }
            }     
        }
    }
}