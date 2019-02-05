<!doctype html> <html> <head> <meta charset="utf-8"> <title> <?php if($ordertype=='all') { ?><?php echo __('全部订单');?><?php } else if($ordertype=='unpay') { ?><?php echo __('未付款订单');?><?php } else { ?><?php echo __('未点评订单');?><?php } ?>
-<?php echo $webname;?></title> <?php echo Common::css('user.css,base.css,extend.css');?> <?php echo Common::js('jquery.min.js,base.js,common.js');?> <style>
      .new{
          display: inline-block;
          width: 6px;
          height: 6px;
          position: relative;
          top: -10px;
          left: 5px;
          -webkit-border-radius: 50%;
          -moz-border-radius: 50%;
          border-radius: 50%;
          background: #f00;
      }
    </style> </head> <body> <?php echo Request::factory("pub/header")->execute()->body(); ?> <div class="big"> <div class="wm-1200"> <div class="st-guide"> <a href="<?php echo $cmsurl;?>"><?php echo __('首页');?></a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;<?php if($ordertype=='all') { ?><?php echo __('全部订单');?><?php } else if($ordertype=='unpay') { ?><?php echo __('未付款订单');?><?php } else { ?><?php echo __('未点评订单');?><?php } ?> </div><!--面包屑--> <div class="st-main-page"> <?php echo  Stourweb_View::template("member/left_menu");  ?> <div class="user-order-box"> <div class="user-home-box"> <div class="tabnav"> <span <?php if($ordertype=='all') { ?>class="on"<?php } ?>
 data-type="all"><?php echo __('全部订单');?></span> <span <?php if($ordertype=='unpay') { ?>class="on"<?php } ?>
 data-type="unpay"><?php echo __('未付款订单');?></span> <span <?php if($ordertype=='uncomment') { ?>class="on"<?php } ?>
 data-type="uncomment"><?php echo __('未点评订单');?></span> </div><!-- 订单切换 --> <div class="user-home-order"> <?php if(!empty($list)) { ?> <div class="order-list"> <table width="100%" border="0"> <tr> <th width="51%" height="38" bgcolor="#fbfbfb" scope="col"><?php echo __('订单信息');?></th> <th width="13%" height="38" bgcolor="#fbfbfb" scope="col"><?php echo __('会员账号');?></th> <th width="13%" height="38" bgcolor="#fbfbfb" scope="col"><?php echo __('订单金额');?></th> <th width="13%" height="38" bgcolor="#fbfbfb" scope="col"><?php echo __('订单状态');?></th> <th width="13%" height="38" bgcolor="#fbfbfb" scope="col"><?php echo __('订单操作');?></th> </tr> <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?> <tr> <td height="114"> <div class="con"> <dl> <dt><a href="<?php if($row['is_standard_product']) { ?><?php echo $row['producturl'];?><?php } else { ?><?php echo $cmsurl;?>member/order/view?ordersn=<?php echo $row['ordersn'];?><?php } ?>
" target="_blank"><img src="<?php echo Common::img($row['litpic'],110,80);?>" width="110" height="80" alt="<?php echo $row['productname'];?>" /></a></dt> <dd> <a class="tit" href="<?php if($row['is_standard_product']) { ?><?php echo $row['producturl'];?><?php } else { ?><?php echo $cmsurl;?>member/order/view?ordersn=<?php echo $row['ordersn'];?><?php } ?>
" target="_blank"><?php echo $row['productname'];?></a> <p><?php echo __('订单编号');?>：<?php echo $row['ordersn'];?></p> <p><?php echo __('下单时间');?>：<?php echo Common::mydate('Y-m-d H:i:s',$row['addtime']);?></p> </dd> </dl> </div> </td> <td align="center"> <?php
                       $user=Model_Member::get_member_info($row['memberid']);
                        if ($user['mobile']!='') {
                          echo $user['mobile'];
                        }else{
                          echo $user['email'];
                        }
                       ?> </td> <?php if($row['typeid']!=107) { ?> <td align="center"><span class="price"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $row['totalprice'];?></span></td> <?php } else { ?> <td align="center"><span class="price"><?php echo $row['needjifen'];?>&nbsp;积分</span></td> <?php } ?> <td align="center"><span class="dfk"><?php echo $row['statusname'];?></span></td> <td align="center"> <?php if($row['status']=='1'&&$row['pid']==0&&$row['memberid']==$mid) { ?> <a class="now-fk" href="<?php echo $cmsurl;?>member/index/pay?ordersn=<?php echo $row['ordersn'];?>"><?php echo __('立即付款');?></a> <a class="cancel_order now-dp" style="background:#ccc" href="javascript:;" data-orderid="<?php echo $row['id'];?>"><?php echo __('取消');?></a> <?php } else if($ordertype=='unpay'&&$row['pid']==0&&$row['memberid']==$mid) { ?> <a class="now-fk" href="<?php echo $cmsurl;?>member/index/pay?ordersn=<?php echo $row['ordersn'];?>"><?php echo __('立即付款');?></a> <a class="cancel_order now-dp" style="background:#ccc" href="javascript:;" data-orderid="<?php echo $row['id'];?>"><?php echo __('取消');?></a> <?php } else if($row['ispinlun']=='0' && $row['status']=='5' && $row['is_commentable']&&$row['memberid']==$mid) { ?> <a class="now-dp" href="<?php echo $cmsurl;?>member/order/pinlun?ordersn=<?php echo $row['ordersn'];?>"><?php echo __('立即点评');?></a> <?php } ?> <a class="order-ck" href="<?php echo $cmsurl;?>member/order/view?ordersn=<?php echo $row['ordersn'];?>"><?php echo __('查看订单');?><?php if($row['dconfirm']==0) { ?><s class="new"></s><?php } ?> </a> <!--   <?php if($ordertype=='all') { ?> <?php if($row['status']=='等待付款') { ?> <a class="now-fk" href="<?php echo $cmsurl;?>member/index/pay?ordersn=<?php echo $row['ordersn'];?>" target="_blank">立即付款</a> <?php } ?> <?php } ?> <?php if($ordertype=='unpay') { ?> <a class="now-fk" href="<?php echo $cmsurl;?>member/index/pay?ordersn=<?php echo $row['ordersn'];?>" target="_blank">立即付款</a> <?php } ?> <?php if($ordertype=='uncomment') { ?> <a class="now-dp" href="<?php echo $cmsurl;?>member/order/pinlun?ordersn=<?php echo $row['ordersn'];?>" >立即点评</a> <?php } ?> <a class="order-ck" href="<?php echo $cmsurl;?>member/order/view?ordersn=<?php echo $row['ordersn'];?>">查看订单</a>--> </td> </tr> <?php $n++;}unset($n); } ?> </table> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div><!-- 翻页 --> </div> <?php } else { ?> <div class="order-no-have"><span></span><p><?php echo __('没有查到相关订单信息');?>，<a href="/" target="_blank"><?php echo __('去逛逛');?></a><?php echo __('去哪儿玩吧');?>！</p></div> <?php } ?> </div><!-- 我的订单 --> </div> </div><!--所有订单--> </div> </div> </div> <?php echo Request::factory("pub/footer")->execute()->body(); ?> <?php echo Common::js('layer/layer.js');?> <script>
     $(function(){
         //导航选中
         $('#nav_allorder').addClass('on');
         if(typeof(on_leftmenu_choosed)=='function')
         {
             on_leftmenu_choosed();
         }
         //订单类型切换
         $(".tabnav span").click(function(){
             var orderType = $(this).attr('data-type');
             var url = SITEURL+'member/order/all-'+orderType;
             window.location.href = url;
         })
     })
 </script> <?php echo  Stourweb_View::template("member/order/jsevent");  ?> </body> </html>
