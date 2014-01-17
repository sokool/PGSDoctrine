<?php

namespace PGSDoctrine\Mvc\Controller\Plugin;

use Doctrine\ORM\Tools\Pagination\Paginator as Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Paginate extends AbstractPlugin
{

    public function query(\Doctrine\ORM\Query $query, $pageNumber = 0, $elements = 10)
    {
        $paginator = new \Zend\Paginator\Paginator(new DoctrinePaginator(new Paginator($query)));
        $paginator->
            setItemCountPerPage($elements)->
            setCurrentPageNumber($pageNumber);

        return $paginator;
    }
}
