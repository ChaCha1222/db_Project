<?php
// 確認用戶是否已登入，並且檢查是否按下了結帳按鈕
session_start();
include "database_connection.php";

if (isset($_SESSION['u_id']) && isset($_POST['checkout']) && ($_SERVER["REQUEST_METHOD"] == "POST")) {
    $buyer_ID = $_SESSION['u_id'];

    try {
        // 獲取商品資訊
        $product_ID = $_POST['productID'];
        $productTotalPrice = $_POST['productTotalPrice'];
        $productAmount = $_POST['productAmount'];
        $orderID = ''; // 這個在下面的程式碼會生成

        // 減少商品庫存
        $update_product_amount_stmt = $db->prepare("UPDATE products 
                                        INNER JOIN carts ON carts.p_id = products.p_id 
                                        SET products.p_amount = products.p_amount - carts.amount 
                                        WHERE carts.p_id = :product_ID AND carts.buyer_id = :buyer_ID");
        $update_product_amount_stmt->bindParam(':buyer_ID', $buyer_ID);
        $update_product_amount_stmt->bindParam(':product_ID', $product_ID);
        $update_product_amount_stmt->execute();

        // 清空購物車中的商品
        $clear_cart_stmt = $db->prepare("DELETE FROM carts WHERE p_id = :product_ID AND buyer_id = :buyer_ID");
        $clear_cart_stmt->bindParam(':buyer_ID', $buyer_ID);
        $clear_cart_stmt->bindParam(':product_ID', $product_ID);
        $clear_cart_stmt->execute();

        // 插入訂單資訊到 orders 資料表
        $date = date("Y-m-d H:i:s");
        $insert_order_stmt = $db->prepare("INSERT INTO orders (sellerID, buyer_id, date) 
                                                VALUES ((SELECT sellerID FROM products WHERE p_id = :product_ID), :buyer_ID, :date)");
        $insert_order_stmt->bindParam(':product_ID', $product_ID);
        $insert_order_stmt->bindParam(':buyer_ID', $buyer_ID);
        $insert_order_stmt->bindParam(':date', $date);
        $insert_order_stmt->execute();

        // 獲取新生成的 orderID
        $orderID = $db->lastInsertId();

        // 將商品詳細資訊插入到 orderDetail 資料表
        $insert_order_detail_stmt = $db->prepare("INSERT INTO orderDetail (p_id, amount, order_id) VALUES (:product_ID, :productAmount, :orderID)");
        $insert_order_detail_stmt->bindParam(':product_ID', $product_ID);
        $insert_order_detail_stmt->bindParam(':productAmount', $productAmount);
        $insert_order_detail_stmt->bindParam(':orderID', $orderID);
        $insert_order_detail_stmt->execute();

        echo "<script>alert('結帳成功!'); window.location.href='check.php';</script>";

        exit();


    } catch (PDOException $e) {
        // 處理錯誤
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<script>alert('未登入或未點擊結帳按鈕！');</script>";
}
?>