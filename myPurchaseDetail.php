<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>丹尼斯的交通裁決所</title>

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

        .custom-title {
            color: #28004D;
            font-size: 24px;
            font-weight: bold;
            padding: 5px 10px;
        }

        .navbar {
            background-color: #FFFFFF;
        }

        .table img {
            max-width: 100px;
            max-height: 100px;
        }

        .heading_container h2 {
            font-size: 32px;
            font-weight: bold;
            color: #28004D;
            margin-bottom: 20px;
        }

        .table {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table th,
        .table td {
            padding: 15px;
            vertical-align: middle;
            text-align: center;
        }

        .table thead th {
            background-color: #28004D;
            color: #fff;
            font-size: 18px;
            font-weight: 600;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table-responsive {
            margin-top: 20px;
        }
    </style>

    <?php
    include "database_connection.php";
    session_start();
    ?>

    <?php

    $records_per_page = 5;

    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $current_page = (int) $_GET['page'];
    } else {
        $current_page = 1;
    }

    $start_index = ($current_page - 1) * $records_per_page;
    ?>
</head>

<body class="sub_page">

    <div class="hero_area">
        <div class="hero_bg_box">
            <div class="bg_img_box">
                <img src="images/hero-bg.png" alt="">
            </div>
        </div>

        <header class="header_section">
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="custom-title" href="index.php">
                        <span>丹尼斯的交通裁決所</span>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav ms-auto p-4 p-lg-0">
                            <div class="navbar-nav ms-auto p-4 p-lg-0">
                                <a href="product.php" class="nav-link">商品列表</a>
                                <a href="sellProduct.php" class="nav-link">上架商品</a>
                                <a href="myProducts.php" class="nav-link">我的商品</a>
                                <a href="myCart.php" class="nav-link">我的購物車</a>
                                <a href="myPurchaseDetail.php" class="nav-link">購買紀錄</a>
                            </div>
                            <li class="nav-item">
                                <a class="nav-link" href="aboutme.php">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    用戶名的個人資訊
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
    </div>

    <section class="about_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>購買紀錄</h2>
            </div>
            <div class="tab-content" id="orders-table-tab-content">
                <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
                    <div class="app-card app-card-orders-table shadow-sm mb-5">
                        <div class="app-card-body px-4 pt-4">
                            <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">

                                    <?php

                                    // =============================================== //
                                    
                                    $FETCH_ORDER_INFO = "

                                            SELECT 
                                                *
                                            FROM 
                                                `orders` 
                                            WHERE 
                                                buyer_id = :buyer_id
                                            LIMIT :start_index , :records_per_page
                                        ";

                                    $fetch_order_stmt = $db->prepare($FETCH_ORDER_INFO);
                                    $fetch_order_stmt->bindParam(":buyer_id", $_SESSION["u_id"], PDO::PARAM_INT);
                                    $fetch_order_stmt->bindParam(":start_index", $start_index, PDO::PARAM_INT);
                                    $fetch_order_stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);


                                    if ($fetch_order_stmt->execute()) {

                                        while ($order_record = $fetch_order_stmt->fetch(PDO::FETCH_ASSOC)) {

                                            $order_id = $order_record["order_id"];
                                            $date = $order_record["date"];
                                            $order_p_id = explode(",", $order_record["p_id"]);
                                            $order_amount = explode(",", $order_record["amount"]);

                                            echo "
                                                    <thead>
                                                        <tr>
                                                            <th>訂單 ID: {$order_id}</th>  
                                                            <th></th> 
                                                            <th></th>
                                                            <th></th>                                                       
                                                            <th>購買時間: {$date}</th>
                                                        </tr>
                                                    </thead>
                                                ";

                                            for ($i = 0; $i < min(count($order_p_id), count($order_amount)); $i++) {

                                                $FETCH_PRODUCT_INFO = "

                                                        SELECT 
                                                            * 
                                                        FROM 
                                                            `products` 
                                                        WHERE 
                                                            p_id = :p_id
                                                    ";

                                                $fetch_product_stmt = $db->prepare($FETCH_PRODUCT_INFO);
                                                $fetch_product_stmt->bindParam(":p_id", $order_p_id[$i], PDO::PARAM_INT);

                                                if ($fetch_product_stmt->execute()) {
                                                    $Product = $fetch_product_stmt->fetch(PDO::FETCH_ASSOC);
                                                    $TOTALPRICE = $order_amount[$i] * $Product["p_price"];

                                                    echo "
                                                        
                                                            <tbody>

                                                                <tr>
                                                                    <td>物品ID:					  {$Product["p_id"]}	    </td>
                                                                    <td></td>
                                                                    <td>物品名稱:					  {$Product["p_name"]}	    </td>
                                                                    <td>物品數量: 	                      {$order_amount[$i]}		</td>
                                                                    <td>價錢: 	                      {$TOTALPRICE}		        </td>
                                                                </tr>

                                                            </tbody>
                                                        ";
                                                }
                                            }
                                        }
                                    } else {
                                        echo "錯誤";
                                    }
                                    ?>

                                    <!-- Pagination -->
                                    <?php
                                    $total_records_stmt = $db->prepare("SELECT COUNT(*) FROM `orders` WHERE buyer_id = :buyer_id");
                                    $total_records_stmt->bindParam(":buyer_id", $_SESSION["u_id"], PDO::PARAM_INT);
                                    $total_records_stmt->execute();
                                    $total_records = $total_records_stmt->fetchColumn();

                                    // 計算總頁數
                                    $total_pages = ceil($total_records / $records_per_page);
                                    echo "<br>分頁";
                                    for ($i = 1; $i <= $total_pages; $i++) {
                                        $page_link = "?page=$i";
                                        echo "<a href='$page_link'>$i</a> ";
                                    }
                                    ?>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- jQery -->
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <!-- bootstrap js -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <!-- owl slider -->
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- custom js -->
    <script type="text/javascript" src="js/custom.js"></script>
    <!-- Google Map -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
</body>

</html>