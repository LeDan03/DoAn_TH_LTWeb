<?php

class PaymentMethod extends Db{
    
    public function addDefaultPayment()
    {
        if(count($this->findAll()) == 0)
        {
            $paymentMethods = [
                "Chuyển khoản",
                "Thẻ ngân hàng",
                "Tiền mặt",
                "Thẻ tín dụng",
                "Trả sau"
            ];
            $sql = "INSERT INTO payment_method(name) values (:pay)";

            foreach ($paymentMethods as $pay) {
                $array = array(":pay" => $pay);
                $this->insert($sql, $array);
            }
        }
    }
    public function findAll()
    {
        $sql = "SELECT * FROM payment_method";

        return $this->select($sql);
    }
    public function getPaymentId($payment_name)
    {
        $payments = $this->findAll();
        foreach($payments as $id=>$val)
            if(strcasecmp($val,$payment_name)===0)
                return $id;
        return -1;
    }
    public function getPaymentName($payment_id)
    {
        $sql = "SELECT name FROM payment WHERE id = :id";
        return $this->select($sql, ['id'=>$payment_id]);
    }
}