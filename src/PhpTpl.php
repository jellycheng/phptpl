<?php
namespace CjsPhptpl;

class PhpTpl {

    protected $data = [];
    protected $template_dir;
    //模板文件找不到是否直接exit
    protected $tpl_not_exists_exit = false;

    public static function getInstance($tpldir='') {
        static $instance;
        if(!$instance) {
            $instance = new static($tpldir);
        }
        return $instance;
    }

    public function __construct($tpldir='') {
        if(!$tpldir) {
            $this->template_dir = dirname(__DIR__) . '/View/';
        } else {
            $this->template_dir = $this->normalizeDirectory($tpldir);
        }
    }

    public function setTplDir($tpldir) {
        $this->template_dir = $this->normalizeDirectory($tpldir);
        return $this;
    }

    public function getTplDir() {
        return $this->template_dir;
    }

    public function assign($key, $var=null) {
        if (is_array($key) && $var===null) {
            $this->data = array_merge($this->data, $key);
        } elseif (is_object($key) && $var===null) {
            $this->data = array_merge($this->data, (array)$key);
        } else {
            $this->data[$key] = $var;
        }
    }

    public function getData() {
        return $this->data;
    }

    public function setTplError($bool = false) {
        $this->tpl_not_exists_exit = (bool)$bool;
        return $this;
    }

    public function getTplError() {
        return $this->tpl_not_exists_exit;
    }

    public function display($tplFile) {
        $tplFile = substr($tplFile, -4)=='.php' ? $tplFile : $tplFile . '.tpl.php';
        $tplFile = $this->template_dir . $tplFile;
        if(file_exists($tplFile)) {
            extract($this->data, EXTR_OVERWRITE);
            include $tplFile;
            return true;
        } else if($this->tpl_not_exists_exit){
            exit('模板文件未找到: ' . $tplFile);
        } else {
            return false;
        }
    }
    public function fetch($tplFile) {
        ob_start();
        $this->display($tplFile);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    protected function normalizeDirectory($directory) {
        $last = $directory[strlen($directory) - 1];
        if (in_array($last, array('/', '\\'))) {
            $directory[strlen($directory) - 1] = DIRECTORY_SEPARATOR;
            return $directory;
        }
        $directory .= DIRECTORY_SEPARATOR;
        return $directory;
    }

}