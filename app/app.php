<?php
class App{
    private $classpath = __DIR__ . DIRECTORY_SEPARATOR . "classes";
    private $routes;
    private $startTime;
    private $mySqlLink;
    private $render;

    function __construct()
    {
        $this->startTime = microtime(true);
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

    public function setRender($render){
        $this->render = $render;
    }
    public function getRender(){
        return $this->render;
    }

    public function setRoutes($routes){
        $this->routes = $routes;
    }

    public function setDB($ip,$user,$password,$dbname){        
        try{
            $this->mySqlLink = mysqli_connect($ip,$user,$password,$dbname);
        } catch(Exception $e){
            echo "Database connect error!" . PHP_EOL;
            return;
        }
        if (!$this->mySqlLink) throw new Exception("Database connect error!");
    }

    public function do(){
        $router = new Router($this->routes);
        $resolved = $router->resolve();
        
        // if resolved not false
        if(!$resolved){
            echo (new DefaultAction())->show404();
            (new DefaultAction())->redirect301("/home");
            return;
        }
        // TODO: check if the controller and its method are present
        $o = new $resolved["controller"];
        $o->setEnv($this);
        echo $o->{$resolved["method"]}($resolved["params"]);
    }

    public function loadTime(){
        return (microtime(true) - $this->startTime);
    }

    public function sqlInfo(){
        return mysqli_get_host_info($this->mySqlLink);
    }


}
?>

