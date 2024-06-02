<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>丹尼斯的交通裁決所</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

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
            background-color: #4682b4;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        /* 調整登入表單的排版 */
        .form-control {
            margin-bottom: 10px;
        }

        .btn-primary {
            width: 100%;
        }

        .register-link {
            text-align: center;
            margin-top: 10px;
        }
    </style>

    <?php
    session_start();
    include "database_connection.php";
    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();


        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['u_id'] = $user['u_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($_SESSION['role'] == "1") {
                header('Location: manageAccounts.php');
            } else {
                header('Location: product.php');
            }

            exit;
        } else {
            // 登入失敗以及錯誤訊息
            echo "<script>alert('使用者名稱或密碼錯誤');</script>";
        }
    }
    ?>
</head>

<body>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.php">
            <h1 class="m-0 custom-title">丹尼斯的交通裁決所</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <!-- Navbar End -->

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-6 col-md-8 col-sm-10 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded h-100 d-flex flex-column align-items-center p-5 shadow-lg">
                    <form action="login.php" method="post" class="w-100" autocomplete="off">
                        <h1 class="mb-4 text-center">使用者登入</h1>
                        <input name="username" class="form-control border-0" placeholder="請輸入使用者名稱">
                        <input type="password" name="password" class="form-control border-0" placeholder="請輸入密碼">
                        <button class="btn btn-primary py-3" type="submit">登入</button>
                    </form>
                    <div class="link-container text-center mt-3">
                        <a href="register.php">註冊新帳號</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="divider">|</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="forgotPassword.php">忘記密碼？</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

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
</body>

</html>