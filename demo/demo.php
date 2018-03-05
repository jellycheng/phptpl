<?php
require_once __DIR__ . '/common.php';

use CjsPhptpl\PhpTpl;

$tplObj = PhpTpl::getInstance()->setTplDir(__DIR__ . '/View/');

$tplObj->assign('api_url', "http://api.domain.com/api.php");
$tplObj->assign('admin_domain', "http://admin.domain.com/");

$b = $tplObj->display("index");

var_dump($b);
echo 'end' . PHP_EOL;


