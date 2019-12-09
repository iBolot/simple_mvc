<?php
class UserController{
    private $app;
    public function showDetails($params){        
        if (is_array($params))
        {
            @extract($params);
        }
        // echo "work: " . $id .PHP_EOL;
        // echo "work: " . $id2 .PHP_EOL;
        // echo PHP_EOL;
        // echo $this->app->loadTime() .PHP_EOL;
        //echo $this->app->sqlInfo() . PHP_EOL;
        //$template = $twig->load('root1.html');
        //$render = $this->app->getRender();
        $template = $this->app->getRender()->load('root1.html');
        echo $template->render(['loadtime'=>$this->app->loadTime(), 'sqlinfo'=>$this->app->sqlInfo()]);
    }

    public function show(){
        echo "show";
    }

    public function setEnv($app){
        $this->app = $app;        
    }
}
?>