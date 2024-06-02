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
            background-color: #fefefe;
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
            background-color: #AAAAFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .product button:hover {
            background-color: #84C1FF;
        }
    </style>

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
                                <a href="myCart.php" class="nav-link">我的購物車</a>
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
                    結帳頁面
                </h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-box">
                        <?php
                        try {
                            // 準備 SQL 查詢，擷取資料
                            $sql = "SELECT carts.*, products.p_name, products.p_picture, products.p_price 
                                        FROM carts 
                                        INNER JOIN products ON carts.p_id = products.p_id WHERE carts.buyer_id = :u_id";

                            // 準備查詢
                            $stmt = $db->prepare($sql);
                            $stmt->bindParam(":u_id", $_SESSION['u_id']);
                            // 初始化總價格
                            $totalPrice = 0;

                            $stmt->execute();

                            // 輸出表格標題
                            echo "<table><tr><th>產品名稱</th><th>數量</th><th>單價</th><th>總價</th><th>圖片</th><th>操作</th></tr>";

                            // 處理每一行資料
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $productName = htmlspecialchars($row['p_name']);
                                $productAmount = htmlspecialchars($row['amount']);
                                $productPrice = htmlspecialchars($row['p_price']);
                                $productTotalPrice = $row['amount'] * $row['p_price'];
                                $productID = $row['p_id'];

                                // 輸出該產品的資料
                                echo "<tr>";
                                echo "<td>$productName</td>";
                                echo "<td>&nbsp;&nbsp;$productAmount&nbsp;&nbsp;</td>";
                                echo "<td>&nbsp;&nbsp;$productPrice&nbsp;&nbsp;</td>";
                                echo "<td>&nbsp;&nbsp;$productTotalPrice&nbsp;&nbsp;</td>";
                                echo '<td><img src="' . $row["p_picture"] . '" style="max-width: 300px; max-height: 300px;"><br></td>';
                                echo "<td><form action='checkout.php' method='post'>";
                                echo "<input type='hidden' name='productAmount' value='$productAmount'>";
                                echo "<input type='hidden' name='productID' value='$productID'>";
                                echo "<input type='hidden' name='productTotalPrice' value='$productTotalPrice'>";
                                echo "</form></td>";
                                echo "</tr>";

                                // 加總價格
                                $totalPrice += $productTotalPrice;

                                // 添加分隔行
                                echo "<tr><td colspan='4'></td></tr>";
                            }

                            // 輸出總價格
                            echo "</table>";
                            echo "<br>商品總價格: $" . $totalPrice;
                            echo "<form action=\"checkout.php\" method=\"post\">";
                            echo "<br>";
                            echo "<button type=\"submit\" name=\"checkout\" class=\"btn btn-primary\" style=\"background-color: #7D7DFF; color: #ffffff;\">結帳</button>";
                            echo "</form>";


                        } catch (PDOException $e) {
                            // 處理錯誤
                            echo "Error: " . $e->getMessage();
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