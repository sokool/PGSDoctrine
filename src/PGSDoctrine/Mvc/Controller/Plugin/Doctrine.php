<?php

namespace PGSDoctrine\Mvc\Controller\Plugin;

use Doctrine\ORM\Query as DoctrineQuery;
use Doctrine\ORM\Tools\Pagination\Paginator as Paginator;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Doctrine extends AbstractPlugin
{

    /**
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function em()
    {
        return $this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }

    public function repository($FQDNClassName)
    {
        return $this->em()->getRepository($FQDNClassName);
    }

    /**
     * @param  object                                      $object
     * @return \Application\Mvc\Controller\Plugin\Doctrine
     */
    public function persist($object)
    {
        $this->em()->persist($object);

        return $this;
    }

    /**
     * @param  object                                      $object
     * @return \Application\Mvc\Controller\Plugin\Doctrine
     */
    public function remove($object)
    {
        $this->em()->remove($object);

        return $this;
    }

    /**
     * @param  object                                      $object
     * @return \Application\Mvc\Controller\Plugin\Doctrine
     */
    public function flush($entity = null)
    {
        $this->em()->flush($entity);

        return $this;
    }

    public function hydrate($FQDNClassName, $data)
    {
        $hydrator = new DoctrineHydrator($this->em(), $FQDNClassName);
        $instance = new $FQDNClassName;
        $hydrator->hydrate($data, $instance);

        return $instance;
    }

    public function paginateResults(DoctrineQuery $query, $pageNumber = 0, $elements = 10)
    {
        $paginator = new \Zend\Paginator\Paginator(new DoctrinePaginator(new Paginator($query)));
        $paginator->
            setItemCountPerPage($elements)->
            setCurrentPageNumber($pageNumber);

        return $paginator;
    }
}
