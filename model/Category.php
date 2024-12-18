<?php

class Category extends Db{

    public function save($name)
    {
        if($this->isExistedCategory($name))
            return false;
        $sql = "INSERT INTO category(name) values(:name)";

        $arr = array(":name"=>$name);
        
        return $this->insert($sql, $arr); // trả id
    }

    public function isExistedCategory($name)
    {
        $categories = $this->findAll();

        foreach($categories as $k=>$cate)
            if(mb_strtolower($cate['name'],'UTF-8') === 
                mb_strtolower($name,'UTF-8'))
                return true;

        return false;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM category";
        return $this->select($sql);
    }

    public function getCategoryId($cate_name)
    {
        $categories = $this->findAll();
        foreach($categories as $k=>$category)
            if(mb_strtolower($category['name'],'UTF-8') === 
                mb_strtolower($cate_name,'UTF-8'))
                return $category['id'];
        return -1;
    }

    public function addDefaultCategory()
    {
        $sql = "SELECT count(id) FROM category";
        $count = $this->select($sql);
        $countValue = $count[0]['count(id)'] ?? 0;
        $cate = 'Ăn uống';
        if($countValue == 0)
        {
            $insertDefaultSql = "INSERT INTO category(name) values (:cate)";
            $arr = array(":cate"=>$cate);
            return $this->insert($insertDefaultSql,$arr);
        }
    }

    public function getCategoryNameById($id)
    {
        $sql = "SELECT id FROM category where id = :id";
        $result = $this->select($sql,['id'=>$id]);
        return $result;
    }
}