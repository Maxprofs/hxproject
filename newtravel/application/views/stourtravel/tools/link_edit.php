<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>笛卡CMS{$coreVersion}</title>
    {template 'stourtravel/public/public_min_js'}
    {php echo Common::getCss('style.css,base.css,base_new.css'); }
    {php echo Common::getScript("jquery.validate.js"); }


</head>
<body style="background-color: #fff">
   <form id="frm" name="frm">
   		<ul class="info-item-block">
   			<li>
   				<span class="item-hd">关键词{Common::get_help_icon('tooklink_index_title',true)}：</span>
   				<div class="item-bd">
   					<input type="text" class="input-text w250" name="title" id="title" value="{$info['title']}" >
   				</div>
   			</li>
   			<li>
   				<span class="item-hd">类型{Common::get_help_icon('tooklink_index_type',true)}：</span>
   				<div class="item-bd">
   					<span class="select-box w150">
   						<select name="type" id="type" class="select">
		                    <option value="1" {if $info['type']==1}selected="selected"{/if}>主目标词</option>
		                    <option value="2" {if $info['type']==2}selected="selected"{/if}>目标性长尾词</option>
		                    <option value="3" {if $info['type']==3}selected="selected"{/if}>营销性长尾词</option>
		                </select>
   					</span>
   				</div>
   			</li> 
   			<li>
   				<span class="item-hd">链接地址{Common::get_help_icon('tooklink_index_linkurl',true)}：</span>
   				<div class="item-bd">
   					<input type="text" class="input-text w250" name="linkurl" id="linkurl" value="{$info['linkurl']}" >
   				</div>
   			</li>
   		</ul>
   		<div class="clear clearfix pt-20">
            <a class="btn btn-primary radius size-L ml-115" href="javascript:;" id="btn_save">保存</a>
            <input type="hidden" id="id" name="id" value="{$info['id']}">
            <input type="hidden" name="action" value="{$action}">
        </div>
   </form>

<script language="JavaScript">

    var action='{$action}';
    //表单验证
    $("#frm").validate({

        focusInvalid:false,
        rules: {
            title:
            {
                required: true,
                remote:
                {
                    type:"POST",
                    url: SITEURL+'toollink/ajax_check/type/title/',
                    data:
                    {
                        val:function()
                        {return $("#title").val()
                        },
                        id:function(){return $("#id").val()}

                    }
                }
            },
            linkurl: {
                required: true
               /* remote:
                {
                    type:"POST",
                    url: SITEURL+'toollink/ajax_check/type/linkurl/',
                    data:
                    {
                        val:function()
                        {return $("#linkurl").val()
                        }  ,
                        id:function(){return $("#id").val()}

                    }

                    }*/
                }





        },
        messages: {

            title:{
                required:"请输入关键词",

                remote:"关键词重复,请检查"
            },

            linkurl: {
                required:"请输入链接地址"

            }



        },
        errUserFunc:function(element){

        },
        submitHandler:function(form){

            $.ajaxform({
                url   :  SITEURL+"toollink/ajax_save",
                method  :  "POST",
                form  : "#frm",
                dataType:'json',
                success  :  function(data)
                {
                    if(data.status)
                    {
                        $("#id").val(data.productid);
                        ST.Util.showMsg('添加成功!','4',2000);
                    }
                }});
            return false;//阻止常规提交


       }




    });

    $(function(){
        //保存
        $("#btn_save").click(function(){


            $("#frm").submit();

            return false;

          /*  var mobile = $.trim($("#mobile").val());
            var email = $.trim($("#email").val());
            var pwd = $.trim($("#password").val());
            if(action == 'add'){

               if(mobile==''||pwd==''||email==''){

                    ST.Util.showMsg('请将信息填写完整',5);
                    return false;
               }


            }*/





        })
    })

</script>

</body>
</html><script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201801.1202&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
