<?php

class Model_Coupon extends ORM
{

    public static function search_result($route_array, $p, $pagesize,$typeid=null,$proid=null,$kindid=1)
    {
        $time = time();
        $page = $p ? $p : 1;
        $w = '';
        if($typeid&&$proid)
        {
            $w = " and (typeid=0 or (find_in_set($typeid,modules) and typeid=1)  or  (typeid=9999 and id in (select cid from sline_coupon_pro WHERE typeid=$typeid and proid=$proid)))";
        }
        $total_sql = "select count(*) as num from sline_coupon WHERE isopen=1 and isdel=0 and kindid=$kindid and (endtime>'{$time}' or isnever=0) {$w}";
        $totalN = DB::query(1, $total_sql)->execute()->current();
        $totalNum = $totalN['num'] ? $totalN['num'] : 0;
        $offset = (intval($page) - 1) * $pagesize;
        $out_sql = "select a.*from sline_coupon as a  WHERE a.isopen=1  and a.isdel=0 and  a.kindid=$kindid and (a.endtime>'{$time}' or a.isnever=0) {$w}  order BY  displayorder limit $offset,$pagesize";
        $lists = DB::query(1, $out_sql)->execute()->as_array();
        foreach ($lists as &$l)
        {
            if ($l['typeid']==0)
            {
                $l['typename'] = '';
            }
            else
            {
                $l['typename'] = self::get_coupon_type($l['id'],$l);
            }
            $arr = self::check_receive_status($l['id'], $l['totalnumber'], $l['maxnumber']);//是否可以领取
            $l['status'] = $arr['status'];
            $l['surplus'] = $arr['surplus'];
            if ($l['isnever'] == 1)
            {
                $l['isout'] = self::check_is_out($l['endtime']);//是否即将要过期
                $l['starttime'] = date('Y-m-d', $l['starttime']);
                $l['endtime'] = date('Y-m-d', $l['endtime']);
            }
            if ($l['type'] == 1)
            {
                $l['amount'] = number_format($l['amount'] * 10 / 100, 1);
            }
            $gradename = self:: get_member_grade($l['memeber_grades']);
            $l['gradename_all'] = $gradename['gradename_all'];
            $l['gradename'] = $gradename['gradename'];
        }
        $out = array(
            'total' => $totalNum,
            'list' => $lists
        );
        return $out;
    }


    /**
     * 会员等级名称
     */
    public static function get_member_grade($memeber_grades)
    {
        if(!$memeber_grades)
        {
            return array('gradename_all'=>'','gradename'=>'');
        }
        $sql = "select `name` from sline_member_grade WHERE id in($memeber_grades) order by id ";
        $memeber_grades = DB::query(1,$sql)->execute()->as_array();
        $memeber_all_grades = DB::select('name')->from('member_grade')->execute()->as_array();
        if(count($memeber_all_grades)==count($memeber_grades))
        {
            return array('gradename_all'=>'','gradename'=>'');
        }
        $gradename_all = '';
        $gradename = '';
        $k=1 ;
        foreach($memeber_grades as $grade)
        {
            $gradename_all .= $grade['name'].'、';
            if($k==1)
            {
                $gradename .= $grade['name'];
            }
            $k++;
        }
        $gradename_all = rtrim($gradename_all, '、');
        return array('gradename_all'=>$gradename_all,'gradename'=>$gradename);

    }





    /**@function 获取优惠券的适用类型
     * @param $cid
     * @return string
     */
    private static function get_coupon_type($cid,$info)
    {
        if($info['typeid']==9999)
        {
            $sql = "select distinct b.modulename from sline_coupon_pro as a  LEFT join sline_model as b on a.typeid=b.id WHERE a.cid=$cid";
            $result = DB::query(1, $sql)->execute()->as_array();
            $typename = '';
            foreach ($result as $r)
            {
                $typename .= $r['modulename'] . ',';
            }
            $typename = rtrim($typename, ',');
        }
        else
        {

            $modules = $info['modules'];
            $modules = DB::select('modulename')->from('model')->where("id in ({$modules})")->execute()->as_array();
            $typename = '';
            foreach ($modules as $r)
            {
                $typename .= $r['modulename'] . ',';
            }
            $typename = rtrim($typename, ',');
        }

        return Common::cutstr_html($typename,18);
    }


