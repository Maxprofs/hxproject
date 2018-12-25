<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH . 'classes/kohana/core' . EXT;

if (is_file(APPPATH . 'classes/kohana' . EXT))
{
    // Application extends the core
    require APPPATH . 'classes/kohana' . EXT;
}
else
{
    // Load empty core extension
    require SYSPATH . 'classes/kohana' . EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
//date_default_timezone_set('America/Chicago');
date_default_timezone_set('Asia/Shanghai');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

/**
 * Set the mb_substitute_character to "none"
 *
 * @link http://www.php.net/manual/function.mb-substitute-character.php
 */
mb_substitute_character('none');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('ch'); //读取语言包

if (isset($_SERVER['SERVER_PROTOCOL']))
{
    // Replace the default protocol.
    HTTP::$protocol = $_SERVER['SERVER_PROTOCOL'];
}

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
    Kohana::$environment = constant('Kohana::' . strtoupper($_SERVER['KOHANA_ENV']));
}
/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
//缓存目录,日志目录指定
$cache_dir = CACHE_DIR . 'supplier';
$logs_dir = LOGS_DIR . 'supplier';
if (!file_exists($cache_dir))
{
    mkdir($cache_dir, 0777, true);
}
if (!file_exists($logs_dir))
{
    mkdir($logs_dir, 0777, true);
}

Kohana::init(array(
    'base_url' => '/plugins/supplier/',
    'index_file' => '',
    'cache_dir' => $cache_dir,
    'errors' => DEVELOPMENT_MODE

));


/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File($logs_dir));

Kohana::$log_errors = false;//关闭日志记录

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */

$modules = array(
    'database' => MODPATH . 'database',   // Database access
    'image' => MODPATH . 'image',      // Image manipulation
    'orm' => MODPATH . 'orm',       // Object Relationship Mapping
    'pagination' => MODPATH . 'pagination', //分页
    'captcha' => MODPATH . 'captcha'//验证码类
);
if (file_exists(($file = BASEPATH . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'supplier_module.php')))
{
    $extend = include $file;
    foreach ($extend as &$item)
    {
        $item = str_replace('{BASEPATH}', BASEPATH, $item);
    }
    $modules = array_merge($modules, $extend);
    unset($extend, $item);
}
// 将模块应用加载到供应商应用中
if(file_exists($plugins_modules = BASEPATH . '/data/module.php'))
{
    $supplier_plugins_modules = include $plugins_modules;
    foreach ($supplier_plugins_modules as $plugin_key => $plugin_modules) {
        $supplier_modules_arr[$plugin_key] = BASEPATH . $plugin_modules;
    }
    $modules = array_merge($modules, $supplier_modules_arr);
}
Kohana::modules($modules);

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
//pc版本
Route::set('pc', 'pc(/<controller>(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'index',
        'directory' => 'pc'
    ));
//手机版本
Route::set('mobile', 'mobile(/<controller>(/<action>(/<params>)))', array('params' => '.*'))
    ->defaults(array(
        'action' => 'index',
        'controller' => 'index',
        'directory' => 'mobile'
    ));

Route::set('default', '(<controller>(/<action>(/<params>)))', array(
    'params' => '.*'
))->defaults(array(
    'controller' => 'index',
    'action' => 'index',
));
/**
 * Initialization configuration
 */

$cfg_basehost = St_Functions::get_http_prefix() . $_SERVER['HTTP_HOST']; //网站域名
$cfg_cmspath = '/supplier';
$cfg_default_templet = '/default/';
//$cfg_client_device = Common::is_mobile_device()?'mobile':'pc';
$cfg_client_device = 'pc';
//$cfg_client_device = 'mobile';
$cfg_public_url = '/public/';
//用于模板上资源调用
$cfg_res_url = '/plugins/supplier/public' . $cfg_default_templet . $cfg_client_device;
$base_url = Common::get_main_host();
//Cookie设置
Cookie::$salt = COOKIES_SALT;
Cookie::$path = COOKIES_PATH;
Cookie::$domain = Common::cookie_domain();