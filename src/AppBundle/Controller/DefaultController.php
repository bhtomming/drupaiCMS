<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\CaseApp;
use AppBundle\Entity\Category;
use AppBundle\Entity\FriendLink;
use AppBundle\Entity\Menu;
use AppBundle\Entity\SiteBuild;
use AppBundle\Entity\Sittings;
use AppBundle\Entity\Slide;
use AppBundle\Entity\Swiper;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage",options={"sitemap" = true})
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();
        $technology = $this->getArticleBy($em,['categories' => 'technology']);
        $cases = $this->getEntityAll($em,CaseApp::class);
        $service = $this->getEntityAll($em,SiteBuild::class);
        $about = $this->getArticleBy($em,['categories' => 'about']);
        $swipers = $this->getEntityAll($em,Swiper::class);
        $sliders = $this->getEntityAll($em,Slide::class);
        return $this->render('default/index.html.twig', [
            'technologies' => $technology,
            'cases' => $cases,
            'services' => $service,
            'abouts' => $about,
            'swipers' => $swipers,
            'sliders' => $sliders,
        ]);
    }

    /**
     * @Route("/article/{slug}", requirements={"_format":"html"},
     *     name="show")
     */
    public function showAction(Article $article){
        return $this->render('default/show.html.twig',['article' => $article]);
    }
    /**
     * @Route("/articles/{categories}", requirements={"_format":"html"},
     *      name="category")
     */
    public function showCategoryAction($categories){
        $em = $this->getDoctrine()->getManager();
        $articles = $this->getArticleBy($em,['categories' => $categories]);
        return $this->render('default/list.html.twig',['articles' => $articles]);
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
     * 显示网站菜单
     */
    public function menuAction(){
        $em = $this->getDoctrine()->getManager();
        $menu = $this->getMenu($em);
        return $this->render('default/menu.html.twig',['menus' => $menu]);
    }


    /**
     * 网站文档里的头部信息
     */
    public function headAction(){
        $em = $this->getDoctrine()->getManager();
        $site = $em->getRepository(Sittings::class)->find(1);
        return $this->render('default/head.html.twig',[
            'keywords'=>$site->getKeywords(),
            'description' => $site->getDescription(),
            'title' => $site->getTitle(),
            ]);
    }

    /**
     * 网站底部信息
     */
    public function footerAction(){
        $em = $this->getDoctrine()->getManager();
        $links = $em->getRepository(FriendLink::class)->findAll();
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->render('default/footer.html.twig',['links' => $links, 'categories' => $categories]);
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
