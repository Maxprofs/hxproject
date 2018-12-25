<?php defined('SYSPATH') or die('No direct access allowed.');


class Model_Spot_Suit extends ORM
{
    /**
     * @function 获取套餐详情
     * @param $suitId
     * @return array
     */
    public static function suit_info($suitId)
    {
        $suit = ORM::factory('spot_ticket',$suitId)->as_array();
        $suit_formats=self::format_suit_info(array($suit));
        $suit=$suit_formats[0];
        $suit['dingjin'] = Currency_Tool::price($suit['dingjin']);
        $suit['paytype_name'] = Model_Member_Order::get_paytype_name($suit['paytype']);
        $tickettype_name = DB::select('kindname')->from('spot_ticket_type')->where('id','=',$suit['tickettypeid'])->execute()->get('kindname');
        $suit['tickettype_name'] = $tickettype_name;
        //产品编号
        $suit['series'] = St_Product::product_series($suit['spotid'], 5);
        return $suit;
    }

    public static function format_suit_info($suits)
    {
        foreach ($suits as &$v)
        {
            //供应商
            if(Model_Supplier::display_is_open()&&$v['supplierlist'])
            {
                $v['suppliername'] = Arr::get(Model_Supplier::get_supplier_info($v['supplierlist'],array('suppliername')),'suppliername');
            }
            $priceArr = Model_Spot::get_minprice($v['spotid'], $v['id']);
            $v['ourprice'] = $priceArr['price'];//最低价
            //报价状态
            $price_status=Model_Spot_Ticket_Price::get_price_status($v);
            $v['price_status'] = $price_status;
            $tickettype_name = DB::select('kindname')->from('spot_ticket_type')->where('id','=',$v['tickettypeid'])->execute()->get('kindname');
            $v['tickettype_name'] = $tickettype_name;
            $v['paytype_name'] = Model_Member_Order::get_paytype_name($v['paytype']);
            $v['day_before_des']='';
            if(!empty($v['day_before']) || !empty($v['hour_before']) || !empty($v['minute_before']))
            {
                $day_before_des = !empty($v['day_before'])?'提前'.$v['day_before'].'天':'当天';
                $day_before_des_mobile = !empty($v['day_before'])?'提前'.$v['day_before'].'天':'当天';
                $hour_before = intval($v['hour_before']);
                $minute_before = intval($v['minute_before']);
                if(!empty($hour_before) || !empty($minute_before))
                {
                    $hour_before = $hour_before < 10 ? '0' . $hour_before : $hour_before;
                    $minute_before = $minute_before < 10 ? '0' . $minute_before : $minute_before;
                    $day_before_des .= $hour_before . ':' . $minute_before;
                    $day_before_des_mobile.=  $hour_before . ':' . $minute_before;
                    $day_before_des.='前';
                    $day_before_des_mobile.='前';
                }
                else if(!empty($v['day_before']))
                {
                    $day_before_des.='24:00前';
                    $day_before_des_mobile.='24:00前';
                }

                $day_before_des_mobile.=!empty($v['day_before'])?'预定门票':'可预定当日票';

                $v['day_before_des'] = $day_before_des;
                $v['day_before_des_mobile'] = $day_before_des_mobile;
            }
            //验票有效期
            $v['effective_before_days_des']='';
            if (!empty($v['effective_days']))
            {
                if($v['effective_days']==-1)
                {
                    $day_before_des='验票当天24:00前';
                }
                else
                {
                    $day_before_des='游客指定入园日期后'.$v['effective_days'].'天内有效';
                }
                $v['effective_before_days_des'] = $day_before_des;
            }

        }
        return $suits;
    }
}