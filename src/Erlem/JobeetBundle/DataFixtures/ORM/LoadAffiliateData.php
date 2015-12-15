<?php
 
namespace Erlem\JobeetBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Erlem\JobeetBundle\Entity\Affiliate;
 
class LoadAffiliateData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        $affiliate = new Affiliate();
 
        $affiliate->setUrl('http://sensio-labs.com/');
        $affiliate->setEmail('address1[at]example.com');
        $affiliate->setToken('sensio-labs');
        $affiliate->setIsActive(true);
        $affiliate->addCategory($em->merge($this->getReference('category-programming')));
 
        $em->persist($affiliate);
 
        $affiliate = new Affiliate();
 
        $affiliate->setUrl('/');
        $affiliate->setEmail('address2[at]example.org');
        $affiliate->setToken('symfony');
        $affiliate->setIsActive(false);
        $affiliate->addCategory($em->merge($this->getReference('category-programming')), $em->merge($this->getReference('category-design')));
 
        $em->persist($affiliate);
        $em->flush();
 
        $this->addReference('affiliate', $affiliate);
    }
 
    public function getOrder()
    {
        return 3; // This represents the order in which fixtures will be loaded
    }
}