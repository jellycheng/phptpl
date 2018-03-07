<?php
require_once __DIR__ . '/common.php';

use CjsPhptpl\SimpleTpl;
$seo = ['title'=>'hi tpl', 'keywords'=>'keywords', 'description'=>''];
SimpleTpl::getInstance()->setTplDir(__DIR__ . '/View/Simple/')->setCompileDir(__DIR__ . '/View_c');

include SimpleTpl::getInstance()->display('index.html');

