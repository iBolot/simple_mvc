<?php
class Router
{   
    private $routes;
    private $url;

    function __construct($routes)
    {
        $this->routes = $routes;
    }


    public function addRoutes($routes){
        $this->routes = $routes;
    }

    public function resolve(){
       $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);       
       $metod = $_SERVER['REQUEST_METHOD'];
       $matched = false;

       $arrURI = explode("/", $path);
       if(end($arrURI) == "") array_pop($arrURI);
        foreach($this->routes as $ind=>$route) {
            // echo $ind . "<br>";
            // print_r($route);            
            if($route[0] !== $metod) continue;
            
            $arrRoute = explode("/", $route[1]);            
            if(count($arrRoute) != count($arrURI)) continue;

            $arrParams = Array();
            // echo $ind . "<br>";
            
            for($i = 1; $i < count($arrRoute); $i++){
                //echo $i;
                //echo $arrURI[$i] . " - " . $arrRoute[$i];                
                //echo"<br>";
                if( $arrRoute[$i][0] == "[") {                    
                    list($type, $name) = explode(":", str_replace(array("[","]"), "",$arrRoute[$i]) );
                    // echo $type . " : " . $name . "<br>";
                    // TODO: add check type and breack chek if types mitchmach
                    $arrParams[$name] = $arrURI[$i];
                }
                elseif( $arrURI[$i] !== $arrRoute[$i] ) break;
                //echo "********* math<br>";
                if($i+1 == count($arrRoute)) $matched = true;
            }

            if($matched) break;
        }

        if(!$matched){
            return false;
        } else{
            $res = Array();
            //return $this->callController($route[2], $arrParams);
            list($cName, $cMethod) = explode("#", $route[2]);
            $res["controller"] = $cName;
            $res["method"] = $cMethod;
            $res["params"] = $arrParams;
            return $res;
        }
    }



    private function callController($mixController, $args){
        list($cName, $cMethod) = explode("#", $mixController);
        //echo"Controller name: " . $cName;
        //echo"Controller method: " . $cMethod;
        //echo "<br>";

        try{
            $o = new $cName();
            return $o->{$cMethod}($args);
        } catch(Throwable $ex){
            return sprintf('Class %s doesn exists!', $cName);
        }

    }
        
    // function render_html($pagepath, $data = array())
    // {
    //     $pagepath = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $pagepath);
    //     if (is_array($data))
    //     {
    //         @extract($data);
    //     }
    //     ob_start();
    //     include(ABSPATH . 'templates/' . $pagepath . '.php');
    //     return ob_get_clean();
    // }

}
?>