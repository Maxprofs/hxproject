<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Standard_Comment extends Controller_Pc_Api_Base
{

    //评论api控制器
    public function before()
    {
        parent::before();
    }


    /**
     * 获取评论列表
     */
    public function action_list()
    {
        //条数
        $pagesize = intval($this->request_body->content->pagesize);
        //页码
        $page = intval($this->request_body->content->page);
        //栏目id
        $typeid = intval($this->request_body->content->typeid);
        //产品id
        $productid = intval($this->request_body->content->productid);

        $result = Model_Api_Standard_Comment::search($typeid,$productid,'',$page,$pagesize);

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }

    //评论统计信息
    public function action_count_info()
    {
        //产品id
        $productid = intval($this->request_body->content->productid);
        //栏目id
        $typeid = intval($this->request_body->content->typeid);

        $result = Model_Api_Standard_Comment::get_count($typeid,$productid);

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);

    }



  

}