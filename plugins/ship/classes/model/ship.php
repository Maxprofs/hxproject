<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/6 0006
 * Time: 18:25
 */
class Model_Ship extends ORM
{
    public static function get_supplier_list($param)
    {
        $default = array(
            'row' => '10',
            'offset' => 0
        );
        $param = array_merge($default, $param);
        extract($param);

        $sql = "select a.* from sline_supplier a inner join sline_ship b on a.id=b.supplierlist group by a.id order by a.displayorder limit {$offset},{$row}";
        $list = DB::query(Database::SELECT, $sql)->execute()->as_array();
        return $list;

    }

    /**
     * 获取游轮信息
     * @param $shipId
     * @param string $field
     * @return null
     */
    public static function get_ship($shipId, $field = '*')
    {
        $result = DB::select($field)->from('ship')->where('id', '=', $shipId)->execute()->current();
        if (!$result)
        {
            return null;
        }
        if ($field != '*')
        {
            return $result[$field];
        }
        return $result;
    }

    /**
     * 获取游轮公司信息
     * @param $shipId
     * @param string $field
     * @return null
     */
    public static function get_ship_supplier($shipId, $field = '*')
    {
        $ship = DB::select('supplierlist')->from('ship')->where('id', '=', $shipId);
        $query = DB::select()->from('supplier')->where('id', 'in', $ship);
        $result = $query->execute()->current();
        if (!$result)
        {
            return null;
        }
        if ($field != '*')
        {
            return $result[$field];
        }
        return $result;
    }

