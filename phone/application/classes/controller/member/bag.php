<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Class Controller_Member
 * 会员总控制器
 */
class Controller_Member_Bag extends Stourweb_Controller
{

    private $member = null;
    public function before()
    {
        parent::before();
        $this->member = Common::session('member');
        $order_query_token = Common::session('order_query_token');
        Common::session('order_query_token','');//重置查询
        if (empty($this->member) && empty($order_query_token))
        {
            Common::message(array('message' => __('unlogin'), 'jumpUrl' => $this->cmsurl . 'member/login'));
        }
    }
    //日志列表
    public function action_index()
    {
        $member = Model_Member::get_member_info($this->member['mid']);
        $config=Model_Member_Withdraw::get_config();
        $this->assign('config',$config);
        $cash_available_num=Model_Member_Withdraw::get_available_num($this->member['mid']);
        $this->assign('cash_available_num',$cash_available_num);
        $this->assign('member',$member);
        $this->display('member/money/index');
    }
    //提现
    public function action_withdraw()
    {
        $member = Model_Member::get_member_info($this->member['mid']);
        $config=Model_Member_Withdraw::get_config();
        $this->assign('config',$config);
        $cash_available_num=Model_Member_Withdraw::get_available_num($this->member['mid']);
        $this->assign('cash_available_num',$cash_available_num);
        $way = $_GET['way'];
        $way = empty($way)?'bank':$way;
        $this->assign('member',$member);
        $this->display('member/money/withdraw_'.$way);
    }
    //收支记录
    public function action_record()
    {
        $this->display('member/money/record');
    }

    public function action_way()
    {
        $way = Model_Sysconfig::get_configs(0,'cfg_member_withdraw_way',true);
        $way = explode(',',$way);
        $this->assign('way',$way);
        $this->display('member/money/way');
    }

    //获取收支记录
    public function action_ajax_get_record()
    {
        $pagesize=10;
        $page = $_POST['page'];
        $type = $_POST['type'];
        $params = array('type'=>$type);
        $out = Model_Member_Cash_Log::search_result($this->member['mid'],$page,$pagesize,$params);
        foreach($out['list'] as &$v)
        {
            $v['addtime'] = date('Y-m-d',$v['addtime']);
        }
        echo json_encode($out);
    }

    //保存
    public function action_ajax_withdraw_save()
    {
        $member = Model_Member::get_member_info($this->member['mid']);
        $amount = doubleval($_POST['amount']);
        $amount = floor($amount*100)/100;

        $config=Model_Member_Withdraw::get_config();
        $cash_available_num=Model_Member_Withdraw::get_available_num($this->member['mid']);
        if($config['cash_min']==1&&$amount<$config['cash_min_num'])
        {
            echo json_encode(array('status'=>false,'msg'=>'申请金额不足最低限度'));
            exit;
        }
        if ($amount < 0.1) {
            echo json_encode(array('status' => false, 'msg' => '申请金额不能低于0.1'));
            exit;
        }
        if($cash_available_num==0)
        {
            echo json_encode(array('status'=>false,'msg'=>'当月可提现次数已用完'));
            exit;
        }
        $bankaccountname = $_POST['bankaccountname'];
        $bankcardnumber = $_POST['bankcardnumber'];
        $bankname = $_POST['bankname'];
        $description = $_POST['description'];
        $way = $_POST['way'];

        $db = Database::instance();
        $db->begin();
        try
        {
            $curtime = time();
            $useful_money = $member['money']-$member['money_frozen'];
            if($useful_money<$amount)
            {
                throw new Exception('可提现余额不足');
            }
            if($amount<=0)
            {
                throw new Exception('提现金额不得小于0');
            }

            $withdraw_model = ORM::factory('member_withdraw');
            $withdraw_model->memberid = $member['mid'];
            $withdraw_model->withdrawamount = $amount;
            $withdraw_model->bankname = $bankname;
            $withdraw_model->way = $way;
            $withdraw_model->bankcardnumber = $bankcardnumber;
            $withdraw_model->bankaccountname = $bankaccountname;
            $withdraw_model->description = $description;
            $withdraw_model->status = 0;
            $withdraw_model->addtime = $curtime;
            $withdraw_model->save();
            if(!$withdraw_model->saved())
            {
                throw new Exception('提现失败，请重试');
            }

            //会员信息修改
            $member_model = ORM::factory('member',$member['mid']);
            $member_model->money_frozen+=$amount;
            $member_model->save();
            if(!$member_model->saved())
            {
                throw new Exception('提现失败，请重试');
            }

            $log_des = '提交提现申请后冻结'.$amount.'元';
            Model_Member_Cash_Log::add_log($member['mid'],2,$amount,$log_des,array('withdrawid'=>$withdraw_model->id));
            $db->commit();
            echo json_encode(array('status'=>true,'msg'=>'提交申请成功'));
            exit;
        }
        catch (Exception $excep)
        {
            $db->rollback();
            echo json_encode(array('status'=>false,'msg'=>$excep->getMessage()));
            exit;
        }
    }
}
