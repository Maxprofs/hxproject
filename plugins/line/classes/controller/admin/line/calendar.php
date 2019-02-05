<?php defined('SYSPATH') or die('No direct script access.');

/*
    * 日历显示
    * */

class Controller_Admin_Line_Calendar extends Stourweb_Controller
{


    private  $_typeid = 1;
    private  $_price_table = 'line_suit_price';


    public function action_index()
    {

        $suitid = $this->params['suitid'];
        $productid = $this->params['productid'];
        $year = date("Y"); //当前月
        $month = date("m");//当前年
        $out = '';
        for ($i = 1; $i <= 24; $i++)
        {
            if ($month == 13)
            {
                $year = $year + 1;
                $month = 1;
            }
            $priceArr = self::get_suitprice_arr($year, $month, $suitid, $this->_typeid);
            $out .= self::my_calender($year, $month, $priceArr, $productid, $suitid, $this->_typeid);
            $month++;
        }

        $this->assign('calendar', $out);
        $this->assign('suitid', $suitid);
        $this->assign('productid', $productid);
        $this->assign('typeid', $this->_typeid);
        $this->display('admin/line/calendar/index');
    }



    /*
     * 动态修改报价
     * */
    public function action_ajax_modprice()
    {



        $basicprice = Arr::get($_POST, 'basicprice') ? Arr::get($_POST, 'basicprice') : 0;
        $profit = Arr::get($_POST, 'profit') ? Arr::get($_POST, 'profit') : 0;
        $productid = Arr::get($_POST, 'productid') ? Arr::get($_POST, 'productid') : 0;

        $child_basicprice = Arr::get($_POST, 'child_basicprice') ? Arr::get($_POST, 'child_basicprice') : 0;
        $child_profit = Arr::get($_POST, 'child_profit') ? Arr::get($_POST, 'child_profit') : 0;

        $old_basicprice = Arr::get($_POST, 'old_basicprice') ? Arr::get($_POST, 'old_basicprice') : 0;
        $old_profit = Arr::get($_POST, 'old_profit') ? Arr::get($_POST, 'old_profit') : 0;

        $number = $_POST['number'] ? $_POST['number'] : 0;
        $number = (string)$number == '不限' ? -1 : $number;


        $day = Arr::get($_POST, 'day');
        $suitid = Arr::get($_POST, 'suitid');
        $price = (int)$basicprice + (int)$profit;
        $child_price = (int)$child_basicprice + (int)$child_profit;
        $old_price = (int)$old_basicprice + (int)$old_profit;

        $table = $this->_price_table;

        $roombalance = empty($_POST['roombalance']) ? 0 : $_POST['roombalance'];


        $flag = false;

        $basicp_f = 'adultbasicprice';
        $profit_f = 'adultprofit';
        $price_f = 'adultprice';
        //判断是否是删除数据
        $isDelete = true;
        //小孩和成人(只有线路有)
        $add_update = '';
        $add_update .= ", childbasicprice='$child_basicprice'";
        $add_update .= ", childprofit='$child_profit'";
        $add_update .= ", childprice='$child_price'";

        $add_update .= ", oldbasicprice='$old_basicprice'";
        $add_update .= ", oldprofit='$old_profit'";
        $add_update .= ", oldprice='$old_price'";
        $add_update .= ", roombalance='$roombalance'";
        if ($old_price || $child_price)
        {
            $isDelete = false;
        }


        if ($price == 0 && $isDelete)
        {
            $sql = "delete from sline_{$table} ";
            $sql .= " where suitid='$suitid' and day='$day'";
            $result = DB::query(Database::DELETE, $sql)->execute();
            if ($result) $flag = true;
        }
        else
        {
            $sql = "update sline_{$table} set $basicp_f='$basicprice'";
            $sql .= ", $profit_f='$profit'";
            $sql .= ", $price_f='$price'";
            $sql .= ", number='$number'";
            $sql .= $add_update;
            $sql .= " where suitid='$suitid' and day='$day'";
            $result = DB::query(Database::UPDATE, $sql)->execute();
            if ($result) $flag = true;

        }
        $out = array();
        if ($flag)
        {
            $out['status'] = true;
            $out['price'] = $price;
            $out['basicprice'] = $basicprice;
            $out['profit'] = $profit;

            $out['child_price'] = $child_price;
            $out['child_basicprice'] = $child_basicprice;
            $out['child_profit'] = $child_profit;

            $out['old_price'] = $old_price;
            $out['old_basicprice'] = $old_basicprice;
            $out['old_profit'] = $old_profit;
            $out['roombalance'] = $roombalance;

            $out['number'] = $number;
            Model_Line::update_min_price($productid);

        }
        else
        {
            $out['status'] = false;
        }
        echo json_encode($out);
        exit;

    }

