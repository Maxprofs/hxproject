<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Standard_Login extends Controller_Pc_Api_Base
{

    public function before()
    {
        parent::before();
    }

    //根据手机验证码登陆
    public function action_login_by_code()
    {
        $mobile = St_Filter::remove_xss($this->request_body->content->mobile);
        $code = St_Filter::remove_xss($this->request_body->content->checkcode);
        $openid = St_Filter::remove_xss($this->request_body->content->openid);
        $secret_code = St_Filter::remove_xss($this->request_body->content->secret_code);
        //返回的会员id
        $mid = 0;
        $msg = array();
        if($mobile && $code)
        {
            $msg[] = 'has mobile and code';
            if($this->verify_code($code,$mobile,$secret_code))
            {
                $msg[] = 'checkcode ok';
                //检测是否存在
                $row = DB::select('mid')->from('member')->where('mobile','=',$mobile)->execute()->as_array();
                if($row[0]['mid']>0)
                {
                    $mid = $row[0]['mid'];
                }
                //如果不存在,则自动注册
                else
                {
                    $mid = St_Product::auto_reg($mobile);

                }
                //检测是否绑定微信第三方
                if($openid)
                {
                    $ar = DB::select()->from('member_third')->where('mid','=',$mid)->execute()->as_array();
                    if(empty($ar[0]['mid']))
                    {
                        $data = array(
                            'mid' => $mid,
                            'openid' => $openid,
                            'from' => 'weixin'
                        );
                        DB::insert('member_third',array_keys($data))->values(array_values($data))->execute();
                    }
                }


            }
            if($mid)
            {
                $result = array(
                    'status' => true,
                    'mid' => $mid
                );
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
            }
            else
            {
                $msg[] = 'checkcode false';


                $this->send_datagrams($this->client_info['id'], $msg, $this->client_info['secret_key']);
            }

        }
    }

    //根据微信openid 获取会员mid
    public function action_get_member_by_weixin()
    {
        $openid = Common::remove_xss($this->request_body->content->openid);
		$wxuid = Common::remove_xss($this->request_body->content->wxuid);
		$wxuid = $wxuid ? $wxuid : -1;
        $mid = 0;
        if(!empty($openid))
        {
            // $ar = DB::select()->from('member_third')->where('openid','=',$openid)->execute()->as_array();
            $sql = "SELECT t.mid,m.mobile FROM sline_member_third t INNER JOIN sline_member m  on(t.mid = m.mid) WHERE t.openid='{$openid}' LIMIT 1" ;
            $ar = DB::query(Database::SELECT, $sql)->execute()->as_array();

            if(!empty($ar[0]['mid']))
            {
                $mid = $ar[0]['mid'];
				$mobile = $ar[0]['mobile'];
            }
        }
        $result = array(
            'status' => true,
            'mid' => $mid,
			'mobile' => $mobile ,
        );
        $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);



    }
	//获取当前用户的手机号码
	public function action_getPhone()
	{	
		//require_once dirname(dirname(__FILE__)) . "/xcx/wxBizDataCrypt.php";
		include_once  BASEPATH . "/plugins/api/vendor/xcx/wxBizDataCrypt.php"; 
		
		$appid = Common::remove_xss($this->request_body->content->appid);
		$sessionKey = Common::remove_xss($this->request_body->content->sessionKey);
		$encryptedData = Common::remove_xss($this->request_body->content->encryptedData);
		$iv = Common::remove_xss($this->request_body->content->iv);
		
		$pc = new WXBizDataCrypt($appid, $sessionKey);
		$errCode = $pc->decryptData($encryptedData, $iv, $data );

		
		$this->send_datagrams($this->client_info['id'], array('data' => $data , 'errCode'=>$errCode), $this->client_info['secret_key']);
	}
	//手机号码登录
	public function action_login_by_phone()
	{
		$mobile = St_Filter::remove_xss($this->request_body->content->mobile);       
        $openid = St_Filter::remove_xss($this->request_body->content->openid);
   
        //返回的会员id
        $mid = 0;
        $msg = array();
        if($mobile)
        {
            
			//检测是否存在
			$row = DB::select('mid')->from('member')->where('mobile','=',$mobile)->execute()->as_array();
			if($row[0]['mid']>0)
			{
				$mid = $row[0]['mid'];
			}
			//如果不存在,则自动注册
			else
			{
				$mid = St_Product::auto_reg($mobile);

			}
			//检测是否绑定微信第三方
			if($openid)
			{
				$ar = DB::select()->from('member_third')->where('mid','=',$mid)->execute()->as_array();
				if(empty($ar[0]['mid']))
				{
					$data = array(
						'mid' => $mid,
						'openid' => $openid,
						'from' => 'weixin'
					);
					DB::insert('member_third',array_keys($data))->values(array_values($data))->execute();
				}
			}
            
            if($mid)
            {
                $result = array(
                    'status' => true,
                    'mid' => $mid
                );
                $this->send_datagrams($this->client_info['id'], $result, $this->client_info['secret_key']);
            }
            else
            {
                $msg[] = 'checkcode false';
                $this->send_datagrams($this->client_info['id'], $msg, $this->client_info['secret_key']);
            }
		}
	}
	
    /**
     * @function 检测验证码是否正确
     * @param $code
     * @param $mobile
     * @return int
     */
    private function verify_code($code,$mobile,$secret_code)
    {
        $code = md5($code.$mobile);
        return $code == $secret_code ? 1 : 0;
    }
	
	


}