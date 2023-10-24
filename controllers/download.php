<?php

class download {

    private $db;

    public function __construct($db){

        $this->db= $db;
    }

    public function image() {

        $sql="SELECT filename FROM uploads WHERE userid='".$_SESSION['user_id']."' AND id='".$_GET['id']."' LIMIT 1";
        $result=$this->db->query($sql);

        if($row=$result->fetch_object()) {

            $file = "../uploads/";
            $filename = $row->filename;

            // Check if the file exists
            if (file_exists($file)) {
                // Set the appropriate headers for a file download
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $filename . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file.$filename));

                readfile($file.$filename);
                exit;
            } else {
                echo "File not found.";
            }
        }
        else {
            echo "File not found.";
        }
    }
}