    //动态添加报价
    public function action_ajax_addprice()
    {

        $typeid = $this->_typeid;
        $productid = Arr::get($_POST, 'productid');
        $suitid = Arr::get($_POST, 'suitid');

        $basicprice = Arr::get($_POST, 'basicprice') ? Arr::get($_POST, 'basicprice') : 0;
        $profit = Arr::get($_POST, 'profit') ? Arr::get($_POST, 'profit') : 0;

        $child_basicprice = Arr::get($_POST, 'child_basicprice') ? Arr::get($_POST, 'child_basicprice') : 0;
        $child_profit = Arr::get($_POST, 'child_profit') ? Arr::get($_POST, 'child_profit') : 0;

        $old_basicprice = Arr::get($_POST, 'old_basicprice') ? Arr::get($_POST, 'old_basicprice') : 0;
        $old_profit = Arr::get($_POST, 'old_profit') ? Arr::get($_POST, 'old_profit') : 0;

        $number = $_POST['number'] == '' ? -1 : $_POST['number'];
        $number = (string)$number == '不限' ? -1 : $number;

        $roombalance = empty($_POST['roombalance']) ? 0 : $_POST['roombalance'];

        $day = Arr::get($_POST, 'day');

        $price = (int)$basicprice + (int)$profit;
        $child_price = (int)$child_basicprice + (int)$child_profit;
        $old_price = (int)$old_basicprice + (int)$old_profit;
        $table = $this->_price_table;
        $arr = array(
            'lineid' => $productid,
            'suitid' => $suitid,
            'adultbasicprice' => $basicprice,
            'adultprofit' => $profit,
            'adultprice' => $price,
            'day' => $day,
            'number' => $number,
            'childbasicprice' => $child_basicprice,
            'childprofit' => $child_profit,
            'childprice' => $child_price,
            'oldbasicprice' => $old_basicprice,
            'oldprofit' => $old_profit,
            'oldprice' => $old_price,
            'roombalance' => $roombalance

        );
        $flag = false;
        if ($price != 0)
        {
            $sql_key = $sql_value = '';
            $sql = "INSERT INTO sline_{$table} (";
            $sql2 = "VALUES ( ";
            foreach ($arr as $key => $value)
            {
                $sql_key .= "`" . $key . "`,";
                $sql_value .= "'" . $value . "',";
            }
            $sql_key = substr($sql_key, 0, -1) . ")";
            $sql_value = substr($sql_value, 0, -1) . ")";
            $sql = $sql . $sql_key . $sql2 . $sql_value . ";";


            $result = DB::query(Database::INSERT, $sql)->execute();
            if ($result) $flag = true;

        }

        $out = array();
        if ($flag)
        {
            $out['status'] = true;
            $out['price'] = $price;
            $out['basicprice'] = $basicprice;
            $out['profit'] = $profit;

            $out['child_price'] = $child_price;
            $out['child_basicprice'] = $child_basicprice;
            $out['child_profit'] = $child_profit;

            $out['old_price'] = $old_price;
            $out['old_basicprice'] = $old_basicprice;
            $out['old_profit'] = $old_profit;
            $out['roombalance'] = $roombalance;

            $out['number'] = $number == -1 ? '不限' : $number;
            Model_Line::update_min_price($productid);

        }
        else
        {
            $out['status'] = false;
        }
        echo json_encode($out);
        exit;
    }

