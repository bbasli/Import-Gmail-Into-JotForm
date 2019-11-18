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
            $gmail = new Gmail($conn->get_client());
            if (!isset($_SESSION['result']))
                $_SESSION['result'] = $gmail->listMessages();
            header("Location: createSubmissions.php");
        }
        else  {
            return $conn->get_unauthenticated_data();
        }
    }
    
}

?>