    /**
     * 获取线路航线
     * @param $lineId
     * @param null $day
     * @return array
     */
    public static function get_ship_suite($lineId, $day)
    {
        $data = array();
        $suit_mini = array();
        //线路详情
        $info = DB::select('shipid', 'scheduleid', 'islinebefore', 'linebefore')->from('ship_line')->where('id', '=', $lineId)->execute()->current();

        $suitids = self::get_useful_suitids($lineId);


        //套餐
       // $obj = DB::select()->from('ship_line_suit_price')->where('lineid', '=', $lineId)->and_where('shipid', '=', $info['shipid'])->and_where('suitid','in',$suitids)->and_where('scheduleid', '=', $info['scheduleid']);
      //  $obj = $obj->and_where('day', '=', $day);
      // $suit_price = $obj->execute()->as_array();

        $suitids_str= implode(',',$suitids);
        $sql_price = "select * from sline_ship_line_suit_price  where lineid='{$lineId}' and  shipid='{$info['shipid']}' and  suitid in ({$suitids_str}) and  scheduleid='{$info['scheduleid']}' and day='{$day}' and dateid in (select id from sline_ship_schedule_date where scheduleid='{$info['scheduleid']}')";
        $suit_price = DB::query(Database::SELECT,$sql_price)->execute()->as_array();

        if (!$suit_price)
        {
            return $data;
        }
        $min_price=0;
        $min_suitid=0;
        //套餐报价价格整理
        foreach ($suit_price as $k => $v)
        {
            $roomid = DB::select('roomid')->from('ship_line_suit')->where('id','=',$v['suitid'])->execute()->get('roomid');
            $peoplenum = DB::select('peoplenum')->from('ship_room')->where('id','=',$roomid)->execute()->get('peoplenum');
            $peoplenum = empty($peoplenum)?1:$peoplenum;

            $avgprice =   floor($v['price']/$peoplenum);

            $suit_price[$k]['avgprice'] = round($v['price']/$peoplenum,2);


            if($min_price==0 && $avgprice>0)
            {
                $min_price = $avgprice;
                $min_suitid = $v['suitid'];
            }
            else if($min_price>0 && $avgprice>0 && $avgprice<$min_price)
            {
                $min_price = $avgprice;
                $min_suitid = $v['suitid'];
            }


            $suit_price[$k]['price'] = Currency_Tool::price($v['price']);
            $suit_price[$k]['storeprice'] = Currency_Tool::price($v['storeprice']);
            //最低价
           // if($suit_price[$k]['price']>0)
              //$suit_mini[] = $suit_price[$k]['price'];

        }


        $suit_mini =Currency_Tool::price($min_price);

        //舱房信息
        $room = array();
        $suitId = self::_array_column($suit_price, 'suitid');
        $suit = DB::select('id', 'roomid', 'paytype', 'jifenbook', 'jifentprice', 'jifencomment','dingjin','displayorder')->from('ship_line_suit')->where('id', 'in', $suitId)->order_by('displayorder','asc')->execute()->as_array();



        foreach ($suit as $v)
        {
            $sql = 'select r.*,k.title as kindname,' . $v['id'] . ' as suitid from sline_ship_room as r left join sline_ship_room_kind as k on r.kindid=k.id where r.id =' . $v['roomid'];
            $temp = DB::query(1, $sql)->execute()->as_array();
            foreach ($temp as $sub)
            {
                $room[] = $sub;
            }
        }

        //舱房类型
        $kind = array();
        foreach ($room as $v)
        {
            if (!in_array($v['kindname'], $kind))
            {
                $kind[$v['kindid']] = $v['kindname'];
            }
        }
        //报价绑定到舱房及舱房类型 最低价
        $kind_suit = null;
        foreach ($suit_price as $k => $sub)
        {
            //绑定房型
            foreach ($room as $v)
            {
                $v['thumb'] = array();
                $v['piclist'] = explode(',', $v['piclist']);
                $v['floors_names'] = Model_Ship_Floor::get_names_bystr($v['floors']);
                foreach ($v['piclist'] as $img)
                {
                    $v['thumb'][] = Common::img($img, 93, 65);
                }
                $v['piccount'] = count($v['piclist']);
                if ($sub['suitid'] == $v['suitid'])
                {
                    $suit_price[$k]['room'] = $v;
                    if (is_null($kind_suit))
                    {
                        $kind_suit = $v['kindid'];
                    }
                }
                //绑定套餐
                foreach ($suit as $s)
                {
                    if ($sub['suitid'] == $s['id'])
                    {
                        $s['paytypeid']=$s['paytype'];
                        switch ($s['paytype'])
                        {
                            case 1:
                                $s['paytype'] = '全款支付';
                                break;
                            case 2:
                                $s['paytype'] = '定金支付';
                                break;
                            default:
                                $s['paytype'] = '二次确认支付';
                        }
                        $suit_price[$k]['suit'] = $s;
                    }
                }
            }
        }
        usort($suit_price,'self::sort_suit');

        //reset($suit_price);
        //获取返回时间
        $backTime = DB::select('endtime')->from('ship_schedule_date')->where('id', '=', $suit_price[0]['dateid'])->execute()->current();
        $format = explode('|', date('Y年m月d日  |w', $backTime['endtime']));
        $week = array('周日', '周一', '周二', '周三', '周四', '周五', '周六');
        $backTime = $format[0] . $week[$format[1]];
        $data = array('kind' => $kind, 'kindSuit' => $kind_suit, 'suit' => $suit_price, 'backTime' => $backTime, 'suitMini' => $suit_mini);
        return $data;
    }
    public static function sort_suit($a,$b)
    {
        if($a['suit']['displayorder']==$b['suit']['displayorder'])
            return 0;
        return $a['suit']['displayorder']<$b['suit']['displayorder']?-1:1;
    }
    /**
     * 获取数组指定字段
     * @param $arr
     * @param $field
     * @return array
     */
    private static function _array_column($arr, $field)
    {
        $data = array();
        foreach ($arr as $v)
        {
            foreach ($v as $k => $val)
            {
                if ($k == $field)
                {
                    $data[] = $val;
                }
            }
        }
        return $data;
    }

    /**
     * 返回某个线路可用的套餐id数组
     * @param $lineid
     */
    public static function get_useful_suitids($lineid)
    {
        $shipid = DB::select('shipid')->from('ship_line')->where('id','=',$lineid)->execute()->get('shipid');
        if(empty($shipid))
            return null;
        $sql = "select DISTINCT a.id from sline_ship_line_suit a  inner join sline_ship_room b on a.shipid=b.shipid and a.roomid=b.id   where a.lineid='$lineid' and a.shipid='{$shipid}' ";
        $arr = DB::query(Database::SELECT,$sql)->execute()->as_array();
        $ids = array();
        foreach($arr as $v)
        {
            $ids[] = $v['id'];
        }
        return $ids;
    }


