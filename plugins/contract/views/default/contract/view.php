<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{$info['title']}</title>
    <style>
        /*重置CSS*/
        body,
        html,
        div,
        blockquote,
        img,
        label,
        p,
        h1, h2, h3, h4, h5, h6,
        pre,
        ul, ol, li,
        dl, dt, dd,
        form,
        a,
        fieldset,
        input,
        th,
        td {
            margin: 0;
            padding: 0;
            border: 0;
            outline: none;
            font-size: 12px;
            font-family: '微软雅黑'
        }

        body,
        html {
            background: #e7e7e7
        }

        select, textarea {
            outline: none;
            font-family: '微软雅黑'
        }

        table {
            border-collapse: collapse;
            border-spacing: 0
        }

        fieldset, img {
            border: 0
        }

        address, caption, cite, code, dfn, em, strong, th, var {
            font-style: normal;
            font-weight: normal
        }

        ol, ul {
            list-style: none
        }

        a {
            color: #333;
            text-decoration: none
        }

        caption, th {
            text-align: left;
        }

        h1, h2, h3, h4, h5, h6 {
            font-size: 100%;
            font-weight: normal
        }

        .fl{
            float: left;
        }

        .fr{
            float: right;
        }

        .w150{
            width: 150px;
        }

        .w400{
            width: 400px;
        }

        .clearfix:before,
        .clearfix:after{
            content:'.';
            display:block;
            height:0;
            clear:both;
            overflow:hidden
        }

        abbr, acronym {
            border: 0
        }

        .print-topBox {
            height: 50px;
            line-height: 50px;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            text-align: center;
            background: #0082dd
        }

        .print-topBox a {
            color: #fff;
            font-size: 14px;
            margin: 0 45px;
        }

        .print-mid-content {
            width: 700px;
            margin: 70px auto 20px;
            padding: 10px 50px;
            background: #fff
        }

        .text-bottom-line{
            border-bottom: 1px solid #000;
        }

        .agreement-tit-bar{
            padding: 20px 0 30px;
            text-align: center;
            font-size: 30px;
        }
        .agreement-number{
            margin-bottom: 20px;
            text-align: right;
        }
        .agreement-first{
            margin-bottom: 20px;
            font-size: 14px;
        }
        .agreement-second{
            margin-bottom: 20px;
            font-size: 14px;
        }
        .agreement-box{
            padding: 20px 0;
        }
        .agreement-box .box-tit{
            text-align: center;
            font-size: 24px;
        }
        .agreement-box .agreement-txt{
            padding-top: 40px;
            line-height: 24px;
            font-size: 14px;
        }
        .agreement-box .agreement-txt .travel-container{
            margin-top: 50px;
        }
        .agreement-box .agreement-txt strong,
        .agreement-box .agreement-txt b{
            font-weight: bold !important;
        }

        .agreement-box .agreement-txt i,
        .agreement-box .agreement-txt em {
            font-style: italic !important;
        }

        .agreement-box .agreement-txt a {
            color: #0082dd;
        }

        .agreement-box .agreement-txt a:hover {
            color: #ff8a00;
            text-decoration: underline;
        }

        .agreement-box .agreement-txt *{
            max-width: 100%;
        }
        .agreement-box .agreement-txt table,
        .agreement-box .agreement-txt th,
        .agreement-box .agreement-txt td{
            border: 1px solid #e5e5e5;
        }
        .travel-container .travel-tit{
            padding-bottom: 10px;
            font-size: 14px;
        }
        .travel-table{
            width: 100%;
            border: 1px solid #333;
        }
        .travel-table td{
            height: 40px;
            padding: 0 8px;
            border: 1px solid #333;
        }
        .agreement-both{
            padding: 50px 0;
        }
        .agreement-both .box{
            width: 50%;
            line-height: 24px;
            position: relative;
        }
        .agreement-both .box .item{
            font-size: 14px;
        }
        .agreement-both .box-right .seal{
            width: 150px;
            height: 150px;
            position: absolute;
            left: 50px;
            top: 50%;
            margin-top: -75px;
        }
        .agreement-both .box-right .seal img{
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            -o-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }
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
    </style>
</head>

<body>
    {if $order['id']&&$headhidden!=1}
    <div class="print-topBox">
        <a href="javascript:;" onclick="if (window.print != null) { window.print(); } else {alert('没有安装打印机'); }">[打印本页]</a>
        <a href="javascript:;" onclick="javascript:window.close()">[关闭窗口]</a>
<!--        <a target="_blank" href="/contract/download/ordersn/{$order['ordersn']}">[下载本页]</a>-->
    </div>
    {/if}

    <div class="print-mid-content">

        <div class="agreement-tit-bar">{$info['title']}</div>
        <div class="agreement-number">合同编号：<input type="text" class="text-bottom-line w150" value="{$order['ordersn']}"  /></div>
        <div class="agreement-first">甲方：<input type="text" class="text-bottom-line w400" value="{$order['linkman']}" /></div>
        <div class="agreement-second">乙方：{$config['name']}（{$config['phone']}）</div>
        <div class="agreement-box clearfix">
            <div class="box-tit">合同条款</div>
            <div class="agreement-txt clearfix">
                {$info['content']}
            </div>
        </div>
        {if $info['typeid']==1}
        {template 'contract/public/line'}
        {/if}
        <div class="agreement-both clearfix">
            <div class="box fl">
                <p class="item">甲方签字：{$order['linkman']}</p>
                <p class="item">（盖章）：</p>
                <p class="item">联系电话：{$order['linktel']}</p>
                <p class="item">签约时间：{if $order}{date('Y',$order['addtime'])}年{date('m',$order['addtime'])}月{date('d',$order['addtime'])}日{else}{date('Y')}年{date('m')}月{date('d')}日{/if}</p>
            </div>
            <div class="box fr box-right">
                <p class="item">乙方签字：{$config['name']}</p>
                <p class="item">（盖章）：</p>
                <p class="item">联系电话：{$config['phone']}</p>
                <p class="item">签约时间：{if $order}{date('Y',$order['addtime'])}年{date('m',$order['addtime'])}月{date('d',$order['addtime'])}日{else}{date('Y')}年{date('m')}月{date('d')}日{/if}</p>
                <div class="seal"><img width="150"  src="{$config['seal']}" /></div>
            </div>
        </div>
        {if $info['typeid']==1&&$order['id']}
        {template 'contract/public/line_content'}
        {/if}

    </div>

</body>
</html>
