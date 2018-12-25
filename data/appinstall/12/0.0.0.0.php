<?php define('DATAPATH', dirname(dirname(dirname(__FILE__))));
require_once(DATAPATH . "/slinesql.class.php");
//执行sql  $mysql->query
//检测数据 $mysql->check_data  bool
//检测字段 $mysql->check_column boo
//检测表   $mysql->check_table bool
//检测索引 $mysql->check_index bool
//获取错误 $mysql->error() void | string(错误信息)
class Uninstall{
    private $_typeid = NULL;
    private $_pinyin = NULL;
    private $_db = NULL;

    public function __construct($typeid,$pinyin,$db)
    {
        $this->_typeid = $typeid;
        $this->_pinyin = $pinyin;
        $this->_db = $db;
    }

    /**
     * @function 卸载数据
     * @param $sqls
     */
    public function delete_data($sqls)
    {
        foreach ($sqls as $k => $v)
        {
            $this->_db->query("delete from {$k} {$v}");
        }
    }

    /**
     * @function 卸载模块
     */
    public function unload_module_file()
    {
        $root_path = dirname(DATAPATH);
        $moduleArr = array();
        $moduleFile = $root_path . str_replace('/', DIRECTORY_SEPARATOR, '/data/module.php');
        if (file_exists($moduleFile))
        {
            $moduleArr = include $moduleFile;
        }
        if (isset($moduleArr[$this->_pinyin]))
        {
            unset($moduleArr[$this->_pinyin]);
            file_put_contents($moduleFile, "<?php \r\n" . 'return ' . var_export($moduleArr, true) . ';');
        }
    }
}

$pinyin = 'photo';
$typeid = 6;
$unins = new Uninstall($typeid,$pinyin,$mysql);
//清除数据
$sqls = array(
    //model
    'sline_model' => 'where id=6 and pinyin="photo"',
    //page
    'sline_page' => 'where pagename in ("photo_index","photo_list","photo_show") or (pid=0 and kindname="相册模块")',
    //site_page
    'sline_site_page' => 'where pagename in ("photo_index","photo_list","photo_show") or (pid=0 and kindname="相册模块")',
    //sline_menu_new
    'sline_menu_new' => 'where typeid=6',
    //sline_nav
    'sline_nav' => 'where typeid=6',
    //sline_nav
    'sline_m_nav' => 'where m_typeid=6',
);
$unins->delete_data($sqls);
$unins->unload_module_file();
//更新视图
update_view_table(6);
function update_view_table($typeid)
{
    global $mysql;
    $file = DATAPATH . '/model_search.php';
    $model = include $file;
    if (is_array($model) && isset($model[$typeid]))
    {
        unset($model[$typeid]);
    }
    else
    {
        return;
    }
    ksort($model);
    $view = ' create view sline_search (channelname,webid,aid,typeid,title,description,litpic,shownum,kindlist,attrid,headimgid,tid,ishidden)
AS ';
    $view .= empty($model) ? '' : (implode(' union ', $model) . ' union ');
    $view .= "SELECT '通用',webid,aid,typeid,title,content,litpic,shownum,kindlist,attrid,0,id,ishidden FROM sline_model_archive;";
    //删除视图
    $mysql->query('DROP VIEW IF EXISTS `sline_search`;');
    //创建视图
    $mysql->query("{$view}");
    //写入model_search
    file_put_contents($file, "<?php \r\n return " . var_export($model, true) . ';');
}
