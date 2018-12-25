<!doctype html>
<html>

	<head>
		<meta charset="utf-8">
        <title>{__('常用发票')}-{$webname}</title>
        {include "pub/varname"}
        {Common::css('user.css,base.css,extend.css,invoice.css')}
        {Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.validate.addcheck.js')}
	</head>

	<body>

    {request "pub/header"}

		<div class="big">
			<div class="wm-1200">

				<div class="st-main-page">

                    {include "member/left_menu"}

					<div class="user-invoice-wrap fr">
						<div class="invoice-tit-box clearfix">
							<h3 class="fl">常用发票信息</h3>
							<a href="/member/index/invoice_add" class="fr add-invo-btn">新增常用发票</a>
						</div>
						<div class="invoice-con-box">
							<table>
								<thead>
									<tr>
										<th width="47%"><div class="invo-name">发票抬头</div></th>
										<th width="19%"><div class="invo-type">类型</div></th>
										<th width="34%"><div class="invo-btn-box">操作</div></th>
									</tr>
								</thead>
								<tbody>
                                {loop $list $row}
									<tr id="iv_{$row['id']}">
										<td><div class="invo-name">{$row['title']}</div></td>
										<td><div class="invo-type">{if $row['type']==2}增值发票{else}普通发票{/if}</div></td>
										<td>
											<div class="invo-btn-box">
												<a href="/member/index/invoice_edit?id={$row['id']}" class="edit-btn">修改</a>
												<a href="javascript:;" data-id="{$row['id']}" class="del-btn">删除</a>
											</div>
										</td>
									</tr>
								{/loop}
								</tbody>
							</table>
						</div>
					</div>

				</div>

			</div>
		</div>

    {request "pub/footer"}
    {Common::js('layer/layer.js')}
		<script>
			$(function() {

                //左侧菜单选中
                $("#nav_invoice").addClass('on');
                if(typeof(on_leftmenu_choosed)=='function')
                {
                    on_leftmenu_choosed();
                }


                $(".del-btn").click(function(){
                    var id=$(this).attr('data-id');

                    layer.confirm('{__("是否删除发票")}', {
                        icon: 3,
                        btn: ['{__("Abort")}','{__("OK")}'], //按钮,
                        btn1:function(){
                            layer.closeAll();
                        },
                        btn2:function(){
                            $.ajax({
                                type:'post',
                                url:SITEURL+'member/index/ajax_invoice_del',
                                data:{id:id},
                                dataType:'json',
                                success:function(data){
                                    if(data.status){
                                        layer.msg("删除成功",{
                                            icon:6,
                                            time:1000
                                        });
                                        $("#iv_"+id).remove();
                                    }else{
                                        layer.msg(data.msg, {icon:5});
                                        return false;
                                    }
                                }
                            })
                        },
                        cancel: function(index, layero){
                            layer.closeAll();

                        }
                    });
                });
			});
		</script>
	</body>
</html>