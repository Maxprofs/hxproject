<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column bool
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)



class Plugin_Install
{


    public function uninstall()
    {
        global $mysql;

        //删除menu_new 表项
        $mysql->query("delete from sline_menu_new where typeid=104");

        $mysql->query("delete from sline_model where id=104");

        $mysql->query("delete from sline_nav where typeid=104");

        $mysql->query("delete from sline_page where pid='0' and kindname='邮轮'");
        $mysql->query("delete from sline_page where pagename in ('ship_index','ship_list','ship_show','ship_cruise')");



    }
	public function delete_module()
	{
		$module_file = DATAPATH.'/module.php';
   
        $module_arr = include($module_file);

        if(isset($module_arr['ship']))
			unset($module_arr['ship']);

        $str="<?php return ".var_export($module_arr,true).';';
        file_put_contents($module_file,$str);
	}
}
$model = new Plugin_Install();
$model->uninstall();
$model->delete_module();









