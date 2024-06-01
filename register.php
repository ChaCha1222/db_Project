<?php
session_start();
?>
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
    </style>
    <?php
    
    include "database_connection.php";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

        $userRealName = $_POST['userRealName'] ?? '';
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $errors = '';
        if (empty($userRealName)) {
            $errors .= "使用者姓名不得為空\\n";
        } else if (strlen($userRealName) < 2 || strlen($userRealName) > 20) {
            $errors .= "使用者姓名的長度必須至少2個字元且少於20個字元\\n";
        }
        if (empty($username)) {
            $errors .= "使用者名稱不得為空\\n";
        } else if (strlen($username) < 4 || strlen($username) > 20) {
            $errors .= "使用者ID的長度必須至少4個字元且少於20個字元\\n";
        }
        if (empty($password)) {
            $errors .= "你的密碼不得為空\\n";
        } else if (strlen($password) < 4 || strlen($password) > 50) {
            $errors .= "密碼的長度必須至少4個字元且少於50個字元\\n";
        }

        if (empty($errors)) {
            $checkUser = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $checkUser->bindParam(':username', $username);
            $checkUser->execute();

            if ($checkUser->fetchColumn() > 0)
                $errors .= "使用者名稱已經被註冊\\n";
        }

        //echo "<script>alert('+$role+'\n'+$userRealName+'\n'+$email+'\n'+$phoneNumber+'\n'+$bloodType+'\n'+$birthday+'\n'+$username +'\n'+ $password+');</script>";
    
        if (!empty($errors))
            echo "<script>alert('$errors');</script>";
        else {
            if (!empty($password) && (strlen($password) >= 4) && (strlen($password) <= 50)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                // echo "<script>
                // 		alert('密碼加密');
                // 	</script>";
            }

            try {
                $stmt = $db->prepare("INSERT INTO users (userRealName, username, password,role) VALUES (:userRealName, :username, :password, :role)");
                $role = '2';
                $stmt->bindParam(':role', $role);
                $stmt->bindParam(':userRealName', $userRealName);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashedPassword);
                $stmt->execute();

                echo "<script>
							alert('使用者註冊成功');
							setTimeout(function() {
								window.location.href = 'login.php';
							}, 0);
						</script>";

            } catch (PDOException $e) {
                echo "資料庫錯誤: " . $e->getMessage();
            }
        }
    }
    ?>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 custom-title"></i>丹尼斯的交通裁決所</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <!-- Navbar End -->

    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="bg-light rounded h-100 d-flex flex-column align-items-center p-5 shadow-lg">
                    <form action="register.php" method="post" autocomplete="off">
                        <h1 class="mb-4 text-center">註冊新帳號</h1>
                        <div class="col-12">
                            <input type="text" name="userRealName" class="form-control border-0" placeholder="你的姓名">
                        </div>
                        <div class="col-12 mt-3">
                            <input type="text" name="username" class="form-control border-0" placeholder="使用者名稱">
                        </div>
                        <div class="col-12 mt-3">
                            <input type="password" name="password" class="form-control border-0" placeholder="請輸入密碼">
                        </div>
                        <div class="col-12 mt-4">
                            <button class="btn btn-primary w-100 py-3" type="submit">註冊帳號</button>
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        </div>
                    </form>
                    <div class="col-12 mt-3">
                        <a href="login.php" class="btn btn-link">返回登入</a>
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