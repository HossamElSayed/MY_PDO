<?php
require_once 'abstractmodel.php';

class teacher extends AbstractModel
{
public $id;
public $name;
public $age;
public $address;
public $tax;
public $salary;
protected static $primarykey='id';

protected static $tablename='user';
protected static $tableschema=array(
                              'name'    =>self::DATA_TYPE_STR,
                              'age'     =>self::DATA_TAPE_INT,
                              'address' =>self::DATA_TYPE_STR,
                              'tax'     =>self::DATA_TYPE_DECIMAL,
                              'salary'  =>self::DATA_TAPE_INT);

public function __construct($name,$age,$address,$tax,$salary)
{
    global $cnn;
    $this->name=$name;
    $this->age=$age;
    $this->address=$address;
    $this->tax=$tax;
    $this->salary=$salary;
}

    public function calSalary()
{
    return $this->salary - ($this->salary*$this->tax/100);
}
public function gettablename()
{
    return teacher::$tablename;
}

}