    /** 判断优惠券的领取情况
     * @param $cid
     *
     * @param status 1,可以领取 2:已经领完 3：已经领取，待使用 4:会员等级不满足
     */
    public static function check_receive_status($cid, $totalnum = null, $maxnum = null)
    {
        $memeber_grades = DB::select('memeber_grades')->from('coupon')->where("id=$cid and isopen=1 and isdel=0")->execute()->get('memeber_grades');
        if(!$memeber_grades)
        {
            return array('status' => 2, 'surplus' => 0);
        }
        if (!$totalnum || !$maxnum)
        {

            $data = DB::select('totalnumber','maxnumber')->from('coupon')->where('id', '=', $cid)->execute()->current();
            $totalnum = $data['totalnumber'];
            $maxnum = $data['maxnumber'];
        }
        $sql = " select count(*) as usernum  from sline_member_coupon where cid = $cid";
        $userdata = DB::query(1, $sql)->execute()->current();
        if (empty($userdata) || $userdata['usernum'] < $totalnum)
        {
            $status = '1';
            $surplus = $totalnum - $userdata['usernum'];//剩余数量
        }
        else
        {
            $status = '2';
            $surplus = 0;
        }
        //会员信息
        $userInfo = Product::get_login_user_info();
        if (!empty($userInfo))
        {
            $sql = "select count(*) as totalnum from sline_member_coupon WHERE mid={$userInfo['mid']} and cid=$cid";
            $infodata = DB::query(1,$sql)->execute()->current();
            if ($infodata['totalnum'] >= $maxnum)
            {
                $status = 3;
                $surplus = $maxnum;
            }
            else
            {
                $member_rank = self::get_member_rank($userInfo['mid']);
                $memeber_grades = explode(',',$memeber_grades);
                if(!in_array($member_rank['id'],$memeber_grades))
                {
                    $status = 4;
                }
            }

        }
        return array('status' => $status, 'surplus' => $surplus);
    }


    /**
     * 会员等级
     * @param $memberId
     * @param array $param
     * @return array|int|string
     */
    public  static function get_member_rank($memberId)
    {
        $rank = DB::select()->from('member_grade')->order_by('begin', 'asc')->execute()->as_array();
        if(!empty($memberId))
        {
            $k = 0;
            //$member = DB::select('jifen')->from('member')->where("mid='{$memberId}'")->execute()->current();
            $member=DB::query(1,'select sum(jifen) as jifen from sline_member_jifen_log where memberid='.$memberId)->execute()->current();
            $range = array();
            foreach ($rank as $k => $v) {
                $range[] = $v['begin'];
            }
            $rangeLevel = count($range);
            if ($member['jifen'] < $range[0]) {
                $k = 0;
            } else if ($member['jifen'] > $range[$rangeLevel - 1]) {
                $k = $rangeLevel - 1;
            } else {
                foreach ($range as $k => $v) {
                    if ($member['jifen'] < $v) {
                        --$k;
                        break;
                    }
                }
            }
            $grade = $rank[$k];
            $grade['current'] = ++$k;
        }
        return $grade;
    }



    /**@function 判断是否即将过期 三天
     * @param $endtime
     * @return int 1 表示时间小于三天 2表示已经过期
     */
    public function check_is_out($endtime)
    {
        $flag = 0;
        $now_time = time();
        $dur = $endtime - $now_time;
        if($dur<0)
        {
            $flag = 2;

        }
        if ($dur>0 &&$dur < 259200) {
            $flag = 1;
        }

        return $flag;

    }

    /** @function 增加会员优惠券记录
     * @param $cid
     * @param $mid
     */

    public static function get_coupon($cid,$mid)
    {

        $flag = null;
        $flag=   DB::insert('member_coupon',array('mid','cid','totalnum','addtime'))->values(array($mid,$cid,1,time()))->execute();
        return $flag;

    }


