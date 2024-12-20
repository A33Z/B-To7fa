<?php
class Order {
    private $order_id;
    private $user_id;
    private $order_date;
    private $order_status;
    private $order_total;

    // Constructor to initialize the order object
    public function __construct($user_id, $order_date, $order_status, $order_total, $order_id = null) {
        if ($order_id) {
            $this->order_id = $order_id;
        }
        $this->user_id = $user_id;
        $this->order_date = $order_date;
        $this->order_status = $order_status;
        $this->order_total = $order_total;
    }

    // Getters
    public function getOrderId() {
        return $this->order_id;
    }

    public function getUserId() {
        return $this->user_id;
    }

    public function getOrderDate() {
        return $this->order_date;
    }

    public function getOrderStatus() {
        return $this->order_status;
    }

    public function getOrderTotal() {
        return $this->order_total;
    }

    // Setters
    public function setOrderId($order_id) {
        $this->order_id = $order_id;
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function setOrderDate($order_date) {
        $this->order_date = $order_date;
    }

    public function setOrderStatus($order_status) {
        $this->order_status = $order_status;
    }

    public function setOrderTotal($order_total) {
        $this->order_total = $order_total;
    }
}
?>
