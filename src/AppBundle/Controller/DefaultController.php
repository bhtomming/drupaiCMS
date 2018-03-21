<?php

namespace AppBundle\Controller;

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
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
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

        $images = scandir($filedir);
        foreach ($images as $index => $image){
            $images[$index] = $this->getParameter('app.path.article_images').'/'.$image;
        }
        $funNum = $request->query->get('CKEditorFuncNum');
        $fileUri = '/uploads/images/articles/df3f1f191c0cb8549aef390bf6cb0415.jpeg';
        $data= "<script type=\"text/javascript\">window.opener.CKEDITOR.tools.callFunction( $funNum, $fileUri );</script>";
        return $this->render('default/view_file.html.twig',[
            'imgs_path' => $images,
            'editor_js' => $data,
            'rootdir' =>$rootpath,
            'filedir' =>$filedir,
        ]);
    }
}
