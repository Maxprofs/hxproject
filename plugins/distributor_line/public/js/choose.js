/**
 * Created by Administrator on 14-8-18.
 */

var CHOOSE={};
    //按站点搜索
    CHOOSE.changeWeb=function(obj,webid,webname,resultid){

        window.product_store.getProxy().setExtraParam('webid',webid);
        window.product_store.loadPage(1);
        $("#"+resultid).html(webname);
        $(obj).addClass('cur').siblings().removeClass('cur');

    }
   //按出发地搜索
    /*
    * obj:当前对象
    * cityid:当前选择的城市id,
    * cityname:当前城市名称,
    * resultid:存储当前城市名称的容器id.
    * */
   CHOOSE.changeStartPlace=function(obj,cityid,cityname,resultid,isall){

       window.product_store.getProxy().setExtraParam('startcity',cityid);
       window.product_store.loadPage(1);
       $("#"+resultid).html(cityname);
       var level = Number($(obj).attr('data-level'));

       $(obj).addClass('cur').siblings().removeClass('cur');

       //读取下级关系
       if(!isall){
           CHOOSE.getCityChild(cityid,resultid,level);//获取下级关系
       }
       else
       {
          $("#startplace_detail").find("div[id^='level']").remove();
       }

   }
     /*
     * pid:父级id,
     * contain:存储容器
     * */
  CHOOSE.getCityChild = function(pid,resultid,level){
      $.ajax({
          type:'POST',
          data:{pid:pid},
          url:SITEURL+'box/ajax_get_citychild',
          dataType:'json',
          success:function(data){

              if(data.length>0){
                  level = level+1;
                  $("#level"+level).remove();
                  var html=' <div class="level" id="level'+level+'">';
                  $.each(data,function(i,row){

                      html+='<a href="javascript:;" data-level="'+level+'" onclick="CHOOSE.changeStartPlace(this,'+row.id+',\''+row.cityname+'\',\''+resultid+'\',0)" >'+row.cityname+'</a>';
                  })
                  html+='</div>';
                  $("#startplace_detail").append(html);

              }



          }
      })


  }

//按目的地搜索
/*
 * obj:当前对象
 * kindid:当前选择的目的地id,
 * kindname:目的地名称,
 * resultid:存储当前名称的容器id.
 * */
CHOOSE.changeDestId=function(obj,kindid,kindname,resultid,isall){

    window.product_store.getProxy().setExtraParam('kindid',kindid);
    window.product_store.loadPage(1);
    $("#"+resultid).html(kindname);
    var level = Number($(obj).attr('data-level'));

    $(obj).addClass('cur').siblings().removeClass('cur');
    window.line_kindname = kindname;//用于列表显示相应目的地排序header
    window.product_kindid = kindid;//当前目的地id
    window.product_kindname = kindname;
    //读取下级关系
    if(!isall){
        CHOOSE.getDestChild(kindid,resultid,level);//获取下级关系
    }
    else
    {
        $("#destlist_detail").find("div[id^='level']").remove();
    }

}
/*
 * pid:父级id,
 * contain:存储容器
 * level:当前层
 * */
CHOOSE.getDestChild = function(pid,resultid,level){
    $.ajax({
        type:'POST',
        data:{pid:pid},
        url:SITEURL+'box/ajax_get_destchild',
        dataType:'json',
        success:function(data){

            if(data.length>0){
                level = level+1;
                var dellevel = level;

                while(dellevel<=5){

                    $("#level"+dellevel).remove();
                    dellevel++;


                }
                var html=' <div class="level" id="level'+level+'">';
                $.each(data,function(i,row){

                    html+='<a href="javascript:;" data-level="'+level+'" onclick="CHOOSE.changeDestId(this,'+row.id+',\''+row.kindname+'\',\''+resultid+'\',0)" >'+row.kindname+'</a>';
                })
                html+='</div>';

                $("#destlist_detail").append(html);



            }



        }
    })


}

//按属性搜索
/*
 * obj:当前对象
 * attrid:当前选择的属性id,
 * attrname:当前属性名称,
 * resultid:存储当前名称的容器id.
 * isall:是否是"全部"按钮
 * */
CHOOSE.changeAttrId=function(obj,attrid,attrname,resultid,isall){

    window.product_store.getProxy().setExtraParam('attrid',attrid);
    window.product_store.loadPage(1);
    $("#"+resultid).html(attrname);
    var level = Number($(obj).attr('data-level'));

    $(obj).addClass('cur').siblings().removeClass('cur');

    //读取下级关系
    if(!isall){
        CHOOSE.getAttrIdChild(attrid,resultid,level);//获取下级关系
    }
    else
    {
        $("#attrlist_detail").find("div[id^='level']").remove();
    }

}
/*
 * pid:父级id,
 * contain:存储容器
 * */
CHOOSE.getAttrIdChild = function(pid,resultid,level){
    var typeid = $("#typeid").val();
    $.ajax({
        type:'POST',
        data:{pid:pid,typeid:typeid},
        url:SITEURL+'box/ajax_get_attrchild',
        dataType:'json',
        success:function(data){

            if(data.length>0){
                level = level+1;
                var dellevel = level;

                while(dellevel<=5){

                    $("#level"+dellevel).remove();
                    dellevel++;


                }
                var html=' <div class="level" id="level'+level+'">';
                $.each(data,function(i,row){

                    html+='<a href="javascript:;" data-level="'+level+'" onclick="CHOOSE.changeAttrId(this,'+row.id+',\''+row.attrname+'\',\''+resultid+'\',0)" >'+row.attrname+'</a>';
                })
                html+='</div>';

                $("#attrlist_detail").append(html);



            }



        }
    })


}

/*
* 关键词搜索
* */

