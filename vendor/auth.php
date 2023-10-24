<?php

class auth{

    public function index() {
    
        include("../views/header.php");
        include("../views/login.php");
        include("../views/footer.php");
    }

    public function logout() {
    
        include("../views/header.php");
        include("../views/logout.php");
        include("../views/footer.php");
    }

    public function tryLogin($db) {

        $return_array=['status_flag'=>false];

        $sql="SELECT * FROM users WHERE username='".$_POST['username']."' AND password='".md5($_POST['password'])."' LIMIT 1";
        $result=$db->query($sql);

        if($row=$result->fetch_object()) $return_array=['status_flag'=>true, 'data'=>$row->id];
    
        return $return_array;
    }
}