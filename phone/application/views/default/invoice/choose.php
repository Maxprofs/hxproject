
    <div id="editInvoice" class="page out">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
            <h1 class="page-title-bar">发票</h1>
        </div>
        <!-- 公用顶部 -->

        <div class="page-content invoice-list-content">
            <div class="invoice-container">
                <div class="invoice-tabs clearfix">
                    <span class="on">不开发票</span>
                    {if in_array(1,$types)}
                    <span data-val="1">普通发票</span>
                    {/if}
                    {if in_array(2,$types)}
                    <span data-val="2">增值专票</span>
                    {/if}
                </div>
                <!-- 切换 -->

                <div class="invoice-tabs-con">
                    <dl class="on"></dl>
                    <!-- 不开发票 -->

                    <dl class="edit-invoice-con" id="invoice_normal_result">
                        <dd>
                            <span class="hd">发票明细</span>
                            <div class="bd">
                                <a href="#selInvoiceContentNormal">
                                <span class="txt invoice_content" ></span>
                                <i class="arr-more-icon"></i>
                                </a>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">发票抬头</span>
                            <div class="bd">
                                <a href="#selInvoiceNormal">
                                    <span class="txt invoice_title"></span>
                                    <i class="arr-more-icon"></i>
                                </a>
                            </div>
                        </dd>
                        <dd class="taxpayer_number_con" style="display: none;">
                            <span class="hd">纳税人识别号</span>
                            <div class="bd">
                                <span class="txt invoice_taxpayer_number"></span>
                            </div>
                        </dd>
                    </dl>
                    <!-- 普通发票 -->

                    <dl class="edit-invoice-con" id="invoice_official_result">
                        <dd>
                            <span class="hd">发票明细</span>
                            <div class="bd">
                                <a href="#selInvoiceContentOfficial">
                                <span class="txt invoice_content"></span>
                                <i class="arr-more-icon"></i>
                                </a>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">发票抬头</span>
                            <div class="bd">
                                <a href="#selInvoiceOfficial">
                                    <span class="txt invoice_title"></span>
                                    <i class="arr-more-icon"></i>
                                </a>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">纳税人识别号</span>
                            <div class="bd">
                                <span class="txt invoice_taxpayer_number"></span>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">地址</span>
                            <div class="bd">
                                <span class="txt invoice_taxpayer_address"></span>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">联系电话</span>
                            <div class="bd">
                                <span class="txt invoice_taxpayer_phone"></span>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">开户网点</span>
                            <div class="bd">
                                <span class="txt invoice_bank_branch"></span>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">银行账号</span>
                            <div class="bd">
                                <span class="txt invoice_bank_account"></span>
                            </div>
                        </dd>
                    </dl>
                    <!-- 增值发票 -->
                </div>
                <!-- 切换内容 -->

                <p class="tip-words" style="display: none">{$description}</p>
            </div>
        </div>

        <div class="btn-wrap">
            <a href="javascript:;" class="invo-btn" id="invoice_submit_btn">确认</a>
        </div>
    </div>
    <!-- 编辑发票信息 -->

    <div id="selInvoiceNormal" class="page out">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
            <h1 class="page-title-bar">常用发票</h1>
        </div>
        <!-- 公用顶部 -->

        <div class="page-content invoice-list-content">
            <div class="invoice-container">
                <ul class="invoice-tit-sel invoice_cs_list" id="invoice_list_normal">

                </ul>
            </div>
        </div>

        <div class="btn-wrap">
            <a href="{$cmsurl}member/invoice/add"  class="invo-btn">新增常用发票</a>
        </div>
    </div>
    <!-- 选择发票抬头 -->

    <div id="selInvoiceOfficial" class="page out">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
            <h1 class="page-title-bar">常用发票</h1>
        </div>
        <!-- 公用顶部 -->

        <div class="page-content invoice-list-content">
            <div class="invoice-container">
                <ul class="invoice-tit-sel invoice_cs_list" id="invoice_list_official">

                </ul>
            </div>
        </div>

        <div class="btn-wrap">
            <a href="{$cmsurl}member/invoice/add"  class="invo-btn">新增常用发票</a>
        </div>
    </div>
    <!-- 选择发票抬头 -->

    <div id="selInvoiceContentNormal" class="page out">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
            <h1 class="page-title-bar">发票明细</h1>
        </div>
        <!-- 公用顶部 -->

        <div class="page-content invoice-list-content invoice-content">
            <div class="invoice-container">
                <ul class="invoice-tit-sel invoice-content-sel-normal">
                    {loop $contents $content}
                    <li style="cursor: pointer;" data-val="{$content}"><label><i class="sel-ico"></i><span class="tit-name">{$content}</span></label></li>
                    {/loop}
                </ul>
            </div>
        </div>
    </div>
    <div id="selInvoiceContentOfficial" class="page out">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
            <h1 class="page-title-bar">发票明细</h1>
        </div>
        <!-- 公用顶部 -->

        <div class="page-content invoice-list-content invoice-content">
            <div class="invoice-container">
                <ul class="invoice-tit-sel  invoice-content-sel-official">
                    {loop $contents $content}
                    <li style="cursor:pointer" data-val="{$content}"><label><i class="sel-ico"></i><span class="tit-name">{$content}</span></label></li>
                    {/loop}
                </ul>
            </div>
        </div>
    </div>


    <!-- 填写发票信息 -->
    <script type="text/javascript">
        var g_normal_page=1;
        var g_official_page=1;
        var g_normal_loading=0;
        var g_official_loading=0;

        $(function(){

            var g_invoice_normal = {};
            var g_invoice_offical = {};

            //填写发票信息-类型切换
            $(".invoice-tabs span").click(function(){
                var index=$(this).index();
                $(this).addClass("on").siblings("span").removeClass("on");
                $(this).parents().siblings(".invoice-tabs-con").children(".invoice-tabs-con dl").eq(index).addClass("on").siblings("dl").removeClass("on");
                var mtype = $(".invoice-tabs span.on").attr('data-val');
                if(!mtype || mtype=='')
                {
                    $(".invoice-list-content .tip-words").hide();
                }
                else{
                    $(".invoice-list-content .tip-words").show();
                }
            });
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

            //第一次加载
            get_invoice_normal_list(g_normal_page);
            get_invoice_official_list(g_official_page);

            //选择发票
            $(document).on('click','.invoice_cs_list li',function(){
                $(this).find('label').addClass('on');
                $(this).siblings().find('label').removeClass('on');
                on_invoice_checked();
            });

            //发票明细
            $(".invoice-content-sel-normal li").click(function(){
                 $(this).find('label').addClass('on');
                 $(this).siblings().find('label').removeClass('on');
                var content =  $(this).find('.tit-name').text();
                 g_invoice_normal['content'] =content;
                 $("#invoice_normal_result .invoice_content").text(content);
                 window.history.back();
            });

            //发票明细
            $(".invoice-content-sel-official li").click(function(){
                $(this).find('label').addClass('on');
                $(this).siblings().find('label').removeClass('on');
                var content =  $(this).find('.tit-name').text();
                g_invoice_offical['content'] =content;
                $("#invoice_official_result .invoice_content").text(content);
                window.history.back();
            });


            //最终确定
            $("#invoice_submit_btn").click(function(){
                var result = check_invoice();
                if(!result)
                {
                    return;
                }

                var mtype = $(".invoice-tabs span.on").attr('data-val');
                var invoice = !mtype?null:g_invoice_normal;
                invoice = mtype==2?g_invoice_offical:invoice;
                if(typeof(on_invoice_choosed)=='function')
                {
                     on_invoice_choosed(invoice);
                     window.history.back();
                }
            });



            //当点击某个后
            function on_invoice_checked()
            {
                $(".invoice_cs_list li label.on").each(function(){
                     var p_ele = $(this).parents('li:first');

                    var info = {
                        'title':p_ele.attr('data-title'),
                        'type': p_ele.attr('data-type'),
                        'taxpayer_number':p_ele.attr('data-taxpayer_number'),
                        'taxpayer_address':p_ele.attr('data-taxpayer_address'),
                        'taxpayer_phone':p_ele.attr('data-taxpayer_phone'),
                        'bank_branch':p_ele.attr('data-bank_branch'),
                        'bank_account':p_ele.attr('data-bank_account')
                    };
                    if(info['type']==2)
                    {
                        g_invoice_offical= $.extend(g_invoice_offical,info);
                        $("#invoice_official_result .invoice_title").text(g_invoice_offical['title']);
                        $("#invoice_official_result .invoice_content").text(g_invoice_offical['content']);
                        $("#invoice_official_result .invoice_taxpayer_number").text(g_invoice_offical['taxpayer_number']);
                        $("#invoice_official_result .invoice_taxpayer_address").text(g_invoice_offical['taxpayer_address']);
                        $("#invoice_official_result .invoice_taxpayer_phone").text(g_invoice_offical['taxpayer_phone']);
                        $("#invoice_official_result .invoice_bank_branch").text(g_invoice_offical['bank_branch']);
                        $("#invoice_official_result .invoice_bank_account").text(g_invoice_offical['bank_account']);
                    }
                    else
                    {
                        g_invoice_normal =  $.extend(g_invoice_normal,info);
                        $("#invoice_normal_result .invoice_title").text(g_invoice_normal['title']);
                        $("#invoice_normal_result .invoice_content").text(g_invoice_normal['content']);
                        $("#invoice_normal_result .invoice_taxpayer_number").text(g_invoice_normal['taxpayer_number']);
                        if(info['type']==1)
                        {
                            $("#invoice_normal_result .taxpayer_number_con").show();
                        }
                        else
                        {
                            $("#invoice_normal_result .taxpayer_number_con").hide();
                        }
                    }

                });
                window.history.back();
            }

            //验证是否已选中发票
            function check_invoice()
            {
                var mtype = $(".invoice-tabs span.on").attr('data-val');
                try{
                    if(mtype==1)
                    {
                        if(!g_invoice_normal['content'])
                        {
                            throw '请选择发票明细';
                        }
                        if(!g_invoice_normal['title'])
                        {
                            throw '请选择发票';
                        }
                    }
                    if(mtype==2)
                    {
                        if(!g_invoice_offical['content'])
                        {
                            throw '请选择发票明细';
                        }
                        if(!g_invoice_offical['title'])
                        {
                            throw '请选择发票';
                        }
                    }
                }
                catch(e)
                {
                   $.layer({type:1, icon:2,time:1000, text:e});
                   return false;
                }
                return true;
            }
        });
        function on_invoice_edited()
        {
            get_invoice_normal_list(1);
            get_invoice_official_list(1);
        }

        //获取普通发票列表
        function get_invoice_normal_list(page)
        {
            if(g_normal_loading==1)
            {
                return;
            }
            g_normal_loading=1;
            var url = SITEURL + 'invoice/ajax_invoice_more';
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {page:page,types:'0,1'},
                url: url,
                success: function (data) {
                    var html='';
                    if(data && data.list)
                    {
                        for(var i in data.list)
                        {
                            var row=data.list[i];
                            html+='<li style="cursor:pointer" data-title="'+row['title']+'" data-type="'+row['type']+'" data-taxpayer_number="'+row['taxpayer_number']+'"' +
                            ' data-taxpayer_address="'+row['taxpayer_address']+'" data-taxpayer_phone="'+row['taxpayer_phone']+'" data-bank_branch="'+row['bank_branch']+'" data-bank_account="'+row['bank_account']+'">';
                            html+='<label><i class="sel-ico"></i><span class="tit-name">'+row['title']+'</span></label>';
                            html+='</li>';
                        }
                        $("#invoice_list_normal").append(html);
                    }
                },
                complete:function(){
                    g_normal_loading=0;
                }
            })
        }

        //获取增值发票
        function get_invoice_official_list(page)
        {
            if(g_official_loading==1)
            {
                return;
            }
            g_official_loading=1;
            var url = SITEURL + 'invoice/ajax_invoice_more';
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {page:page,types:2},
                url: url,
                success: function (data) {
                    var html='';
                    if(data && data.list)
                    {
                        for(var i in data.list)
                        {
                            var row=data.list[i];
                            html+='<li style="cursor:pointer" data-title="'+row['title']+'" data-type="'+row['type']+'" data-taxpayer_number="'+row['taxpayer_number']+'"' +
                            ' data-taxpayer_address="'+row['taxpayer_address']+'" data-taxpayer_phone="'+row['taxpayer_phone']+'" data-bank_branch="'+row['bank_branch']+'" data-bank_account="'+row['bank_account']+'">';
                            html+='<label><i class="sel-ico"></i><span class="tit-name">'+row['title']+'</span></label>';
                            html+='</li>';
                        }
                        $("#invoice_list_official").append(html);
                    }
                },
                complete:function(){
                    g_official_loading=0;
                }
            })
        }


        //重置发票， isforbidden表示是否禁用
        function invoice_reset(totalprice)
        {
            if(totalprice>0)
            {
                $("#invoice_book_con").show();
            }
            else
            {
                if(typeof(on_invoice_choosed)=='function')
                {
                    on_invoice_choosed(null);
                }
                if(totalprice==0)
                {
                    $("#invoice_book_con").hide();
                }
            }
        }
    </script>
