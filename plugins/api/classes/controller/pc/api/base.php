<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pc_Api_Base extends Stourweb_Controller
{
    /*
     * 当前请求所属的api客户端信息
     */
    protected $client_info = null;
    /*
     * 当前请求内容体信息
     */
    protected $request_body = null;

    public function before()
    {
        set_exception_handler(array($this, "exception_handler"));
        set_error_handler(array($this, "error_handler"), 'E_ALL & ~E_DEPRECATED');

        parent::before();

        $this->verify_request();
    }

    /*
     * 验证当前请求的合法性，并在合法请求报文中分析出相应内容
     */
    private function verify_request()
    {
        $request_content = file_get_contents("php://input");

        $analyse_result = Model_Api_Envelope::analyse_datagrams($request_content);
        $this->client_info = $analyse_result['client'];
        $this->request_body = $analyse_result['body'];

        if ($analyse_result['success'] === false)
        {
            $this->send_datagrams($analyse_result['client']['id'], null, $analyse_result['client']['secret_key'], $analyse_result['success'], $analyse_result['message'], $analyse_result['message']);
        }
    }

    public function exception_handler(Exception $e)
    {
        // Get the exception information
        $type = get_class($e);
        $code = $e->getCode();
        $message = $e->getMessage();
        $file = $e->getFile();
        $line = $e->getLine();
        $trace = $e->getTrace(); // Get the exception backtrace

        $msg = "errno:{$code}" . PHP_EOL;
        $msg .= "errstr:{$message}" . PHP_EOL;
        $msg .= "errfile:{$file}" . PHP_EOL;
        $msg .= "errline:{$line}" . PHP_EOL;

        // Display the exception text
        $this->send_datagrams($this->client_info['id'], null, $this->client_info['secret_key'], false, "API服务内部错误", $msg);
    }

    public function error_handler($errno, $errstr, $errfile, $errline)
    {
        throw new ErrorException($errstr, $errno, 0, $errfile, $errline);

        // Do not execute the PHP error handler
        return TRUE;
    }

    /*
     * 写交互日志
     */
    protected function add_interop_log($success, $msg)
    {
        $client_ip = Model_Api_Interop_Log::get_client_ip();
        Model_Api_Interop_Log::add_info(array(
            'client_id' => $this->client_info['id'],
            'url' => $this->request->uri(),
            'request_params' => json_encode($this->request_body),
            'success' => ($success ? 1 : 0),
            'msg' => $msg,
            'remote_info' => "IP:{$client_ip}"
        ));
    }

    /*
     * 发送响应报文
     */
    protected function send_datagrams($client_id, $content, $secret_key = "", $success = true, $message = "", $log_message = "", $is_abort = true)
    {
        $this->add_interop_log($success, $log_message);

        $api_envelop = new Model_Api_Envelope($client_id, $content, $success, $message);
        $datagrams = $api_envelop->generate_datagrams($secret_key);
        header("content-type:application/json");
        if ($is_abort)
        {
            exit($datagrams);
        }
        else
        {
            echo $datagrams;
        }
    }

    /**
     * 获取货币符号
     */
    public function action_symbol()
    {
        $this->send_datagrams($this->client_info['id'], array('symbol' => Currency_Tool::symbol()), $this->client_info['secret_key']);
    }
}