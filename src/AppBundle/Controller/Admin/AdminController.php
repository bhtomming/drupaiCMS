<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\3\18 0018
 * Time: 14:23
 */

namespace AppBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
    protected $entity;

    protected $config;

    protected $request;

    protected $em;


    public function persistEntity($entity){
        $this->autoFillInfo($entity);
        parent::persistEntity($entity);
    }

    public function updateEntity($entity){
        $this->autoFillInfo($entity);
        parent::updateEntity($entity);
    }

    public function autoFillInfo($entity){
        method_exists($entity,'setCreatedAt') && method_exists($entity,'getCreatedAt') && null == $entity->getCreatedAt() ? $entity->setCreatedAt(new \DateTime()) : null;
        method_exists($entity,'setUpdatedAt') ? $entity->setUpdatedAt(new \DateTime()) : null;
        method_exists($entity,'setAuthor') ? $entity->setAuthor($this->getUser()) : null;
    }

}