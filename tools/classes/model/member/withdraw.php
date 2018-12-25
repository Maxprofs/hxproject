<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 订单管理
 * Class Order
 */
Class Model_Member_Withdraw extends ORM
{
    public static $status_names=array('0'=>'申请中','1'=>'完成',2=>'未通过');

    public static function get_status_name($status)
    {
        return self::$status_names[$status];
    }

    public static function get_config()
    {
        //获取提现规则配置
        $configinfo = Model_Sysconfig::get_configs(0,array('cash_min_num','cash_max_num','cash_min','cash_max'));
        foreach ($configinfo as &$item)
        {
            $item=intval($item);
        }
        //获取用户
        return $configinfo;
    }

    public static function get_available_num($mid)
    {
        //获取当月提现次数
        $configinfo=Model_Member_Withdraw::get_config();
        $num=0;
        if($configinfo['cash_max']==1)
        {
            //设置的次数
            $config_num=$configinfo['cash_max_num'];
            //已提现的次数
            $start_time = strtotime(date( 'Y-m-01 00:00:00', time()));
            $mdays = date( 't', time() );
            $end_time = strtotime(date( 'Y-m-' . $mdays . ' 23:59:59', time()));
            $cash_log=DB::select()->from('member_withdraw')
                ->where('status','<=',1)
                ->and_where('memberid','=',$mid)
                ->and_where('addtime','<',$end_time)
                ->and_where('addtime','>',$start_time)
                ->execute()->as_array();
            $cash_num=count($cash_log);
            $num=$config_num-$cash_num<0?0:($config_num-$cash_num);
        }
        else
        {
            $num=-1;
        }
        return $num;
    }


    public static function withdraw_alipay($withdraw_id)
    {

        $widthdraw_model = ORM::factory('member_withdraw',$withdraw_id);
        $widthdraw_info = $widthdraw_model->as_array();
        $db = Database::instance();
        $db->begin();
        try {

            if(empty($widthdraw_info))
            {
                throw new Exception('提现订单不存在');
            }
            if($widthdraw_info['status']!=0)
            {
                throw new Exception('当前订单不能退款');
            }
            if($widthdraw_info['way']!='alipay')
            {
                throw new Exception('只有支付宝才可以在线退款');
            }

            $member_model = ORM::factory('member',$widthdraw_info['memberid']);

            if(!$member_model->loaded())
            {
                throw new Exception('会员不存在');
            }
            $money = doubleval($member_model->money);
            $money_frozen = doubleval($member_model->money_frozen);

            $amount = doubleval($widthdraw_info['withdrawamount']);
            if($amount>$money)
            {
                throw new Exception('提现金额高于存款总额');
            }
            if($amount>$money_frozen)
            {
                throw new Exception('提现金额高于冻结总额');
            }


            $transfer_info = array();
            $transfer_info['out_biz_no'] = 'wiz'.$widthdraw_info['id'];
            $transfer_info['amount'] = $amount;
            $transfer_info['account']= $widthdraw_info['bankcardnumber'];
            $transfer_info['payer_show_name']= Model_Sysconfig::get_configs(0,'cfg_webname',true);
            $transfer_info['payee_real_name'] = $widthdraw_info['bankaccountname'];

            $result = self::transfer_alipay($transfer_info);
            if($result['status'])
            {
                $member_model->money-= doubleval($amount);
                $member_model->money_frozen-= doubleval($amount);
                $member_model->save();
                if(!$member_model->saved())
                {
                    throw new Exception('审核未成功，请重试');
                }
                $log_des = '提现审核完成，解冻并扣除'.$amount.'元';
                $log_result = Model_Member_Cash_Log::add_log($member_model->mid,1,$amount,$log_des,array('withdrawid'=>$withdraw_id));
                if(!$log_result)
                {
                    throw new Exception('审核未成功，请重试');
                }

                $alipay_success_des = "已通过支付宝在线转账，交易订单号".  $transfer_info['out_biz_no'];
                $widthdraw_model->status = 1;
                $widthdraw_model->audit_description = $alipay_success_des;
                $widthdraw_model->finishtime = time();
                $widthdraw_model->save();
                $db->commit();
                return $result;
            }
            else
            {
                throw new Exception($result['msg']);
            }
        }
        catch (Exception $e)
        {
            $db->rollback();
            return array('status'=>false,'msg'=>$e->getMessage());
        }



    }

    //执行支付宝转账功能
    public static function transfer_alipay($info)
    {
       // return array('status'=>false,'msg'=>'暂不支持退款功能，请提升PHP版本');
        require_once TOOLS_PATH.'lib/alipay_refund/AlipayTradeService.php';
        require_once TOOLS_PATH.'lib/alipay_refund/AopClient.php';
        require_once TOOLS_PATH.'lib/alipay_refund/SignData.php';
        require_once TOOLS_PATH.'lib/alipay_refund/AlipayFundTransToaccountTransferRequest.php';
        $alipay_config =  self::_alipay_config();


        $aop = new AopClient ();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = $alipay_config['app_id'];
        $aop->rsaPrivateKey = $alipay_config['merchant_private_key'];
        $aop->alipayrsaPublicKey=$alipay_config['alipay_public_key'];
        $aop->apiVersion = '1.0';
        $aop->signType = $alipay_config['sign_type'];
        $aop->postCharset=$alipay_config['charset'];
        $aop->format='json';
        $request = new AlipayFundTransToaccountTransferRequest();

        $request_params = array(
            'out_biz_no'=>$info['out_biz_no'],
            'payee_type'=>'ALIPAY_LOGONID',
            'payee_account'=>$info['account'],
            'amount' => $info['amount'],
            'payer_show_name'=>  $info['payer_show_name'],
            'payee_real_name' => $info['payee_real_name']
        );

        $request->setBizContent(json_encode($request_params));
        $result = $aop->execute ( $request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){

            return array('status' => true,'msg'=>'提现完成');
        }
        else
        {
            if(!empty($resultCode))
            {
                return array('status' => false, 'msg' => $result->$responseNode->sub_msg);
            }
            else
            {
                return array('status' => false, 'msg' =>'请求失败');
            }
        }


    }

    //获取支付宝配置
    private static function _alipay_config()
    {
        $ext_dir = self::_get_ext_dir('alipay');
        $merchant_private_key_path = $ext_dir .'/vendor/pc/alipay_cash/rsa_private_key.pem';
        $alipay_public_key_path = $ext_dir .'/vendor/pc/alipay_cash/rsa_public_key.pem';
        $merchant_private_key = Model_Sysconfig::get_sys_conf('value','merchant_private_key');
        $alipay_public_key = Model_Sysconfig::get_sys_conf('value','alipay_public_key');
        //合作身份者id
        $alipay_config['app_id'] = Model_Sysconfig::get_configs(0,'cfg_alipay_appid',true);//('cfg_alipay_appid');
        //商户私钥
        //如果没有秘钥值，那么读取文件
        if($merchant_private_key)
        {
            $alipay_config['merchant_private_key'] = $merchant_private_key;
        }
        else
        {
            $alipay_config['merchant_private_key_path'] = $merchant_private_key_path;
        }
        //支付宝公钥
        if($alipay_public_key)
        {
            $alipay_config['alipay_public_key'] = $alipay_public_key;
        }
        else
        {
            $alipay_config['alipay_public_key_path'] = $alipay_public_key_path;
        }
        //字符编码格式
        $alipay_config['charset'] = strtolower('utf-8');
        //签名方式
        $alipay_config['sign_type'] = strtoupper('RSA2');
        //签名
        $alipay_config['sign'] = strtoupper('MD5');
        //支付宝网关
        $alipay_config['gatewayUrl'] = 'https://openapi.alipay.com/gateway.do';


        return $alipay_config;
    }
    /**
     * @function 获取支付应用的路径
     * @param $source
     */
    private static function _get_ext_dir($source)
    {
        //证书路径,注意应该填写绝对路径
        $dir = rtrim(BASEPATH,DIRECTORY_SEPARATOR);
        $issystem = DB::select('issystem')
            ->from('payset')
            ->where('pinyin','=',$source)
            ->execute()->get('issystem');
        if($issystem!=1)
        {
            $dir .= '/plugins/'.$source;
        }
        else
        {
            $dir .= '/payment/application';
        }
        return $dir;
    }

    public static function withdraw_weixin($withdraw_id)
    {
        $widthdraw_model = ORM::factory('member_withdraw',$withdraw_id);
        $widthdraw_info = $widthdraw_model->as_array();
        $db = Database::instance();
        $db->begin();
        try {
            $openid = DB::query(Database::SELECT,"select openid from sline_member_third where mid='{$widthdraw_info['memberid']}' and `from`='weixin'")->execute()->get('openid');

            if(empty($widthdraw_info))
            {
                throw new Exception('提现订单不存在');
            }

            if(empty($openid))
            {
                throw new Exception('该会员不是微信登录会员');
            }

            if($widthdraw_info['status']!=0)
            {
                throw new Exception('当前订单不能退款');
            }
            if($widthdraw_info['way']!='weixin')
            {
                throw new Exception('只有支付宝才可以在线退款');
            }

            $member_model = ORM::factory('member',$widthdraw_info['memberid']);

            if(!$member_model->loaded())
            {
                throw new Exception('会员不存在');
            }
            $money = doubleval($member_model->money);
            $money_frozen = doubleval($member_model->money_frozen);

            $amount = doubleval($widthdraw_info['withdrawamount']);
            if($amount>$money)
            {
                throw new Exception('提现金额高于存款总额');
            }
            if($amount>$money_frozen)
            {
                throw new Exception('提现金额高于冻结总额');
            }


            $transfer_info = array();
            $transfer_info['partner_trade_no'] = 'wiz'.$widthdraw_info['id'];
            $transfer_info['amount'] = $amount;
            $transfer_info['account'] = $widthdraw_info['bankcardnumber'];
            $transfer_info['desc'] = '微信提现';
            $transfer_info['openid'] = $openid;


            $result = self::transfer_weixin($transfer_info);
            if($result['status'])
            {
                $member_model->money-= doubleval($amount);
                $member_model->money_frozen-= doubleval($amount);
                $member_model->save();
                if(!$member_model->saved())
                {
                    throw new Exception('审核未成功，请重试');
                }
                $log_des = '提现审核完成，解冻并扣除'.$amount.'元';
                $log_result = Model_Member_Cash_Log::add_log($member_model->mid,1,$amount,$log_des,array('withdrawid'=>$withdraw_id));
                if(!$log_result)
                {
                    throw new Exception('审核未成功，请重试');
                }

                $alipay_success_des = "已通过微信在线转账，交易订单号".  $transfer_info['partner_trade_no'];
                $widthdraw_model->status = 1;
                $widthdraw_model->audit_description = $alipay_success_des;
                $widthdraw_model->finishtime = time();
                $widthdraw_model->save();
                $db->commit();
                return $result;
            }
            else
            {
                throw new Exception($result['msg']);
            }
        }
        catch (Exception $e)
        {
            $db->rollback();
            return array('status'=>false,'msg'=>$e->getMessage());
        }

    }
    public static function transfer_weixin($transfer_info)
    {
        //绑定支付的APPID
        $appid = Model_Sysconfig::get_configs(0,'cfg_wxpay_appid',true);
        //商户号
        $mchid = Model_Sysconfig::get_configs(0,'cfg_wxpay_mchid',true);
        //商户支付密钥
        $key = Model_Sysconfig::get_configs(0,'cfg_wxpay_key',true);
        //公众帐号secert
        $appsecret =  Model_Sysconfig::get_configs(0,'cfg_wxpay_appsecret',true);



        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $params["mch_appid"]= $appid;   //公众账号appid
        $params["mchid"]= $mchid;   //商户号 微信支付平台账号
        $params["nonce_str"]= mt_rand(100,999);   //随机字符串
        $params["partner_trade_no"] =$transfer_info['partner_trade_no'];           //商户订单号
        $params["amount"] = $transfer_info['amount'];          //金额
        $params["desc"]= $transfer_info['desc'];            //企业付款描述
        $params["openid"]= $transfer_info['openid'];          //用户openid
        $params["check_name"]= 'NO_CHECK';       //不检验用户姓名$
        $params['spbill_create_ip']= $_SERVER['SERVER_ADDR'];   //获取IP
        $str = 'amount='.$params["amount"].'&check_name='.$params["check_name"].'&desc='.$params["desc"].'&mch_appid='.$params["mch_appid"].'&mchid='.$params["mchid"].'&nonce_str='.$params["nonce_str"].'&openid='.$params["openid"].'&partner_trade_no='.$params["partner_trade_no"].'&spbill_create_ip='.$params['spbill_create_ip'].'&key='.$key;
        $sign = strtoupper(md5($str));
        $params["sign"] = $sign;//签名
        $xml = self::array_to_xml($params);
        $result =  self::weixin_curl_post_ssl($url, $xml);

        $xml_object = simplexml_load_string($result);
        try {
            if (empty($result) || empty($xml_object)) {
                throw new Exception('网络请求错误');
            }
            $return_code = (string)$xml_object->return_code;
            $return_msg = (string)$xml_object->return_msg;
            if($return_code!='SUCCESS')
            {
                throw new Exception($return_msg);
            }

            $result_code = (string)$xml_object->result_code;
            $err_code_des = (string)$xml_object->err_code_des;
            if($result_code!='SUCCESS')
            {
                throw new Exception($err_code_des);
            }
            return array('status'=>true);
        }
        catch (Exception $e)
        {
            return array('status'=>false,'msg'=>$e->getMessage());
        }



    }

    public static function array_to_xml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val)
        {
            if (is_numeric($val))
            {
                $xml .= "<".$key.">".$val."</".$key.">";
            }else
            {
                $xml .= "<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    public static function weixin_curl_post_ssl($url, $vars, $second=30)
    {

        $ext_dir = self::_get_ext_dir('wxpay');//微信文件所在路径
        $ssl_cert = $ext_dir . '/vendor/pc/wxpay/cert/apiclient_cert.pem';
        $sslkey = $ext_dir . '/vendor/pc/wxpay/cert/apiclient_key.pem';

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);

        curl_setopt($ch,CURLOPT_SSLCERT,$ssl_cert);
        curl_setopt($ch,CURLOPT_SSLKEY,$sslkey);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);

        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            return $data;
        }else {
            $error = curl_errno($ch);
            curl_close($ch);
            return false;
        }
    }
}