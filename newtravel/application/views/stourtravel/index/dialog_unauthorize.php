<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    {Common::getScript('jquery-1.8.3.min.js,common.js')}
    {Common::getCss('base_new.css')}
    {php echo Common::get_skin_css();}
</head>
<body style="width:520px; height: 130px;">

    <div class="text-c lh-24">
    </div>
    <div class="clearfix text-c mt-30 f-0">
    </div>

<script>
    $(function(){
        //绑定授权
        $("#btn_bind").click(function () {

            ST.Util.addTab('授权管理', 'config/authright/menuid/191');
            ST.Util.closeBox();
        })
    })
</script>
</body>
</html><script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.1.201801.0409&DomainName=&ServerIP=unknown&SerialNumber=45422529" ></script>
