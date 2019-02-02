<?php defined('SYSPATH') or die();?> <!doctype html> <html> <head> <meta charset="utf-8"/> <?php echo  Stourweb_View::template("pub/varname");  ?> <?php echo Common::css('base.css,user.css');?> <?php echo Common::load_skin();?> <?php echo Common::js('jquery.min.js');?> </head> <body> <div class="user-order-box"> <div class="user-home-box"> <div class="tabnav"> <span <?php if($ordertype=='all') { ?>class="on"<?php } ?>
 data-type="all">全部订单</span> <span <?php if($ordertype=='unpay') { ?>class="on"<?php } ?>
 data-type="unpay">未付款订单</span> <span <?php if($ordertype=='uncomment') { ?>class="on"<?php } ?>
 data-type="uncomment">未点评订单</span> </div><!-- 订单切换 --> <div class="user-home-order"> <?php if(!empty($list)) { ?> <div class="order-list"> <table width="100%" border="0"> <tr> <th width="50%" height="38" bgcolor="#fbfbfb" scope="col">订单信息</th> <th width="10%" height="38" bgcolor="#fbfbfb" scope="col">使用日期</th> <th width="8%" height="38" bgcolor="#fbfbfb" scope="col">数量</th> <th width="8%" height="38" bgcolor="#fbfbfb" scope="col">订单金额</th> <th width="12%" height="38" bgcolor="#fbfbfb" scope="col">订单状态</th> <th width="12%" height="38" bgcolor="#fbfbfb" scope="col">订单操作</th> </tr> <?php $n=1; if(is_array($list)) { foreach($list as $row) { ?> <tr> <td height="114"> <div class="con"> <dl> <dt><a href="<?php echo $row['producturl'];?>" target="_blank"><img src="<?php echo Common::img($row['litpic'],110,80);?>" alt="<?php echo $row['productname'];?>" /></a></dt> <dd> <a class="tit" href="<?php echo $row['producturl'];?>" target="_blank"><?php echo $row['productname'];?></a> <p>订单编号：<?php echo $row['ordersn'];?></p> <p>下单时间：<?php echo Common::mydate('Y-m-d H:i:s',$row['addtime']);?></p> </dd> </dl> </div> </td> <td align="center"><span class="attr"><?php echo $row['usedate'];?></span></td> <td align="center"><span class="attr"><?php echo $row['dingnum'];?></span></td> <td align="center"><span class="price"><i class="currency_sy"><?php echo Currency_Tool::symbol();?></i><?php echo $row['totalprice'];?></span></td> <td align="center"><span class="dfk"><?php echo $row['statusname'];?></span></td> <td align="center"> <?php if($row['status']=='1') { ?> <a class="now-fk" target="_top" href="<?php echo $cmsurl;?>member/index/pay?ordersn=<?php echo $row['ordersn'];?>">立即付款</a> <a class="cancel_order now-dp" style="background:#ccc" href="javascript:;" data-orderid="<?php echo $row['id'];?>">取消</a> <?php } else if($ordertype=='unpay') { ?> <a class="now-fk"  target="_top" href="<?php echo $cmsurl;?>member/index/pay?ordersn=<?php echo $row['ordersn'];?>">立即付款</a> <a class="cancel_order now-dp" style="background:#ccc" href="javascript:;" data-orderid="<?php echo $row['id'];?>">取消</a> <?php } else if($row['ispinlun']=='0' && $row['status'] == '5') { ?> <a class="now-dp" target="_top" href="<?php echo $cmsurl;?>member/order/pinlun?ordersn=<?php echo $row['ordersn'];?>">立即点评</a> <?php } ?> <a class="order-ck" target="_top" href="<?php echo $cmsurl;?>member/order/view?ordersn=<?php echo $row['ordersn'];?>">查看订单</a> </td> </tr> <?php $n++;}unset($n); } ?> </table> <div class="main_mod_page clear"> <?php echo $pageinfo;?> </div><!-- 翻页 --> </div> <?php } else { ?> <div class="order-no-have"><span></span><p>没有查到相关订单信息，<a href="/" target="_blank">去逛逛</a>去哪儿玩吧！</p></div> <?php } ?> </div><!-- 我的订单 --> </div> </div><!--所有订单--> <script>
    var typeid = "<?php echo $typeid;?>";
    $(function(){
        $(".tabnav span").click(function(){
            var orderType = $(this).attr('data-type');
            var url = SITEURL+'member/order/plugin_list?typeid='+typeid+'&ordertype='+orderType;
            top.location.href = url;
        })
        //取消订单
        var LayerDlg = parent && parent.layer ? parent.layer:layer;
        $(".cancel_order").click(function(){
            var orderid = $(this).attr('data-orderid');
            var url = SITEURL +'visa/member/ajax_order_cancel';
            LayerDlg.confirm('<?php echo __("order_cancel_content");?>', {
                icon: 3,
                btn: ['<?php echo __("Abort");?>','<?php echo __("OK");?>'], //按钮
                btn1:function(){
                    LayerDlg.closeAll();
                },
                btn2:function(){
                    $.getJSON(url,{orderid:orderid},function(data){
                        if(data.status){
                            LayerDlg.msg('<?php echo __("order_cancel_ok");?>', {icon:6,time:1000});
                            setTimeout(function(){location.reload()},1000);
                        }
                        else{
                            LayerDlg.msg('<?php echo __("order_cancel_failure");?>', {icon:5,time:1000});
                        }
                    })
                },
                cancel:function(){
                    LayerDlg.closeAll();
                }
            })
        })
    })
</script> </body> </html>