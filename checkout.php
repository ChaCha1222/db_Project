<?php
// 確認用戶是否已登入，並且檢查是否按下了結帳按鈕
session_start();
include "database_connection.php";

if (isset($_SESSION['u_id']) && isset($_POST['checkout'])) {
    $buyer_ID = $_SESSION['u_id'];

    try {
        // 開始交易
        $db->beginTransaction();

        // 獲取購物車中所有商品
        $cart_items_stmt = $db->prepare("SELECT p_id, amount FROM carts WHERE buyer_id = :buyer_id");
        $cart_items_stmt->bindParam(':buyer_id', $buyer_ID, PDO::PARAM_INT);
        $cart_items_stmt->execute();
        $cart_items = $cart_items_stmt->fetchAll(PDO::FETCH_ASSOC);

        // 逐個商品更新庫存
        foreach ($cart_items as $item) {
            $product_ID = $item['p_id'];
            $amount = $item['amount'];

            // 減少商品庫存
            $update_product_amount_stmt = $db->prepare("UPDATE products 
                                                        SET p_amount = p_amount - :amount 
                                                        WHERE p_id = :p_id");
            $update_product_amount_stmt->bindParam(':amount', $amount, PDO::PARAM_INT);
            $update_product_amount_stmt->bindParam(':p_id', $product_ID, PDO::PARAM_INT);
            $update_product_amount_stmt->execute();

            // 檢查庫存是否減少成功
            if ($update_product_amount_stmt->rowCount() == 0) {
                // 庫存減少失敗，回滾交易
                $db->rollBack();
                echo "<script>alert('商品庫存不足或商品不存在！'); window.location.href='cart.php';</script>";
                exit();
            }
        }

        // 清空購物車
        $clear_cart_stmt = $db->prepare("DELETE FROM carts WHERE buyer_id = :buyer_id");
        $clear_cart_stmt->bindParam(':buyer_id', $buyer_ID, PDO::PARAM_INT);
        $clear_cart_stmt->execute();

        // 提交交易
        $db->commit();

        echo "<script>alert('結帳成功!'); window.location.href='check.php';</script>";
        exit();
    } catch (PDOException $e) {
        // 回滾交易
        $db->rollBack();
        echo "<script>alert('結帳失敗: " . $e->getMessage() . "'); window.location.href='cart.php';</script>";
    }
} else {
    echo "<script>alert('未登入或未點擊結帳按鈕！'); window.location.href='login.php';</script>";
}
?>