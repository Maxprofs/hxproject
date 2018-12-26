<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head> <meta charset="utf-8"> <title><?php echo $info['title'];?>-打印行程</title> <?php echo  Stourweb_View::template("pub/varname");  ?> <style>
/*重置CSS*/
body,
html,
div,
blockquote,
img,
label,
p,
h1,h2,h3,h4,h5,h6,
pre,
ul,ol,li,
dl,dt,dd,
form,
a,
fieldset,
input,
th,
td{
margin:0;
padding:0;
border:0;
outline:none;
font-size:12px;
font-family:'微软雅黑'}
body,
html{
background:#e7e7e7}
select,textarea{
outline:none;
font-family:'微软雅黑'}
table {
border-collapse:collapse;
border-spacing:0}
fieldset,img {
border:0}
address,caption,cite,code,dfn,em,strong,th,var{
font-style:normal;
font-weight:normal}
ol,ul {
list-style:none}
a{
color:#333;
text-decoration:none}
caption,th{
text-align:left;}
h1,h2,h3,h4,h5,h6{
font-size:100%;
font-weight:normal}
q:before,q:after{
content:'.';
display:block;
height:0;
clear:both;
visibility:hidden}
abbr,acronym{
border:0}
.print-topBox{
height:50px;
line-height:50px;
text-align:center;
background:#0082dd}
.print-topBox a{
color:#fff;
font-size:14px;
margin:0 45px;}
.print-mid-content{
width:700px;
margin:20px auto;
padding:10px 50px;
background:#fff}
.print-mid-content:after,
.day-num:after,
.day-attr dd:after{
content:'.';
clear:both;
display:block;
height:0;
overflow:hidden}
.print-top-msg{
height:50px;
padding-bottom:10px;
overflow:hidden;
border-bottom:1px solid #989898}
.print-top-msg .logo{
float:left;
height:50px}
.print-top-msg .logo img{
float:left;
height:50px}
.print-top-msg .lx-msg{
float:right;
height:40px;
padding:5px 0;}
.print-top-msg .lx-msg p{
color:#333;
height:20px;
line-height:20px;
text-align:right;}
.print-nrBox{
margin-top:1px;
border-top:2px solid #989898;
border-bottom:1px solid #989898}
.print-nrBox .xc-msg{
color:#333;
margin-bottom:20px}
.print-nrBox .xc-msg h1{
padding:15px 0;
font-size:24px}
.print-nrBox .xc-msg ul li{
line-height:24px;
font-size:14px}
.print-nrBox .xc-list{
margin-bottom:20px}
.print-nrBox .xc-list h3{
color:#333;
padding:5px;
font-size:20px;
border-bottom:1px solid #989898}
.print-nrBox .xc-list .day-con{
margin-top:15px;
padding-bottom:10px;
border-bottom:1px dotted #989898}
.print-nrBox .xc-list .day-con .day-num{
color:#333;}
.print-nrBox .xc-list .day-con .day-num strong{
float:left;
width:70px;
font-size:18px;
font-weight:bold}
.print-nrBox .xc-list .day-con .day-num p{
padding-left:70px;
line-height:30px;
font-size:14px}
.print-nrBox .xc-list .day-con .day-attr dt{
float:left;
width:70px;
height:24px;
line-height:24px;
font-weight:bold}
.print-nrBox .xc-list .day-con .day-attr dd{
padding-left:70px;
line-height:24px}
.print-nrBox .xc-list .day-con .day-attr dd span{
display:inline-block;
width:150px;
height:24px;
line-height:24px}
.print-nrBox .xc-list .contxt{
    padding:5px;
    margin-top:10px;
    font-size:14px;
    line-height:24px;
    overflow: hidden;
}
.print-nrBox .xc-list .contxt strong,
.print-nrBox .xc-list .contxt b{
font-weight: bold !important;
}
.print-nrBox .xc-list .contxt i,
.print-nrBox .xc-list .contxt em {
font-style: italic !important;
}
.print-nrBox .xc-list .contxt a {
color: #0082dd;
}
.print-nrBox .xc-list .contxt a:hover {
color: #ff8a00;
text-decoration: underline;
}
.print-nrBox .xc-list .contxt *{
max-width: 100%;
}
.print-nrBox .xc-list .contxt table,
.print-nrBox .xc-list .contxt th,
.print-nrBox .xc-list .contxt td{
    border: 1px solid #e5e5e5;
}
.print-bottomBox{
color:#333;
height:30px;
margin-top:1px;
border-top:2px solid #989898}
.print-bottomBox .num{
float:left;
height:30px;
line-height:30px}
.print-bottomBox .more{
float:right;
height:30px;
line-height:30px}
        .product-code {
            position: absolute;
            top: 50px;
            right: 20px;
            text-align: center;
        }
        .product-code .img {
            width: 105px;
            height: 105px;
        }
        .product-code .txt {
            display: block;
            padding: 5px 0;
        }
        .print-nrBox {
            margin-top: 1px;
            position: relative;
            border-top: 2px solid #989898;
            border-bottom: 1px solid #989898;
        }
        @media print {
            .print-topBox{
                display:none;
            }
        }
    </style> </head> <body> <div class="print-topBox"> <a href="javascript:;" onclick="if (window.print != null) { window.print(); } else {alert('没有安装打印机'); }">[打印本页]</a> <!--<a href="<?php echo $GLOBALS['cfg_basehost'];?>/lines/show_<?php echo $info['aid'];?>.html" >返回上一页</a>--> <a href="javascript:;" onclick="javascript:window.close()">[关闭窗口]</a> </div> <div class="print-mid-content"> <div class="print-top-msg"> <div class="logo"><a href="<?php echo $GLOBALS['cfg_basehost'];?>" target="_blank"><img src="<?php echo $GLOBALS['cfg_logo'];?>" /></a></div> <div class="lx-msg"> <p>TEL：<?php echo $GLOBALS['cfg_phone'];?></p> <p><?php echo $GLOBALS['cfg_basehost'];?></p> </div> </div> <div class="print-nrBox"> <div class="product-code"> <img class="img" src="/res/vendor/qrcode/make.php?param=<?php echo $GLOBALS['cfg_basehost'];?>/lines/show_<?php echo $info['aid'];?>.html"> <span class="txt">查看产品</span> </div> <div class="xc-msg"> <h1><?php echo $info['title'];?></h1> <ul> <li>线路网址：<?php echo $GLOBALS['cfg_basehost'];?>/lines/show_<?php echo $info['aid'];?>.html</li> <li>出发城市：<?php echo $info['startcity'];?></li> <li>出行天数：<?php echo $info['lineday'];?>天</li> <li>往返交通：<?php echo $info['transport'];?></li> </ul> </div> <?php require_once ("E:/wamp64/www/taglib/detailcontent.php");$detailcontent_tag = new Taglib_Detailcontent();if (method_exists($detailcontent_tag, 'get_content')) {$linecontent = $detailcontent_tag->get_content(array('action'=>'get_content','typeid'=>'1','productinfo'=>$info,'return'=>'linecontent',));}?> <?php $n=1; if(is_array($linecontent)) { foreach($linecontent as $line) { ?> <?php if(preg_match('/^\d+$/',$line['content'])) { ?> <div class="xc-list"> <h3>行程安排</h3> <?php if($info['isstyle']==2) { ?> <?php $n=1; if(is_array(Model_Line_Jieshao::detail($line['content'],$info['lineday']))) { foreach(Model_Line_Jieshao::detail($line['content'],$info['lineday']) as $v) { ?> <div class="day-con"> <div class="day-num"><strong>第<?php echo Common::daxie($v['day']);?>天</strong> <p><?php echo $v['title'];?></p></div> <?php if($info['showrepast']==1) { ?> <dl class="day-attr"> <dt>用餐情况：</dt> <dd> <?php if($v['breakfirsthas'] ) { ?> <span>早餐：<?php if(!empty($v['breakfirst'])) { ?><?php echo $v['breakfirst'];?><?php } else { ?>含<?php } ?> </span> <?php } else { ?> <span>早餐：不含</span> <?php } ?> <?php if($v['lunchhas']) { ?> <span>午餐：<?php if(!empty($v['lunch'])) { ?><?php echo $v['lunch'];?><?php } else { ?>含<?php } ?> </span> <?php } else { ?> <span>午餐：不含</span> <?php } ?> <?php if($v['supperhas']) { ?> <span>晚餐：<?php if(!empty($v['supper'])) { ?><?php echo $v['supper'];?><?php } else { ?>含<?php } ?> </span> <?php } else { ?> <span>晚餐:不含</span> <?php } ?> </dd> </dl> <?php } ?> <?php if($info['showhotel']==1 && !empty($v['hotel'])) { ?> <dl class="day-attr"> <dt>住宿情况：</dt> <dd><span><?php echo $v['hotel'];?></span></dd> </dl> <?php } ?> <?php if($info['showtran']==1 && !empty($v['transport'])) { ?> <dl class="day-attr"> <dt>交通工具：</dt> <dd><span> <?php $n=1; if(is_array(explode(',',$v['transport']))) { foreach(explode(',',$v['transport']) as $t) { ?> <?php echo $t;?> <?php $n++;}unset($n); } ?> </span> </dd> </dl> <?php } ?> <div class="contxt"> <?php echo $v['jieshao'];?> </div> </div> <?php $n++;}unset($n); } ?> <?php } else { ?> <div class="contxt"> <?php echo $info['jieshao'];?> </div> <?php } ?> </div> <?php } else if($line['columnname']!='linedoc') { ?> <div class="xc-list"> <h3><?php echo $line['chinesename'];?></h3> <div class="contxt"> <?php echo $line['content'];?> </div> </div> <?php } ?> <?php $n++;}unset($n); } ?> </div> <div class="print-bottomBox"> <div class="num"> <span>电话：<?php echo $GLOBALS['cfg_phone'];?></span> <!--   <span>微信：sdwdlvyou</span>--> </div> <div class="more">更多线路请登录：<?php echo $GLOBALS['cfg_basehost'];?></div> </div> </div> </body> </html>
