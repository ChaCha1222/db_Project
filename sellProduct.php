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
    include "database_connection.php";
    session_start();
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('偵測到未登入'); window.location.href = 'login.php';</script>";
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
            <a href="product.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
                <h1 class="m-0 custom-title">丹尼斯的交通裁決所</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="product.php" class="nav-link">商品列表</a>
                    <a href="sellProducts.php" class="nav-link">我的上架列表</a>
                    <a href="cart.php" class="nav-link">我的購物車</a>
                    <a href="myOrders.php" class="nav-link">我的訂單</a>
                    <a href="myAccount.php" class="nav-link"><?php echo "歡迎，" . $_SESSION['userRealName']; ?></a>
                </div>
                <a href="logout.php" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">登出</a>
            </div>
        </nav>
        <!-- end header section -->
    </div>

    <!-- about section -->

    <section class="about_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    上架您的商品
                </h2>
            </div>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="detail-box">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="p_name">商品名稱:</label>
                                <input type="text" class="form-control" maxlength="50" id="p_name" name="p_name">
                            </div>
                            <div class="form-group">
                                <label for="p_price">價格:</label>
                                <input type="text" class="form-control" maxlength="50" id="p_price" name="p_price">
                            </div>
                            <div class="form-group">
                                <label for="p_amount">上架數量:</label>
                                <input type="text" class="form-control" maxlength="50" id="p_amount" name="p_amount">
                            </div>
                            <div class="form-group">
                                <label for="p_intro">商品介紹:</label>
                                <input type="text" class="form-control" maxlength="255" id="p_intro" name="p_intro">
                            </div>
                            <div class="form-group">
                                <label for="p_picture">商品封面圖片:</label>
                                <input type="file" class="form-control-file" id="p_picture" name="p_picture" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3" name="uploadBtn">上架</button>
                            <button type="reset" class="btn btn-secondary mt-3" name="resetBtn">重設</button>
                        </form>
                        <h3 class="mt-4">
                            <?php
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                if (isset($_POST['uploadBtn'])) {
                                    if (empty($_POST['p_name']) || empty($_POST['p_price']) || empty($_POST['p_amount']) || empty($_POST['p_intro'])) {
                                        echo "<script>alert('您的商品資訊不完整');</script>";
                                    } else {
                                        $productName = $_POST['p_name'];
                                        $productPrice = $_POST['p_price'];
                                        $productAmount = $_POST['p_amount'];
                                        $productIntro = $_POST['p_intro'];
                                        $productCover = $_FILES['p_picture'];

                                        try {
                                            $imageContent = file_get_contents($productCover["tmp_name"]);

                                            // Prepare INSERT statement
                                            $stmt = $db->prepare("INSERT INTO `products` (`p_name`, `p_price`, `p_amount`, `p_intro`, `p_picture`) VALUES (:p_name, :p_price, :p_amount, :p_intro, :p_picture)");

                                            // Bind parameters
                                            $stmt->bindParam(':p_name', $productName);
                                            $stmt->bindParam(':p_price', $productPrice);
                                            $stmt->bindParam(':p_amount', $productAmount);
                                            $stmt->bindParam(':p_intro', $productIntro);
                                            $stmt->bindParam(':p_picture', $imageContent, PDO::PARAM_LOB);

                                            // Execute the query
                                            if ($stmt->execute()) {
                                                echo "商品" . $productName . "上傳成功!";
                                            } else {
                                                echo "上傳失敗 :(";
                                            }
                                        } catch (PDOException $e) {
                                            echo "Error: " . $e->getMessage();
                                        }
                                    }
                                }
                            }
                            ?>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery -->
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