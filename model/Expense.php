<?php

class Expense extends Db
{

    public function save($category_write, $category_choose, $value, $date_time, $description, $payment_method)
    {
        $category = new Category();
        $cate_name = "";
        $email = $_SESSION['email'];
        $cate_id = -1;

        if ($category_write != '') {
            $cate_name = ucfirst(strtolower(trim($category_write)));
            if(!$category->isExistedCategory($cate_name))
            {
                $cate_id = $category->save($cate_name);
                if ($cate_id == false)
                    return false;
            }
            else {
                // $cate_name = $category_choose;
                $cate_id = $category->getCategoryId($cate_name);
                var_dump($cate_id);
            }
        } else {
            $cate_name = $category_choose;
            $cate_id = $category->getCategoryId($cate_name);
        }

        $payment = new PaymentMethod();

        $expense_id = -1;
        if ($this->isExistedExpense($cate_id, $payment_method) == false) {
            $sql = "INSERT INTO expense(category_id, payment_id) values(:category_id,:payment_id)";
            $arr = array(
                ":category_id" => $cate_id,
                ":payment_id" => $payment_method
            );
            $expense_id = $this->insert($sql, $arr);
        } else
            $expense_id = $this->getExpenseId($cate_id, $payment_method);

        $sql = "INSERT INTO user_expense(expense_date, amount_spent, description, user_email, expense_id) 
            values(:date_time, :value, :description, :email, :expense_id)";

        $arr = array(
            ":date_time" => $date_time,
            ":value" => $value,
            ":description" => $description,
            ":email" => $email,
            ":expense_id" => $expense_id
        );

        $rs = $this->insert($sql, $arr);
        return $rs;
    }

    public function findAll()
    {
        $sql = "SELECT category_id, payment_id from expense";
        return $this->select($sql);
    }

    public function findAllExpenseByMonth($month)
    {
        $sql = "SELECT * FROM user_expense WHERE MONTH(expense_date) = :month";
        $result = $this->select($sql, ['month' => $month]);
        return $result;
    }

    public function isExistedExpense($cate_id, $payment_id)
    {
        $sql = "SELECT 1 FROM expense WHERE category_id = :category_id AND payment_id = :payment_id LIMIT 1";
        $arr = [
            ':category_id' => $cate_id,
            ':payment_id' => $payment_id
        ];
        return $this->select($sql, $arr);
    }

    public function getExpenseId($cate_id, $payment_id)
    {
        $sql = "SELECT expense_id FROM expense WHERE category_id = :category_id AND payment_id = :payment_id LIMIT 1";
        $arr = [
            ':category_id' => $cate_id,
            ':payment_id' => $payment_id
        ];
        $result = $this->select($sql, $arr);
        return $result ? $result[0]['expense_id'] : -1;
    }

    public function returnCategory_id($expense_id)
    {
        $sql = "SELECT category_id FROM expense where expense_id = :expense_id";
        return $this->select($sql, ['expense_id'=>$expense_id]);
    }
    public function returnPayment_id($expense_id)
    {
        $sql = "SELECT payment_id FROM expense where expense_id = :expense_id";
        return $this->select($sql, ['expense_id'=>$expense_id]);
    }
}