<?php defined('SYSPATH') or die('No direct script access.');

/*
    * 日历显示
    * */

class Controller_Admin_Car_Calendar extends Stourweb_Controller
{
    private $_typeid=3;
    private $_price_table = 'car_suit_price';
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
            $priceArr = self::get_suitprice_arr($year, $month, $suitid);
            $out .= self::my_calendar($year, $month, $priceArr, $productid, $suitid);
            $month++;
        }
        $this->assign('calendar', $out);
        $this->assign('typeid', $this->_typeid);
        $this->display('admin/car/calendar/index');
    }

    /*
     * 动态修改报价
     * */
    public function action_ajax_modprice()
    {

        $basicprice = Arr::get($_POST, 'basicprice') ? Arr::get($_POST, 'basicprice') : 0;
        $profit = Arr::get($_POST, 'profit') ? Arr::get($_POST, 'profit') : 0;
        $productid = Arr::get($_POST, 'productid') ? Arr::get($_POST, 'productid') : 0;


        $number = $_POST['number'] ? $_POST['number'] : 0;
        $number = (string)$number == '不限' ? -1 : $number;
        $day = Arr::get($_POST, 'day');
        $suitid = Arr::get($_POST, 'suitid');
        $price = (int)$basicprice + (int)$profit;
        $flag = false;
        $basicp_f = 'adultbasicprice';
        $profit_f = 'adultprofit';
        $price_f = 'adultprice';
        //判断是否是删除数据
        $isDelete = true;
        //小孩和成人(只有线路有)
        $add_update = '';


        if ($price == 0 && $isDelete)
        {
            $sql = "delete from sline_".$this->_price_table;

            $sql .= " where suitid='$suitid' and day='$day'";
            $result = DB::query(Database::DELETE, $sql)->execute();
            if ($result) $flag = true;
        }
        else
        {
            $sql = "update sline_".$this->_price_table." set $basicp_f='$basicprice'";
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
            $out['number'] = $number;
            Model_Car::update_min_price($productid);

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


        $productid = Arr::get($_POST, 'productid');
        $suitid = Arr::get($_POST, 'suitid');

        $basicprice = Arr::get($_POST, 'basicprice') ? Arr::get($_POST, 'basicprice') : 0;
        $profit = Arr::get($_POST, 'profit') ? Arr::get($_POST, 'profit') : 0;




        $number = $_POST['number'] == '' ? -1 : $_POST['number'];
        $number = (string)$number == '不限' ? -1 : $number;



        $day = Arr::get($_POST, 'day');

        $price = (int)$basicprice + (int)$profit;



        $arr = array(
            'carid' => $productid,
            'suitid' => $suitid,
            'adultbasicprice' => $basicprice,
            'number' => $number,
            'adultprofit' => $profit,
            'adultprice' => $price,
            'day' => $day


        );

        $flag = false;
        if ($price != 0)
        {
            $sql_key = $sql_value = '';
            $sql = 'INSERT INTO sline_'.$this->_price_table.' (';
            $sql2 = "VALUES ( ";
            foreach ($arr as $key => $value)
            {
                $sql_key .= "`" . $key . "`,";
                $sql_value .= "'" . $value . "',";
            }
            $sql_key = substr($sql_key, 0, -1) . ")";
            $sql_value = substr($sql_value, 0, -1) . ")";
            $sql = $sql . $sql_key . $sql2 . $sql_value . ";";

            //$sql = "insert into sline_{$table} ($field) values(";
            //$sql.= "'{$productid}','{$suitid}','{$basicprice}','{$profit}','{$price}','{$day}')";
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


            $out['number'] = $number == -1 ? '不限' : $number;


             Model_Hotel::update_min_price($productid);

        }
        else
        {
            $out['status'] = false;
        }
        echo json_encode($out);
        exit;
    }


    /**
     * 生成格式化的数据
     * 用于日历中进行呈现
     * @param $arr
     */
    public function get_suitprice_arr($year, $month, $suitid)
    {


        $start = strtotime("$year-$month-1");
        $end = strtotime("$year-$month-31");

        $arr = ORM::factory($this->_price_table)->where('suitid', '=', $suitid)
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
                $price[$day]['basicprice'] =  $row['adultbasicprice'];
                $price[$day]['profit'] =  $row['adultprofit'];
                $price[$day]['price'] = $row['adultprice'];

                $price[$day]['suitid'] = $suitid;
                $price[$day]['number'] = $row['number'];//库存
                $price[$day]['description'] = $row['description'];//描述
            }
        }


        return $price;
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


    public static function my_calendar($year = '', $month = '', $priceArr = NULL, $productid = null, $suitid = '')
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
        $html = '<div class="tab">
<table width="460" border="1" style="border-collapse: collapse;">

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
                $line .= str_repeat('<td>&nbsp;</td>', $nowWeek - 1);
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


            //库存
            $number = $priceArr[$cdayme]['number'] != -1 ? $priceArr[$cdayme]['number'] : '不限';




            //suitid
            $daysuitid = $suitid;

            //定义单元格样式，高，宽
            $tdStyle = "height='80'";
            //判断当前的日期是否小于今天
            $tdcontent = '<span class="num">' . $day . '</span>';

            if ($defaultmktime >= $currentmktime)
            {
                if ($dayPrice )
                {
                    if ($dayPrice > 0)
                    {
                        $dayPriceStrs = "成人:{$dayPrice}<br>";
                    }

                   $dayPriceStrs = "报价:{$dayPrice}<br>";

                    $ydCls = '';
                    $balanceStr = '';
                    $tdcontent .= '<b class="yes_yd ' . $ydCls . '">' . $dayPriceStrs . '</b>' . $balanceStr;
                    $onclick = 'onclick="modPrice(this)"';
                    $numberinfo = "<span class='kucun'>库存:$number</span>";

                }
                else
                {
                    $dayPriceStrs = '';
                    $tdcontent .= '<b class="no_yd">' . $dayPriceStrs . '</b>';
                    $onclick = 'onclick="addPrice(this)"';
                    $numberinfo = "<span class='kucun'></span>";

                }

                $line .= "<td $tdStyle $onclick style='cursor:pointer;' data-price='" . $dayPrice . "'  data-basicprice='" . $daybasicprice . "' data-profit='" . $dayprofitprice . "' data-suitid='" . $daysuitid . "' data-day='" . $cdayme . "' data-date='" . $cdaydate . "' data-productid='" . $productid . "'   data-number='" . $number . "'>" . $tdcontent . $numberinfo . "</td>";
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


}