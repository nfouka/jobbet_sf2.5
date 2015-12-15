<?php

namespace Erlem\JobeetBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Erlem\JobeetBundle\Entity\User;
 
class LoadUserData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
 
    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
 
    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $em
     */
    public function load(ObjectManager $em)
    {
        $user = new User();
        $user->setUsername('admin');
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user)
        ;
 
        $encodedPassword = $encoder->encodePassword('admin', $user->getSalt());
        $user->setPassword($encodedPassword);
 
        $em->persist($user);
        $em->flush();
    }
 
    public function getOrder()
    {
        return 4; // the order in which fixtures will be loaded
    }
}