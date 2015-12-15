<?php

namespace Erlem\JobeetBundle\Entity;

use Erlem\JobeetBundle\Utils\Jobeet;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $jobs;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $affiliates;

    private $active_jobs;

    private $more_jobs;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->affiliates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add jobs
     *
     * @param \Erlem\JobeetBundle\Entity\Job $jobs
     * @return Category
     */
    public function addJob(\Erlem\JobeetBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;

        return $this;
    }

    /**
     * Remove jobs
     *
     * @param \Erlem\JobeetBundle\Entity\Job $jobs
     */
    public function removeJob(\Erlem\JobeetBundle\Entity\Job $jobs)
    {
        $this->jobs->removeElement($jobs);
    }

    /**
     * Get jobs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Add affiliates
     *
     * @param \Erlem\JobeetBundle\Entity\Affiliate $affiliates
     * @return Category
     */
    public function addAffiliate(\Erlem\JobeetBundle\Entity\Affiliate $affiliates)
    {
        $this->affiliates[] = $affiliates;

        return $this;
    }

    /**
     * Remove affiliates
     *
     * @param \Erlem\JobeetBundle\Entity\Affiliate $affiliates
     */
    public function removeAffiliate(\Erlem\JobeetBundle\Entity\Affiliate $affiliates)
    {
        $this->affiliates->removeElement($affiliates);
    }

    /**
     * Get affiliates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAffiliates()
    {
        return $this->affiliates;
    }

    public function __toString()
    {
      return $this->getName();
    }    

    public function setActiveJobs($jobs)
    {
        $this->active_jobs = $jobs;
    }
 
    public function getActiveJobs()
    {
        return $this->active_jobs;
    }    

    public function setMoreJobs($jobs)
    {
        $this->more_jobs = $jobs >=  0 ? $jobs : 0;
    }
 
    public function getMoreJobs()
    {
        return $this->more_jobs;
    }
    /**
     * @var string
     */
    private $slug;


    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * @ORM\PrePersist
     */
    public function setSlugValue()
    {
        $this->slug = Jobeet::slugify($this->getName());
    }
}
