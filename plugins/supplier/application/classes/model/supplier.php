<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Supplier extends ORM
{
    //对应数据库
    protected $_table_name = 'supplier';
    protected $_primary_key = 'id';

    private $_qualify_type = array(
        '1' => 'card',
        '2' => 'certificate',
        '3' => 'license'
    );

    /*
     * 新增用户
     * @param array $data
     * return mixed
     */
    public static function register($data)
    {
        //数据验证
        //检查账号
        $user = self::supplier_find($data['account'], null, false);
        if (!empty($user))
        {
            return __('error_member_exists');
        }
        //添加
        if (stripos($data['account'], '@') === false)
        {
            $data['mobile'] = $data['account'];
        } else
        {
            $data['email'] = $data['account'];
        }
        $data['addtime'] = time();
        $result = DB::insert('supplier', array_keys($data))->values(array_values($data))->execute();
        return $result[1] > 0 ? $result : __('error_member_insert');
    }

    /*
     * 密码找回
     * @param array $data
     * return mixed
     */
    public static function findpass($data)
    {
        //数据验证
        //检查账号
        $user = self::supplier_find($data['account'], null, false);
        if (empty($user))
        {
            return __('error_member_not_exists');
        }
        //修改
        $updateArr = array('password' => $data['password']);
        $whereStr = "account='{$data['account']}' or mobile='{$data['account']}' or email='{$data['account']}'";
        DB::update('supplier')->set($updateArr)->where($whereStr)->execute();
        return 1;
    }

    /**
     * @param $loginname
     * @param $loginpwd
     * @param $hasencode 密码是否已加密
     */
    public static function login($loginname, $loginpwd, $hasencode)
    {
        $user = self::supplier_find($loginname, $loginpwd, $hasencode);
        if ($user)
        {
            //写登陆信息
            self::write_cookie('st_supplier_name', $user['suppliername']);
            self::write_cookie('st_supplier_id', $user['id']);
            self::save_login_time($user['id']);

        }
        return $user;
    }

    /*
     * 退出登陆
     * */
    public static function login_out()
    {
        Cookie::delete('st_supplier_name');
        Cookie::delete('st_supplier_id');
    }

    /*
     * 保存登陆时间
     * */
    public static function save_login_time($id)
    {
        $m = ORM::factory('supplier', $id);
        $m->logintime = time();
        $m->save();
    }

    /*
     * 查找用户
     * @param string $account 用户账号
     * return array
     */
    public static function supplier_find($account, $pwd = null, $hasencode)
    {

        $where = "(account='{$account}' or mobile='$account' or email='$account')";
        if (!is_null($pwd))
        {
            $pwd = $hasencode ? $pwd : md5($pwd);
            $where .= " and password='" . $pwd . "'";
        }

        $result = DB::select()->from('supplier')->where($where)->execute()->as_array();
        if (!empty($result))
        {
            $result = $result[0];
        }
        return $result;
    }

    /**
     * 根据会员id获取用户信息
     * @param $mid
     * @return array
     */
    public static function get_supplier_byid($supplierid)
    {
        if ($supplierid)
        {
            $memberinfo = ORM::factory('supplier', $supplierid)->as_array();
            $memberinfo['supplierkind'] = ORM::factory('supplier_kind', $memberinfo['kindid'])->get('kindname');
            return $memberinfo;
        }

    }

    public static function get_authorization_product_list()
    {
        $product_list =  ORM::factory('model')->where('isopen=1 and id not in(4,6,7,10,11,14)')->get_all();
        foreach($product_list as $k=>$v)
        {
            $pinyin = $v['maintable']=='model_archive'?'common':$v['pinyin'];
            if((!St_Functions::is_system_app_install($v['id']) || !St_Functions::is_normal_app_install('supplier'.$pinyin.'manage')) && $v['maintable']!="model_archive")
            {
                unset($product_list[$k]);
            }
            if( $v['maintable']=="model_archive" && !St_Functions::is_normal_app_install('supplier'.$pinyin.'manage'))
            {
                unset($product_list[$k]);
            }
        }
        return $product_list;
    }

    /**
     * 写入session
     * @param $member 会员详细信息
     * @param $user
     */
    public static function write_session($member, $user = null)
    {

    }

    /*
     * 登陆cookie信息设置
     * */
    public static function write_cookie($key, $value)
    {

        Cookie::set($key, $value);
    }

    /**
     * @param $loginname
     * @return bool
     */
    public static function check_supplier_exist($loginname)
    {

        $where = "account='{$loginname}'";
        $result = DB::select()->from('supplier')->where($where)->execute()->as_array();
        $flag = false;
        if (!empty($result))
        {
            $flag = true;
        }
        return $flag;
    }

    /**
     * 数据修改
     * @param $updateArr
     * @param $whereStr
     * @param $tabName
     * @return object
     */
    public static function update_field_by_where($updateArr, $whereStr, $tabName)
    {
        return DB::update($tabName)->set($updateArr)->where($whereStr)->execute();
    }

    /**
     * 手机版本需要功能.
     */
    /**
     * @param $token
     * @return mixed
     * 根据token登陆
     */

    public static function login_by_token($token)
    {

        $sql = "SELECT * FROM `sline_supplier` where md5(concat(account,password))='$token'";
        $user = DB::query(1, $sql)->execute()->current();
        if ($user)
        {
            //写登陆信息

            self::write_cookie('st_supplier_name', $user['suppliername']);
            self::write_cookie('st_supplier_id', $user['id']);
            //self::write_cookie('st_supplier_account_id',$user['id']);

        }
        return $user;
    }

    /**
     * @function 供应商css
     * @param $file
     * @param $plugin
     * @param bool $min_css
     * @return string
     */
    public static function css($file, $plugin = '', $min_css = true)
    {
        $out = '';
        $plugin = $plugin ? "_{$plugin}" : '';
        $file = explode(',', $file);
        $link_file = array();
        foreach ($file as $item)
        {
            $original = realpath(BASEPATH . "plugins/supplier{$plugin}/public/css/" . $item);
            if ($original)
            {
                array_push($link_file, "/plugins/supplier{$plugin}/public/css/{$item}");
            }
        }
        if (!empty($link_file))
        {

            if ($min_css)
            {
                $f = implode(',', $link_file);
                $cssUrl = '/min/?f=' . $f;
                $out = '<link type="text/css" href="' . $cssUrl . '" rel="stylesheet"  />' . "\r\n";
            }
            else
            {
                foreach ($link_file as $css)
                {
                    $out .= '<link type="text/css" href="' . $css . '" rel="stylesheet"  />' . "\r\n";
                }
            }
        }
        return $out;
    }


    public static function getLastAid($tablename, $webid = 0)
    {
        $aid = 1;//初始值
        $sql = "select max(aid) as aid from {$tablename} where webid=$webid order by id desc";
        $row = DB::query(1, $sql)->execute()->as_array();
        if (is_array($row))
        {
            $aid = $row[0]['aid'] + 1;
        }
        return $aid;
    }

    /*
   //扩展字段信息保存
  * */
    public static function saveExtendData($typeid, $productid, $info)
    {
        //$table = self::$extend_table_arr[$typeid];
        $table = self::getExtendTable($typeid);
        $extendinfo = array();
        $columns = array('productid');
        $values = array($productid);
        foreach ($info as $k => $v)
        {
            if (preg_match('/^e_/', $k)) //找出所有扩展字段设置
            {
                $extendinfo[$k] = $v;
                $columns[] = $k;
                $values[] = $v;
            }
        }
        if (count($extendinfo) > 0)
        {
            $sql = "select count(*) as num from $table where productid='$productid'";
            $row = DB::query(1, $sql)->execute()->as_array();
            //optable
            $optable = str_replace('sline_', '', $table);
            if ($row[0]['num'] > 0)//已存在则更新
            {
                DB::update($optable)->set($extendinfo)->where("productid='$productid'")->execute();
            }
            else
            {
                DB::insert($optable)->columns($columns)->values($values)->execute();
            }
        }
    }

    /*
     * 获取扩展表
     * */
    public static function getExtendTable($typeid)
    {
        $row = ORM::factory('model', $typeid)->as_array();
        return 'sline_' . $row['addtable'];
    }

    /**
     * @function 获取属性列表
     * @param $table
     * @param $attrid_str
     * @param string $separator
     * @return string
     */
    public static function get_attr_name($table, $attrid_str, $separator = ',')
    {
        if (!$attrid_str)
        {
            return '';
        }
        $attr_arr = array();
        $result = DB::select()->from($table)->where('id', 'in', DB::expr('(' . $attrid_str . ')'))->execute()->as_array();
        foreach ($result as $item)
        {
            array_push($attr_arr, $item['attrname']);
        }
        return implode($separator, $attr_arr);
    }

    public static function getBaseUrl($webid)
    {
        $web = DB::select()->from('destinations')->where('id', '=', $webid)->execute()->current();
        return $web ? $web['weburl'] : '';
    }

    public static function getSeries($id, $prefix)
    {
        $ar = array(
            '01' => 'A',
            '02' => 'B',
            '05' => 'C',
            '03' => 'D',
            '08' => 'E',
            '13' => 'G',
            '14' => 'H',
            '15' => 'I',
            '16' => 'J',
            '17' => 'K',
            '18' => 'L',
            '19' => 'M',
            '20' => 'N',
            '21' => 'O',
            '22' => 'P',
            '23' => 'Q',
            '24' => 'R',
            '25' => 'S',
            '26' => 'T'
        );
        $prefix = $ar[$prefix];
        $len = strlen($id);
        $needlen = 4 - $len;
        if ($needlen == 3)
            $s = '000';
        else if ($needlen == 2)
            $s = '00';
        else if ($needlen == 1)
            $s = '0';
        $out = $prefix . $s . "{$id}";
        return $out;
    }

    public static  function page($count,$pageno,$pagesize,$url,$disnum=5,$url1)  //分页函数
    {
        $title_arr=array(
            'firstpage'=>'',
            'prepage'=>'',
            'lastpage'=>'',
            'nextpage'=>''
        );

        if($count==0)
            return '';

        $page=ceil($count/$pagesize);
        $str.='<div class="page">
		';

        //前一页按钮2
        if($pageno<=1)
            $str.='<span class="pageOff firstpage">'.$title_arr['firstpage'].'</span> <span class="pageOff prepage">'.$title_arr['prepage'].'</span> ';
        else
        {
            $pre_pageno=$pageno-1;
            $nurl=$pre_pageno==1?$url1:str_replace('{page}',$pre_pageno,$url);
            $str.="<a class='pageOff firstpage' href='$url1'>".$title_arr['firstpage']."</a> <a class='pageOff prepage' href='$nurl'>".$title_arr['prepage']."</a> ";
        }
        //计算页起始页和结束页
        if($page>=$disnum)
        {
            $pre_num=ceil(($disnum-1)/2);
            $next_num=floor(($disnum-1)/2);
            if($pre_num>=$pageno)
            {
                $start_index=1;
                $end_index=$disnum;
            }
            else
            {
                $start_index=$pageno-$pre_num;
                $end_index=$pageno+$next_num;
            }
            if($end_index>=$page)
            {
                $start_index=$page-$disnum;
                $end_index=$page;
            }
        }
        else
        {
            $start_index=1;
            $end_index=$page;
        }

        //前置省略页面
        if($start_index>1)
            $str.='<span class="pageOff pagenum">...</span> ';


        $start_index=$start_index<1?1:$start_index;
        //实现
        for($i=$start_index;$i<=$end_index;$i++)
        {
            if($pageno==$i)
            {
                $str.="<span class='pageCurrent pagenum'>$i</span> ";
            }
            else
            {
                $burl=$i==1?$url1:str_replace('{page}',$i,$url);;
                $str.="<a class='pageOff pagenum' href='$burl'>{$i}</a> ";
            }
        }

        //后置省略页面
        if($end_index<$page)
            $str.='<span class="pageOff pagenum">...</span> ';


        //下一页按钮
        if($pageno==$page)
        {
            $str.='<span class="pageOff nextpage">'.$title_arr['nextpage'].'</span> <span class="pageOff lastpage">'.$title_arr['lastpage'].'</span> ';
        }
        else
        {
            $next_pageno=($pageno+1)<=$page?$pageno+1:$page;
            $nurl=str_replace('{page}',$next_pageno,$url);
            $lasturl=str_replace('{page}',$page,$url);
            $str.="<a href=\"{$nurl}\" class=\"pageOff nextpage\">".$title_arr['nextpage']."</a> <a href=\"{$lasturl}\" class=\"pageOff lastpage\">".$title_arr['lastpage']."</a> ";
        }
        $str.="<span class='pageContent'>(总计<span class='pageTotal'>{$page}</span>页<span class='numTotal'>{$count}</span>条记录)</span></div>";
        return $str;
    }
}