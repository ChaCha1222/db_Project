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
        include "database_connection.php";
        session_start();
    ?>
    <?php
        if (!isset($_SESSION['username'])) {
            echo "<script>alert('偵測到未登入'); window.location.href = 'login.php';</script>";
                    exit(); 
        }
        try {
            $stmt = $db->prepare("SELECT * FROM users WHERE u_id = :u_id");
            $stmt->bindParam(':u_id', $_SESSION['u_id']);
            $stmt->execute();
        
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $role = $user['role'];
                $username = $user['username'];
                $userRealName = $user['userRealName'];
            } else {
                //echo "No user found with that username.";
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
        if (($_SERVER['REQUEST_METHOD'] === "POST")&&(isset($_POST['update']))){ //update stands for the field name
            $fieldToUpdate = $_POST['update'];
            $updateValue = $_POST[$fieldToUpdate]?? '';
            // echo "<script>alert('".$fieldToUpdate.$updateValue."');</script>";

            if ($fieldToUpdate === 'password') { //處理更改密碼需要加密的部分
                if (($_POST['password'] === $_POST['confirmPassword'])) {
                    $updateValue = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    try { //更新資料庫
                        $stmt = $db->prepare("UPDATE users SET `$fieldToUpdate` = :updateValue WHERE u_id = :u_id");
                        $stmt->bindParam(':updateValue', $updateValue);
                        $stmt->bindParam(':u_id', $_SESSION['u_id']);
                        $stmt->execute();
                
                        if ($stmt->rowCount() > 0) {
                            echo "<script>alert('更新成功'); window.location.href = 'aboutme.php';</script>";
                        } else {
                            echo "<script>alert('無變更導致的未更新'); window.history.back();</script>";
                        }
                    } catch (PDOException $e) {
                        die("Database error during update: " . $e->getMessage());
                    }
                } else {
                    echo "<script>alert('密碼與確認密碼不相同'); window.history.back();</script>";
                    exit();
                }
            }
            if ($fieldToUpdate === 'userRealName') { //處理更改密碼需要加密的部分
                $stmt = $db->prepare("SELECT * FROM users WHERE userRealName = :userRealName");
                $stmt->bindParam(':userRealName', $_POST['userRealName']);
                $stmt->execute();
                if($stmt -> rowCount()>0){
                    echo "<script>alert('姓名重複!'); window.history.back();</script>";  
                }else{
                    try { //更新資料庫
                        $stmt = $db->prepare("UPDATE users SET `$fieldToUpdate` = :updateValue WHERE u_id = :u_id");
                        $stmt->bindParam(':updateValue', $updateValue);
                        $stmt->bindParam(':u_id', $_SESSION['u_id']);
                        $stmt->execute();
                
                        if ($stmt->rowCount() > 0) {
                            echo "<script>alert('更新成功'); window.location.href = 'aboutme.php';</script>";
                        } else {
                            echo "<script>alert('無變更導致的未更新'); window.history.back();</script>";
                        }
                    } catch (PDOException $e) {
                        die("Database error during update: " . $e->getMessage());
                    }
                }
            }

            if ($fieldToUpdate === 'username') { //處理更改密碼需要加密的部分
                $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->bindParam(':username', $_POST['username']);
                $stmt->execute();
                if($stmt -> rowCount()>0){
                    echo "<script>alert('使用者名稱重複!'); window.history.back();</script>";  
                }else{
                    try { //更新資料庫
                        $stmt = $db->prepare("UPDATE users SET `$fieldToUpdate` = :updateValue WHERE u_id = :u_id");
                        $stmt->bindParam(':updateValue', $updateValue);
                        $stmt->bindParam(':u_id', $_SESSION['u_id']);
                        $stmt->execute();
                
                        if ($stmt->rowCount() > 0) {
                            $_SESSION['username']=$updateValue;
                            echo "<script>alert('更新成功'); window.location.href = 'aboutme.php';</script>";
                        } else {
                            echo "<script>alert('無變更導致的未更新'); window.history.back();</script>";
                        }
                    } catch (PDOException $e) {
                        die("Database error during update: " . $e->getMessage());
                    }
                }
            }
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
            這我
            </h2>
        </div>
        <div class="row">
            <div class="col-md-6">
            <div class="detail-box">
            <table>
                <tr>
                    <form action="aboutme.php" method="post" autocomplete="off">
                        <th>姓名</th>
                        <td><input type="text" name="userRealName" class="form-control border-0" value="<?php echo $userRealName;?>" ></td>
                        <td><button type="submit" name="update" value="userRealName">更改</button></td>
                    </form>
                </tr>
                <tr>
                    <form action="aboutme.php" method="post" autocomplete="off">
                        <th>使用者名稱</th>
                        <td><input type="text" name="username" class="form-control border-0" value="<?php echo $username;?>" ></td>
                        <td><button type="submit" name="update" value="username">更改</button></td>
                    </form>
                </tr>
                <form action="aboutme.php" method="post" autocomplete="off">
                <tr>
                    <th>密碼</th>
                    <td><input type="password" name="password" ></td>
                    <td rowspan="2" ><button type="submit" name="update" value="password">更改</button></td>
                </tr>
                <tr>
                    <th>再次確認密碼</th>
                    <td><input type="password" name="confirmPassword" ></td>
                </tr>
                </form>
            </table>
            </div>
            </div>
        </div>
        </div>
    </section>

    <!-- end about section -->

    <!-- jQery -->
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
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
        