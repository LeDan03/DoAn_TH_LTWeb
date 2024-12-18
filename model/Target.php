<?php

class Target extends Db{

    public function save($income_target, $expense_target)
    {
        $month = date('m');
        $year = date('Y');
        $email = $_SESSION['email'];
        if(!$this->isExistedTarget($month,$year))
        {
            $sql = "INSERT INTO target(user_email, income_target, expense_target, month, year)
                    values (:email, :income_target, :expense_target, :month, :year)";
            $arr = array(":email"=>$email,
                        ":income_target"=>$income_target,
                        ":expense_target"=>$expense_target,
                        ":month"=>$month,
                        ":year"=>$year);
            $result = $this->insert($sql, $arr);
            return $result;
        }
        else
            return false;
    }

    public function isExistedTarget($month, $year)
    {
        $sql = "SELECT id FROM target where month = :month and year = :year";
        $result = $this->select($sql, ['month'=>$month,'year'=>$year]);
        return !empty($result);
    }

    public function getUserTargetByTime($month, $year, $email)
    {
        $sql = "SELECT income_target, expense_target FROM target WHERE user_email = :email
                AND month = :month AND year = :year";
        
        $arr = array(
            ":month" => $month,
            ":year" => $year,
            ":email" => $email
        );
    
        $result = $this->select($sql, $arr);
        return !empty($result) ? $result : null;
    }

    public function getAllUserTarget($email)
    {
        $sql = "SELECT * FROM target WHERE user_email = :email";
        $result = $this->select($sql,['email'=>$email]);
        return $result;
    }
}