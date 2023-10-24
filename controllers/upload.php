<?php

class upload {

    private $db;

    public function __construct($db){

        $this->db= $db;
    }

    public function show() {

        $sql="SELECT * FROM uploads WHERE userid='".$_SESSION['user_id']."'";
        $result=$this->db->query($sql);
        $uploaded_files=$result->fetch_all(MYSQLI_ASSOC);

        include("../views/header.php");
        include("../views/upload.php");
        include("../views/footer.php");
    }

    public function submit() {

        if (isset($_FILES["upload_file"]) && $_FILES["upload_file"]["error"] == 0) {
            $allowedExtensions = array("jpg", "pdf", "docx"); // List of allowed extensions

            // Get the file extension
            $fileInfo = pathinfo($_FILES["upload_file"]["name"]);
            $fileExtension = strtolower($fileInfo["extension"]);

            // Check if the file extension is in the list of allowed extensions
            if (in_array($fileExtension, $allowedExtensions)) {

                $fileSize = $_FILES["upload_file"]["size"];
                if ($fileSize <= 5*1024*1024) {

                    $targetDir = "../uploads/";  // Directory to save the uploaded file
                    $targetFilename = time(). "_" . bin2hex(random_bytes(8)). "_" . basename($_FILES["upload_file"]["name"]);
                    $targetFile = $targetDir . $targetFilename;

                    $sql="INSERT INTO uploads(userid, filename) VALUES('".$_SESSION['user_id']."', '$targetFilename')";
                    $this->db->query($sql);

                    if (move_uploaded_file($_FILES["upload_file"]["tmp_name"], $targetFile)) {
                        $_SESSION['message'] = "The file has been uploaded successfully.";
                    } else {
                        $_SESSION['message'] = "Sorry, there was an error uploading your file.";
                    }
                }
                else {
                    $_SESSION['message'] = "Please upload a file with size less than 5mb.";
                }
            } else {
                $_SESSION['message'] = "File extension not allowed. Please upload a file with one of the following extensions: " . implode(", ", $allowedExtensions);
            }
        } else {
            $_SESSION['message'] = "File upload error: " . $_FILES["upload_file"]["error"];
        }

        //getting the files uploaded by this user
        $sql="SELECT * FROM uploads WHERE userid='".$_SESSION['user_id']."'";
        $result=$this->db->query($sql);
        $uploaded_files=$result->fetch_all(MYSQLI_ASSOC);

        include("../views/header.php");
        include("../views/upload.php");
        include("../views/footer.php");
    }
}