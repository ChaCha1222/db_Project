<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="images/favicon.png" type="">

    <title> 丹尼斯的交通裁決所 </title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap"
        rel="stylesheet">

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
    session_start();
    include "database_connection.php";
    // 處理越權查看以及錯誤登入
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('偵測到未登入'); window.location.href = 'login.php';</script>";
        exit();
    } else if ($_SESSION['role'] != "2") {
        echo "<script>alert('權限錯誤'); window.location.href = 'logout.php';</script>";
        exit();
    }
    ?>

    <style>
        body {
            background-color: #f0f8ff;
        }

        .container {
            margin: 0 auto;
            width: 600px;
        }

        .custom-title {
            color: #28004D;
            font-size: 24px;
            font-weight: bold;
            padding: 5px 10px;
        }

        .navbar {
            background-color: #4682b4;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="sub_page">

    <div class="hero_area">

        <div class="hero_bg_box">
            <div class="bg_img_box">
                <img src="images/hero-bg.png" alt="">
            </div>
        </div>

        <!-- header section strats -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
            <a class="custom-title" href="index.php">
                <span>
                    丹尼斯的交通裁決所
                </span>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="product.php" class="nav-link">商品列表</a>
                    <a href="sellProduct.php" class="nav-link">上架商品</a>
                    <a href="myProducts.php" class="nav-link">我的商品</a>
                    <a href="myCart.php" class="nav-link">我的購物車</a>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutme.php">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <?php echo $_SESSION['username']; ?>的個人資訊
                        </a>
                    </li>
                </div>
                <a href="logout.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">登出</a>
            </div>
        </nav>
        <!-- end header section -->
    </div>

    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            <div class="heading_container heading_center">
                <h2>
                    管理我的購物車
                    <a href='check.php'><button>全部商品結帳</button></a>
                </h2>
                <h4>
                    <form method="GET" action="myCart.php">
                        <input name="keyword" placeholder="搜尋購物車內商品名稱"></input>
                        <button type="submit" name="searchBtn">搜尋</button>
                        <button onclick="window.history.back()">取消搜尋</button>
                    </form>
                </h4>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-box">
                        <?php
                        // 設定每頁顯示的資料筆數
                        $records_per_page = 5;

                        // 初始化搜尋條件
                        $search_keyword = '';

                        // 檢查是否有搜尋關鍵字
                        if (isset($_GET['keyword'])) {
                            $search_keyword = $_GET['keyword'];
                        }

                        // 獲取當前頁碼
                        $current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

                        // 計算起始擷取的資料索引
                        $start_index = ($current_page - 1) * $records_per_page;

                        try {
                            // 準備 SQL 查詢，擷取指定範圍內的資料
                            $sql = "SELECT carts.*, products.p_name, products.p_picture, products.p_price 
                                        FROM carts 
                                        INNER JOIN products ON carts.p_id = products.p_id WHERE carts.buyer_id = :u_id";
                            // 添加搜尋條件
                            if (!empty($search_keyword)) {
                                $sql .= " AND products.p_name LIKE :keyword";
                            }

                            $sql .= " LIMIT :start_index, :records_per_page";

                            // 準備查詢
                            $stmt = $db->prepare($sql);

                            // 綁定參數
                            $stmt->bindParam(':u_id', $_SESSION['u_id']);
                            $stmt->bindParam(':start_index', $start_index, PDO::PARAM_INT);
                            $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);

                            // 添加搜尋參數
                            if (!empty($search_keyword)) {
                                $keyword = '%' . $search_keyword . '%';
                                $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                            }

                            $stmt->execute();

                            // 檢查是否有資料
                            if ($stmt->rowCount() > 0) {
                                // 輸出資料表格
                                echo "<table><tr><th>商品圖片</th><th>商品ID</th><th>商品名</th><th>單價</th><th>數量</th><th>操作</th></tr>";
                                while ($cart = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo '<td><img src="' . $cart["p_picture"] . '" style="max-width: 300px; max-height: 300px;"><br></td>';
                                    echo "<td>" . htmlspecialchars($cart['p_id']) . "&nbsp&nbsp</td>";
                                    echo "<td>" . htmlspecialchars($cart['p_name']) . "&nbsp&nbsp</td>"; // 修改此處以顯示商品名稱
                                    echo "<td>" . htmlspecialchars($cart['p_price']) . "&nbsp&nbsp</td>";
                                    echo "<td>
                                                <form action=\"myCart.php\" method=\"post\" onsubmit=\"return confirmUpdate();\">
                                                    <input type=\"hidden\" name=\"cartID\" value=\"" . $cart['cartID'] . "\">
                                                    <input type=\"number\" name=\"newAmount\" value=\"" . $cart['amount'] . "\" min=\"1\">
                                                    <button type=\"submit\" name=\"updateAmount\" style=\"background-color: #B9B9FF; color: black;\">更改數量</button>
                                                </form>
                                            </td>";
                                    echo "<td><form action=\"myCart.php\" method=\"post\" onsubmit=\"return confirmDelete();\">
                                                <input type=\"hidden\" name=\"deleteProduct\" value=\"" . $cart['cartID'] . "\">
                                                <button type=\"submit\" value=\"deleteProduct\" style=\"background-color: #CE0000; color: white;\">刪除此商品</button>
                                                </form></td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "0 筆結果";
                            }

                            // 計算符合搜尋條件的總共的資料筆數
                            $total_records_stmt = $db->prepare("SELECT COUNT(*) FROM carts WHERE buyer_id = :u_id");
                            $total_records_stmt->bindParam(':u_id', $_SESSION['u_id']);
                            if (!empty($search_keyword)) {
                                $total_records_stmt = $db->prepare("SELECT COUNT(*) 
                                    FROM carts 
                                    INNER JOIN products 
                                    ON carts.p_id = products.p_id 
                                    WHERE carts.buyer_id = :u_id 
                                    AND products.productName LIKE :keyword");
                                $total_records_stmt->bindParam(':u_id', $_SESSION['u_id']);
                                $total_records_stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                            }
                            $total_records_stmt->execute();
                            $total_records = $total_records_stmt->fetchColumn();

                            // 計算總頁數
                            $total_pages = ceil($total_records / $records_per_page);

                            // 顯示分頁連結
                            echo "<br>分頁";
                            for ($i = 1; $i <= $total_pages; $i++) {
                                // 顯示分頁連結時也包含搜尋關鍵字
                                $page_link = "?page=$i";
                                if (!empty($search_keyword)) {
                                    $page_link .= "&keyword=$search_keyword";
                                }
                                // 檢查當前頁碼是否小於或等於總頁數，只有在這種情況下才生成分頁連結
                                if ($i <= $total_pages) {
                                    echo "<a href='$page_link'>$i</a> ";
                                }
                            }
                        } catch (PDOException $e) {
                            // 處理錯誤
                            echo "Error: " . $e->getMessage();
                        }

                        // 處理更新購物車內容數量的表單提交
                        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateAmount'])) {
                            $cartID = $_POST['cartID'];
                            $newAmount = $_POST['newAmount'];

                            // 檢查購買數量是否超過商品庫存數量
                            $stmt = $db->prepare("SELECT carts.amount, products.p_amount 
                                                    FROM carts 
                                                    INNER JOIN products ON carts.p_id = products.p_id 
                                                    WHERE carts.cartID = :cartID");
                            $stmt->bindParam(':cartID', $cartID);
                            $stmt->execute();
                            $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            $currentAmount = $result['amount'];
                            $productAmount = $result['p_amount'];

                            // 如果購買數量超過商品庫存數量，顯示錯誤訊息
                            if ($newAmount > $productAmount) {
                                echo "<script>alert('購買數量超過商品庫存數量，請重新設定數量。'); window.location.href = 'myCart.php';</script>";
                                exit(); // 停止腳本執行
                            }

                            // 更新 carts 資料表中的數量
                            $stmt = $db->prepare("UPDATE `carts` SET amount = :newAmount WHERE cartID = :cartID");
                            $stmt->bindParam(':newAmount', $newAmount);
                            $stmt->bindParam(':cartID', $cartID);
                            $stmt->execute();

                            echo "<script>window.location.href = 'myCart.php';</script>";
                        }


                        // 處理刪除購物車內容的表單提交
                        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['deleteProduct'])) {
                            $deleteProductID = $_POST['deleteProduct'];
                            $stmt = $db->prepare("DELETE FROM `carts` WHERE cartID = :deleteID");
                            $stmt->bindParam(':deleteID', $deleteProductID);
                            $stmt->execute();

                            echo "<script>window.location.href = 'myCart.php';</script>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->


    <!-- jQery -->
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
        </script>
    <!-- bootstrap js -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <!-- owl slider -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
    </script>
    <!-- custom js -->
    <script type="text/javascript" src="js/custom.js"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
    </script>
    <!-- End Google Map -->
    <script>
        function confirmUpdate() {
            return confirm('請再次確認');
        }
    </script>
</body>

</html>