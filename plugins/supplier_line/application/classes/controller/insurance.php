<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/5/5 0005
 * Time: 11:46
 */
class Controller_Insurance extends Stourweb_Controller
{
    public function before()
    {
        parent::before();
        $this->assign('weblist', Common::getWebList());

    }






    public function action_dialog_detail()
    {
        $id = $this->params['id'];
        $model = new Model_Insurance($id);
        if (!$model->loaded())
            exit('错误的ID');
        $info = $model->as_array();
        $info['content'] = Model_Insurance::filterProductInfo($info['content']);
        $this->assign('info', $info);
        $this->display('insurance/dialog_detail');
    }

    public function action_dialog_set()
    {
        $selids = $_GET['insuranceids'];
        $selArr = explode(',', $selids);

        $products = Model_Insurance::getList();
        foreach ($products as $k => $v) {
            $products[$k]['content'] = Model_Insurance::filterProductInfo($v['content']);
        }
        $this->assign('selids', $selArr);
        $this->assign('products', $products);
        $this->display('insurance/dialog_set');
    }
}