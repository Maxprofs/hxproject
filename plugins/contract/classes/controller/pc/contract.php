<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by PhpStorm.
 * Author: daisc
 * QQ: 2444329889
 * Time: 2017/12/26 16:30
 * Desc: desc
 */

class  Controller_Pc_Contract extends Stourweb_Controller
{

    function before()
    {
        parent::before();
    }



    public function action_download()
    {
        $ordersn = Common::remove_xss($this->params['ordersn']);
        $url = $GLOBALS['cfg_basehost'].'/contract/view/ordersn/'.$ordersn.'/headhidden/1';
        $html = file_get_contents($url);
        $order = DB::select('contract_id','typeid')->from('member_order')
            ->where('ordersn','=',$ordersn)->execute()->current();
        $contract = Model_Contract::get_contents($order['contract_id'],$order['typeid']);

        include(DOCROOT . '/res/vendor/mpdf/mpdf.php');
        $mpdf = new mPDF('zh-CN','A4','','',15,15,38,28,15,15);
        $mpdf->useAdobeCJK = true;
        $mpdf->showWatermarkText = true;
        $mpdf->WriteHTML($html);
        $mpdf->Output($GLOBALS['cfg_webname'].$contract['title'].'.pdf','I');
        exit;
    }


    public function action_view()
    {
        $ordersn = Common::remove_xss($this->params['ordersn']);
        $headhidden = Common::remove_xss($this->params['headhidden']);
        $order = Model_Member_Order::order_info($ordersn);

        if(!in_array($order['status'],array(2,5)))
        {
            Common::head404();
        }
        $order = Model_Contract::format_order_data($order);
        $info = DB::select()->from('contract')
            ->where('id','=',$order['contract_id'])->execute()
            ->current();
        if(!$info['partyBid']||$info['partyBid']<=0)
        {
            $info['partyBid']=Model_Sysconfig::get_configs(0,'cfg_default_partyB',1);
        }
        $config=  Model_Contract::get_contract_config($info['partyBid']);
        if(!$info['partyBid'])
        {
            $list=Model_Contract::get_contract_config(false);
            $config=$list[0];
        }
        $this->assign('config',$config);
        $this->assign('order',$order);
        $this->assign('info',$info);
        $this->assign('headhidden',$headhidden);
        $this->display('contract/view');

    }

    public function action_book_view()
    {
        $contract_id = intval($this->params['contract_id']);
        $info = DB::select()->from('contract')
            ->where('id','=',$contract_id)->execute()
            ->current();
        if(!$info['partyBid']||$info['partyBid']<=0)
        {
            $info['partyBid']=Model_Sysconfig::get_configs(0,'cfg_default_partyB',1);
        }
        $config=  Model_Contract::get_contract_config($info['partyBid']);
        if(!$info['partyBid'])
        {
            $list=Model_Contract::get_contract_config(false);
            $config=$list[0];
        }
        $this->assign('config',$config);
        $this->assign('info',$info);
        $this->assign('headhidden',1);
        $this->display('contract/view');
    }



}