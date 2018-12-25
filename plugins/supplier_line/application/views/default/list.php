<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>供应商管理</title>
    {Common::css('base.css,style.css,extend.css')}
    {Common::js('jquery.min.js,jquery.colorpicker.js,common.js,choose.js,product.js,insurance.js')}
    {include "pub"}
    <script src="/res/js/layer/layer.js"></script>
</head>

<body>

    	<div class="content-box">
        
        <div class="frame-box">
          
          <div class="pt-manage-box">
          
            <div class="pt-rows"><a class="pt-manage-add-btn fr add-line" href="javascript:;">添加</a></div>
            
            <div class="pm-tab-box">
            
              <div class="pm-search-box">
                <div class="pm-search-con"><form method="get"><input type="text" class="pm-search-text" name="keyword" value="{$keyword}"/><a href="javascript:void(0)" id="search_btn" class="pm-search-btn">搜索</a></form></div>
                <div class="pm-tabnav">
                  <a class="pm-ta-lb cur togmod"  href="{$cmsurl}index/list" data-id="1">列表</a>
                  <a class="pm-ta-bj togmod" href="{$cmsurl}index/suit" data-id="2">报价</a>
                </div>
              </div>

                <div class="pm-tabcon-list">
                    <table class="pm-table-hd" width="100%" border="0">
                        <tr class="pl-th">
                            <th width="5%" height="38" scope="col">选择</th>
                            <th width="15%" scope="col">编号</th>
                            <th width="40%" scope="col">路线名称</th>
                            <th width="15%" scope="col">报价有效期</th>
                            <th width="15%" scope="col">上架状态</th>
                            <th width="10%" scope="col">管理</th>
                        </tr>
                    </table>
                </div>

                <div class="pm-tabcon-list" id="productList">
                    <table class="pm-table-list" width="100%" border="0">
                        {loop $list $row}
                        <tr class="pl-tr" id="product_{$row['id']}">
                            <td width="5%" height="34" align="center"><div class="pm-table-boxs"><input type="checkbox" class="checkbox-lb cs-check" value="{$row['id']}"/></div></td>
                            <td width="15%" align="center"><div class="pm-table-boxs">{$row['lineseries']}</div></td>
                            <td width="40%"><div class="pm-table-boxs"><a class="pm-table-bt" href="{$row['url']}" target="_blank">{$row['title']}</a></div></td>
                            <td width="15%" align="center"><div class="pm-table-boxs">{if $row['suitday']}<span class="color-grey">{$row['suitday']}</span>{else}<span class="color-red">无报价</span>{/if}</div></td>
                            <td width="15%" align="center">
                                <div class="pm-table-boxs" data-id="{$row['id']}">
                                    {if $row['status']==0}
                                    <span class="sup-status-label edit" onclick="goCheck('{$row['id']}')" title="当前产品为编辑状态"></span>
                                    {elseif $row['status']==1}
                                    <span id="statusIngPass" class="sup-status-label ing statusIngPass" title="审核中"></span>
                                    {elseif $row['status']==2}
                                    <span class="sup-status-label hid up-product" title="当前产品为下架状态"></span>
                                    {elseif $row['status']==3}
                                    <span class="sup-status-label shw off-product" title="当前产品为上架状态"></span>
                                    {else}
                                    <span id="statusNotPass" class="sup-status-label not statusNotPass" data-msg="{$row['refuse_msg']}" title="未通过"></span>
                                    {/if}
                                </div>
                            </td>
                            <td width="10%" align="center">
                                <div class="pm-table-boxs">
                                    <a href="javascript:void(0)" class="pm-delete-btn" onclick="goEdit('{$row['id']}')"  title="编辑"></a>
                                    <a href="javascript:void(0)" class="pm-clone-btn" onclick="goClone('{$row['id']}')"  title="克隆"></a>
                                </div>
                            </td>
                        </tr>
                        {/loop}
                    </table>
                </div>
                <div class="pm-btm-box">
                    <a id="choose_all" class="pm-gn-btn" href="javascript:;">全选</a>
                    <a id="choose_diff" class="pm-gn-btn ml-10" href="javascript:;">反选</a>
                    <a class="pm-gn-btn btm-delete-btn ml-10" id="product_offline" href="javascript:;">下架</a>
                    <div class="pm-btm-msg">
                        {$pagestr}
                        <div class="show-num ml-20">
                            <form action="" method="get" id="pagesize_fm">
                                每页显示数量：
                                <select name="pagesize" >
                                    <option value="30" {if $pagesize==30} selected="selected"  {/if}>30</option>
                                    <option value="40" {if $pagesize==40} selected="selected"  {/if}>40</option>
                                    <option value="50" {if $pagesize==50} selected="selected"  {/if}>50</option>
                                    <option value="60" {if $pagesize==60} selected="selected"  {/if}>60</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
          </div><!-- 产品列表 -->
        </div>
        {include "footer"}
      </div>

