<?php

class Income extends Db{


    public function save($source_select, $source_write, $note, $amount, $time, $description)
    {
        $source = new Source();
        $source_name = "";
        $source_id = -1;
        $email = $_SESSION['email'];

        if($source_write != '')
        {
            $source_name = ucfirst(strtolower(trim($source_write)));
            if(!$source->isExistedSource($source_name))
            {
                $source_id = $source->save($source_name);
                if($source_id == false)
                    return false;
            }
            else {
                $source_id = $source->getSourceId($source_name);
            }
        }
        else
        {
            $source_id = $source->getSourceId($source_select);
            $source_name = $source_select;
        }

        $income_id = -1;
        if($this->isExistedIncome($source_id,$note) == false)
        {
            $sql = "INSERT INTO income(source_id, note) values (:source_id, :note)";
            $arr = array(":source_id"=>$source_id,
                        ":note"=>$note);
            $income_id = $this->insert($sql,$arr);
        }
        else
            $income_id = $this->getIncomeId($source_id,$note);
            
        var_dump($email);
        var_dump($income_id);
        var_dump($time);
        var_dump($description);
        var_dump($amount);
        $sql = "INSERT INTO user_income(user_email, income_id, income_date, description, amount_received)
                values (:email, :income_id, :date, :description, :amount)";
        $arr = array(":email"=>$email,
                        ":income_id"=>$income_id,
                        ":date"=>$time,
                        ":description"=>$description,
                        ":amount"=>$amount);

        $rs = $this->insert($sql,$arr);
        var_dump($rs);
        return $rs;
    }

    public function findAll()
    {
        $sql = "SELECT * from expense";
        return $this->select($sql);
    }

    public function isExistedIncome($source_id, $income_note)
    {
        $sql = "SELECT id FROM income WHERE source_id = :source_id AND LOWER(note) = LOWER(:income_note)";
        $arr = array(":source_id" => $source_id, ":income_note" => $income_note);
        $result = $this->select($sql, $arr);
        return !empty($result); 
    }
    
    
    public function getIncomeId($source_id, $note)
    {
        $sql = "SELECT id FROM income WHERE source_id = :source_id AND LOWER(note) = LOWER(:note)";
        $arr = array(":source_id" => $source_id, ":note" => $note);
    
        $result = $this->select($sql, $arr);
        if (!empty($result)) {
            return $result[0]['id']; 
        }
        return -1;
    }
    
}