    /**
     * 会员已经领取的优惠券信息
     */
    public static function  member_search_result($route_array, $p, $pagesize)
    {
        $time = time();
        $page = $p ? $p : 1;
        $offset = (intval($page) - 1) * $pagesize;
        $userInfo = Product::get_login_user_info();
        $mid = $userInfo['mid'];
        $w = " a.mid=$mid";
        switch($route_array['isout'])
        {
            case 1:
                $w .="  and  a.usenum < a.totalnum and (b.endtime>$time or b.isnever=0) ";//未使用
                break;
            case 2:
                $w .= " and (b.endtime<$time and b.isnever=1)";//已过期
                break;
            case 3:
                $w .= "  and  a.usenum=a.totalnum";//已使用
                break;
        }
        if($kindid=$route_array['kindid'])
        {
            $w .= " and b.kindid =$kindid ";
        }

        $total_sql = "select count(*) as num from sline_member_coupon as a  LEFT join  sline_coupon as b on a.cid=b.id  WHERE {$w}";
        $totalN = DB::query(1, $total_sql)->execute()->current();
        $totalNum = $totalN['num'] ? $totalN['num'] : 0;
        $out_sql = "select b.*,a.id as roleid,a.cid,a.mid,a.totalnum,a.usenum from  sline_member_coupon as a  LEFT join  sline_coupon as b on a.cid=b.id  WHERE {$w}  ORDER by a.usetime,b.isnever ,b.endtime desc  limit $offset,$pagesize";
        $lists = DB::query(1, $out_sql)->execute()->as_array();
        foreach ($lists as &$l) {
            if (!$l['typeid']) {
                $l['typename'] = '';
            } else {
                $l['typename'] = self::get_coupon_type($l['cid'],$l);
            }
            $arr = self::check_receive_status($l['id'], $l['totalnumber'], $l['maxnumber']);//是否可以领取
            $l['status'] = $arr['status'];
            $l['surplus'] = $arr['surplus'];
            if ($l['isnever'] == 1)
            {
                $l['isout'] = self::check_is_out($l['endtime']);//是否即将要过期
                $l['starttime'] = date('Y-m-d', $l['starttime']);
                $l['endtime'] = date('Y-m-d', $l['endtime']);
            }
            if ($l['type'] == 1) {
                $l['amount'] = number_format($l['amount'] * 10 / 100, 1);

            }
            $orderdata = DB::select('ordersn')->from('member_order_coupon')->where('roleid','=',$l['roleid'])->and_where('is_refund','=',0)->execute()->as_array();
            foreach($orderdata as $ordersn)
            {

                $check = DB::select()->from('member_order')->where("ordersn='{$ordersn['ordersn']}' and memberid='{$mid}'")->execute()->as_array();
                if($check)
                {
                    $l['ordersn'] = $ordersn['ordersn'];
                }
            }

        }
        $out = array(
            'total' => $totalNum,
            'list' => $lists
        );
        return $out;

    }

    /**@function 获取产品的优惠券信息
     * @param $typeid 产品模块ID
     * @param $proid 产品ID
     */
    public static function get_pro_coupon($typeid,$proid,$starttime=0)
    {

        $tpltime = $starttime;
        $time = time();
        $userInfo = Product::get_login_user_info();
        if(empty($userInfo))
        {
            return false;
        }
        $mid = $userInfo['mid'];
        $out = array();
        //获取该用户已经领取的所有未使用的优惠券
        $sql = "select * from sline_member_coupon WHERE mid=$mid and usenum=0";
        $list  = DB::query(1,$sql)->execute()->as_array();
        $couponlist = array();
        foreach($list as $key=>$l)
        {
            $w = "id={$l['cid']}  ";
            $sql = "select * from sline_coupon WHERE {$w}";
            $tpl = DB::query(1,$sql)->execute()->current();
            $tpl['roleid'] =  $l['id'];
            $couponlist[] = $tpl;
        }
        foreach($couponlist as $couponinfo)
        {
            //提前天数判断
            if($couponinfo['antedate']>0&&$tpltime>0)
            {
                $starttime = strtotime($tpltime);
                $flagtime = strtotime(date('Y-m-d',time()));
                $flag =  ($starttime-$flagtime)/(24*60*60);
                if($flag<$couponinfo['antedate'])
                {
                    continue;
                }
            }
            //使用时间是否满足要求
            if($couponinfo['isnever']==1)
            {

                if($couponinfo['endtime']<$time||$couponinfo['starttime']>$time)
                {
                    continue;
                }
                $couponinfo['endtime'] = date('Y-m-d',$couponinfo['endtime']);
                $couponinfo['starttime'] = date('Y-m-d',$couponinfo['starttime']);
            }
            //指定产品
            if($couponinfo['typeid']==9999)
            {
                $check = DB::select('id')->from('coupon_pro')->where("cid={$couponinfo['id']} and proid=$proid and typeid=$typeid")->execute()->current();
                if(empty($check))
                {
                    continue;
                }
                $couponinfo['typename'] = self::get_coupon_type($couponinfo['id'],$couponinfo);
            }
            //知道产品类
            if($couponinfo['typeid']==1)
            {
                $couponinfo['typename'] = self::get_coupon_type($couponinfo['id'],$couponinfo);
                if(!in_array($typeid,explode(',',$couponinfo['modules'])))
                {
                    continue;
                }

            }
            //金额比的时候计算金额
            if ($couponinfo['type'] == 1) {
                $couponinfo['amount'] = number_format($couponinfo['amount'] * 10 / 100, 1);
            }
            $out[] = $couponinfo;
        }
        return $out;
    }