    /**
     * 日历报价
     */
    public function action_dialog_calendar()
    {

        $suitid = intval($this->params['suitid']);
        $year = intval($this->params['year']);
        $month = intval($this->params['month']);
        $lineid = intval($this->params['lineid']);
        $nowDate = new DateTime();
        $year = !empty($year) ? $year : $nowDate->format('Y');
        $month = !empty($month) ? $month : $nowDate->format('m');
        $out = '';
        $info = DB::select('islinebefore', 'linebefore')->from('line')->where('id', '=', $lineid)->execute()->current();
        $ext['islinebefore'] = $info['islinebefore'];
        $ext['linebefore'] = $info['linebefore'];
        if ($ext['islinebefore'])
        {
            $startdate = date('Y-m-d', strtotime("+{$ext['linebefore']} days", time()));
        }

        $priceArr = St_Product::get_suit_price($year, $month, $suitid, $this->_typeid, $startdate);


        $cfg_line_minprice_rule = $GLOBALS['cfg_line_minprice_rule'];
        foreach($priceArr as &$v)
        {

            $adultprice = $v['price'];
            $childprice = $v['child_price'];
            $oldprice = $v['old_price'];
            $minprice = $adultprice;
            $minprice = (floatval($childprice)<floatval($minprice) && $childprice>0) || empty($minprice)? $childprice:$minprice;
            $minprice = (floatval($oldprice)<floatval($minprice) && $oldprice>0) || empty($minprice)>0? $oldprice:$minprice;

            switch($cfg_line_minprice_rule)
            {
                case 1:
                    $price = $childprice;
                    break;
                case 2:
                    $price = $adultprice;
                    break;
                case 3:
                    $price = $oldprice;
                    break;
                default:
                    $price = $adultprice;
                    break;
            }
            $price = empty($price)?$minprice:$price;
            $v['price'] = $price;
        }

        $calendar = St_Functions::calender($year, $month, $priceArr, $suitid);
        $this->assign('calendar',$calendar);
        $this->assign('lineid',$lineid);
        $this->assign('suitid',$suitid);
        $this->display('admin/line/calendar/dialog');
    }


    /**
     * 生成格式化的数据
     * 用于日历中进行呈现
     * @param $arr
     */
    public function get_suitprice_arr($year, $month, $suitid, $typeid)
    {


        $start = strtotime("$year-$month-1");
        $end = strtotime("$year-$month-31");

        $table = $this->_price_table;
        $arr = ORM::factory($table)->where('suitid', '=', $suitid)
            ->and_where('day', '>=', $start)
            ->and_where('day', '<=', $end)
            ->get_all();

        $price = array();
        foreach ($arr as $row)
        {
            if ($row)
            {

                $day = $row['day'];
                $price[$day]['date'] = Common::myDate('Y-m-d', $row['day']);
                $price[$day]['basicprice'] = isset($row['adultbasicprice']) ? $row['adultbasicprice'] : $row['basicprice'];
                $price[$day]['profit'] = isset($row['adultprofit']) ? $row['adultprofit'] : $row['profit'];
                $price[$day]['price'] = isset($row['adultprice']) ? $row['adultprice'] : $row['price'];

                $price[$day]['child_basicprice'] = isset($row['childbasicprice']) ? $row['childbasicprice'] : 0;
                $price[$day]['child_profit'] = isset($row['childprofit']) ? $row['childprofit'] : 0;
                $price[$day]['child_price'] = isset($row['childprice']) ? $row['childprice'] : 0;

                $price[$day]['old_basicprice'] = isset($row['oldbasicprice']) ? $row['oldbasicprice'] : 0;
                $price[$day]['old_profit'] = isset($row['oldprofit']) ? $row['oldprofit'] : 0;
                $price[$day]['old_price'] = isset($row['oldprice']) ? $row['oldprice'] : 0;

                $price[$day]['suitid'] = $suitid;
                $price[$day]['number'] = $row['number'];//库存
                $price[$day]['description'] = $row['description'];//描述
                $price[$day]['roombalance'] = $row['roombalance'];//单房差
                $price[$day]['propgroup'] = $row['propgroup'];//报价人群

            }


        }


        return $price;
    }

