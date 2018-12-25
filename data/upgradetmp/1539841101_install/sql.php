<?php
require_once(dirname(__FILE__) . "/handle.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)


//模板所属广告位信息列表
$advertise_info_list = array(
//array(flag=>广告类别 1:单图 2:多图,custom_label=>自定义标示,is_pc=>是否为pc广告位 1:pc 0:移动,prefix=>广告位页面标识 car_index,footer,position=>广告位置描述,size=>广告尺寸 1200*110),
    array(flag=>"2",custom_label=>"ll_tk11257_no296_index",is_pc=>"1",prefix=>"index",position=>"296模板首页轮播广告图",size=>"1920*400"),
    array(flag=>"1",custom_label=>"ll_tk11257_no296_hotel",is_pc=>"1",prefix=>"index",position=>"296模板左侧酒店广告图",size=>"224*281"),
    array(flag=>"1",custom_label=>"ll_tk11257_no296_car",is_pc=>"1",prefix=>"index",position=>"296模板左侧租车广告图",size=>"224*281"),
    array(flag=>"1",custom_label=>"ll_tk11257_no296_spot",is_pc=>"1",prefix=>"index",position=>"296模板左侧景点广告图",size=>"224*281"),
    array(flag=>"1",custom_label=>"ll_tk11257_no296_ship",is_pc=>"1",prefix=>"index",position=>"296模板左侧邮轮广告图",size=>"224*281"),
	array(flag=>"1",custom_label=>"ll_tk11257_no296_top",is_pc=>"1",prefix=>"index",position=>"296模板顶部广告图",size=>"1920*60"),
	array(flag=>"1",custom_label=>"ll_tk11257_no296_phoen",is_pc=>"1",prefix=>"index",position=>"296模板手机二维码广告图",size=>"80*80"),
	
);

//===========================================================================================================================================================================

foreach ($advertise_info_list as $advertise_info)
{
    if (!$mysql->check_data("select * from sline_advertise_5x where remark='{$advertise_templet_id}' and prefix='{$advertise_info['prefix']}' and is_pc={$advertise_info['is_pc']} and is_system=0"))
    {
        $number = $mysql->query("select ifnull(max(number),0)+1 as maxnumber from sline_advertise_5x where prefix='{$advertise_info['prefix']}' and is_pc={$advertise_info['is_pc']} and is_system=0");
        $number = $number[0]['maxnumber'];

        $values = "'{$advertise_info['flag']}','{$advertise_info['custom_label']}','','0','1','{$advertise_info['is_pc']}','{$advertise_info['prefix']}',{$number},'{$advertise_info['position']}','{$advertise_info['size']}','{$advertise_templet_id}'";
        $sql = "insert into sline_advertise_5x(flag,custom_label,adsrc,is_system,is_show,is_pc,prefix,number,position,size,remark) values ({$values});";
        $mysql->query($sql);
    }
}













