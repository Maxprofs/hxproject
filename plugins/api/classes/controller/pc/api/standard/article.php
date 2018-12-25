<?php defined('SYSPATH') or die('No direct script access.');

/**
 *Copyright www.deccatech.cn
 *Author: nilsir
 *QQ: 2758691158
 *Time: 2017/7/24 10:20
 *Desc: 攻略api
 */
class Controller_Pc_Api_Standard_Article extends Controller_Pc_Api_Base
{
    public function before()
    {
        parent::before();
    }

    /**
     * @desc 获取轮播图
     */
    public function action_get_rolling_ad()
    {
        $adname = Common::remove_xss($this->request_body->content->name);
        $result = array();
        if ($adname)
        {
            $result = Model_Api_Standard_Ad::getad(array('name' => $adname));
        }

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * @desc 栏目信息
     */
    public function action_channel()
    {
        $result = Model_Api_Standard_Article::channel();

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * @desc 获取攻略列表
     */
    public function action_list()
    {
        //条数
        $pagesize = intval($this->request_body->content->pagesize);
        //页码
        $page = intval($this->request_body->content->page);
        //目的地
        $destpy = $this->request_body->content->destpy;
        //关键词
        $keyword = Common::remove_xss($this->request_body->content->keyword);
        $params = array(
            'page'     => $page,
            'pagesize' => $pagesize,
            'destpy'   => $destpy,
            'keyword'  => $keyword,
        );
        $result = Model_Api_Standard_Article::search($params);

        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
    }

    /**
     * @desc 攻略详情
     */
    public function action_detail()
    {
        $id = intval($this->request_body->content->productid);
        if ($id)
        {
            $result = Model_Api_Standard_Article::detail($id);

            if (empty($result))
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key'], false, '查询攻略失败', '查询攻略失败');
            }
            else
            {
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
            }

        }
    }
}