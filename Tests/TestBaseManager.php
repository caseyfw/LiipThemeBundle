<?php

namespace Liip\ThemeBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

class TestBaseManager extends WebTestCase
{
    protected $container;
    
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $env = isset($_SERVER['ENVIRONMENT']) ? $_SERVER['ENVIRONMENT'] : 'test';

        static::$kernel = static::createKernel(array('environment' => $env));
        static::$kernel->boot();
        $this->container = static::$kernel->getContainer();
        $this->em = $this->container->get('doctrine.orm.default_entity_manager');

        $this->purge();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        if($this->em) {
            $this->em->close();
        }
    }

    public function purge()
    {
        $purger = new ORMPurger($this->em);
        $executor = new ORMExecutor($this->em, $purger);
        $executor->purge();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->em;
    }
}
