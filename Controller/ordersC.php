<?php
class OrderController {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create an order
    public function create($userId, $firstName, $lastName, $email, $phone, 
    $address, $country, $state, $postalCode, $delivery, $totalPrice) {

    $query = "INSERT INTO orders 
        (user_id, first_name, last_name, email, phone, 
        address, country, state, postal_code, delivery, total_price)
        VALUES 
        (:userId, :firstName, :lastName, :email, :phone, 
        :address, :country, :state, :postalCode, :delivery, :totalPrice)";

    $sql = $this->conn->prepare($query);

    $sql->bindParam(':userId', $userId);
    $sql->bindParam(':firstName', $firstName);
    $sql->bindParam(':lastName', $lastName);
    $sql->bindParam(':email', $email);
    $sql->bindParam(':phone', $phone);
    $sql->bindParam(':address', $address);
    $sql->bindParam(':country', $country);
    $sql->bindParam(':state', $state);
    $sql->bindParam(':postalCode', $postalCode);
    $sql->bindParam(':delivery', $delivery, PDO::PARAM_INT);
    $sql->bindParam(':totalPrice', $totalPrice);

    if ($sql->execute()) {
        return $this->conn->lastInsertId(); // Return the inserted order ID
    } else {
        return false; // Indicate failure
    }
}

    // Get all orders by user ID
    public function getOrdersByUserId($user_id) {
        $query = "SELECT * FROM orders WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get a single order by ID
    public function getOrderById($order_id) {
        $query = "SELECT * FROM orders WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Update an order
    public function update($order_id, $order_status, $total_price) {
        $query = "UPDATE orders SET order_status = :order_status, total_price = :total_price WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_status', $order_status);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':order_id', $order_id);
        return $stmt->execute();
    }

    // Delete an order
    public function delete($order_id) {
        $query = "DELETE FROM orders WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $order_id);
        return $stmt->execute();
    }
}
?>
