<!doctype html>
<html>
<head>

<meta charset="utf-8">
<title>{$seoinfo['seotitle']}-{$webname}</title>
    {if $seoinfo['keyword']}
    <meta name="keywords" content="{$seoinfo['keyword']}"/>
    {/if}
    {if $seoinfo['description']}
    <meta name="description" content="{$seoinfo['description']}"/>
    {/if}
    {$GLOBALS['cfg_indexcode']}
    {include "pub/varname"}
    {Common::css("font-awesome.min.css,base.css,index_2.css,extend.css")}
    {Common::js("jquery.min.js,jquery.cookie.js,base.js,common.js,SuperSlide.min.js,slideTabs.js,delayLoading.min.js")}
<script>
    $(function(){
        $('.con_list,.car_con_list,.article_con').switchTab({trigger:'hover'});
				            //首页焦点图
            $('.st-focus-banners').slide({
                mainCell:".banners ul",
                titCell:".focus li",
                effect:"fold",
                interTime: 5000,
                delayTime: 1000,
                autoPlay:true,
                switchLoad:"original-src"
            });
    })
</script>
</head>

<body>

{request "pub/header"}
<div class="usernav-frame">
  <div class="usernav">
      {include "pub/usernav"}
    <div class="index-right">
        <!--滚动焦点图开始-->
      <div class="st-focus-banners">
          <div class="banners">
              <ul>
                {st:ad action="getad" name="Index2RollingAd" pc="1" return="ad"}
                 {loop $ad['aditems'] $v}
                  <li class="banner"><a href="{$v['adlink']}" target="_blank"><img src="{Product::get_lazy_img()}" original-src="{Common::img($v['adsrc'],810,235)}" /></a></li>
                  {/loop}
                  {/st}
              </ul>
          </div>
          <div class="focus">
              <ul>
                {loop $ad['aditems'] $k}
                  <li></li>
                {/loop}
                </ul>
          </div>
      </div>
      <!--滚动焦点图结束-->
      <div class="arr">
        <span class="arrspan">出行风向标<i class="arri"></i></span>
        <div>
          <div class="usertitle hot">
            {st:ad action="getad" name="indexhot" pc="1" row="1"}
            {if !empty($data)}
            <div class="userbanner">
                <a href="{$data['adlink']}" target="_blank">
                  <img class="userimg" src="{Common::img($data['adsrc'])}" title="{$data['adname']}">
                </a>
            </div>
            {/if}
          </div>
          <!-- 近期热门 -->
          <div class="usertitle">
            {st:ad action="getad" name="indexnew" pc="1" row="1"}
            {if !empty($data)}
            <div class="userbanner usernew">
                <a href="{$data['adlink']}" target="_blank">
                  <img class="userimg" src="{Common::img($data['adsrc'])}" title="{$data['adname']}">
                </a>
            </div>
            {/if}
          </div>
          <!-- 新品上市 -->
          <div class="usertitle">
            {st:ad action="getad" name="indexval" pc="1" row="1"}
            {if !empty($data)}
            <div class="userbanner">
                <a href="{$data['adlink']}" target="_blank">
                  <img class="userimg" src="{Common::img($data['adsrc'])}" title="{$data['adname']}">
                </a>
            </div>
            {/if}
          </div>
          <!-- 超值特价 -->
        </div>
      </div>
      <div class="top_pz_box">
  <div class="child"><i class="fa fa-camera ico"></i> <span class="txt">深度旅行线路</span></div>
  <div class="child"><i class="fa fa-star ico"></i> <span class="txt">专业精品小团</span></div>
  <div class="child"><i class="fa fa-diamond ico"></i> <span class="txt">全程细心指导</span></div>
  <div class="child"><i class="fa fa-thumbs-up ico"></i> <span class="txt">全面安全保障</span></div>
</div>
    </div>
  </div>
</div>

<div class="user-frame">
  <div class="usernav">
    <div class="useradvtitle">
      <div class="useradvbg"></div>
        <!-- 广告1 -->
      <div class="useradv">
    {st:ad action="getad" name="indexadv1" pc="1" row="1"}
    {if !empty($data)}
    <div class="useradvbanner">
        <a href="{$data['adlink']}" target="_blank">
          <img class="useradvimg1 advright" src="{Common::img($data['adsrc'])}" title="{$data['adname']}">
        </a>
    </div>
    {/if}
</div>
  <!-- 广告2 -->
<div class="useradv">
    {st:ad action="getad" name="indexadv2" pc="1" row="1"}
    {if !empty($data)}
    <div class="useradvbanner">
        <a href="{$data['adlink']}" target="_blank">
          <img class="useradvimg2 advright" src="{Common::img($data['adsrc'])}" title="{$data['adname']}">
        </a>
    </div>
    {/if}
</div>

<div class="useradv useradvbanner">
  <table>
    <td>
      <tr>
            <!-- 广告3 -->
    {st:ad action="getad" name="indexadv3" pc="1" row="1"}
    {if !empty($data)}
    <div>
        <a href="{$data['adlink']}" target="_blank">
          <img class="useradvimg3 advright" src="{Common::img($data['adsrc'])}" title="{$data['adname']}">
        </a>
    </div>
    {/if}
      </tr>
      <tr>
            <!-- 广告4 -->
    {st:ad action="getad" name="indexadv4" pc="1" row="1"}
    {if !empty($data)}
    <div>
        <a href="{$data['adlink']}" target="_blank">
          <img class="useradvimg4" src="{Common::img($data['adsrc'])}" title="{$data['adname']}">
        </a>
    </div>
    {/if}
      </tr>
    </td>
  </table>


</div>
    </div>
  </div>
</div>


<!--品质保证-->
  <div class="big">
  	<div class="wm-1200">
        {st:channel action="pc" row="20"}
        {loop $data $row}
            {if $row['typeid'] < 14 && $row['issystem'] && !in_array($row['typeid'],array(0,6,7,9,10,11,12))}
                {include 'standard_pc_0_2_index/index_2/'.Model_Model::all_model($row['typeid'],'maintable')}
            {/if}
        {/loop}
    </div>
  </div>
{request "pub/footer"}
{request "pub/flink/isindex/1"}
</body>
</html>
