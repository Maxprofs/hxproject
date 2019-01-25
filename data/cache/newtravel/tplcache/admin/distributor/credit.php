<?php defined('SYSPATH') or die();?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>分销商列表-笛卡CMS<?php echo $coreVersion;?></title>
    <?php echo  Stourweb_View::template('stourtravel/public/public_js');  ?>
    <?php echo Common::getCss('style.css,base.css,base_new.css'); ?>
    <?php echo Common::getScript('datepicker/WdatePicker.js');?>
    <style>
        .item-name{
            position: relative;
            top: 5.5px;
        }
    </style>
</head>
<body style="overflow:hidden">
    <table class="content-tab">
        <tr>
            <td width="119px" class="content-lt-td" valign="top">
                <?php echo  Stourweb_View::template('stourtravel/public/leftnav');  ?>
                <!--右侧内容区-->
            </td>
            <td valign="top" class="content-rt-td" style="overflow:hidden">
                <div class="cfg-header-bar clearfix">
                    <a href="javascript:;" class="fr btn btn-primary radius mt-6 mr-10" onclick="window.location.reload()">刷新</a>
                </div>
                <div class="cfg-search-bar" id="search_bar">
                    <span class="cfg-search-tab display-mod fr">
                        <a href="javascript:void(0);" title="加盟授信管理" class="item on">加盟授信管理</a>
                    </span>
                </div>
                <div id="product_grid_panel" class="content-nrt" style="width: 100%;">
                    <div class="product-add-div">
                        <ul class="info-item-block">
                            <li class="list_dl">
                                <span class="item-hd">部门名称：</span>
                                <div class="item-bd">
                                    <span class="item-name" id="nickname"><?php echo $info['0']['nickname'];?></span>
                                </div>
                            </li>
                            <li class="list_dl">
                                <span class="item-hd">授信额度：</span>
                                <div class="item-bd">
                                    <span class="item-name" id="sx"><?php echo $info['0']['shouxinedu'];?></span>
                                </div>
                            </li>
                            <li class="list_dl">
                                <span class="item-hd">加盟期限：</span>
                                <div class="item-bd">
                                    <span class="item-name" id="jmqx"><?php echo $info['0']['jiamengqixian'];?></span>
                                </div>
                            </li>
                            <li class="list_dl">
                                <span class="item-hd">加盟费：</span>
                                <div class="item-bd">
                                    <span class="item-name" id="jmf"><?php echo $info['0']['jiamengfei'];?></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
<script>
</script>
</html>