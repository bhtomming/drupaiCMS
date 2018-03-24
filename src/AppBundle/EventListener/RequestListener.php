<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 23:00
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\VisitedLog;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class RequestListener
{
    public function onKernelRequest(GetResponseEvent $event){
        $request = $event->getRequest();
        $visitedLog = new VisitedLog();
        $visitedLog->setPage($request->getUri());
        $visitedLog->setTitle(ob_start(function($buffer){
            preg_match('/<title.*>\s*(.*)\s*<\/title>/',$buffer,$str);
            return $str[1];
        }));
        $visitedLog->setIpAddress($request->getClientIp());
        $visitedLog->setUserName($request->getUser());
        $visitedLog->setComeFrom($request->getHost());
        $visitedLog->setVisitedTime(new \DateTime());
        $request->get('doctrine')->getManager()->persist($visitedLog);
        $request->get('doctrine')->getManager()->flush();
        return;
    }

}