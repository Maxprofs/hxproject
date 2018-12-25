<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Class Model_Share_Weixin 微信分享公共模型
 */
class Model_Share_Weixin extends Model
{

    /**
     * 配置第三方登陆信息
     */
    public static function get_config()
    {
        $arr = DB::select()->from('sysconfig')->where("varname in('cfg_wx_share_appkey','cfg_wx_share_appsecret')")->execute()->as_array();
        foreach ($arr as $v)
        {
            if ($v['varname'] == 'cfg_wx_share_appkey')
            {
                $info['appid'] = $v['value'];
            }
            if ($v['varname'] == 'cfg_wx_share_appsecret')
            {
                $info['appsecret'] = $v['value'];
            }
        }
        return $info;
    }


    public static  function get_wx_noncestr()
    {
        $charStr='abcdefghijklmnopqrstuvwxyz123456789';
        $len=strlen($charStr)-1;
        $str='';
        for($i=0;$i<10;$i++)
        {
            $index=mt_rand(0,$len);
            $str.=$charStr[$index];
        }
        return $str;
    }

    public static function get_token($app_id, $app_secret)
    {
        $result = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$app_id}&secret={$app_secret}");
        if (!$result)
        {
            return false;
        }
        $result = json_decode($result, true);
        $access_token = $result['access_token'];
        if (!$access_token)
        {
            return false;
        }
        return $access_token;
    }

    public static function get_ticket($app_id, $app_secret)
    {
        $config = Kohana::$config->load('share_wx_client')->as_array();
        $now_tick = time();
        //  微信默认是7200过期, 减少调用频率和防止ticket失效设置为3600
        if ($config['ticket'] && ($now_tick - $config['ticket_tick']) <= 3600)
        {
            return $config['ticket'];
        }
        else
        {
            $access_token = self::get_token($app_id, $app_secret);
            $ticket_result = file_get_contents("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$access_token}&type=jsapi");
            $ticket_result = json_decode($ticket_result, true);
            $ticket = $ticket_result['ticket'];
            if ( !$ticket )
            {
                return false;
            }
            else
            {
                $path = SHAREWXCLIENT.'config/share_wx_client.php';
                $arr = array(
                    'ticket'        => $ticket,     // 票号
                    'ticket_tick'   => $now_tick,   // 票号写入时间戳
                );
                $content = "<?php defined('SYSPATH') or die('No direct script access.');\r\nreturn ". var_export($arr, 1).';';
                file_put_contents($path, $content);
                return $ticket;
            }
        }
    }


    public static function get_wx_share_default_info()
    {
        $rows = DB::select('varname', 'value')->from('sysconfig')
            ->where("varname in('cfg_wx_share_default_title','cfg_wx_share_default_litpic','cfg_wx_share_default_desc','cfg_webname','cfg_description','cfg_logo')")
            ->and_where('webid','=',0)
            ->execute()->as_array('varname', 'value');
        foreach($rows as $k=>$v)
        {
            $rows[$k] = Common::cutstr_html($v, 99999);
        }

        $rtn['title']   = $rows['cfg_wx_share_default_title'] ? $rows['cfg_wx_share_default_title']: $rows['cfg_webname'];
        $rtn['litpic']  = $rows['cfg_wx_share_default_litpic'];// ? $rows['cfg_wx_share_default_litpic']: $rows['cfg_logo'];
        $rtn['desc']    = $rows['cfg_wx_share_default_desc'] ? $rows['cfg_wx_share_default_desc']: $rows['cfg_description'];
        return $rtn;
    }
}