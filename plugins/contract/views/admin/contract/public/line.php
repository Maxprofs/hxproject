<?php defined('SYSPATH') or die('No direct script access.');   $symbol = Currency_Tool::symbol(); ?>
<div class="travel-container">
    <h3 class="travel-tit">行程及订单内容</h3>
    <table class="travel-table" script_color=5ATBbm >
        <tr>
            <td width="80" bgcolor="#ccc">产品名称</td>
            <td colspan="3">{$order['productname']}</td>
        </tr>
        <tr>
            <td width="80" bgcolor="#ccc">产品编号</td>
            <td >{$order['series']}</td>
            <td width="80" bgcolor="#ccc">预定套餐</td>
            <td>{$order['suitname']}</td>
        </tr>
        <tr>
            <td width="80" bgcolor="#ccc">出团日期</td>
            <td>{$order['usedate']}</td>
            <td width="80" bgcolor="#ccc">行程天数</td>
            <td>{$order['line']['lineday']}天{$order['line']['linenight']}晚</td>
        </tr>
        <tr>
            <td width="80" bgcolor="#ccc">参团人数</td>
            <td>{php}echo $order['oldnum']+$order['dingnum']+$order['childnum'];{/php}人（其中成人{$order['dingnum']}人，小孩{$order['childnum']}人，老人{$order['oldnum']}人）</td>
            <td width="80" bgcolor="#ccc">单房差</td>
            <td>{php}echo $order['roombalance']*$order['roombalancenum'];{/php}</td>
        </tr>
        <tr>
            <td width="80" bgcolor="#ccc">收费标准</td>
            <td colspan="3"> 成人：{$symbol}{$order['price']}/人，老人：{$symbol}{$order['oldprice']}/人；儿童：{$symbol}{$order['childprice']}/人；单房差：{$symbol}{$order['roombalance']}/人</td>
        </tr>
        <tr>
            <td width="80" bgcolor="#ccc">优惠</td>
            <td>{$symbol}{$order['privileg_price']}</td>
            <td width="80" bgcolor="#ccc">合计</td>
            <td>{$symbol}{$order['payprice']}</td>
        </tr>
    </table>
</div>
