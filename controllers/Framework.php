<?php

class Framework{

    public $request_status=true;
    public $page;
    public $controller_name;
    public $method_name;
    public $db;
    public $controller_path="../controllers/";
    public $vendor_path="../vendor/";

    public function __construct(){

        $this->db=mysqli_connect("localhost","root","","interview_stealthguard");
        $this->controller_name=$_GET['controller'];
        $this->method_name=$_GET['method'];
        $this->validate_csrf();

        if($this->request_status) $this->validate_route();
        if($this->request_status) $this->validate_session();

        $this->page=new $this->controller_name($this->db);
    }

    public function validate_csrf() {
    
        if(!empty($_POST) 
            && (
                !isset($_POST['csrf_token']) 
                || $_POST['csrf_token']!=$_SESSION['csrf_token']
            )
        ) 
        {
            $this->request_status=false;
            $this->controller_name='ErrorClass';
            $this->method_name='csrf_mismatch';
        }

        $csrfToken = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrfToken;
    }

    public function validate_session() {
        
        if(isset($_POST['trylogin'])) {

            $login_obj=new auth();
            $login_status=$login_obj->tryLogin($this->db);

            if($login_status['status_flag']) $_SESSION['user_id']=$login_status['data'];
            else {

                $this->controller_name='auth';
                $this->method_name='index';
                $_SESSION['message']='Invalid Credentials.';
            }
        }
        else if($this->method_name== 'logout') {
            session_destroy();
            $this->controller_name='auth';
            $this->method_name='logout';
        }
        else {
            if( $this->method_name!= 'migrate' && !isset($_SESSION['user_id'])) {

                $this->controller_name='auth';
                $this->method_name='index';
            }
        }
    }

    public function validate_route() {

        if(
            (!file_exists($this->controller_path.$this->controller_name.".php") 
            || !method_exists($this->controller_name, $this->method_name))
            &&
            (!file_exists($this->vendor_path.$this->controller_name.".php") 
            || !method_exists($this->controller_name, $this->method_name))
        ){
            $this->request_status=false;
            $this->controller_name='ErrorClass';
            $this->method_name='page_not_found';
        }
    }
    
}