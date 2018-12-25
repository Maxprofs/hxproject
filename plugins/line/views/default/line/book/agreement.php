{if $GLOBALS['cfg_line_order_agreement_open'] || !empty($info['contract'])}
<div class="fl booking-agreement-block mt10">
    <span id="agreementBookingCheck" class="common-use-label {if $GLOBALS['cfg_line_order_agreement_selected']!=='0'}active{/if}"><i class="icon"></i>我已阅读并同意</span>
    {if $GLOBALS['cfg_line_order_agreement_open']}
    <a class="link" id="bkDocument" href="javascript:;">《预定须知》</a>
    {/if}
    {if $info['contract']}
    <a id="hdDocument" class="link" href="javascript:;">《{Common::cutstr_html($info['contract']['title'],14)}》</a>
    {/if}
</div>
{/if}
{if $GLOBALS['cfg_line_order_agreement_open']}
<div class="bk-document-box" style=" display: none;" id="bkDocumentBox">
    {$GLOBALS['cfg_line_order_agreement']}
</div>
{/if}

{if $info['contract']['content']}
<div class="bk-document-box" style=" display: none;" id="hdDocumentBox">
    {$info['contract']['content']}
</div>
{/if}

<script>
    $(function(){
        //预订须知合同
        $("#agreementBookingCheck").on("click",function(){
            if($(this).hasClass("active")){
                $(this).removeClass("active")
            }
            else{
                $(this).addClass("active")
            }
        });


        $("#bkDocument").on("click",function(){
            layer.open({
                type: 1,
                title: "预订须知",
                area: ['900px', '500px'],
                btn: ['确定'],
                btnAlign: "c",
                scrollbar: false,
                content: $('#bkDocumentBox')
            })
        });

        $("#hdDocument").on("click",function(){
            var title = $(this).text()
            layer.open({
                type: 2,
                title: title,
                area: ['900px', '500px'],
                btn: ['确定'],
                btnAlign: "c",
                scrollbar: false,
                content: "{$cmsurl}contract/book_view/contract_id/{$info['contractid']}"

            })
        });
    })
</script>