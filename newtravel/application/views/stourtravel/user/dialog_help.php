<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
        {template 'stourtravel/public/public_min_js'}
        {php echo Common::getCss('base.css,dialog_help.css'); }
	</head>
	<body>
        {if $info['status']==1}
		<div class="help-content-txt container">
             {if !empty($info['data']['content'])}
                {$info['data']['content']}
             {else}
                暂无相关内容
             {/if}
		</div>
        {else}
		<div class="pirate-warn container">
            <div class="ico-con">
			<div class="ico"></div>
            </div>
         </div>
        {/if}
        <script>
            ST.Util.resizeDialog('.container');
        </script>
	</body>
</html>
<script type="text/javascript" src="http://update.souxw.com/service/api_V3.ashx?action=releasefeedback&ProductName=stourwebcms&Version=7.0.201709.1401&DomainName=&ServerIP=unknown&SerialNumber=50551355" ></script>
