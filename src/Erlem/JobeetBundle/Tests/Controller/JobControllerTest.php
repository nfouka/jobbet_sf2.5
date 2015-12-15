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
 
class JobControllerTest extends WebTestCase
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
 
    public function getMostRecentProgrammingJob()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
 
        $query = $em->createQuery('SELECT j from ErlemJobeetBundle:Job j LEFT JOIN j.category c WHERE c.slug = :slug AND j.expires_at > :date ORDER BY j.created_at DESC');
        $query->setParameter('slug', 'programming');
        $query->setParameter('date', date('Y-m-d H:i:s', time()));
        $query->setMaxResults(1);
 
        return $query->getSingleResult();
    }
 
    public function getExpiredJob()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
 
        $query = $em->createQuery('SELECT j from ErlemJobeetBundle:Job j WHERE j.expires_at < :date');             
        $query->setParameter('date', date('Y-m-d H:i:s', time()));
        $query->setMaxResults(1);
 
        return $query->getSingleResult();
    }
 
    public function testIndex()
    {
        // get the custom parameters from app config.yml
        $kernel = static::createKernel();
        $kernel->boot();
        $max_jobs_on_homepage = $kernel->getContainer()->getParameter('max_jobs_on_homepage');
 
        $client = static::createClient();
 
        $crawler = $client->request('GET', '/fr/');
        $this->assertEquals('Erlem\JobeetBundle\Controller\JobController::indexAction', $client->getRequest()->attributes->get('_controller'));
 
        // If the selected culture is italian, the page requested will not be found
        $crawler = $client->request('GET', '/it/');
        $this->assertTrue(404 === $client->getResponse()->getStatusCode());
 
        $crawler = $client->request('GET', '/en/');
        $this->assertEquals('Erlem\JobeetBundle\Controller\JobController::indexAction', $client->getRequest()->attributes->get('_controller'));
 
        // expired jobs are not listed
        $this->assertTrue($crawler->filter('.jobs td.position:contains("Expired")')->count() == 0);
 
        // only $max_jobs_on_homepage jobs are listed for a category
        $this->assertTrue($crawler->filter('.category_programming tr')->count()<= $max_jobs_on_homepage); 
        $this->assertTrue($crawler->filter('.category_design .more_jobs')->count() == 0);
        $this->assertTrue($crawler->filter('.category_programming .more_jobs')->count() == 1);
 
        // jobs are sorted by date
        $this->assertTrue($crawler->filter('.category_programming tr')->first()->filter(sprintf('a[href*="/%d/"]', $this->getMostRecentProgrammingJob()->getId()))->count() == 1);
 
        // each job on the homepage is clickable and give detailed information
        $job = $this->getMostRecentProgrammingJob();
        $link = $crawler->selectLink('Web Developer')->first()->link();
        $crawler = $client->click($link);
        $this->assertEquals('Erlem\JobeetBundle\Controller\JobController::showAction', $client->getRequest()->attributes->get('_controller'));
        $this->assertEquals($job->getCompanySlug(), $client->getRequest()->attributes->get('company'));
        $this->assertEquals($job->getLocationSlug(), $client->getRequest()->attributes->get('location'));
        $this->assertEquals($job->getPositionSlug(), $client->getRequest()->attributes->get('position'));
        $this->assertEquals($job->getId(), $client->getRequest()->attributes->get('id'));
 
        // a non-existent job forwards the user to a 404
        $crawler = $client->request('GET', '/en/job/foo-inc/milano-italy/0/painter');
        $this->assertTrue(404 === $client->getResponse()->getStatusCode());
 
        // an expired job page forwards the user to a 404
        $crawler = $client->request('GET', sprintf('/en/job/sensio-labs/paris-france/%d/web-developer', $this->getExpiredJob()->getId()));
        $this->assertTrue(404 === $client->getResponse()->getStatusCode());
    }
 
    public function testJobForm()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/job/new');
 
        $this->assertEquals('Erlem\JobeetBundle\Controller\JobController::newAction', $client->getRequest()->attributes->get('_controller'));
 
        $form = $crawler->selectButton('Preview your job')->form(array(
            'job[company]'      => 'Sensio Labs',
            'job[url]'          => 'http://www.sensio.com',
            'job[file]'         => __DIR__.'/../../../../../web/bundles/erlemjobeet/images/sensio-labs.gif',
            'job[how_to_apply]' => 'Send me an email',
            'job[description]'  => 'You will work with symfony to develop websites for our customers',
            'job[location]'     => 'Atlanta, USA',
            'job[email]'        => 'for.a.job[at]example.com',
            'job[position]'     => 'Developer',
            'job[is_public]'    => false,
        ));
 
        $client->submit($form);
        $this->assertEquals('Erlem\JobeetBundle\Controller\JobController::createAction', $client->getRequest()->attributes->get('_controller'));
 
        $client->followRedirect();
        $this->assertEquals('Erlem\JobeetBundle\Controller\JobController::previewAction', $client->getRequest()->attributes->get('_controller'));
 
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
 
        $query = $em->createQuery('SELECT count(j.id) from ErlemJobeetBundle:Job j WHERE j.location = :location AND j.is_activated IS NULL AND j.is_public = 0');
        $query->setParameter('location', 'Atlanta, USA');
        $this->assertTrue(0 < $query->getSingleScalarResult());
 
        $crawler = $client->request('GET', '/en/job/new');
        $form = $crawler->selectButton('Preview your job')->form(array(
            'job[company]'      => 'Sensio Labs',
            'job[position]'     => 'Developer',
            'job[location]'     => 'Atlanta, USA',
            'job[email]'        => 'not.an.email',
        ));
        $crawler = $client->submit($form);
 
        // check if we have 3 errors
        $this->assertTrue($crawler->filter('.error_list')->count() == 3);
        // check if we have error on job_description field
        $this->assertTrue($crawler->filter('#job_description')->siblings()->first()->filter('.error_list')->count() == 1);
        // check if we have error on job_how_to_apply field
        $this->assertTrue($crawler->filter('#job_how_to_apply')->siblings()->first()->filter('.error_list')->count() == 1);
        // check if we have error on job_email field
        $this->assertTrue($crawler->filter('#job_email')->siblings()->first()->filter('.error_list')->count() == 1);
    }
 
    public function createJob($values = array(), $publish = false)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/en/job/new');
        $form = $crawler->selectButton('Preview your job')->form(array_merge(array(
            'job[company]'      => 'Sensio Labs',
            'job[url]'          => 'http://www.sensio.com/',
            'job[position]'     => 'Developer',
            'job[location]'     => 'Atlanta, USA',
            'job[description]'  => 'You will work with symfony to develop websites for our customers.',
            'job[how_to_apply]' => 'Send me an email',
            'job[email]'        => 'for.a.job[at]example.com',
            'job[is_public]'    => false,
        ), $values));
 
        $client->submit($form);
        $client->followRedirect();
 
        if($publish) {
            $crawler = $client->getCrawler();
            $form = $crawler->selectButton('Publish')->form();
            $client->submit($form);
            $client->followRedirect();
        }
 
        return $client;
    }
     
    public function getJobByPosition($position)
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
     
        $query = $em->createQuery('SELECT j from ErlemJobeetBundle:Job j WHERE j.position = :position');
        $query->setParameter('position', $position);
        $query->setMaxResults(1);
        return $query->getSingleResult();
    }

    public function testPublishJob()
    {
        $client = $this->createJob(array('job[position]' => 'FOO1'));
        $crawler = $client->getCrawler();
        $form = $crawler->selectButton('Publish')->form();
        $client->submit($form);
     
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
     
        $query = $em->createQuery('SELECT count(j.id) from ErlemJobeetBundle:Job j WHERE j.position = :position AND j.is_activated = 1');
        $query->setParameter('position', 'FOO1');
        $this->assertTrue(0 < $query->getSingleScalarResult());
    }

    public function testDeleteJob()
    {
        $client = $this->createJob(array('job[position]' => 'FOO2'));
        $crawler = $client->getCrawler();
        $form = $crawler->selectButton('Delete')->form();
        $client->submit($form);
     
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
     
        $query = $em->createQuery('SELECT count(j.id) from ErlemJobeetBundle:Job j WHERE j.position = :position');
        $query->setParameter('position', 'FOO2');
        $this->assertTrue(0 == $query->getSingleScalarResult());
    }   
    
     public function testEditJob()
    {
        $client = $this->createJob(array('job[position]' => 'FOO3'), true);
        $crawler = $client->getCrawler();
        $crawler = $client->request('GET', sprintf('/en/job/%s/edit', $this->getJobByPosition('FOO3')->getToken()));
        $this->assertTrue( 404 === $client->getResponse()->getStatusCode());
    }
 
    public function testExtendJob()
    {
        // A job validity cannot be extended before the job expires soon
        $client = $this->createJob(array('job[position]' => 'FOO4'), true);
        $crawler = $client->getCrawler();
        $this->assertTrue($crawler->filter('input[type=submit]:contains("Extend")')->count() == 0);
 
        // A job validity can be extended hen the job expires soon
        // Create a new FOO5 job
        $client = $this->createJob(array('job[position]' => 'FOO5'), true);
        // Get the job and change the expire date to today
        $kernel = static::createKernel();
        $kernel->boot();
        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $job = $em->getRepository('ErlemJobeetBundle:Job')->findOneByPosition('FOO5');
        $job->setExpiresAt(new \DateTime());
        $em->flush();
 
        // Go to preview page and extend the job
        $crawler = $client->request('GET', sprintf('/en/job/%s/%s/%s/%s', $job->getCompanySlug(), $job->getLocationSlug(), $job->getToken(), $job->getPositionSlug()));
        $crawler = $client->getCrawler();
 
        $form = $crawler->selectButton('Extend')->form();
        $client->submit($form);
        $client->followRedirect();
        $this->assertEquals('Erlem\JobeetBundle\Controller\JobController::previewAction', $client->getRequest()->attributes->get('_controller'));
 
        // Reload the job from database
        $job = $this->getJobByPosition('FOO5');
 
        // Check the expiration date
        $this->assertTrue($job->getExpiresAt()->format('y/m/d') == date('y/m/d', time() + 86400 * 30));
    }
 
    public function testSearch()
    {
        $client = static::createClient();
 
        $crawler = $client->request('GET', '/en/job/search');
        $this->assertEquals('Erlem\JobeetBundle\Controller\JobController::searchAction', $client->getRequest()->attributes->get('_controller'));
 
        $crawler = $client->request('GET', '/en/job/search?query=sens*', array(), array(), array(
            'X-Requested-With' => 'XMLHttpRequest',
        ));
        $this->assertTrue($crawler->filter('tr')->count()== 2);
    }
}