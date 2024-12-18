<?php

class Source extends Db{

    public function save($name)
    {
        $sql = "INSERT INTO source(name) values(:name)";
        $arr = array(":name"=>$name);
        return $this->insert($sql,$arr);
    }

    public function addDefaultSource()
    {
        if($this->countSource() == 0)
        {
            $sql = "INSERT INTO source(name) values(:name)";
            $name = "Lương tháng";
            $arr = array(":name"=>$name);
            $this->insert($sql,$arr);
        }
    }

    public function findAll()
    {
        $sql = "SELECT * FROM source";
        return $this->select($sql);
    }

    public function countSource()
    {
        $sql = "SELECT count(id) FROM source";
        $result = $this->select($sql);
        $count = 0;
        if($result && isset($result[0]['count(id)']))
            $count = $result[0]['count(id)'];
        return $count;
    }

    public function isExistedSource($name)
    {
        $sql = "SELECT name FROM source";
        $result = $this->select($sql);
        if($result)
        {
            foreach($result as $value)
                if (mb_strtolower($value['name'],"UTF-8") == mb_strtolower($name, "UTF-8"))
                    return true;
        }
        return false;
    }

    public function getSourceId($name)
    {
        $sql = "SELECT id FROM source WHERE LOWER(name) = LOWER(:name)";

        $result = $this->select($sql, ['name' => $name]);
        if($result)
        {
            return $result[0]['id'];
        }
        return -1;
    }

}