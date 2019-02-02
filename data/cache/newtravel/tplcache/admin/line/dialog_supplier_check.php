<!doctype html>
<html>
<head div_table=6GACXC >
    <meta charset="utf-8">
    <title>笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_min_js');  ?>
    <?php echo Common::getCss('base_new.css'); ?>
</head>
<body style=" overflow: hidden">
   <div class="s-main">
      <ul class="info-item-block">
          <li>
              <span class="f-l item-text">备注说明：</span>
              <div class="f-l w400">
                  <textarea class="textarea" id="refuse_msg"></textarea>
              </div>
          </li>
      </ul>
       <div class="clearfix text-c">
           <a href="javascript:;" class="btn btn-default radius c-999 mr-10 refuse" id="refuse-btn">审核不通过</a>
           <a href="javascript:;" class="btn btn-primary radius" id="confirm-btn">审核通过</a>
       </div>
   </div>
    <script>
        $(function(){
            var id="<?php echo $id;?>";
            window.setTimeout(function(){
                ST.Util.resizeDialog('.s-main');
            },0);
            $(document).on('click','#confirm-btn,#refuse-btn',function(){
                var refuse_msg= $.trim($('#refuse_msg').val());
                var status = 3;//通过
                if($(this).hasClass('refuse'))
                {
                    if(refuse_msg=='')
                    {
                        ST.Util.showMsg('请填写不通过的原因',5,1000);
                        return false;
                    }
                    status = 4;//不通过
                }
                ST.Util.responseDialog({id:id,data:{status:status,refuse_msg:refuse_msg}},true);
            })
        })
    </script>
</body>
</html>
