<?php
      
   abstract class mySQL {
	
      public $bag;

      function __construct(){
            $host= "localhost";
            $db = "fatura";
            $hesap=  "root";
            $sifre=  "1234";
            $DSN = "mysql:host=$host; dbname=$db";
            try	
            { 
               $this->bag = new PDO($DSN,$hesap,$sifre);
               $this->bag->exec("SET NAMES utf8");
            } 
            catch(PDOException $ex)
            {
    	       unset($this->bag);
            }
       }

       function __destruct(){
            $this->bag = NULL;
       }
   }

?>

