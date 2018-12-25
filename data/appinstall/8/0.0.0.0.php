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

$pinyin = 'notes';
$typeid = 101;
$unins = new Uninstall($typeid,$pinyin,$mysql);
//清除数据
$sqls = array(
    //model
    'sline_model' => 'where id=101 and pinyin="notes"',
    //page
    'sline_page' => 'where pagename in ("notes_index","notes_list","notes_show") or (pid=0 and kindname="游记模块")',
    //sline_menu_new
    'sline_menu_new' => 'where typeid=101',
    //sline_nav
    'sline_nav' => 'where typeid=101',
    //sline_m_nav
    'sline_m_nav' => 'where m_typeid=101'

);
$unins->delete_data($sqls);
$unins->unload_module_file();

