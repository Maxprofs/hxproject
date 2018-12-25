<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Zt_Channel_Coupon extends ORM
{

    //删除数据
    public function delete_clear()
    {
        $this->delete();
    }

    /**
     * @function 栏目信息
     * @param $channelid
     * @return mixed
     */
    public static function add_coupon($channelid,$couponids)
    {
        foreach($couponids as $id)
        {
            if(!self::check_is_exists($id,$channelid))
            {
                $data = array(
                    'channelid'=>$channelid,
                    'couponid'=>$id
                );
                $result = DB::insert('zt_channel_coupon',array_keys($data))->values(array_values($data))->execute();
            }
        }


    }

    /**
     * @function 检测优惠券是否添加
     * @param $productid
     * @param $typeid
     * @param $channelid
     * @return int
     */
    public static function check_is_exists($couponid,$channelid)
    {
        $row = DB::select('id')->from('zt_channel_coupon')
            ->where('channelid','=',$channelid)
            ->and_where('couponid','=',$couponid)
            ->execute()
            ->current();
        return $row['id'] ? 1 : 0;
    }


    /**
     * @function 获取专题栏目已设置的优惠券
     * @param $channelid
     * @param $page
     * @param $pagesize
     * @return array
     */
    public static function get_coupon($channelid,$page,$pagesize,$isadmin=0)
    {
        $offset = $pagesize*($page-1);
        $arr = DB::select()->from('zt_channel_coupon')
            ->where('channelid','=',$channelid)
            ->offset($offset)
            ->limit($pagesize)
            ->execute()
            ->as_array();
        $out = array();
        foreach($arr as $row)
        {
            $r = self::get_coupon_info($row['couponid'],$isadmin);
            array_push($out,$r);
        }
        return $out;
    }

    /**
     * @function 获取优惠券信息
     * @param $couponid
     * @return mixed
     */
    public static function get_coupon_info($couponid,$isadmin=0)
    {
        $l = DB::select()->from('coupon')->where('id','=',$couponid)->execute()->current();
        $modeldata = DB::select('kindname')->from('coupon_kind')->where('id','=',$l['kindid'])->execute()->current();


        $l['kindname'] = $modeldata['kindname'];
        if(!$isadmin)
        {

            $r = self::check_receive_status($l['id'], $l['totalnumber'], $l['maxnumber']);//是否可以领取
            $l['status'] = $r['status'];

        }

        if(!$l['isnever'])
        {
            $l['endtime']='永久有效';
        }
        else
        {
            $l['endtime']=date('Y-m-d H:i:s',$l['endtime']);
        }
        $l['typename'] = Model_Zt_Channel_Coupon::get_coupon_types($couponid);
        return $l;
    }

    /**
     * @function 获取栏目产品总量
     * @param $channelid
     * @return int
     */
    public static function get_total_num($channelid)
    {
        $t = DB::select()->from('zt_channel_coupon')->where('channelid','=',$channelid)->execute()->as_array();
        $total = count($t);
        return $total;
    }



    /**
     * @function 删除栏目里的产品
     * @param $id
     * @return object
     */
    public static function remove_coupon($id)
    {
        return DB::delete('zt_channel_coupon')->where('couponid','=',$id)->execute();
    }

    /**
     * @function 获取优惠券支持的类型
     * @param $couponid
     * @return string
     */
    public static function get_coupon_types($couponid)
    {
        $sql = "select distinct b.modulename from sline_coupon_pro as a  LEFT join sline_model as b on a.typeid=b.id WHERE a.cid=$couponid";
        $result = DB::query(1, $sql)->execute()->as_array();
        $typename = '';
        foreach ($result as $r) {
            $typename .= $r['modulename'] . ',';
        }
        $typename = rtrim($typename, ',');

        return $typename;
    }
    /** 判断优惠券的领取情况
     * @param $cid
     *
     * @param status 1,可以领取 2:已经领完 3：已经领取，待使用
     */
    public static function check_receive_status($cid, $totalnum = null, $maxnum = null)
    {
        if (!$totalnum || !$maxnum) {

            $data = DB::select('totalnumber','maxnumber')->from('coupon')->where('id', '=', $cid)->execute()->current();
            $totalnum = $data['totalnumber'];
            $maxnum = $data['maxnumber'];
        }
        $sql = " select count(*) as usernum  from sline_member_coupon where cid = $cid";
        $userdata = DB::query(1, $sql)->execute()->current();

        if (empty($userdata) || $userdata['usernum'] < $totalnum) {
            $status = '1';
            $surplus = $totalnum - $userdata['usernum'];//剩余数量
        } else {
            $status = '2';
            $surplus = 0;
        }
        if($status == '2')
        {
            return array('status' => $status, 'surplus' => $surplus);
        }

        //会员信息
        $userInfo = Product::get_login_user_info();
        if (!empty($userInfo)) {
            $sql = "select count(*) as totalnum from sline_member_coupon WHERE mid={$userInfo['mid']} and cid=$cid";
            $infodata = DB::query(1,$sql)->execute()->current();
            if ($infodata['totalnum'] >= $maxnum) {
                $status = 3;
                $surplus = $maxnum;
            }
        }
        return array('status' => $status, 'surplus' => $surplus);
    }






    



}