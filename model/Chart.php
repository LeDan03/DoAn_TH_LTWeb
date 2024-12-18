<?php

class Chart extends Db
{

    public function getTotal()
    {

        $expense_sum = $this->getExpenseSum();

        $income_sum = $this->getIncomeSum();

        $total = $expense_sum + $income_sum;

        return $total;
    }
    public function getTotalByMonth($month)
    {
        $expense_sum = $this->getExpenseSumByMonth($month);
        $income_sum = $this->getIncomeSumByMonth($month);

        $total = $expense_sum + $income_sum;

        return $total;
    }

    public function getTotalByMonthAndEmail($month,$email)
    {
        $expense_sum = $this->getExpenseSumByMonthAndEmail($month,$email);
        $income_sum = $this->getIncomeSumByMonthAndEmail($month,$email);

        $total = $expense_sum + $income_sum;

        return $total;
    }

    public function getExpenseSum()
    {
        $sql = "SELECT sum(amount_spent) FROM user_expense";
        $expense_result = $this->select($sql);
        $expense_sum = 0;

        if (isset($expense_result[0]['sum(amount_spent)']))
            $expense_sum = $expense_result[0]['sum(amount_spent)'] ?? 0;

        return $expense_sum;
    }
    public function getExpenseSumByMonth($month)
    {
        $sql = "SELECT sum(amount_spent) FROM user_expense WHERE MONTH(expense_date) = :month";
        $expense_result = $this->select($sql, ['month' => $month]);
        $expense_sum = 0;

        if (isset($expense_result[0]['sum(amount_spent)']))
            $expense_sum = $expense_result[0]['sum(amount_spent)'] ?? 0;

        return $expense_sum;
    }

    public function getExpenseSumByMonthAndEmail($month, $email)
    {
        $sql = "SELECT sum(amount_spent) FROM user_expense WHERE MONTH(expense_date) = :month and user_email = :email";
        $expense_result = $this->select($sql, ['month' => $month,'email'=>$email]);
        $expense_sum = 0;
        if(isset($expense_result[0]['sum(amount_spent)']))
            $expense_sum = $expense_result[0]['sum(amount_spent)'] ?? 0;
        return $expense_sum;
    }

    public function getIncomeSum()
    {
        $sql = "SELECT sum(amount_received) FROM user_income";
        $income_result = $this->select($sql);
        $income_sum = 0;

        if (isset($income_result[0]['sum(amount_received)']))
            $income_sum = $income_result[0]['sum(amount_received)'] ?? 0;

        return $income_sum;
    }
    public function getIncomeSumByMonth($month)
    {
        $sql = "SELECT sum(amount_received) FROM user_income WHERE MONTH(income_date) = :month";
        $income_result = $this->select($sql, ['month' => $month]);
        $income_sum = 0;

        if (isset($income_result[0]['sum(amount_received)']))
            $income_sum = $income_result[0]['sum(amount_received)'] ?? 0;

        return $income_sum;
    }
    public function getIncomeSumByMonthAndEmail($month, $email)
    {
        $sql = "SELECT sum(amount_received) FROM user_income WHERE MONTH(income_date) = :month and user_email = :email";
        $income_result = $this->select($sql, ['month' => $month, 'email' => $email]);
        $income_sum = 0;

        if(isset($income_result[0]['sum(amount_received)']))
            $income_sum = $income_result[0]['sum(amount_received)'] ?? 0;
           
        return $income_sum;
    }

    public function getExpensePercent()
    {
        $total = $this->getTotal();
        if ($total == 0)
            return 0;
        $expense_sum = $this->getExpenseSum();

        return ($expense_sum * 100) / $total;
    }
    public function getExpensePercentByMonth($month)
    {
        $total = $this->getTotalByMonth($month);
        if ($total == 0)
            return 0;

        $expense_sum = $this->getExpenseSumByMonth($month);

        return ($expense_sum * 100) / $total;
    }
    public function getExpensePercentByMonthAndEmail($month,$email)
    {
        $total = $this->getTotalByMonthAndEmail($month,$email);
        if ($total == 0)
            return 0;

        $expense_sum = $this->getExpenseSumByMonthAndEmail($month,$email);

        return ($expense_sum * 100) / $total;
    }
    public function getIncomePercent()
    {
        $total = $this->getTotal();
        if ($total == 0)
            return 0;
        $income_sum = $this->getIncomeSum();

        return ($income_sum * 100) / $total;
    }
    public function getIncomePercentByMonth($month)
    {
        $total = $this->getTotalByMonth($month);
        if ($total == 0)
            return 0;

        $income_sum = $this->getIncomeSumByMonth($month);

        return ($income_sum * 100) / $total;
    }

    public function getIncomePercentByMonthAndEmail($month,$email)
    {
        $total = $this->getTotalByMonthAndEmail($month,$email);
        if ($total == 0)
            return 0;

        $income_sum = $this->getIncomeSumByMonthAndEmail($month,$email);

        return ($income_sum * 100) / $total;
    }

}