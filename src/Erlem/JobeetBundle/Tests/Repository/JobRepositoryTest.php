<?php

namespace Erlem\JobeetBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\ArrayInput;
use Doctrine\Bundle\DoctrineBundle\Command\DropDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\CreateDatabaseDoctrineCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand;
use Erlem\JobeetBundle\Entity\Job;

class JobRepositoryTest extends WebTestCase
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

	public function testCountActiveJobs()
	{
		$query = $this->em->createQuery('SELECT c FROM ErlemJobeetBundle:Category c');
		$categories = $query->getResult();

		foreach($categories as $category) {
			$query = $this->em->createQuery('SELECT COUNT(j.id) FROM ErlemJobeetBundle:Job j WHERE j.category = :category AND j.expires_at > :date');
			$query->setParameter('category', $category->getId());
			$query->setParameter('date', date('Y-m-d H:i:s', time()));
			$jobs_db = $query->getSingleScalarResult();

			$jobs_rep = $this->em->getRepository('ErlemJobeetBundle:Job')->countActiveJobs($category->getId());
            // This test will verify if the value returned by the countActiveJobs() function
            // coincides with the number of active jobs for a given category from the database
			$this->assertEquals($jobs_rep, $jobs_db);
		}
	}

	public function testGetActiveJobs()
	{
		$query = $this->em->createQuery('SELECT c from ErlemJobeetBundle:Category c');
		$categories = $query->getResult();

		foreach ($categories as $category) {
			$query = $this->em->createQuery('SELECT COUNT(j.id) from ErlemJobeetBundle:Job j WHERE j.expires_at > :date AND j.category = :category');
			$query->setParameter('date', date('Y-m-d H:i:s', time()));
			$query->setParameter('category', $category->getId());
			$jobs_db = $query->getSingleScalarResult();

			$jobs_rep = $this->em->getRepository('ErlemJobeetBundle:Job')->getActiveJobs($category->getId(), null, null);
            // This test tells if the number of active jobs for a given category from
            // the database is the same as the value returned by the function
			$this->assertEquals($jobs_db, count($jobs_rep));

		    // If there are at least 3 active jobs in the selected category, we will
		    // test the getActiveJobs() method using the limit and offset parameters too
		    // to get 100% code coverage
			if($jobs_db > 2 ) {
				$jobs_rep = $this->em->getRepository('ErlemJobeetBundle:Job')->getActiveJobs($category->getId(), 2);
        		// This test tells if the number of returned active jobs is the one $max parameter requires
				$this->assertEquals(2, count($jobs_rep));

				$jobs_rep = $this->em->getRepository('ErlemJobeetBundle:Job')->getActiveJobs($category->getId(), 2, 1);
        		// We set the limit to 2 results, starting from the second job and test if the result is as expected
				$this->assertEquals(2, count($jobs_rep));
			}
		}
	}

	public function testGetActiveJob()
	{
		$query = $this->em->createQuery('SELECT j FROM ErlemJobeetBundle:Job j WHERE j.expires_at > :date');
		$query->setParameter('date', date('Y-m-d H:i:s', time()));
		$query->setMaxResults(1);
		$job_db = $query->getSingleResult();

		$job_rep = $this->em->getRepository('ErlemJobeetBundle:Job')->getActiveJob($job_db->getId());
        // If the job is active, the getActiveJob() method should return a non-null value
		$this->assertNotNull($job_rep);

		$query = $this->em->createQuery('SELECT j FROM ErlemJobeetBundle:Job j WHERE j.expires_at < :date');         $query->setParameter('date', date('Y-m-d H:i:s', time()));
		$query->setMaxResults(1);
		$job_expired = $query->getSingleResult();

		$job_rep = $this->em->getRepository('ErlemJobeetBundle:Job')->getActiveJob($job_expired->getId());
        // If the job is expired, the getActiveJob() method should return a null value
		$this->assertNull($job_rep);
	}

	protected function tearDown()
	{
		parent::tearDown();
		$this->em->close();
	}

    public function testGetForLuceneQuery()
    {
        $em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
 
        $job = new Job();
        $job->setType('part-time');
        $job->setCompany('Sensio');
        $job->setPosition('FOO6');
        $job->setLocation('Paris');
        $job->setDescription('WebDevelopment');
        $job->setHowToApply('Send resumee');
        $job->setEmail('jobeet[at]example.com');
        $job->setUrl('http://sensio-labs.com');
        $job->setIsActivated(false);
 
        $em->persist($job);
        $em->flush();
 
        $jobs = $em->getRepository('ErlemJobeetBundle:Job')->getForLuceneQuery('FOO6');
        $this->assertEquals(count($jobs), 0);
 
        $job = new Job();
        $job->setType('part-time');
        $job->setCompany('Sensio');
        $job->setPosition('FOO7');
        $job->setLocation('Paris');
        $job->setDescription('WebDevelopment');
        $job->setHowToApply('Send resumee');
        $job->setEmail('jobeet[at]example.com');
        $job->setUrl('http://sensio-labs.com');
        $job->setIsActivated(true);
 
        $em->persist($job);
        $em->flush();
 
        $jobs = $em->getRepository('ErlemJobeetBundle:Job')->getForLuceneQuery('position:FOO7');
        $this->assertEquals(count($jobs), 1);
        foreach ($jobs as $job_rep) {
            $this->assertEquals($job_rep->getId(), $job->getId());
        }
 
        $em->remove($job);
        $em->flush();
 
        $jobs = $em->getRepository('ErlemJobeetBundle:Job')->getForLuceneQuery('position:FOO7');
 
        $this->assertEquals(count($jobs), 0);
    }

}