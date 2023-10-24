<?php

class ErrorClass{

    public function page_not_found() {
    
        include("../views/header.php");
        include("../views/404.php");
        include("../views/footer.php");
    }
}