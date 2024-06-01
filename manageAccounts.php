<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>丹尼斯的交通裁決所-管理員介面</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <?php
        // 處理越權查看以及錯誤登入
        if (!isset($_SESSION['username'])) {
            echo "<script>alert('偵測到未登入'); window.location.href = 'login.php';</script>";
            exit();
        } else if ($_SESSION['role'] != "1") {
            echo "<script>alert('無權訪問，請重新登入'); window.location.href = 'logout.php';</script>";
            exit();
        }
        
        // 處理管理員調出使用者清單
        include "database_connection.php";
        $records_per_page = 10;

        $stmt = $db->prepare("SELECT COUNT(*) FROM `users`");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $total_records = $row[0];

        $total_pages = ceil($total_records / $records_per_page);

        if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
            $current_page = (int) $_GET["page"];
        } else {
            $current_page = 1;
        }

        $start_from = ($current_page - 1) * $records_per_page;

        $stmt = $db->prepare("SELECT * FROM `users` LIMIT :start_from, :records_per_page");
        $stmt->bindParam(':start_from', $start_from, PDO::PARAM_INT);
        $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
        $stmt->execute();

    ?>

    <style>
        table {
            width: 100%;        /* 表格寬度佔滿父元素 */
            border-collapse: collapse; /* 邊框合併為單一邊框 */
            margin: 20px 0;     /* 上下邊距為 20px，左右為 0 */
            font-family: Arial, sans-serif; /* 使用 Arial 或無襯線字體 */
            color: #333;        /* 字體顏色 */
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1); /* 輕微陰影效果 */
            background-color: #ffffff; /* 白色背景 */
        }

        body {
            background-color: #f0f8ff;
        }

        .custom-title {
            color: #28004D;
            font-size: 24px;
            font-weight: bold;
            padding: 5px 10px;
        }

        /* 表格標頭 */
        th {
            background-color: #f2f2f2; /* 標頭背景顏色 */
            color: #333;        /* 標頭文字顏色 */
            font-weight: bold;  /* 粗體文字 */
            padding: 12px 15px; /* 內距 */
            text-align: left;   /* 文字對齊 */
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            background-color: #4682b4;
        }

        /* 表格行與單元格 */
        tr {
            border-bottom: 1px solid #ddd; /* 行底部邊框 */
        }

        td {
            padding: 12px 15px; /* 單元格內距 */
            text-align: left;   /* 文字對齊 */
        }

        /* 滑過行變色效果 */
        tr:hover {
            background-color: #f5f5f5; /* 滑過時的背景顏色 */
        }

    </style>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
        <a href="manageAccounts.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 custom-title"></i>丹尼斯的交通裁決所</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="manageAccounts.php" class="nav-item nav-link active">管理使用者</a>
                <a href="manageShelf.php" class="nav-item nav-link active">管理貨架</a>
                <a href="manageOrders.php" class="nav-item nav-link active">管理訂單</a>
                <a href="myAccount.php" class="nav-item nav-link active"><?php echo "歡迎，". $_SESSION['userRealName'];?></a>
            </div>
            <a href="logout.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block ">登出<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->

    <div class="bg-light rounded h-100 d-flex align-items-center p-5">
        <?php
            echo "<table>";
            echo "<tr><th>ID</th><th>身分組</th><th>使用者姓名</th><th>使用者名稱</tr>";
            while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>" . htmlspecialchars($user['ID']) . "</td><td>" . htmlspecialchars($user['role']) . "</td><td>" . htmlspecialchars($user['userRealName']) . "</td><td>" . htmlspecialchars($user['username']) . "</td><td>";
                echo "<td>".((($user['role'] === "1")||($user['role'] === "root")) ? "</td>" : "<form action=\"manageAccounts.php\" method=\"post\" onsubmit=\"return confirmDelete();\"><input type=\"hidden\" name=\"deleteID\" value=\"".$user['ID']."\"><button type=\"submit\" name=\"removeUserFlag\" value=\"true\" style=\"background-color: #ff4d4d; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease;\">刪除使用者</button></form></td>");
                echo "<td><form action=\"manageAccounts.php\" method=\"post\" onsubmit=\"return confirmDelete();\"><input type=\"hidden\" name=\"resetPasswordID\" value=\"".$user['ID']."\"><button type=\"submit\" name=\"resetFlag\" value=\"true\" style=\"background-color: #0080FF; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; transition: background 0.3s ease;\">重設密碼</button></form></td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
    </div>
    <div class="bg-light rounded h-100 d-flex align-items-center p-5">
        <?php
            echo "<div class='pagination'>第";
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $current_page) {
                    echo "<a href='#' class='active'>$i</a>";
                } else {
                    echo "<a href='manageAccounts.php?page=".$i."'>$i</a>";
                }
            }
            echo "頁</div>";
        ?>
    </div>
    <?php
        if (($_SERVER['REQUEST_METHOD'] === "POST")&&($_POST['removeUserFlag'])){
            include "database_connection.php";
            $deleteUserID = $_POST['deleteID'];
            $stmt = $db -> prepare("DELETE FROM `users` WHERE ID = :deleteID"); //Remove user from users table
            $stmt->bindParam(':deleteID', $deleteUserID);
            $stmt->execute();

            $removeFromCart = $db -> prepare("DELETE FROM `cart` WHERE ID = :deleteID"); //Remove user-related ID from cart table
            $removeFromCart->bindParam(':deleteID', $deleteUserID);
            $removeFromCart->execute();

            $removeFromProduct = $db -> prepare("DELETE FROM `product` WHERE ownerID = :deleteID"); //Remove user-related ownerID from Product table
            $removeFromProduct->bindParam(':deleteID', $deleteUserID);
            $removeFromProduct->execute();
            echo "<script>alert('已刪除使用者相關所有資料'); window.location.href='manageAccounts.php';</script>";
            exit;
        }
    ?>

    <?php
        if (($_SERVER['REQUEST_METHOD'] === "POST")&&($_POST['resetFlag'])){
            include "database_connection.php";
            //find username
            $resetPasswordID = $_POST['resetPasswordID'];
            $findUsername = $db -> prepare("SELECT username FROM `users` WHERE ID = :ID");
            $findUsername -> bindParam(':ID', $resetPasswordID);
            $findUsername -> execute();
            $user = $findUsername -> fetch(PDO::FETCH_ASSOC);

            $stmt = $db -> prepare("UPDATE `users` SET `password` = :newPassword WHERE ID = :resetPasswordID"); // await
            $newPassword = password_hash($user['username'], PASSWORD_DEFAULT);
            $stmt->bindParam(':newPassword', $newPassword);
            $stmt->bindParam(':resetPasswordID', $resetPasswordID);
            $stmt->execute();
            echo "<script>alert('密碼已經更新為使用者名稱'); window.location.href='manageAccounts.php';</script>";
            exit;
        }
    ?>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    <script>
        function confirmDelete() {
            return confirm('操作不可逆，請再次確認是否要執行');
        }
    </script>
</body>

</html>