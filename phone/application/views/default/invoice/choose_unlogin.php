
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

                    <dl class="edit-invoice-con invoice_normal_con">
                        <dd>
                            <span class="hd">发票明细</span>
                            <div class="bd">
                                <a href="#selInvoiceContentNormal">
                                    <span class="txt content" ></span>
                                    <i class="arr-more-icon"></i>
                                </a>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">发票类型</span>
                            <div class="bd" id="invoice_type_switch">
                                <label class="on" data-val="0"><i class="sel-ico"></i>个人</label>
                                <label data-val="1"><i class="sel-ico"></i>公司</label>
                                <input type="hidden" class="type" name="type" value="0"/>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">发票抬头</span>
                            <div class="bd">
                                <input type="text" class="txt title" placeholder="" value="">
                                <span class="tags">必填</span>
                            </div>
                        </dd>
                        <dd class="taxpayer_number_con" style="display: none">
                            <span class="hd">纳税人识别号</span>
                            <div class="bd">
                                <input type="text" class="txt taxpayer_number" placeholder="" value="">
                                <span class="tags">必填</span>
                            </div>
                        </dd>
                    </dl>
                    <!-- 普通发票 -->

                    <dl class="edit-invoice-con invoice_official_con">
                        <dd>
                            <span class="hd">发票明细</span>
                            <div class="bd">
                                <a href="#selInvoiceContentOfficial">
                                    <span class="txt content" ></span>
                                    <i class="arr-more-icon"></i>
                                </a>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">发票抬头</span>
                            <div class="bd">
                                <a href="#">
                                    <input type="text" class="txt title" placeholder="" value=""/>
                                    <span class="tags">必填</span>
                                </a>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">纳税人识别号</span>
                            <div class="bd">
                                <input type="text" class="txt taxpayer_number" placeholder="" value=""/>
                                <span class="tags">必填</span>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">地址</span>
                            <div class="bd">
                                <input type="text" class="txt taxpayer_address" placeholder="" value=""/>
                                <span class="tags">必填</span>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">联系电话</span>
                            <div class="bd">
                                <input type="text" class="txt taxpayer_phone" placeholder="" value=""/>
                                <span class="tags">必填</span>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">开户网点</span>
                            <div class="bd">
                                <input type="text" class="txt bank_branch" placeholder="" value=""/>
                                <span class="tags">必填</span>
                            </div>
                        </dd>
                        <dd>
                            <span class="hd">银行账号</span>
                            <div class="bd">
                                <input type="text" class="txt bank_account" placeholder="" value=""/>
                                <span class="tags">必填</span>
                            </div>
                        </dd>
                    </dl>
                    <!-- 增值发票 -->
                </div>
                <!-- 切换内容 -->

                <p class="tip-words">{$description}</p>
            </div>
        </div>

        <div class="btn-wrap">
            <a href="javascript:;" class="invo-btn" id="invoice_submit_btn">保存</a>
        </div>
    </div>

    <div id="selInvoiceContentNormal" class="page out">
        <div class="header_top bar-nav">
            <a class="back-link-icon" href="javascript:;" data-rel="back"></a>
            <h1 class="page-title-bar">发票明细</h1>
        </div>
        <!-- 公用顶部 -->

        <div class="page-content invoice-list-content">
            <div class="invoice-container">
                <ul class="invoice-tit-sel invoice-content-sel-normal">
                    {loop $contents $content}
                    <li data-val="{$content}"><label><i class="sel-ico"></i><span class="tit-name">{$content}</span></label></li>
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

        <div class="page-content invoice-list-content">
            <div class="invoice-container">
                <ul class="invoice-tit-sel  invoice-content-sel-official">
                    {loop $contents $content}
                    <li data-val="{$content}"><label><i class="sel-ico"></i><span class="tit-name">{$content}</span></label></li>
                    {/loop}
                </ul>
            </div>
        </div>
    </div>

    <!-- 填写发票信息 -->
    <script type="text/javascript">
        $(function(){

            //填写发票信息-类型切换
            $(".invoice-tabs span").click(function(){
                var index=$(this).index();
                $(this).addClass("on").siblings("span").removeClass("on");
                $(this).parents().siblings(".invoice-tabs-con").children(".invoice-tabs-con dl").eq(index).addClass("on").siblings("dl").removeClass("on");
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

            //类型切换
            $("#invoice_type_switch label").click(function(){
                var type=$(this).attr('data-val');
                $("#invoice_type_switch input:hidden").val(type);
                $(this).addClass('on');
                $(this).siblings().removeClass('on');

                if(type==0)
                {
                    $(".taxpayer_number_con").hide();
                }
                else
                {
                    $(".taxpayer_number_con").show();
                }
            })

            //选择发票
            $("#invoice_submit_btn").click(function(){
                var mtype=$(".invoice-tabs span.on").attr('data-val');
                if(!mtype || mtype=='')
                {
                    on_invoice_choosed(null);
                    window.history.back();
                    return;
                }


                var info = {};
                if(mtype==1)
                {
                    info['type'] = $(".invoice_normal_con input.type").val();
                    info['title'] = $(".invoice_normal_con input.title").val();
                    info['content'] =$(".invoice_normal_con span.content").text();
                    info['taxpayer_number'] = $(".invoice_normal_con input.taxpayer_number").val();
                }
                else if(mtype==2)
                {
                    info['type'] = 2;
                    info['title'] = $(".invoice_official_con input.title").val();
                    info['content'] =$(".invoice_official_con span.content").text();
                    info['taxpayer_number'] = $(".invoice_official_con input.taxpayer_number").val();
                    info['taxpayer_address'] = $(".invoice_official_con input.taxpayer_address").val();
                    info['taxpayer_phone'] = $(".invoice_official_con input.taxpayer_phone").val();
                    info['bank_branch'] = $(".invoice_official_con input.bank_branch").val();
                    info['bank_account'] = $(".invoice_official_con input.bank_account").val();
                }

                try {
                    if(!info['content'])
                    {
                        throw "发票明细不能为空";
                    }
                    if(!info['title'])
                    {
                        throw '发票抬头不能为空';
                    }

                    if(info['type']!=0 && !info['taxpayer_number'])
                    {
                        throw  "纳税人识别号不能为空";
                    }

                    if(info['type']==2)
                    {
                        if (!info['taxpayer_address']) {
                            throw '纳税人地址不能为空';
                        }
                        if (!info['taxpayer_phone'] || !is_phone(info['taxpayer_phone'])) {
                            throw '纳税人电话格式不正确';
                        }
                        if (!info['bank_branch']) {
                            throw '开户网点不能为空';
                        }
                        if (!info['bank_account']) {
                            throw '开启账号不能为空';
                        }
                    }
                }
                catch (e) {
                    $.layer({type:1, icon:2,time:1000, text:e});
                    return;
                }
                if(typeof(on_invoice_choosed)=='function')
                {
                    on_invoice_choosed(info);
                    window.history.back();
                }
            });


            //发票明细
            $(".invoice-content-sel-normal li").click(function(){
                $(this).find('label').addClass('on');
                $(this).siblings().find('label').removeClass('on');
                var content =  $(this).find('.tit-name').text();
                $(".invoice_normal_con span.content").text(content);
                window.history.back();
            });

            //发票明细
            $(".invoice-content-sel-official li").click(function(){
                $(this).find('label').addClass('on');
                $(this).siblings().find('label').removeClass('on');
                var content =  $(this).find('.tit-name').text();
                $(".invoice_official_con span.content").text(content);
                window.history.back();
            });

            //判断是否为手机
            function is_phone(value)
            {
                var mobile = /^1+\d{10}$/;
                var tel = /^\d{3,4}-?\d{7,9}$/;
                return tel.test(value) || mobile.test(value);
            }
        });
    </script>
