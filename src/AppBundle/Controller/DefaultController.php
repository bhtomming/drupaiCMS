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
        $fullpath = $rootpath.'/web'.$filedir;

        $dirAll = scandir($fullpath);
        $images = [];
        foreach ($dirAll as $index => $image){
            if($image != '.' && $image != '..'){
                $img['path'] = $this->getParameter('app.path.article_images').'/'.$image;
                $img['fileName'] = $image;
                $images[] = $img;
            }
        }
        $funNum = $request->query->get('CKEditorFuncNum');
        $fileUri = '/uploads/images/articles/df3f1f191c0cb8549aef390bf6cb0415.jpeg';
        $data= "<script type=\"text/javascript\">window.opener.CKEDITOR.tools.callFunction( $funNum, $fileUri );</script>";
        return $this->render('default/view_file.html.twig',[
            'images' => $images,
            'editor_js' => $data,
            'rootdir' =>$rootpath,
            'filedir' => $filedir,
            'funNum' =>$funNum,
            'fileUri' => $fileUri,
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
}
