<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Tên người dùng cơ sở dữ liệu
$password = "";  // Mật khẩu cơ sở dữ liệu
$dbname = "website_bando";  // Tên cơ sở dữ liệu

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy danh mục từ bảng tbl_category
$sql_category = "SELECT category_id, category_name FROM tbl_category";
$result_category = $conn->query($sql_category);

// Lấy thương hiệu từ bảng tbl_brand
$sql_brand = "SELECT brand_name, category_id FROM tbl_brand";
$result_brand = $conn->query($sql_brand);

// Lưu trữ thương hiệu theo category_id
$brands_by_category = [];
if ($result_brand->num_rows > 0) {
    while ($row_brand = $result_brand->fetch_assoc()) {
        $brands_by_category[$row_brand['category_id']][] = $row_brand['brand_name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Liên hệ</title>
</head>
<body>
    <!----------header---------->
    <header>
        <div class="logo">
            <a href="index.php"> <img src="../images/logopage.jpg"></a>
        </div>
        <div class="menu">
            <?php
                // Hiển thị danh mục và thương hiệu
                if ($result_category->num_rows > 0) {
                    while ($row_category = $result_category->fetch_assoc()) {
                        $category_id = $row_category['category_id'];
                        $category_name = $row_category['category_name'];
                        
                        // Xử lý cho các mục đặc biệt
                        if ($category_name == 'Outlet Sale - Sale up to 70%') {
                            echo "<li><a href='/user/category_user.php?category_id=" . $category_id . "'>" . $category_name . "</a></li>";
                        } elseif ($category_name == 'Bộ sưu tập') {
                            echo "<li><a href='/user/category_user.php?category_id=" . $category_id . "'>" . $category_name . "</a></li>";
                        } elseif ($category_name == 'Liên hệ') {
                            echo "<li><a href='/contact.php'>" . $category_name . "</a></li>";
                        } elseif ($category_name == 'Tin tức') {
                            echo "<li><a href='/news.php'>" . $category_name . "</a></li>";
                        } elseif ($category_name == 'Tuyển dụng') {
                            echo "<li><a href='/employees.php'>" . $category_name . "</a></li>";
                        } elseif ($category_name == 'Về chúng tôi') {
                            echo "<li><a href='/about_us.php'>" . $category_name . "</a></li>";
                        } else {
                            // Các mục danh mục còn lại sẽ vẫn hiển thị với liên kết đến category_user.php
                            echo "<li><a href='/user/category_user.php?category_id=" . $category_id . "'>" . $category_name . "</a></li>";
                        }
                    }
                } else {
                    echo "<li>Không có danh mục.</li>";
                }
            ?>
        </div>
        <div class="others">
            <li>
                <form action="search.php" method="GET" style="display: flex; align-items: center;">
                <input name="keyword" placeholder="Search..." type="text" required>
                <button type="submit" style="background: none; border: none; cursor: pointer;"><i class="fas fa-search"></i></button>       
                </form>
            </li>
            <li><a class="fa fa-user" href="#"></a></li>
            <li><a class="fa fa-shopping-bag" href="/user/cart.php"></a></li>
            <li><a class="fa-solid fa-right-from-bracket" href="/logout.php"></a></li>
        </div>
    </header>

    <!----------header---------->
    <section class="contact row">
        <div class="contact-left">
            <img src="/images/logopage.jpg" alt="">
        </div>
        <div class="contact-right">
            <h1>Thông tin liên hệ</h1>
            <h3>CS 403 M</h3>
            <p>HOTLINE: 123456<br>
                Địa chỉ: DTU, DaNang, VietNam<br>
                Email: abc@gmail.com
            </p>
        </div>
    </section>

        <!----------footer---------->
        <div class="footer-top">
        <li><a href="/index.php"><img src="/images/logopage.jpg"></a></li>
        <li><a href="/user/contact.php">Liên hệ</a></li>
        <li><a href="/user/employees.php">Tuyển dụng</a></li>
        <li><a href="/user/about_us.php">Giới thiệu</a></li>
        <li>
            <a href="" class="fab fa-facebook-f"></a>
            <a href="" class="fab fa-twitter"></a>
            <a href="" class="fab fa-youtube"></a>
        </li>
    </div>
    <div class="footer-center">
        <p>Trường Đại học Duy Tân<br>
            Địa chỉ: DTU, ĐÀ NẴNG <br>
            Đặt hàng online: <b>0123456</b>.
        </p>
    </div>
    <div class="footer-bottom">
        @DTU All rights reserved
    </div>  

<script src="/js/script.js"></script>
</body>
</html>
