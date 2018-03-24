<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\3\24 0024
 * Time: 17:02
 */

namespace AppBundle\Controller;


use AppBundle\Entity\VisitedLog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class VisitedLogController extends Controller{
    private $visitedLog;
    public function __construct(){
        $this->visitedLog = new VisitedLog();
    }

    public function logVisited(Request $request){
        $ip = $request->getClientIp();
        $page = $request->getUri();
        $title = ob_start(function($buffer){
            preg_match('/<title.*>\s*(.*)\s*<\/title>/',$buffer,$str);
            return $str[1];
        });
        $userName =  '匿名用户';
        $this->visitedLog->setTitle($title);
        $this->visitedLog->setPage($page);
        $this->visitedLog->setIpAddress($ip);
        $this->visitedLog->setUserName($userName);
        $this->visitedLog->setVisitedTime(new \DateTime());
        $this->getDoctrine()->getManager()->persist($this->visitedLog);
        $this->getDoctrine()->getManager()->flush();

    }
}