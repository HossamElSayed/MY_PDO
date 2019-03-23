<?php

class AbstractModel
{
    const DATA_TYPE_BOOL=PDO::PARAM_BOOL;
    const DATA_TYPE_STR=PDO::PARAM_STR;
    const DATA_TAPE_INT=PDO::PARAM_INT;
    const DATA_TYPE_DECIMAL=4;

    private function prepareValues(PDOStatement & $stm)
    {
        foreach (static::$tableschema as $columnname=>$type)
        {
            if ($type==4)
            {
                $sanitizesdValue=filter_var($this->$columnname,FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                $stm->bindParam(":{$columnname}",$sanitizesdValue);
            }
            else
            {
                $stm->bindParam(":{$columnname}",$this->$columnname,$type);
            }
        }
    }

    private function buildnameparamSQL()
    {
        $parama_name='';
        foreach (static::$tableschema as $columnname=>$type)
        {
            $parama_name.=$columnname.'='.':'.$columnname.',';
        }
        return trim($parama_name,',');
        echo trim($sql,',');
    }

    private function create()
    {
        global $cnn;
        $sql = 'insert into ' . static::$tablename . ' set ' . $this->buildnameparamSQL();
        $stm = $cnn->prepare($sql);
        $this->prepareValues($stm);
        return $stm->execute();
    }

    private function update()
    {
        global $cnn;
        $sql='UPDATE '.static::$tablename.' set '.$this->buildnameparamSQL().' where '.static::$primarykey.'='.$this->{static::$primarykey};
        $stm=$cnn->prepare($sql);
        $this->prepareValues($stm);
        return $stm->execute();
    }
	public function save()
	{
		return $this->{static::$primarykey}===null? $this->create() : $this->update();
	}

    public function delete()
    {
        global $cnn;
        $sql=' delete from '.static::$tablename.' where '.static::$primarykey.'='.$this->{static::$primarykey};
        $stm=$cnn->prepare($sql);
        return $stm->execute();
    }

    public static function getAll()
    {
        global $cnn;
        $sql='SELECT *FROM '.static::$tablename;
        $stm=$cnn->prepare($sql);
		$stm->execute();
		$result =$stm->fetchAll(PDO::FETCH_CLASS |PDO::FETCH_PROPS_LATE,get_called_class(),array_keys(static::$tableschema));
		return (is_array($result)&&!empty($result))? $result:FALSE;
        

    }
    public static function getByPK($pk)
    {
        global $cnn;
        $sql='SELECT *FROM  '.static::$tablename.' where '.static::$primarykey.'="'.$pk.'"';
        $stm=$cnn->prepare($sql);
        if ($stm->execute()==true)
        {
            $obj=$stm->fetchAll(PDO::FETCH_CLASS |PDO::FETCH_PROPS_LATE,get_called_class(),array_keys(static::$tableschema));
            return array_shift($obj);
        }
        else
        {
            return false;
        }
    }




}