CHOOSE.searchKeyword=function(keyword){
    var keyword = $.trim($("#searchkey").val());
    var datadef = $("#searchkey").attr('datadef');
    keyword = keyword==datadef ? '' : keyword;
    window.product_store.getProxy().setExtraParam('keyword',keyword);
    window.product_store.loadPage(1);

}

/*
* 按车型进行搜索
* */

CHOOSE.changeCarKind=function(obj,kindid,kindname,resultid,isall){

    window.product_store.getProxy().setExtraParam('carkindid',kindid);
    window.product_store.loadPage(1);
    $("#"+resultid).html(kindname);
    $(obj).addClass('cur').siblings().removeClass('cur');


}
/*
 * 按签证类型进行搜索
 * */

CHOOSE.changeVisaKind=function(obj,kindid,kindname,resultid,isall){

    window.product_store.getProxy().setExtraParam('visatype',kindid);
    window.product_store.loadPage(1);
    $("#"+resultid).html(kindname);
    $(obj).addClass('cur').siblings().removeClass('cur');


}
/*
 * 按签发城市进行搜索
 * */

CHOOSE.changeVisaCity=function(obj,kindid,kindname,resultid,isall){

    window.product_store.getProxy().setExtraParam('cityid',kindid);
    window.product_store.loadPage(1);
    $("#"+resultid).html(kindname);
    $(obj).addClass('cur').siblings().removeClass('cur');


}
/*
 * 按品牌进行搜索
 * */

CHOOSE.changeCarBrand=function(obj,kindid,kindname,resultid,isall){

    window.product_store.getProxy().setExtraParam('carbrandid',kindid);
    window.product_store.loadPage(1);
    $("#"+resultid).html(kindname);
    $(obj).addClass('cur').siblings().removeClass('cur');


}

/*
 * 按帮助分类进行搜索
 * */

CHOOSE.changeHelpKind=function(obj,kindid,kindname,resultid,isall){

    window.product_store.getProxy().setExtraParam('kindid',kindid);
    window.product_store.loadPage(1);
    $("#"+resultid).html(kindname);
    $(obj).addClass('cur').siblings().removeClass('cur');


}

/*
* 更换模块版本
* */
CHOOSE.changeModuleVersion=function(obj,kindid,kindname,resultid,isall){

    window.product_store.getProxy().setExtraParam('moduleversion',kindid);
    window.product_store.loadPage(1);
    $("#"+resultid).html(kindname);
    $(obj).addClass('cur').siblings().removeClass('cur');


}


/*
* 底部分页切换显示数量
* */

CHOOSE.changeNum = function(combo,records){
    var pagesize=records[0].get('num');
    window.product_store.pageSize=pagesize;
    window.product_store.loadPage(1);

}

//选择全部
CHOOSE.chooseAll=function()
{



}
//反选
CHOOSE.chooseDiff=function()
{


}

//批量设置属性目的地图标专题等
CHOOSE.setSome=function(title,params,url,isone)
{
    var check_cmp=$('.product_check:checked');
    if(check_cmp.length==0&&!isone)
    {
        ST.Util.showMsg('请先选择项',5);
        return;
    }
    if(params) {
        params['loadWindow'] = window;
        if(!params['maxHeight'])
            params['maxHeight']=600;
    }
    ST.Util.showBox(title,url,600,'',null,null,document,params);

}
//属性设置回调函数
CHOOSE.attrSetBack=function(id,arr,bl)
{
    if(bl)
    {
        ST.Util.showMsg('设置属性成功',4);

        var attrid='';
        var attrname='';
        for(var i in arr)
        {
            attrid+=arr[i].id+',';
            attrname+=arr[i].name+',';
        }
        attrid=attrid.slice(0,-1);
        attrname=attrname.slice(0,-1);
        CHOOSE.refreshField(id,{attrid:attrid,attrname:attrname});
    }
    else
    {
        ST.Util.showMsg('保存失败',5);
    }
}

//目的地设置回调函数
CHOOSE.destSetBack=function(productid,arr,bl)
{
    if(bl)
    {
        ST.Util.showMsg('设置目的地成功',4);
        var kindlist='';
        var kindname='';
        for(var i in arr)
        {
            kindlist+=arr[i].id+',';
            kindname+=arr[i].name+',';
        }
        kindlist=kindlist.slice(0,-1);
        kindname=kindname.slice(0,-1);
        CHOOSE.refreshField(productid,{kindlist:kindlist,kindname:kindname});



    }
    else
    {
        ST.Util.showMsg('保存失败',5);
    }
}
//主题设置回调函数
CHOOSE.themeSetBack=function(id,arr,bl)
{
    if(bl)
    {
        ST.Util.showMsg('设置主题成功',4);
        var themelist='';
        for(var i in arr)
        {
            themelist+=arr[i].id+',';
        }
        themelist=themelist.slice(0,-1);
        CHOOSE.refreshField(id,{themelist:themelist});
    }
    else
    {
        ST.Util.showMsg('保存失败',5);
    }
}

//图标设置回调函数
CHOOSE.iconSetBack=function(id,arr,bl)
{
    if(bl)
    {
        ST.Util.showMsg('设置图标成功',4,1500);
        var iconlist='';
        for(var i in arr)
        {
            iconlist+=arr[i].id+',';
        }
        iconlist=iconlist.slice(0,-1);
        CHOOSE.refreshField(id,{iconlist:iconlist});

    }
    else
    {
        ST.Util.showMsg('保存失败',5,1500);
    }
}


//刷新保存后的结果
CHOOSE.refreshField=function(id,arr)
{



}

//切换视图，比如套餐，基本等
CHOOSE.togMod=function(obj,num)
{





}

//批量删除

CHOOSE.delMore=function()
{

}

