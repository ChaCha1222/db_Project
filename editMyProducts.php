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
            background-color: #FFFFFF;
        }

        .product {
            background-color: #e0e0e0;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            width: 400px;
        }

        .product img {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .product p {
            font-size: 14px;
        }

        .product button {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .product button:hover {
            background-color: #930000;
        }

        .text-color {
            color: #000000;

        }
    </style>

    <?php
    include "database_connection.php";
    session_start();
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('偵測到未登入'); window.location.href = 'login.php';</script>";
        exit();
    }
    ?>
</head>

<body class="sub_page">

    <div class="hero_area">

        <div class="hero_bg_box">
            <div class="bg_img_box">
                <img src="images/hero-bg.png" alt="">
            </div>
        </div>

        <!-- header section strats -->
        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn "
                    data-wow-delay="0.1s">
                    <a class="custom-title" href="index.php">
                        <span>
                            丹尼斯的交通裁決所
                        </span>
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""> </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav ms-auto p-4 p-lg-0  ">
                            <div class="navbar-nav ms-auto p-4 p-lg-0">
                                <a href="product.php" class="nav-link">商品列表</a>
                                <a href="sellProduct.php" class="nav-link">上架商品</a>
                                <a href="myProducts.php" class="nav-link">我的商品</a>
                                <a href="cart.php" class="nav-link">我的購物車</a>
                                <a href="myPurchaseDetail.php" class="nav-link">購買紀錄</a>
                            </div>
                            <li class="nav-item">
                                <a class="nav-link" href="aboutme.php">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <?php echo $_SESSION['username']; ?>的個人資訊
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="logout.php"
                                    class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">登出</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- end header section -->
    </div>

    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container  ">
            <div class="heading_container heading_center">
                <h2>
                    我的商品
                    <a href='myProducts.php'><button class='nav_search-btn'>回到管理商品介面</button></a>
                </h2>
                <form method="GET" action="editMyProducts.php">
                    <input name="keyword" placeholder="搜尋你的商品名稱"></input>
                    <button type="submit" name="searchBtn">搜尋</button>
                    <button onclick="window.history.back()">取消搜尋</button>
                </form>
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
                        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
                            $current_page = (int) $_GET['page'];
                        } else {
                            $current_page = 1;
                        }

                        // 計算起始擷取的資料索引
                        $start_index = ($current_page - 1) * $records_per_page;

                        try {
                            // 準備 SQL 查詢，擷取指定範圍內的資料
                            $sql = "SELECT * FROM products";
                            $sellerID = $_SESSION['u_id'];
                            // 添加搜尋條件
                            if (!empty($search_keyword)) {
                                $sql .= " WHERE productName LIKE :keyword";
                            }

                            if (!empty($sellerID)) {
                                if (!empty($search_keyword)) {
                                    $sql .= " AND sellerID = :sellerID";
                                } else {
                                    $sql .= " WHERE sellerID = :sellerID";
                                }
                            }

                            $sql .= " LIMIT :start_index, :records_per_page";

                            // 準備查詢
                            $stmt = $db->prepare($sql);

                            // 綁定參數
                            $stmt->bindParam(':sellerID', $sellerID);
                            $stmt->bindParam(':start_index', $start_index, PDO::PARAM_INT);
                            $stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);

                            // 添加搜尋參數
                            if (!empty($search_keyword)) {
                                $keyword = '%' . $search_keyword . '%';
                                $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
                            }

                            // 執行查詢
                            $stmt->execute();

                            // 檢查是否有資料
                            if ($stmt->rowCount() > 0) {
                                // 逐行讀取資料並輸出
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<div style='background-color: #9D9D9D; padding: 10px; margin-bottom: 10px;'>";
                                    echo "<form method='POST'>";
                                    echo "<label class='text-color'>商品名稱:</label><input type='text' name='p_name' value='" . $row["p_name"] . "' class='text-color'><br>";
                                    echo "<label class='text-color'>商品價格:</label><input type='text' name='p_price' value='" . $row["p_price"] . "' class='text-color'><br>";
                                    echo "<label class='text-color'>商品數量:</label><input type='text' name='p_amount' value='" . $row["p_amount"] . "' class='text-color'><br>";
                                    echo "<label class='text-color'>商品介紹:</label><input type='text' name='p_intro' value='" . $row["p_intro"] . "' class='text-color'><br>";
                                    echo "<input type='hidden' name='p_id' value='" . $row["p_id"] . "'>";
                                    echo "<button type='submit' name='editProduct'>編輯商品</button>";
                                    echo "</form>";
                                    echo "</div>";
                                }
                            } else {
                                echo "0 筆結果";
                            }

                            // 獲取特定賣家的商品總數
                            if (!empty($search_keyword)) {
                                $total_records_stmt = $db->prepare("SELECT COUNT(*) FROM products WHERE sellerID = :u_id AND p_name LIKE :keyword");
                                $total_records_stmt->bindParam(":u_id", $_SESSION['u_id']);
                                $total_records_stmt->bindParam(":keyword", $keyword);
                            } else {
                                $total_records_stmt = $db->prepare("SELECT COUNT(*) FROM products WHERE sellerID = :u_id");
                                $total_records_stmt->bindParam(":u_id", $_SESSION['u_id']);
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
                            // Handle any errors
                            echo "Error: " . $e->getMessage();
                        }

                        // Handle edit product form submission
                        if (isset($_POST['editProduct'])) {
                            $productId = $_POST['p_id'];
                            $productName = !empty($_POST['p_name']) ? $_POST['p_name'] : null;
                            $productPrice = !empty($_POST['p_price']) ? $_POST['p_price'] : null;
                            $productAmount = !empty($_POST['p_amount']) ? $_POST['p_amount'] : null;
                            $productIntro = !empty($_POST['p_intro']) ? $_POST['p_intro'] : null;

                            // Update the product with new values
                            try {
                                $sql = "UPDATE products SET p_name = :p_name, p_price = :p_price, p_amount = :p_amount, p_intro = :p_intro WHERE p_id = :p_id";
                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':p_name', $productName);
                                $stmt->bindParam(':p_price', $productPrice);
                                $stmt->bindParam(':p_amount', $productAmount);
                                $stmt->bindParam(':p_intro', $productIntro);
                                $stmt->bindParam(':p_id', $productId);
                                $stmt->execute();
                                // Redirect to the same page to update the product list
                                echo "<script>alert('編輯商品成功'); window.location.href='editMyProducts.php'; </script>";
                                exit();
                            } catch (PDOException $e) {
                                // Handle any errors
                                echo "Error: " . $e->getMessage();
                            }
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

</body>

</html>