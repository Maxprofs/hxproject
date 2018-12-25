
    <div id="pageInvoice" class="page out">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
            <h1 class="page-title-bar">常用发票信息</h1>
        </div>
        <!-- 公用顶部 -->

        <div class="page-content invoice-list-content">
            <div class="invoice-container">
                <ul class="invoice-list-block" id="invoice_con">

                </ul>
            </div>

            <div class="no-invoice-page hide">
                <div class="no-invoice-icon"></div>
                <p class="no-invoice-txt">您还没有发票信息哦！</p>
            </div>
        </div>

        <div class="btn-wrap">
            <a href="{$cmsurl}member/invoice/add" class="invo-btn">新增常用发票信息</a>
        </div>
        <div class="lay-wrap">
            <div class="del-wrap">
                <p>确定删除该发票吗？</p>
                <div class="lay-btn-wrap clearfix">
                    <a href="javascript:" class="cancel-btn">取消</a>
                    <a href="javascript:" class="confirm-btn">确定</a>
                </div>
            </div>
        </div>
    </div>




    <!-- 删除弹框 -->

    <script type="text/javascript">
        var g_invoice_list_page=1;
        var g_invoice_list_isloading=0;
        var g_invoice_list_isfinish=0;
        $(function(){
            //填写状态
            $(".edit-invoice-con dd .bd input").focus(function(){
                $(this).siblings(".tags").hide();
            });
            $(".edit-invoice-con dd .bd input").blur(function(){
                var val=$(this).val();
                if(val==""){
                    $(this).siblings(".tags").show();
                }
            });

            //删除信息
            $(document).on('click',"#invoice_con .del-btn",function(){
                $(this).parents('li:first').addClass('del').siblings('li').removeClass('del');
                $("#pageInvoice .lay-wrap").show();
            });

            //取消删除
            $("#pageInvoice .lay-wrap .cancel-btn").click(function(){
                $("#invoice_con li").removeClass('on');
                $("#pageInvoice .lay-wrap").hide();
            });

            //确定删除
            $("#pageInvoice .lay-wrap .confirm-btn").click(function(){
                var id=$("#invoice_con li.del").attr('data-id');
                var url = SITEURL + 'member/invoice/ajax_invoice_del';
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {id:id},
                    url: url,
                    success:function(data) {
                        if (data.status)
                        {
                            $("#invoice_item_"+id).remove();
                        }
                        else
                        {
                            $.layer({
                                type:2,
                                text:data.msg,
                                time:1000
                            })
                        }
                    },
                    complete:function(){
                        $("#pageInvoice .lay-wrap").hide();
                    }
                })
            });


            //滚动加载
            $('.invoice-list-content').scroll( function() {
                var totalheight = parseFloat($(this).height()) + parseFloat($(this).scrollTop());
                var scrollHeight = $(this)[0].scrollHeight;//实际高度
                if(totalheight-scrollHeight>= -10){
                    if(g_invoice_list_isfinish==0)
                    {
                        get_invoice_list(parseInt(g_invoice_list_page)+1);
                    }
                }
            });



            //第一次加载
            get_invoice_list(g_invoice_list_page);




        });
        //获取数据函数
        function get_invoice_list(page)
        {
            if(g_invoice_list_isloading==1)
            {
                return;
            }
            g_invoice_list_isloading=1;
            var url = SITEURL + 'member/invoice/ajax_invoice_more';
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {page:page},
                url: url,
                success: function (data) {
                    var html='';
                    if(data && data.list)
                    {
                        for(var i in data.list)
                        {
                            var row=data.list[i];
                            html+='<li class="item" id="invoice_item_'+row['id']+'" data-id="'+row['id']+'">';
                            html+='<div class="box">';
                            html+='<div class="bd-info">';
                            html+='<div class="bt">'+row['title']+'</div>';
                            html+='<div class="tc">';

                            var type_name = row['type']==2?'增值发票':'普通发票';
                            html+='<span>'+type_name+'</span>';
                            html+='<span>'+row['taxpayer_number']+'</span>';
                            html+='</div>';
                            html+='</div>';
                            html+='</div>';
                            html+='<div class="bar">';
                            html+='<a href="'+SITEURL+'member/invoice/edit?id='+row['id']+'" class="edit-btn"><i class="icon"></i>编辑</a>';
                            html+='<a href="javascript:;" class="del-btn"><i class="icon"></i>删除</a>';
                            html+='</div>';
                            html+='</li>'
                        }
                        if(page==1)
                        {
                            $("#invoice_con").html(html);
                        }
                        else{
                            $("#invoice_con").append(html);
                        }

                    }

                    if(!data || !data.list || data.list.length<10)
                    {
                        g_invoice_list_isfinish=1;
                    }

                    if($("#invoice_con li").length<=0)
                    {
                        $(".no-invoice-page").show();
                    }
                    else
                    {
                        $(".no-invoice-page").hide();
                    }
                },
                complete:function(){
                    g_invoice_list_isloading=0;
                }
            })
        }

        function  on_invoice_edited()
        {
            get_invoice_list(1);
        }
    </script>
