<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>{__('常用联系人')}-{$webname}</title>
    {include "pub/varname"}
    {Common::css('user.css,base.css,extend.css')}
    {Common::js('jquery.min.js,base.js,common.js,jquery.validate.js,jquery.cookie.js,jquery.validate.addcheck.js')}
    <style>
        .layui-layer-btn .layui-layer-btn0
        {

            border: 1px solid #dedede !important;
            background-color: #f1f1f1 !important;
            color: #333 !important;
        }
        .layui-layer-btn .layui-layer-btn1
        {
            border-color: #4898d5 !important;
            background-color: #2e8ded !important;
            color: #fff;


        }
    </style>
</head>

<body>

{request "pub/header"}
  
  <div class="big">
  	<div class="wm-1200">
    
    	<div class="st-guide">
      	<a href="{$cmsurl}">{__('首页')}</a>&nbsp;&nbsp;&gt;&nbsp;&nbsp;{__('常用地址')}
      </div><!--面包屑-->
      
      <div class="st-main-page">
          {include "member/left_menu"}
          <div class="user-cont-box">
              <div class="add-linkman-box">
                  <div class="linkman-tit clearfix">
                      常用旅客
                      <a class="delete-btn delete-all" href="javascript:void(0)">删除</a>
                      <a class="add-btn" href="{$cmsurl}member/index/add_linkman">添加</a>
                  </div>
                  <div class="linkman-con">
                      <div class="linkman-list">
                          <table width="100%">
                              <tr>
                                  <th width="5%">选择</th>
                                  <th width="15%">姓名</th>
                                  <th width="15%">性别</th>
                                  <th width="15%">手机号</th>
                                  <th width="10%">证件类型</th>
                                  <th width="20%">证件号码</th>
                                  <th width="20%">操作</th>
                              </tr>
                              {loop $list $l}
                              <tr data-id="{$l['id']}">
                                  <td><input class="choose_linkman" type="checkbox" /></td>
                                  <td>{$l['linkman']}</td>
                                  <td>{$l['sex']}</td>
                                  <td>{$l['mobile']}</td>
                                  <td>{$l['cardtype']}</td>
                                  <td>{$l['idcard']}</td>
                                  <td >
                                      <a class="edit" href="{$cmsurl}member/index/edit_linkman/{$l['id']}">编辑</a>
                                      <a class="delete delete-linkman" href="javascript:void(0)">删除</a>
                                  </td>
                              </tr>
                              {/loop}
                          </table>
                            {if empty($list)}
                          <div class="no-linkman-box">
                              <i></i>
                              <p>亲，还没有常用旅客哦，点击按钮进行添加~</p>
                          </div>
                          {/if}

                          <div class="main_mod_page clear">
                            {$pageinfo}
                          </div>
                      </div>
                  </div>
              </div>

          </div>
      </div>
    
    </div>
  </div>
  
{request "pub/footer"}
{Common::js('layer/layer.js')}
<script>
    $(function(){
        //导航选中
        $("#nav_linkman").addClass('on');
        if(typeof(on_leftmenu_choosed)=='function')
        {
            on_leftmenu_choosed();
        }

        $('.delete-linkman').click(function () {
            var ele = $(this).parents('tr');
            layer.confirm('确定删除？', {
                btn: ['取消','确认'] ,
                title:'提示'
            }, function(){
                layer.closeAll();
              return false;
            }, function(){
                delete_obj(ele.data('id'),ele);
                layer.msg('删除成功!',{icon:6,time:500})

            });
        });
        $('.delete-all').click(function () {
            var length = $('.choose_linkman:checked').length;
            if(length<1)
            {
                layer.alert('请选择要删除的游客',{title:'提示'})

            }
            else
            {
                layer.confirm('确定删除？', {
                    btn: ['取消','确认'] ,
                    title:'提示'
                }, function(){
                    layer.closeAll();
                    return false;
                }, function(){
                    $('.choose_linkman:checked').each(function () {
                        var ele = $(this).parents('tr');
                        delete_obj(ele.data('id'),ele)
                    });
                    layer.msg('删除成功!',{icon:6,time:500})
                });
            }
        })
    });

    //删除节点
    function  delete_obj(id,ele) {
        var flag = false;
        $.ajax({
            type:'post',
            dataType:'json',
            data:{id:id},
            url:'{$cmsurl}member/index/ajax_do_del_linkman',
            success:function (data) {
                if(data.status)
                {
                    flag = true;
                    ele.remove();
                }
                else
                {
                    flag = false;
                    return false;
                }
            }
        });
        return flag;

    }


</script>
</body>
</html>