<script>



    $(function() {
        $("#pagesize_fm select").change(function(){
            $("#pagesize_fm").submit();
        });

        $("#choose_all").click(function(){
            $(".cs-check").each(function(){
                $(this).attr("checked",true)
            });
        });
        $("#choose_diff").click(function(){
            $(".cs-check").each(function(){
                $(this).attr("checked",!this.checked);
            });
        });
        $("#product_offline").click(function(){

            if($(".cs-check:checked").length<=0)
            {
                ST.Util.showMsg("请选择至少一条线路",1);
                return;
            }
            ST.Util.confirmBox("提示","下架产品再次上架需要管理员审核,确定下架?",function(){
                $(".cs-check:checked").each(function(){
                    var id=$(this).val();
                    offProduct(id);
                });
            })

        });
        $("#search_btn").click(function(){
             $(this).parents("form:first").submit();
        });
        //添加线路
        $(".add-line").click(function(){
            var verifystatus = "{$userinfo['verifystatus']}";
            if(verifystatus != '3'){
                ST.Util.showMsg('未通过资质审核,暂时不能进行此操作',5);
                return false;
            }else{
                location.href = SITEURL+'index/add';
            }

        })

        //全局配置自定义样式
        layer.config({
            skin: 'supplier-skin'
        });


        //审核中
       $(".statusIngPass").on("click",function(){
            layer.closeAll();
            layer.open({
                type: 1,
                title:'审核提示',
                area: ["320px"],
                btn: ['确定'],
                btnAlign: "c",
                content: '正在等待平台管理员审核，请稍后'
            });
        });
        //审核未通过

        $(".statusNotPass").on("click",function(){
            layer.closeAll();
            var msg = $(this).data('msg');
            layer.open({
                type: 1,
                title:'审核提示',
                area: ["320px"],
                btn: ['确定'],
                btnAlign: "c",
                content: msg
            });
        })

        //上架产品
        $('.up-product').click(function(){

            var product_id = $(this).parents('.pm-table-boxs').first().data('id');
            upProduct(product_id);


        })
        //下架产品
        $('.off-product').click(function(){
            var product_id = $(this).parents('.pm-table-boxs').first().data('id');
            offProduct(product_id);
        })



    });

    $(window).resize(function(){
        sizeHeight()
    })
    function sizeHeight()
    {
        var pmHeight = $(window).height();
        var gdHeight = 250;
        $('#productList').height(pmHeight-gdHeight);
    }
    sizeHeight();

    //其他操作
     function goEdit(id)
     {
         ST.openUrl(SITEURL+"index/edit/id/"+id);
     }
    //克隆操作
    function goClone(id) {

        var url = SITEURL + 'index/ajax_clone_product';
        var params = {id: id, num: 1};
        $.ajax({
            type: "POST",
            url: url,
            data: params,
            dataType: "json",
            success: function (data) {
                if (data.status) {
                    ST.Util.showMsg('克隆成功', 4);
                    location.reload();
                }
                else {
                    ST.Util.showMsg("克隆失败，错误：" + data.msg, 5);
                }
            }
        });
    }
    function offProduct(id)
    {
        var url=SITEURL+'index/ajax_off_product';
        var params={id:id};
        $.ajax({
            type: "POST",
            url: url,
            data: params,
            dataType: "json",
            success: function(data){
                if(data.status)
                {
                    location.reload();
                  //  $("#product_"+id).remove();
                  //  $(".sub_"+id).remove();
                }
            }
        });
    }
    //上线产品
    function upProduct(id)
    {
        var url=SITEURL+'index/ajax_up_product';
        var params={id:id};
        $.ajax({
            type: "POST",
            url: url,
            data: params,
            dataType: "json",
            success: function(data){
                if(data.status)
                {
                    location.reload();
                    //  $("#product_"+id).remove();
                    //  $(".sub_"+id).remove();
                }
            }
        });

    }
    //提交审核
    function goCheck(id){
        ST.Util.showMsg('提交成功',4);
        var url=SITEURL+'index/ajax_verify_product';
        var params={id:id};
        $.ajax({
            type: "POST",
            url: url,
            data: params,
            dataType: "json",
            success: function(data){
                if(data.status)
                {
                    location.reload();
                    //  $("#product_"+id).remove();
                    //  $(".sub_"+id).remove();
                }
            }
        });
    }



</script>

</body>
</html>
