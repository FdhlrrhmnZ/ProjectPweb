<?php
class Connection {
    private $host = "localhost";
    private $struser = "root";
    private $strpass = "";
    private $strdbname = "company";
    public $connection;

    function __construct(){
        $conn = mysqli_connect($this->host, $this->struser, $this->strpass);
        $dbselect = mysqli_select_db($conn, $this->strdbname);
        $this->connection = $conn;
        }
    }
?>