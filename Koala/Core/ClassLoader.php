<?php
//类加载器
//参考 PSR0规范 https://github.com/hfcorriez/fig-standards/blob/zh_CN/%E6%8E%A5%E5%8F%97/PSR-0.md
class ClassLoader extends Initial{
    //名称空间map
    protected $namespaces = array();
    //前缀map
    protected $prefixes = array();
    //目录list
    protected $dirs = array();
    //名称空间分隔符
    protected $separator = '\\';
    
    //获得名称空间映射表
    public function getNamespaces(){
        return $this->namespaces;
    }
    //获取目录列表
    public function getDirs(){
        return $this->dirs;
    }
    //注册名称空间
    public function registerNamespaces(array $namespaces){
        $this->namespaces = array_merge($this->namespaces, $namespaces);
    }
    public function registerNamespace($namespace, $path){
        $this->namespaces[$namespace] = rtrim($path,'\\/');
    }
    //注册目录
    public function registerDirs(array $dirs){
        $this->dirs = array_unique(array_merge($this->dirs, $dirs));
    }
    public function registerDir($dir, $path){
        $this->dirs[$dir] = rtrim($path,'\\/');
    }
    //设置分隔符
    public function setSeparator($separator='\\'){
        $this->separator = $separator;
    }
    //类加载器注册
    public function register(){
        spl_autoload_register(array($this, 'loadClass'));
    }
    //类加载
    public function loadClass($class){
        //分割
        $parts = explode($this->separator, $class);

        $parts[] = str_replace('_',$this->separator, array_pop($parts));
        
        $path = implode(DIRECTORY_SEPARATOR, $parts);
        $path = str_replace($this->separator,DIRECTORY_SEPARATOR,$path);
        
        $class = implode($this->separator, $parts);
        $namespace = substr($class, 0,strripos($class,$this->separator));

        if($namespace!=''){
            //根据名称空间搜索
            foreach ($this->namespaces as $ns => $dir) {
                if (0 === strpos($namespace, $ns)) {
                    $file = $dir.DIRECTORY_SEPARATOR.$path.'.php';
                    if (file_exists($file)) {
                        require_once $file;
                    }
                }
            }
        }else{
            //根据目录搜索
            foreach ($this->dirs as $dir) {
                $file = $dir.DIRECTORY_SEPARATOR.$path.'.php';//dir/class.php
                $file1 = $dir.DIRECTORY_SEPARATOR.$path."/$class.php";//dir/class/class.php
                if (file_exists($file)) {
                    require_once $file;
                }elseif(file_exists($file1)){
                    include_once $file1;
                }
            }
        }
        
    }
}