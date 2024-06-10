<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>丹尼斯的交通裁決所</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

   <style>
      body {
         background-color: #f0f8ff;
         font-family: 'Roboto', sans-serif;
      }

      .custom-title {
         color: #28004D;
         font-size: 24px;
         font-weight: bold;
         padding: 5px 10px;
      }

      .navbar {
         background-color: #FFFFFF;
         padding: 10px 20px;
      }

      .product {
         background-color: #fefefe;
         border: 1px solid #ccc;
         border-radius: 5px;
         padding: 10px;
         margin-bottom: 20px;
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

      .hover01 img {
         transition: transform 0.3s;
      }

      .hover01 img:hover {
         transform: scale(1.1);
      }

      .const_text {
         font-size: 1.5rem;
         /* 放大字体 */
         font-weight: 700;
         text-align: center;
         margin-top: 20px;
      }
   </style>
</head>

<body>
   <!-- Header Section -->
   <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
         <a class="custom-title" href="index.php">丹尼斯的交通裁決所</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
               <li class="nav-item active">
                  <a class="navbar" href="index.php">主頁</a>
               </li>
               <li class="nav-item">
                  <a class="navbar" href="login.php">登入</a>
               </li>
            </ul>
         </div>
      </div>
   </nav>

   <!-- 中间图片部分 -->
   <div class="container my-5">
      <div class="text-center">
         <img src="img/210998542_3995422013868153_8430457108632488863_n.jpg" class="img-fluid" alt="Center Image">
      </div>
   </div>

   <!-- Studies Section -->
   <div class="container">
      <h1 class="text-center mb-5">賣啥呢</h1>
      <div class="row">
         <div class="col-md-4">
            <div class="hover01 column">
               <figure><img src="img/T-VTR250-MTR02.jpg" class="img-fluid" alt="Service Image 1"></figure>
            </div>
            <div class="const_text">機車零件</div>
         </div>
         <div class="col-md-4">
            <div class="hover01 column">
               <figure><img src="img/fbcd144fc9b81dc1d2fbbf7ba687d574.jpg" class="img-fluid" alt="Service Image 2"></figure>
            </div>
            <div class="const_text">二手車</div>
         </div>
         <div class="col-md-4">
            <div class="hover01 column">
               <figure><img src="img/414402488_18305604058193678_5134493753816692781_n.jpg" class="img-fluid" alt="Service Image 3"></figure>
            </div>
            <div class="const_text">猴猴改裝品</div>
         </div>
      </div>
   </div>

   <!-- Footer Bottom Section -->
   <div class="copyright_section mt-5 py-3 text-center">
      <div class="container">
         <p class="copyright_text">© 2023 All Rights Reserved. Design by CBB111232</a></p>
      </div>
   </div>

   <!-- JS Scripts -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>