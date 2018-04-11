<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\CaseApp;
use AppBundle\Entity\Category;
use AppBundle\Entity\FriendLink;
use AppBundle\Entity\Menu;
use AppBundle\Entity\SiteBuild;
use AppBundle\Entity\Sittings;
use AppBundle\Entity\Swiper;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();
        $site = $this->getEntityAll($em,Sittings::class);
        $menu = $this->getMenu($em);
        $links = $this->getEntityAll($em,FriendLink::class);
        $categories = $this->getEntityAll($em,Category::class );
        $technology = $this->getArticleBy($em,['categories' => 'technology']);
        $cases = $this->getEntityAll($em,CaseApp::class);
        $service = $this->getEntityAll($em,SiteBuild::class);
        $about = $this->getArticleBy($em,['categories' => 'about']);
        $swipers = $this->getEntityAll($em,Swiper::class);
        return $this->render('default/index.html.twig', [
            'site' => $site[0],
            'menus' => $menu,
            'links' => $links,
            'categories' => $categories,
            'technologies' => $technology,
            'cases' => $cases,
            'services' => $service,
            'abouts' => $about,
            'swipers' => $swipers,
        ]);
    }

    /**
     * @Route("/upload/file", name="upload")
     */
    public function uploadAction(Request $request){
        $file = $request->files->get('upload');
        $token = $request->request->get('token');
        $fileName = $this->get('app.file.uploader')->upload($file);
        //$data = "<script type=\"text / javascript\"> window.parent.CKEDITOR.tools.callFunction( '/uploads/images/".$fileName."','');</script>";
        $data  = [
            'uploaded' => 1,
            'fileName' => $fileName,
            'url' => $this->getParameter('app.path.article_images').'/'.$fileName,
        ];
        return new JsonResponse($data);
    }

    /**
     * @Route("/article/{id}", name="show")
     */
    public function showAction(){

    }

    /**
     * @Route("/view/image/", name="view_file");
     */
    public function browseFileAction(Request $request){
        $rootpath=$this->getParameter('kernel.project_dir');
        $filedir = $this->getParameter('app.path.article_images');
        $fullpath = $rootpath.'/web'.$filedir;

        $dirAll = scandir($fullpath);
        $images = [];
        foreach ($dirAll as $index => $image){
            $relationPath = $filedir.'/'.$image;
            $absolutePath = $rootpath.'/web'.$relationPath;
            if($image != '.' && $image != '..' && !is_dir($absolutePath)){
                $img['path'] = $relationPath;
                $img['fileName'] = $image;
                $images[] = $img;
            }
        }
        return $this->render('default/view_file.html.twig',[
            'images' => $images,
            'rootdir' =>$rootpath,
            'filedir' => $filedir,
        ]);
    }

    /**
     * @Route("/api/images/del", name="del");
     */
    public function imagesDelAction(Request $request){
        $data = [
            'status' => 202,
        ];
        $fileName = $this->getParameter('kernel.project_dir').'/web'.$request->request->get('fileName');
        if(file_exists($fileName)){
            unlink($fileName);
            $data['status'] = 200;
        }
        return new JsonResponse($data);
    }

    /**
     * @Route("/api/images/modify", name="mod");
     */
    public function imagesModAction(Request $request){
        $data = [
            'status' => 202,
        ];
        $filePath = $this->getParameter('kernel.project_dir').'/web'.$request->request->get('filePath');
        $fileName = $this->getParameter('kernel.project_dir').'/web'.$this->getParameter('app.path.article_images').'/'.$request->request->get('fileName');
        if(file_exists($filePath)){
            rename($filePath,$fileName);
            $data['status'] = 200;
        }
        return new JsonResponse($data);
    }



    public function getMenu(ObjectManager $em){
        $menus = $em->getRepository(Menu::class)->findAll();
        $parentMenus = [];
        foreach ($menus as $menu){
            if(null == $menu->getParentMenu()){
                $id = $menu->getId();
                $parentMenus[$id][] = $menu;
                $parentMenus[$id]['submenu'] = [];
            }else{
                $pid = $menu->getParentMenu()->getId();
                $parentMenus[$pid]['submenu'][] = $menu;
            }
        }
        return $parentMenus;
    }

    public function getArticleBy(ObjectManager $em,array $queries = null){
        $article = $em->getRepository(Article::class);
        if(empty($queries)) {
            return $article->findAll();
        }
        return $article->findByCategory($queries['categories']);
    }

    public function getEntityAll(ObjectManager $em,$className){
        return $em->getRepository($className)->findAll();
    }
}