    /**
     * @param $destpy
     * @return array
     */
    public static function search_seo_mobile($destpy)
    {
        if (!empty($destpy) && $destpy != 'all')
        {

            $destinfo = DB::select('id', 'kindname')->from('destinations')->where('pinyin', '=', $destpy)->and_where('isopen', '=', 1)->execute()->current();
            //$info = ORM::factory('destinations', $destId)->as_array();
            $info = DB::select('seotitle')->from('ship_line_kindlist')->where('kindid', '=', $destinfo['id'])->execute()->current();
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $destinfo['kindname'];
        }
        else
        {
            $info = Model_Nav::get_channel_info_mobile(104);
            $seotitle = $info['seotitle'] ? $info['seotitle'] : $info['m_title'];
        }

        return array('seotitle' => $seotitle);
    }



    /**
     * 获取网站的所有支付方式
     */
    public static function get_paytype_list()
    {
        $paytypeArr = explode(',', $GLOBALS['cfg_pay_type']);
        $paytypeArr = array_unique(array_filter($paytypeArr));
        $out = array();
        $pay_list = array(
            '1' => array('name' => '支付宝', 'ico' => 'pay_zfb.gif', 'payid' => 1),
            '2' => array('name' => '快钱', 'ico' => 'pay_kq.gif', 'payid' => 2),
            '3' => array('name' => '汇潮', 'ico' => 'pay_hc.gif', 'payid' => 3),
            '4' => array('name' => '银联', 'ico' => 'pay_yl.gif', 'payid' => 4),
            '5' => array('name' => '钱包', 'ico' => 'pay_qb.gif', 'payid' => 5),
            '7' => array('name' => '贝宝', 'ico' => 'pay_bb.gif', 'payid' => 7),
            '8' => array('name' => '微信', 'ico' => 'pay_wx.gif', 'payid' => 8),
            '6' => array('name' => '线下支付', 'ico' => 'pay_xx.gif', 'payid' => 6)
        );
        foreach ($paytypeArr as $pay)
        {

            if (isset($pay_list[$pay]))
            {
                $out[] = $pay_list[$pay];
            }

        }
        return $out;

    }


    /**
     * @param $destid
     * 获取目的地上级
     */
    public static function get_predest($destid)
    {
        $loopid = intval($destid);

        $result = array();
        $k = 1;

        while (1)
        {
            $pid = DB::select('pid')->from('destinations')->where('id', '=', $loopid)->execute()->get('pid');


            $pinfo = DB::select('id', 'pid', 'pinyin', 'kindname')->from('destinations')->where('id', '=', $pid)->execute()->current();
            if (empty($pinfo['id']))
                break;
            else
            {
                $result[] = $pinfo;
                $loopid = $pinfo['id'];
            }
            if ($k == 5)
            {
                break;
            }
            $k++;

        }
        $count = count($result);
        for ($i = $count - 1; $i >= 0; $i--)
        {
            $newresult[] = $result[$i];
        }

        $destinfo = DB::select('id', 'pid', 'pinyin', 'kindname')->from('destinations')->where('id', '=', $destid)->execute()->current();
        $newresult[] = $destinfo;
        return $newresult;
    }


    /**
     * @function 获取邮轮设施第一张图片
     * @param $shipid 邮轮id
     * @param $kindid 设施类型id
     */
    public static function get_facility_litpic($shipid,$kindid=0)
    {
        $shipid = intval($shipid);
        //舱房
        if($kindid==0)
        {
            $litpic = DB::select('litpic')->from('ship_room')->where("shipid=$shipid")->order_by('displayorder')->limit(1)->execute()->get('litpic');

        }
        else //其他设施
        {

            $litpic = DB::select('litpic')->from('ship_facility')->where("shipid=$shipid and kindid=$kindid")->order_by('displayorder')->limit(1)->execute()->get('litpic');
        }
        return $litpic;

    }

}