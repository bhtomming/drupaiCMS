<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\3\18 0018
 * Time: 14:23
 */

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Article;
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

    /**
     * @Route("/drupai/datebase/migrate", name="data_update");
     *
     */
    public function importAction(){
        $nodes = $this->get("app.sql.migrate")->readFromDatabase();
        foreach ($nodes as $node){
            $article = new Article();
            $article->setAuthor($this->getUser());
            $article->setTitle($node[1]);
            $article->setCreatedAt(new \DateTime(date("Y-m-d h:i:s",$node[2])));
            $article->setUpdatedAt(new \DateTime(date("Y-m-d h:i:s",$node[3])));
            $article->setContent($node[5]);
            $this->getDoctrine()->getManager()->persist($article);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute('admin');
    }

}