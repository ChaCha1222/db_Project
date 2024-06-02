<?php
    session_start();
    include "database_connection.php";

    if (isset($_SESSION['username'])) {
        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['p_id']) && isset($_POST['amount']) && isset($_POST['p_amount'])) {
            $productId = $_POST['p_id'];
            $amount = $_POST['amount'];
            $productAmount = $_POST['p_amount'];

            if ($amount > $productAmount) {
                echo "購買數量超出庫存。";
            } else {
                // 執行插入操作
                $stmt = $db->prepare("INSERT INTO carts (buyer_id, p_id, amount) VALUES (:u_id, :p_id, :amount)");
                $stmt->bindParam(':u_id', $_SESSION['u_id']);
                $stmt->bindParam(':p_id', $productId);
                $stmt->bindParam(':amount', $amount);
                
                if ($stmt->execute()) {
                    echo "商品已成功加入購物車！";
                } else {
                    echo "添加到購物車失敗。";
                }
            }
        } else {
            echo "無效的請求。";
        }
    } else {
        echo "請先登入。";
    }
?>
