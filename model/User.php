<?php

include "../DTO/UserExpenseDto";
include "../DTO/UserIncomeDto";
class User extends Db
{

    public function save($email, $pass, $fullName)
    {
        $existingUser = $this->getUserByEmail($email);
        if (!empty($existingUser)) {
            return false;
        }

        $sql = "INSERT INTO user (email, password, full_name) VALUES (:email, :pass, :fullname)";
        $arr = array(
            ":email" => $email,
            ":pass" => password_hash($pass, PASSWORD_DEFAULT),
            ":fullname" => $fullName
        );
        return $this->insert_charPK($sql, $arr);

    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM user WHERE email = :email";
        $arr = array(":email" => $email);
        $result = $this->select($sql, $arr);

        return !empty($result) ? $result : null;
    }

    public function authenticate($email, $password)
    {
        $user = $this->getUserByEmail($email);

        if (empty($user))
            return false;
        $user = $user[0];
        if (password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    }

    public function getAllExpenseDTO()
    {
        $email = $_SESSION['email'];

        $sql = "
            SELECT ue.expense_date, ue.description, ue.amount_spent, pm.name AS payment_name, c.name AS category_name
            FROM user_expense ue
            LEFT JOIN expense e ON e.expense_id = ue.expense_id  
            LEFT JOIN payment_method pm ON pm.id = e.payment_id  
            LEFT JOIN category c ON c.id = e.category_id 
            WHERE ue.user_email = :email";

        $result = $this->select($sql, ['email' => $email]);

        $listExpenseDTO = array();

        if ($result) {
            foreach ($result as $value) {
                $dto = new UserExpenseDto();
                $dto->setDateTime($value['expense_date']);
                $dto->setDescription($value['description']);
                $dto->setAmountSpent($value['amount_spent']);
                $dto->setPaymentMethod($value['payment_name']);
                $dto->setCategory($value['category_name']);

                $listExpenseDTO[] = $dto;
            }
        }

        return $listExpenseDTO;
    }

    public function getAllIncomeDTO()
    {
        $email = $_SESSION['email'];

        $sql = "
            SELECT ui.income_date, ui.description, ui.amount_received, s.name AS source_name, i.note
            FROM user_income ui
            LEFT JOIN income i ON i.id = ui.income_id
            LEFT JOIN source s ON s.id = i.source_id
            WHERE ui.user_email = :email";

        $result = $this->select($sql, ['email' => $email]);

        $listIncomeDTO = array();

        if ($result) {
            foreach ($result as $value) {
                $dto = new UserIncomeDto();
                $dto->setDateTime($value['income_date']);
                $dto->setDescription($value['description']);
                $dto->setAmountReceived($value['amount_received']);
                $dto->setSource($value['source_name']);
                $dto->setNote($value['note']);

                $listIncomeDTO[] = $dto;
            }
        }
        return $listIncomeDTO;
    }

}
