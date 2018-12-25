<?php defined('SYSPATH') or die('No direct script access.');   $symbol = Currency_Tool::symbol(); ?>
<style>
    .agreement-travel-box{
        margin-top: 50px;
        padding: 20px 0;
    }
    .agreement-travel-tit{
        font-size: 14px;
        font-weight: bold;
    }
    .agreement-travel-block{
        line-height: 24px;
        margin-top: 10px;
        font-size: 14px;
    }
    .xc-list{
        margin-bottom:20px}
    .agreement-travel-box h3,.xc-list h3{
        color:#333;
        padding:5px;
        font-size:20px;
        border-bottom:1px solid #989898}
    .xc-list .day-con{
        margin-top:15px;
        padding-bottom:10px;
        border-bottom:1px dotted #989898}
    .xc-list .day-con .day-num{
        color:#333;}
    .xc-list .day-con .day-num strong{
        float:left;
        width:70px;
        font-size:18px;
        font-weight:bold}
    .xc-list .day-con .day-num p{
        padding-left:70px;
        line-height:30px;
        font-size:14px}
    .xc-list .day-con .day-attr dt{
        float:left;
        width:70px;
        height:24px;
        line-height:24px;
        font-weight:bold}
    .xc-list .day-con .day-attr dd{
        padding-left:70px;
        line-height:24px}
    .xc-list .day-con .day-attr dd span{
        display:inline-block;
        width:150px;
        height:24px;
        line-height:24px}

    .xc-list .contxt{
        padding:5px;
        margin-top:10px;
        font-size:14px;
        line-height:24px;
        overflow: hidden;
    }
    .xc-list .contxt *{
        max-width: 100%;
    }
    .xc-list .contxt strong{
        font-weight: bold !important;
    }
    .xc-list .contxt em{
        font-style: italic !important;
    }

</style>
{php}$linecontent=Model_Contract::get_content(array('pc'=>1,'typeid'=>1,'productinfo'=>$order['line']));{/php}

<div class="agreement-travel-box">
{loop $linecontent $line}
    {if preg_match('/^\d+$/',$line['content'])}
        {if $order['line']['isstyle']!=2}
            <div class="xc-list">
                <h3>行程安排</h3>
                <div class="agreement-travel-block clearfix">
                    {$order['line']['jieshao']}
                </div>
            </div>

        {else}

            <div class="xc-list">
                <h3>行程安排</h3>
                {loop Model_Line_Jieshao::detail($line['content'],$order['line']['lineday']) $v}
                <div class="day-con">
                    <div class="day-num"><strong>第{St_String::daxie($v['day'])}天</strong><p>{$v['title']}</p></div>
                    <dl class="day-attr">
                        <dt>用餐情况：</dt>
                        <dd>   
                            {if $v['breakfirsthas']}
                                {if !empty($v['breakfirst'])}
                                <span>早餐：{$v[breakfirst]}</span>
                                {else}
                                <span>早餐：含 </span>
                                {/if}
                            {else}
                             <span>早餐：不含 </span>
                            {/if}
                            {if $v['lunchhas']}
                                {if !empty($v['lunch'])}
                                <span>午餐：{$v[lunch]}</span>
                                {else}
                                <span>午餐：含</span>
                                {/if}
                            {else}
                             <span>午餐：不含 </span>
                            {/if}
                            {if $v['supperhas']}
                                {if !empty($v['supper'])}
                                <span>晚餐：{$v[supper]}</span>
                                {else}
                                <span>晚餐：含</span>
                                {/if}
                            {else}
                             <span>晚餐：不含 </span>
                            {/if}
                        </dd>
                    </dl>
                    <dl class="day-attr">
                        <dt>住宿情况：</dt>
                        <dd><span>{$v['hotel']}</span></dd>
                    </dl>
                    <dl class="day-attr">
                        <dt>交通工具：</dt>
                        <dd><span> {loop explode(',',$v['transport']) $t}
                                   {$t}
                                {/loop}</span></dd>
                    </dl>
                    <div class="contxt">
                        {$v['jieshao']}
                    </div>
                </div>
                {/loop}
            </div>
        {/if}

    {elseif $line['columnname']!='linedoc'}
        <div class="xc-list">
            <h3>{$line['chinesename']}</h3>
            <div class="contxt">
                {$line['content']}
            </div>
        </div>
    {/if}
{/loop}
</div>
