<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/24
 * Time: 23:00
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\VisitedLog;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


class RequestListener
{
    private $em;
    private $tokenStorage;
    private $checker;
    private $container;

    public function __construct(Container $container){
        $this->container = $container;
        $this->em = $this->get('doctrine.orm.entity_manager');
        $this->checker = $this->get('security.authorization_checker');
        $this->tokenStorage = $this->get('security.token_storage');
    }
    public function onKernelRequest(GetResponseEvent $event){
        $request = $event->getRequest();
        if($request->getClientIp() == '127.0.0.1'){
            return;
        }
        $header = $request->headers;
        $logType = [
            'text/html',
            'application/xhtml+xml',
            'application/xml;q=0.9',
            'application/json',
        ];
        $headerAccept = explode(',',$header->get('accept'));
        if(!empty(array_intersect($logType,$headerAccept))){
            $visitedLog = new VisitedLog();
            $visitedLog->setPage($request->getUri());
            $referer = $request->server->get('HTTP_REFERER') ? $request->server->get('HTTP_REFERER'): '直接打开';
            $visitedLog->setIpAddress($request->getClientIp());
            $userName = '匿名用户';
            if($this->checker->isGranted('IS_AUTHENTICATED_FULLY')){
                $userName = $this->tokenStorage->getToken()->getUsername();
            }
            $visitedLog->setUserName($userName);
            $visitedLog->setComeFrom($referer);
            $visitedLog->setVisitedTime(new \DateTime());
            $this->em->persist($visitedLog);
            $this->em->flush();
        }
        return ;
    }
    public function get($server){
        return $this->container->get($server);
    }
}