    /*
     *
     * 读取线路报价类型(成人,老人,小孩)
     * */
    public function get_price_group($suitid)
    {
        $info = ORM::factory('line_suit')->where("id='$suitid'")->find();
        return $info->propgroup;
    }

    /**
     *
     * 我的日历(DateTime版本)
     * date_default_timezone_set date mktime
     * @param int $year
     * @param int $month
     * @priceArr array 成人,儿童,老人报价
     * @param string $timezone
     */
    public function my_calender($year = '', $month = '', $priceArr = NULL, $productid = null, $suitid = '', $typeid)
    {
        date_default_timezone_set('Asia/Shanghai');
        $year = abs(intval($year));
        $month = abs(intval($month));
        $tmonth = $month < 10 ? "0" . $month : $month;
        $defaultYM = $year . '-' . $tmonth;
        $nowDate = new DateTime();

        if ($year <= 0)
        {
            $year = $nowDate->format('Y');
        }

        if ($month <= 0 or $month > 12)
        {
            $month = $nowDate->format('m');
        }

        //上一年
        $pretYear = $year - 1;
        //上一月
        $mpYear = $year;
        $preMonth = $month - 1;
        if ($preMonth <= 0)
        {
            $preMonth = 1;
            $mpYear = $pretYear;
        }
        $preMonth = $preMonth < 10 ? '0' . $preMonth : $preMonth;

        //下一年
        $nextYear = $year + 1;
        //下一月
        $mnYear = $year;
        $nextMonth = $month + 1;
        if ($nextMonth > 12)
        {
            $nextMonth = 1;
            $mnYear = $nextYear;
        }
        $nextMonth = $nextMonth < 10 ? '0' . $nextMonth : $nextMonth;


        //日历头
        $html = '<div class="tab" >
<table border="1" style="border-collapse: collapse;">

  <tr align="center" >
    <td colspan="3" class="top_title" style="height:50px;">' . $year . '年' . $month . '月</td>

  </tr>
  <tr>
  	<td colspan="5">
		<table width="100%" border="1" >
			<tr align="center">
				<td style="background-color:#DAF0DD;height:25px;">星期一</td>
				<td style="background-color:#DAF0DD;height:25px;">星期二</td>
				<td style="background-color:#DAF0DD;height:25px;">星期三</td>
				<td style="background-color:#DAF0DD;height:25px;">星期四</td>
				<td style="background-color:#DAF0DD;height:25px;">星期五</td>
				<td style="background-color:#F60;color:#fff;font-weight: bold;">星期六</td>
				<td style="background-color:#F60;color:#fff;font-weight: bold;">星期天</td>
			</tr>
';

        $currentDay = $nowDate->format('Y-m-j');

        //当月最后一天
        $creatDate = new DateTime("$year-$nextMonth-0");
        $lastday = $creatDate->format('j');
        $creatDate = NULL;

        //循环输出天数
        $day = 1;
        $line = '';
        $back_symbol = Currency_Tool::back_symbol();
        while ($day <= $lastday)
        {

            $cday = $year . '-' . $month . '-' . $day;

            //当前星期几
            $creatDate = new DateTime("$year-$month-$day");
            $nowWeek = $creatDate->format('N');
            $creatDate = NULL;

            if ($day == 1)
            {
                $line = '<tr align="center">';
                $line .= str_repeat('<td class="content-td">&nbsp;</td>', $nowWeek - 1);
            }
            if ($cday == $currentDay)
            {
                $style = 'style="font-size:16px; font-family:微软雅黑,Arial,Helvetica,sans-serif;color:#FF6600;line-height:22px;"';
            }
            else
            {
                $style = 'style=" font-size:16px; font-family:微软雅黑,Arial,Helvetica,sans-serif;line-height:22px;"';
            }
            //判断当前的日期是否小于今天
            $defaultmktime = mktime(1, 1, 1, $month, $day, $year);

            $currentmktime = mktime(1, 1, 1, date("m"), date("j"), date("Y"));
            //echo '<hr>';
            $tday = ($day < 10) ? '0' . $day : $day;
            $cdaydate = $defaultYM . '-' . $tday;
            $cdayme = strtotime($cdaydate);
            //单价
            $dayPrice = $priceArr[$cdayme]['price'];
            //成本
            $daybasicprice = $priceArr[$cdayme]['basicprice'];
            //利润
            $dayprofitprice = $priceArr[$cdayme]['profit'];

            //老人
            $day_old_price = $priceArr[$cdayme]['old_price'];
            $day_old_basicprice = $priceArr[$cdayme]['old_basicprice'];
            $day_old_profit = $priceArr[$cdayme]['old_profit'];
            //儿童
            $day_child_price = $priceArr[$cdayme]['child_price'];
            $day_child_basicprice = $priceArr[$cdayme]['child_basicprice'];
            $day_child_profit = $priceArr[$cdayme]['child_profit'];
            //库存
            $number = $priceArr[$cdayme]['number'] != -1 ? $priceArr[$cdayme]['number'] : '不限';

            //人群
            $group = self::get_price_group($suitid);
            $propgroup = explode(',',$priceArr[$cdayme]['propgroup']);
            //suitid
            $daysuitid = $suitid;

            //定义单元格样式，高，宽
            $tdStyle = "height='105'";
            //判断当前的日期是否小于今天
            $tdcontent = '<span class="num">' . $day . '</span>';

            if ($defaultmktime >= $currentmktime)
            {
                if ($propgroup[0])
                {
                    $dayPriceStrs = '';
                    if (in_array(2,$propgroup))
                    {
                        $dayPriceStrs .= '<b class="yes_yd  line_yes_yd">成人:'.$back_symbol.$dayPrice.'<br></b>';

                    }
                     if (in_array(1,$propgroup))
                    {
                        $dayPriceStrs .= '<b class="yes_yd  line_yes_yd">儿童:'.$back_symbol.$day_child_price.'<br></b>';
                    }
                    if(in_array(3,$propgroup))
                    {
                        $dayPriceStrs .= '<b class="yes_yd  line_yes_yd">老人:'.$back_symbol.$day_old_price.'<br></b>';
                    }

                    $ydCls = '';
                    $balanceStr = '';

                    $roombalance = $priceArr[$cdayme]['roombalance'];
                    $roombalance = empty($roombalance) ? 0 : $roombalance;
                    if ($roombalance)
                    {
                        $balanceStr = '<b class="roombalance_b">单房差:' . $back_symbol.$roombalance . '</b>';
                    }
                    $tdcontent .= $dayPriceStrs . $balanceStr;
                    $onclick = 'onclick="modPrice(this)"';
                    $numberinfo = "<span class='kucun'>库存:$number</span>";

                }
                else
                {
                    $dayPriceStrs = '';
                    $tdcontent .= '<b class="no_yd">' . $dayPriceStrs . '</b>' . '<b class="roombalance_b"></b>';
                    $onclick = 'onclick="addPrice(this)"';
                    $numberinfo = "<span class='kucun'></span>";

                }

                $line .= "<td $tdStyle $onclick style='cursor:pointer;' data-price='" . $dayPrice . "' data-roombalance='" . $roombalance . "' data-basicprice='" . $daybasicprice . "' data-profit='" . $dayprofitprice . "' data-suitid='" . $daysuitid . "' data-day='" . $cdayme . "' data-date='" . $cdaydate . "' data-productid='" . $productid . "' data-typeid='" . $typeid . "' data-child-basicprice='" . $day_child_basicprice . "' data-child-profit='" . $day_child_profit . "' data-child-price='" . $day_child_price . "' data-old-basicprice='" . $day_old_basicprice . "' data-old-profit='" . $day_old_profit . "' data-old-price='" . $day_old_price . "' data-group='" . $priceArr[$cdayme]['propgroup'] . "' data-number='" . $number . "'>" . $tdcontent . $numberinfo . "</td>";
            }
            else
            {
                $dayPriceStrs = '&nbsp;&nbsp;';
                $tdcontent .= '<b class="no_yd">' . $dayPriceStrs . '</b>';
                $line .= "<td $tdStyle >" . $tdcontent . "</td>";
            }


            //$line .= "<td $style>$day <div>不可订</div></td>";

            //一周结束
            if ($nowWeek == 7)
            {
                $line .= '</tr>';
                $html .= $line;
                $line = '<tr align="center">';
            }

            //全月结束
            if ($day == $lastday)
            {
                if ($nowWeek != 7)
                {
                    $line .= str_repeat('<td>&nbsp;</td>', 7 - $nowWeek);
                }
                $line .= '</tr>';
                $html .= $line;

                break;
            }

            $day++;
        }

        $html .= '
		</table>
	</td>
  </tr>
</table>
</div>
';
        return $html;
    }

