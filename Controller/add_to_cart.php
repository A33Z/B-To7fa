<?php

class CartController {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM cart"; 
        $sql = $this->conn->prepare($query);
        $sql->execute();
        return $sql;
    }

    public function create($userId, $productId, $quantity) {
        $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':user_id', $userId);
        $sql->bindParam(':product_id', $productId);
        $sql->bindParam(':quantity', $quantity);
        return $sql->execute();
    }

    public function delete($userId, $productId) {
        $query = "DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id"; 
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':user_id', $userId); 
        $sql->bindParam(':product_id', $productId); 
        return $sql->execute();
    }

    public function update($userId, $productId, $quantity) {
        $query = "UPDATE cart SET quantity = :quantity WHERE user_id = :user_id AND product_id = :product_id";
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':user_id', $userId);
        $sql->bindParam(':product_id', $productId);
        $sql->bindParam(':quantity', $quantity);
        return $sql->execute();
    }
    public function updateProductStock($productId, $newStock) {
        $stmt = $this->conn->prepare("UPDATE produit SET qte_stock = :qte_stock WHERE reference = :reference");
        $stmt->bindParam(':qte_stock', $newStock);
        $stmt->bindParam(':reference', $productId);
        $stmt->execute();
    }

    public function updateCartItemQuantity($cartItemId, $newQuantity) {
        $query = "UPDATE cart SET quantity = :quantity WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantity', $newQuantity, PDO::PARAM_INT);
        $stmt->bindParam(':id', $cartItemId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getUserCartItems($userId) {
        $query = "SELECT cart.product_id, cart.quantity,cart.id, produit.libelle, produit.price, produit.picture 
                  FROM cart 
                  INNER JOIN produit ON cart.product_id = produit.reference 
                  WHERE cart.user_id = :user_id";
        
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':user_id', $userId);
        $sql->execute();
        
        return $sql->fetchAll(PDO::FETCH_ASSOC); // Make sure to return results
    }

    public function getProductById($productId) {
        $query = "SELECT * FROM produit WHERE reference = :product_id";
        
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':product_id', $productId);
        $sql->execute();
        
        return $sql->fetch(PDO::FETCH_ASSOC); 
    }

    public function removeCartItem($cartItemId) {
        $query = "DELETE FROM cart WHERE id = :cart_item_id";
    
        $sql = $this->conn->prepare($query);
        $sql->bindParam(':cart_item_id', $cartItemId);
        $sql->execute();
    }

    public function clearUserCart($userId) {
        $query = "DELETE FROM cart WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }
}
?>
