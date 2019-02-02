<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head> <meta charset="utf-8"> <title>打印行程</title> <style>
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
.print-nrBox .xc-list .day-con .day-attr{
float:left;
width:690px;
            padding: 5px 5px 0;
        }
        .print-nrBox .xc-list .day-con .day-attr li{
            float: left;
            width: 700px;
            height: 24px;
        }
        .print-nrBox .xc-list .day-con .day-attr li span{
            float: left;
            width: 30%;
        }
        .print-nrBox .xc-list .day-con .day-attr li strong{
            display: inline-block;
            width: 70px;
            font-weight:bold;
        }
.print-nrBox .xc-list .contxt{
padding:5px;
margin-top:10px;
font-size:14px;
line-height:24px;
overflow: hidden;
}
.print-nrBox .xc-list .contxt img{
max-width: 100%;
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
        .print-bottomBox .num span{
            margin-right: 20px;
        }
.print-bottomBox .more{
float:right;
height:30px;
line-height:30px}
</style> </head> <body> <div class="print-topBox"> <a href="javascript:;" onclick="if (window.print != null) { window.print(); } else {alert('没有安装打印机'); }">[打印本页]</a> <a href="<?php echo $GLOBALS['cfg_basehost'];?>/ship/show_<?php echo $info['aid'];?>.html">返回上一页</a> <a href="javascript:;" onclick="javascript:window.close()">[关闭窗口]</a> </div> <div class="print-mid-content"> <div class="print-top-msg"> <div class="logo"><a href="<?php echo $GLOBALS['cfg_basehost'];?>"><img src="<?php echo $GLOBALS['cfg_logo'];?>" /></a></div> <div class="lx-msg"> <p>TEL：<?php echo $GLOBALS['cfg_phone'];?></p> <p><?php echo $GLOBALS['cfg_basehost'];?></p> </div> </div> <div class="print-nrBox"> <div class="xc-msg"> <h1><?php echo $info['title'];?></h1> <ul> <li>线路网址：<?php echo $GLOBALS['cfg_basehost'];?>/ship/show_<?php echo $info['aid'];?>.html</li> <li>航线编号：<?php echo $info['series'];?></li> <li>出发地：<?php echo $info['startcity'];?></li> <li>目的地：<?php echo $info['finaldest_name'];?></li> <li>行程天数：<?php echo $info['schedule_name'];?></li> <?php if(!empty($info['starttime'])) { ?> <li>出发日期：<?php echo date('Y年m月d日',$info['starttime']);?></li> <?php } ?> <?php if(!empty($info['endtime'])) { ?> <li>返程日期：<?php echo date('Y年m月d日',$info['endtime']);?></li> <?php } ?> </ul> </div> <div class="xc-list"> <h3>行程安排</h3> <?php $n=1; if(is_array($jieshaolist)) { foreach($jieshaolist as $v) { ?> <div class="day-con"> <div class="day-num"><strong>第<?php echo Common::daxie($v['day']);?>天</strong><p><?php echo $v['title'];?></p></div> <ul class="day-attr"> <?php if($v['starttimehas']==1 || $v['endtimehas']==1) { ?> <li> <?php if($v['starttimehas']==1) { ?> <span><strong>起航时间：</strong><?php echo $v['starttime'];?></span> <?php } ?> <?php if($v['endtimehas']==1) { ?> <span><strong>抵达时间：</strong><?php echo $v['endtime'];?></span> <?php } ?> </li> <?php } ?> <li> <span><strong>邮轮早餐：</strong> <?php if($v['breakfirsthas']) { ?> <?php if(!empty($v['breakfirst'])) { ?> <?php echo $v['breakfirst'];?> <?php } else { ?>
                                                          含
                                                        <?php } ?> <?php } else { ?>
                                                      不含
                                                    <?php } ?> </span> <span><strong>邮轮午餐：</strong> <?php if($v['lunchhas']) { ?> <?php if(!empty($v['lunch'])) { ?> <?php echo $v['lunch'];?> <?php } else { ?>
                                                            含
                                                        <?php } ?> <?php } else { ?>
                                                   不含
                                                <?php } ?> </span> <span><strong>游轮晚餐：</strong> <?php if($v['supperhas']) { ?> <?php if(!empty($v['supper'])) { ?> <?php echo $v['supper'];?> <?php } else { ?>
                                                      含
                                                    <?php } ?> <?php } else { ?>
                                                    不含
                                                <?php } ?> </span> </li> <?php if($v['countryhas']==1 || $v['livinghas']==1) { ?> <li> <?php if($v['countryhas']==1) { ?> <span><strong>国家/城市：</strong><?php echo $v['country'];?></span> <?php } ?> <?php if($v['livinghas']==1) { ?> <span><strong>入住：</strong><?php echo $v['living'];?></span> <?php } ?> </li> <?php } ?> </ul> <div class="contxt"> <?php echo $v['content'];?> </div> </div> <?php $n++;}unset($n); } ?> </div> </div> <div class="print-bottomBox"> <div class="num"> <span>电话：<?php echo $GLOBALS['cfg_phone'];?></span> </div> <div class="more">更多线路请登录：<?php echo $GLOBALS['cfg_basehost'];?></div> </div> </div> </body> </html>
