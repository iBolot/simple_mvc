<?php
class UserController{
    public function showDetails($params){        
        if (is_array($params))
        {
            @extract($params);
        }
        echo "work: " . $id;
        echo "work: " . $id2;
    }

    public function show(){
        echo "show";
    }
}
?>