    /**
     * @param $roleid  会员领取优惠券之后的id
     * @param $totalprice
     * @param $typeid
     * @param $proid
     * @return array
     */
    public  static function check_samount($roleid,$totalprice,$typeid,$proid,$starttime=0)
    {

        $status = 0;

        //获取会员改产品可以使用的优惠券
        $out =  self::get_pro_coupon($typeid,$proid,$starttime);

        if(empty($out))
        {
            return array('status'=> $status) ;
        }

        $roleids = array();
        foreach($out as $o)
        {
            $roleids[] = $o['roleid'];
        }

        if(!in_array($roleid,$roleids))
        {
            return array('status'=> $status) ;
        }

        //检查该优惠券是否使用
        $conponid = DB::select('cid')->from('member_coupon')->where("id=$roleid and usenum=0")->execute()->current();
        if(empty($conponid))
        {
            return array('status'=> $status) ;
        }

        $cid = $conponid['cid'];

        $couponinfo = DB::select('samount','amount','type','antedate','starttime')->from('coupon')->where("id=$cid")->execute()->current();
        //金额是否满足
        if($totalprice>=Currency_Tool::price($couponinfo['samount']))
        {
            $status = 1;
            if($couponinfo['type']==1)
            {

                $totalprice = floatval($totalprice*$couponinfo['amount']/100);

            }
            else
            {

                $totalprice = floatval($totalprice-Currency_Tool::price($couponinfo['amount']));

            }


        }
        if($totalprice<0)
        {
            $status = 0;
        }
        return array('status'=>$status,'totalprice'=>$totalprice);


    }

    /** 添加订单与优惠券信息
     * @param $croleid 会员领取之后产生的ID
     * @param $orderSn
     */
    public function add_coupon_order($cid,$orderSn,$totalprice,$ischeck,$croleid)
    {
        $cmoney = $totalprice - $ischeck['totalprice'];
        DB::insert('member_order_coupon',array('cid','ordersn','cmoney','roleid'))->values(array($cid,$orderSn,$cmoney,$croleid))->execute();
        DB::update('member_coupon')->set(array('usetime'=>time(),'usenum'=>1))->where('id','=',$croleid)->execute();
    }


    /** 计算订单金额
     * @param $rs
     * @return float
     */
    public  function get_order_totalprice($rs)
    {

        $num = $rs['dingnum'] + $rs['childnum'] + $rs['oldnum'];

        //全额支付
        $total = $rs['dingnum'] * $rs['price'] + $rs['childnum'] * $rs['childprice'] + $rs['oldnum'] * $rs['oldprice'];


        //保险
        if ($rs['typeid'] == 1)
        {
            $sql = "select bookordersn,insurednum,payprice from sline_insurance_booking where bookordersn='{$rs['ordersn']}'";
            $insurance = DB::query(Database::SELECT, $sql)->execute()->as_array();
            //叠加保险金额
            foreach ($insurance as $v)
            {
                if (!empty($v['insurednum']))
                {
                    $total += $v['payprice'];
                }
            }

            if ($rs['roombalance_paytype'] == 1)
            {
                $balanceTotal = doubleval($rs['roombalance'] * intval($rs['roombalancenum']));
                $total += $balanceTotal;
            }
        }

        //总价
        $rs['total_fee'] = $total;
        //积分抵现
       /* if (intval($rs['usejifen']) === 1)
        {
            $total = $total - $rs['jifentprice'];
        }*/
        return $total;

    }


