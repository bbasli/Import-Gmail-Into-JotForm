<?php


class getMails  {

    public function __construct()  {
        $this->ekle();
    }

    private function ekle()  {
        require __DIR__ . '/vendor/autoload.php';
        include "connection.php";
    }

    public function setup()  {
        $conn = new Connection();

        if ($conn->is_connected()) {
            require_once("gmail.php");
            //session_start();
            $gmail = new Gmail($conn->get_client());
            $_SESSION['result'] = $gmail->listMessages();
            header("Location: createSubmissions.php");
        }
        else  {
            return $conn->get_unauthenticated_data();
        }
    }
    
}
    if(isset($_SESSION['var']))

?>