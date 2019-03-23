<?php
//DSN data source name "mysql://hostname=localhost;dbname=php_pdo"

$cnn=null;
try{
    $cnn=new PDO('mysql://host=localhost;dbname=php_pdo','root' ,'',array(
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8'
    ));
  }
catch (PDOException $ex)
{
    echo $ex->getMessage();
}

