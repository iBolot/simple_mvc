<?php
class App{
    private $classpath = __DIR__ . DIRECTORY_SEPARATOR . "classes";
    private $routes;

    function __construct()
    {
        spl_autoload_register(array($this, 'loader'));
    }

    public function loader($class) {
        $classFileName = strtolower($class);
        //echo 'Trying to load ', $class, ' via ', __METHOD__, "()\n";
        $arrEntrys = array_diff(scandir($this->classpath), array('..', '.'));
        foreach($arrEntrys as $dirEntry){
            $entryFullPath = $this->classpath . DIRECTORY_SEPARATOR . $dirEntry;
            if( !is_dir($entryFullPath) ) continue;
            $path = $entryFullPath.DIRECTORY_SEPARATOR.$classFileName.'.php';
            if(file_exists($path)){
                require_once($path);
            }
        }
        return false;
    }

    public function setRoutes($routes){
        $this->routes = $routes;
    }

    public function do(){
        $router = new Router($this->routes);
        $router->resolve();
    }
}
?>

