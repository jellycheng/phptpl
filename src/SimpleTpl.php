<?php
namespace CjsPhptpl;

class SimpleTpl {

    protected $template_dir;
    protected $compile_dir;

    public static function getInstance($tpldir='', $compile_dir='') {
        static $instance;
        if(!$instance) {
            $instance = new static($tpldir, $compile_dir);
        }
        return $instance;
    }

    public function __construct($tpldir='', $compile_dir = '') {
        if(!$tpldir) {
            $this->template_dir = dirname(__DIR__) . '/View/';
        } else {
            $this->template_dir = $this->normalizeDirectory($tpldir);
        }

        if(!$compile_dir) {
            $this->compile_dir = dirname(__DIR__) . '/View_c/';
        } else {
            $this->compile_dir = $this->normalizeDirectory($compile_dir);
        }
    }

    public function setTplDir($tpldir) {
        $this->template_dir = $this->normalizeDirectory($tpldir);
        return $this;
    }

    public function getTplDir() {
        return $this->template_dir;
    }

    /**
     * @return mixed
     */
    public function getCompileDir()
    {
        return $this->compile_dir;
    }

    /**
     * @param mixed $compile_dir
     */
    public function setCompileDir($compile_dir)
    {
        $this->compile_dir = $this->normalizeDirectory($compile_dir);
        return $this;
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

    public function display($tplname) {
        $tplnamearr = explode('.', $tplname);
        $tplpathcache = $this->getCompileDir();
        $tplpathcache_name = "{$tplpathcache}{$tplnamearr[0]}.php";
        $tplpath_name = $this->getTplDir() . $tplname;
        !is_dir(dirname($tplpathcache_name)) && @mkdir(dirname($tplpathcache_name), 0777, true);
        if (!is_file($tplpathcache_name) || @filemtime($tplpath_name) > @filemtime($tplpathcache_name)) {
            if (!is_file($tplpath_name)) {
                exit('模板文件未找到: ' . $tplpath_name);
            }
            $html = file_get_contents($tplpath_name);
            $html = preg_replace('/<\!\-\-\{/', '<?php ', $html);
            $html = preg_replace('/\}\-\->/', '?>', $html);
            $html = preg_replace('/\{\$([^\}]*)\}/', '<?php echo \$\1 ?>', $html);
            $html = preg_replace('/\{(\w+\([^\}]*\))\}/', '<?php echo \1 ?>', $html);
            file_put_contents($tplpathcache_name, $html);
        }
        return $tplpathcache_name;
    }

}