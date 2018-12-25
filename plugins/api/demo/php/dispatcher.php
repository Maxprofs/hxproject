<?php
$method = $_REQUEST['method'];
if (!empty($method))
{
    $classfile = dirname(__FILE__) . "/command/" . strtolower($method) . ".php";
    require($classfile);

    $response = new $method();
    $response->exec();
}

?>