    /**
     * @function 订单详情显示优惠券信息
     *
     * @return mixed
     */
    public static function order_view($ordersn)
    {
        if(!$ordersn)
        {
            return false;
        }

        $sql = "select a.cmoney ,b.name from sline_member_order_coupon as a LEFT JOIN sline_coupon as b on a.cid=b.id WHERE a.ordersn ='$ordersn' ";

        return DB::query(1,$sql)->execute()->current();


    }


    /**@function 手机版产品详情页获取当前产品是否满足优惠券使用条件
     * @param $typeid 产品类型
     * @param $productid 产品ID
     * @return array
     */
    public static function get_mobile_coupon_info($typeid,$productid)
    {
        $info = array();
        $time = time();
        $sql = "select type,amount from sline_coupon WHERE kindid=1 and isopen=1 and isdel=0 and (typeid=0 or (find_in_set($typeid,modules) and typeid=1) or (typeid=9999 and id in
(select cid from sline_coupon_pro WHERE typeid=$typeid and proid=$productid))) and (isnever=0 or (starttime<$time and endtime>$time)) order by displayorder";
        $result = DB::query(1,$sql)->execute()->as_array();
        $totalnum = count($result);
        foreach($result as  $key=>$r)
        {
            if($key<3)
            {
                if($r['type']==1)
                {
                    $price[] = number_format($r['amount'] * 10 / 100, 1).'折';
                }
                else
                {
                    $price[] = $r['amount'].'元';

                }
            }
        }
        $info['totalnum'] = $totalnum;
        $info['price'] = $price;
        return  $info;
    }


    /**
     * 封装返回的数据  手机端使用
     */
    public static function get_data($list)
    {
        foreach($list as &$val)
        {
            switch($val['typeid'])
            {
                case 0:
                    $val['typename'] = '无品类限制';
                    break;
                case 1:
                    $val['typename'] .= '产品可用';
                    break;
                case 9999:
                    $val['typename'] .= '部分产品可用';
                    break;
            }
            if($val['type']==1)
            {
                $val['amount'] .= '折';
            }
            $val['gradename_all'] = Common::cutstr_html($val['gradename_all'].'领取',16);
            $val['typename'] = Common::cutstr_html($val['typename'],12);
        }
        return $list;
    }


    /**取消订单返回优惠券
     * @param $ordersn
     */
    public static function cancel_order_back($ordersn)
    {
        $order_coupon = DB::select()->from('member_order_coupon')->where('ordersn','=',$ordersn)->execute()->current();
        if($order_coupon)
        {
            DB::update('member_order_coupon')->where('id','=',$order_coupon['id'])->set(array('is_refund'=>1))->execute();
            DB::update('member_coupon')->set(array('usenum'=>0,'usetime'=>0))->where('id','=',$order_coupon['roleid'])->execute();
        }
    }



    /**
     * @param $where
     * @param $typeid
     * @return array
     */
    public static function get_search_left_nav($where,$product_list)
    {


        $where = " typeid NOT IN(7,10,11,12,14) AND ishidden=0 and {$where}";
        $allnum = DB::query(1,"SELECT count(*) as num FROM `sline_search` where {$where}")->execute()->get('num');
        $out = array();
        $out[] = array('channelname'=>'全部','num'=>$allnum,'typeid'=>0);
        $arr =array();
        if(is_array($product_list))
        {
            foreach($product_list as $product)
            {
                if(!in_array($product['typeid'],$arr))
                {

                    $arr[] = $product['typeid'];
                }
            }
        }
        else
        {
            $arr = explode(',',$product_list);
        }

        foreach($arr as $row)
        {
            $wh ="where $where and typeid = '$row' and ishidden=0";

            $sql = "SELECT count(*) as num FROM `sline_search` $wh";
            $num = DB::query(1,$sql)->execute()->get('num');
            $num = $num>0 ? $num : 0;
            if($num>0)
            {
                $modulename = DB::select('modulename')->from('model')->where("id=$row")->execute()->get('modulename');
                $out[] = array('channelname'=>$modulename,'num'=>$num,'typeid'=>$row['id']);
            }
        }
        return $out;

    }


    /**
     *
     * 产品搜索页
     * @param $params
     * @param $where
     * @param $page
     * @param $pagesize
     * @return array
     */
    public static function search_search_result($params,$where,$page,$pagesize)
    {
        $page = $page ? $page : 1;
        $offset = (intval($page)-1)*$pagesize;
        $sql = "SELECT a.* FROM `sline_search` a ";
        $sql.= "WHERE  a.ishidden=0 and {$where} ";
        //选择了栏目
        if($params['typeid'])
        {
            $sql.=" AND a.typeid='{$params['typeid']}' ";
        }
        $sql.= "ORDER BY a.typeid ASC ";
        //计算总数
        $totalSql = "SELECT count(*) as dd ".strchr($sql," FROM");
        $totalSql = str_replace(strchr($totalSql,"ORDER BY"),'', $totalSql);//去掉order by
        $totalN = DB::query(1,$totalSql)->execute()->as_array();
        $totalNum = $totalN[0]['dd'] ? $totalN[0]['dd'] : 0;
        $sql.= "LIMIT {$offset},{$pagesize}";
        $arr = DB::query(1,$sql)->execute()->as_array();
        foreach($arr as &$v)
        {
            $module_info = $row = ORM::factory('model',$v['typeid'])->as_array();
            $typeid = $v['typeid']<10 ? '0'.$v['typeid'] : $v['typeid'];
            $v['label'] = $module_info['modulename'];//标签
            $v['producttitle'] = $v['title'];//标题
            $v['series'] = Product::product_number($v['tid'], $typeid);//编号
            $v['url'] = self::get_product_url($v['typeid'],$v['aid'],$v['webid']);//地址
        }
        $out = array(
            'total' => $totalNum,
            'list' => $arr
        );
        return $out;
    }

    /**
     * @param $typeid
     * @param $aid
     * @param $pinyin
     * @param $webid
     * @return string
     * 获取产品地址
     */
    private static function get_product_url($typeid,$aid,$webid)
    {
        $module = ORM::factory('model',$typeid);
        $pinyin = $module->pinyin;
        $correct = $module->correct;
        $py = empty($correct)?$pinyin:$correct;//($typeid>17 || $typeid==8 || $typeid==13) ? $pinyin : $correct;
        $url = Common::get_web_url($webid);
        $url.="/$py/show_{$aid}.html";
        return $url;
    }


    /**
     * @function 获取积分商城详情
     * @param $cid
     */
    public static function get_integral_info($cid,$memberid)
    {
        $info = DB::select()->from('coupon')->where("isdel=0 and isopen=1 and id=$cid")->execute()->current();

        $sql = "select count(*) as num from sline_member_coupon WHERE cid=$cid";
        $getnum =DB::query(1,$sql)->execute()->get('num');
        $info['leftnum'] = ($info['maxnumber'] - $getnum)>0 ? ($info['maxnumber'] - $getnum) :0 ;
        $info['litpic']  = $GLOBALS['cfg_basehost'].'/plugins/coupon/public/images/integral.jpg';
        if ($info['type'] == 1)
        {
            $info['amount'] = number_format($info['amount'] * 10 / 100, 1);
        }
        if ($info['isnever'] == 1)
        {
            $info['isout'] = self::check_is_out($info['endtime']);//是否即将要过期
            $info['starttime'] = date('Y-m-d', $info['starttime']);
            $info['endtime'] = date('Y-m-d', $info['endtime']);
        }
        $gradename = self:: get_member_grade($info['memeber_grades']);
        $info['gradename_all'] = $gradename['gradename_all'];
        if ($info['typeid']==0)
        {
            $l['typename'] = '';
        }
        else
        {
            $info['typename'] = self::get_coupon_type($info['id'],$info);
        }
        return $info;
    }



}