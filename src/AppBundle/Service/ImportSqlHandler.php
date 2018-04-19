<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\3\28 0028
 * Time: 10:20
 */

namespace AppBundle\Service;


class ImportSqlHandler{

    public function readFromDatabase(){
        $dsn = "mysql:host=localhost;dbname=drupai;charset=utf8;";
        $option = array(\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC);
        $conn = new \PDO($dsn,'root','root',$option);
        $conn->query('set name utf8');
        $sql = "select entity_id, body_value,body_summary from drun_field_data_body";
        $thr = $conn->prepare($sql);
        $thr->execute();
        $bodyData = $thr->fetchAll();
        $pages = [];
        foreach ($bodyData as $index => $page){
            $page['body_value'] = str_replace('/sites/default/files/ueditor/','/uploads/images/articles',$page['body_value']);
            $sql = "select nid,title,created,changed from drun_node where nid = ".$bodyData[$index]['entity_id'];
            $titles = $conn->query($sql)->fetch();
            $page['title'] = $titles['title'];
            $page['created'] = $titles['created'];
            $page['changed'] = $titles['changed'];
            $bodyData[$index]  = $page;
            //$pages[] = array_merge($titles,$bodyData[$index]);
        }

        return $bodyData;
    }
}