    /**
     * @function 获取套餐的报价，按月份
     */
    public function action_ajax_get_suit_price()
    {
        $suitid = $_POST['suitid'];
        $year = $_POST['year'];
        $month = $_POST['month'];

        //获取最近的报价时间
        if(!$year&&!$month)
        {
            $firstday = DB::select('day')->from('line_suit_price')
                ->where('suitid','=',$suitid)->and_where('day','>=',strtotime(date('Y-m-d')))->limit(1)->execute()->get('day');
            if(empty($firstday))
            {
                exit(json_encode(array('starttime'=>'')));
            }
            $startday = date('Y-m-01',$firstday);
            //如果默认的当月的第一天小于当前时间，那么最近可编辑时间为当前时间
            if(strtotime($startday)<date('Y-m-d'))
            {
                $startday = date('Y-m-d');
            }
            $year = date('Y',$firstday);
            $month = date('m',$firstday);
        }
        else
        {
            $startday = date('Y-m-d');
        }

        $out = $this->get_suitprice_arr($year,$month,$suitid,1);
        $list = array();
        $back_symbol = Currency_Tool::back_symbol();
                $h="<span class='basic'>";
        $t="</span>";
        foreach ($out as $o)
        {
            $propgroup = explode(',',$o['propgroup']);
            $temp = array();
            $temp['date'] = $o['date'];
            if($propgroup)
            {
                $temp['price'] = in_array(2, $propgroup) ? $back_symbol . $o['price'].'  '.$h.$back_symbol . $o['basicprice'].$t : ''; //售价
                $temp['child_price'] = in_array(1, $propgroup) ? $back_symbol . $o['child_price'].'  '.$h.$back_symbol . $o['child_basicprice'].$t : ''; //售价
                $temp['old_price'] = in_array(3, $propgroup) ? $back_symbol . $o['old_price'].'  '.$h.$back_symbol . $o['old_basicprice'].$t : ''; //售价
                // $temp['price'] = in_array(2,$propgroup) ?  $back_symbol.$o['price'] : '';
                // $temp['child_price'] = in_array(1,$propgroup) ?  $back_symbol.$o['child_price'] : '';
                // $temp['old_price'] = in_array(3,$propgroup) ? $back_symbol.$o['old_price'] : '';
                $temp['roombalance'] = $back_symbol.$o['roombalance'];
                $o['number']==-1 ? $temp['number'] = '充足' : $temp['number'] = $o['number'];
            }
            $list[] = $temp;
        }
        echo  json_encode(array('list'=>$list,'starttime'=>$startday));

    }

}