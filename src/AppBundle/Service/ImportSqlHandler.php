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
        $conn = new \mysqli('127.0.0.1','root','root','drupai');
        $conn->query('set name utf8');
        $sql = "select entity_id, body_value from drun_field_data_body";
        $bodyData = $conn->query($sql)->fetch_all();
        $pages = [];
        foreach ($bodyData as $index => $page){
            $page[1] = str_replace('/sites/default/files/ueditor/','/uploads/images/articles',$page[1]);
            $bodyData[$index]  = $page;
            $sql = "select nid,title,created,changed from drun_node where nid = ".$bodyData[$index][0];
            $titles = $conn->query($sql)->fetch_row();
            $pages[] = array_merge($titles,$bodyData[$index]);
        }

        return $pages;
    }
}