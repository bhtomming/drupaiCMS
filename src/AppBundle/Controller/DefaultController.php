<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Entity\FriendLink;
use AppBundle\Entity\Menu;
use AppBundle\Entity\Sittings;
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
        $site = $this->getSite();
        $menu = $this->getMenu();
        $links = $this->getFriendLink();
        $categories = $this->getCategory();
        $technology = $this->getArticleBy(['categories' => 'technology']);
        $cases = $this->getArticleBy(['categories' => 'case']);
        $service = $this->getArticleBy(['categories' => 'service']);
        $about = $this->getArticleBy(['categories' => 'about']);
        return $this->render('default/index.html.twig', [
            'site' => $site[0],
            'menus' => $menu,
            'links' => $links,
            'categories' => $categories,
            'technologies' => $technology,
            'cases' => $cases,
            'services' => $service,
            'abouts' => $about,
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

    public function getSite(){
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository(Sittings::class)->findAll();
    }

    public function getMenu(){
        $em = $this->getDoctrine()->getManager();
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

    public function getFriendLink(){
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository(FriendLink::class)->findAll();
    }

    public function getCategory(){
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository(Category::class)->findAll();
    }

    public function getArticleBy(array $queries = null){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class);
        if(empty($queries)) {
            return $article->findAll();
        }
        return $article->findByCategory($queries['categories']);
    }
}
