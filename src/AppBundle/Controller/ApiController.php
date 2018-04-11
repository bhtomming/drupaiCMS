<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\4\11 0011
 * Time: 16:01
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiController
 * @package AppBundle\Controller
 * @Route("/api")
 */
class ApiController extends Controller
{
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
     * @Route("/images/del", name="del");
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
     * @Route("/images/modify", name="mod");
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