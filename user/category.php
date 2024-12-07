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

// Truy vấn để lấy danh mục
$sql_category = "SELECT category_id, category_name FROM tbl_category";
$result_category = $conn->query($sql_category);

// Truy vấn để lấy thương hiệu theo category_id
$sql_brand = "SELECT brand_name, category_id FROM tbl_brand";
$result_brand = $conn->query($sql_brand);

// Lưu trữ thương hiệu theo category_id
$brands_by_category = [];
if ($result_brand->num_rows > 0) {
    while ($row_brand = $result_brand->fetch_assoc()) {
        $brands_by_category[$row_brand['category_id']][] = $row_brand['brand_name'];
    }
}

// Lấy tham số lọc và sắp xếp
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$brand_name = isset($_GET['brand_name']) ? $_GET['brand_name'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';

// Tạo câu truy vấn sản phẩm
$where = [];
if ($category_id > 0) {
    $where[] = "category_id = $category_id";
}
if (!empty($brand_name)) {
    $where[] = "brand_name = '" . $conn->real_escape_string($brand_name) . "'";
}
$where_clause = !empty($where) ? "WHERE " . implode(' AND ', $where) : '';

$order_clause = '';
if ($order === 'asc') {
    $order_clause = "ORDER BY product_price_new ASC"; // Sắp xếp theo giá giảm dần
} elseif ($order === 'desc') {
    $order_clause = "ORDER BY product_price_new DESC"; // Sắp xếp theo giá tăng dần
} elseif ($order === 'name_asc') {
    $order_clause = "ORDER BY product_name ASC";  // Sắp xếp theo tên A-Z
} elseif ($order === 'name_desc') {
    $order_clause = "ORDER BY product_name DESC";  // Sắp xếp theo tên Z-A
}


// Truy vấn tổng số sản phẩm
$sql_total = "SELECT COUNT(*) AS total FROM tbl_product $where_clause";
$result_total = $conn->query($sql_total);
$total_row = $result_total->fetch_assoc();
$total_products = $total_row['total'];  // Tổng số sản phẩm

// Định nghĩa số sản phẩm mỗi trang
$products_per_page = 8;
$total_pages = ceil($total_products / $products_per_page);  // Số trang tổng cộng

// Lấy trang hiện tại từ URL
$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($current_page < 1) $current_page = 1;
if ($current_page > $total_pages) $current_page = $total_pages;

// Tính toán OFFSET cho truy vấn SQL
$offset = ($current_page - 1) * $products_per_page;

// Truy vấn dữ liệu sản phẩm
$sql_product = "SELECT product_img, product_name, product_price_new FROM tbl_product $where_clause $order_clause LIMIT $products_per_page OFFSET $offset";
$result_product = $conn->query($sql_product);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bộ sưu tập</title>
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
                    echo "<li><a href='?category_id='>" . $row_category['category_name'] . "</a>";
                    
                    // Hiển thị thương hiệu theo từng danh mục
                    if (isset($brands_by_category[$row_category['category_id']])) {
                        echo "<ul class='sub-menu'>";
                        foreach ($brands_by_category[$row_category['category_id']] as $brand) {
                            echo "<li><a href='?category_id='>" . $brand . "</a></li>";
                        }
                        echo "</ul>";
                    }
                    echo "</li>";
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

    <!----------category---------->
    <section class="category">
        <div class="container">
            <div class="row">
                <div class="category-left">
                    <ul>
                        <li class="category-left-li"><a href="#">Nữ</a>
                            <ul>
                                <li><a href="">Áo</a></li>
                                <li><a href="">Quần</a></li>
                            </ul>
                        </li>
                        <li class="category-left-li"><a href="#">NAM</a>
                            <ul>
                                <li><a href="">Áo</a></li>
                                <li><a href="">Quần</a></li>
                                <li><a href="">Áo khoác</a></li>
                                <li><a href="">Sale</a></li>
                            </ul>
                        </li>
                        <li class="category-left-li"><a href="">Đồ bộ</a></li>
                        <li class="category-left-li"><a href="">FLASH SALE</a></li>
                        <li class="category-left-li"><a href="">HOT ITEMS</a></li>
                    </ul>
                </div>

                <div class="category-right row">
                    <div class="category-right-top-item">
                        <p>Hàng mới về</p>
                    </div>
                    <div class="category-right-top-item">
                        <button><span>Filter</span><i class="fas fa-sort-down"></i></button>
                    </div>
                    <div class="category-right-top-item">
                        <select name="sortSelect" id="sortSelect">
                            <option value="">--Sắp xếp--</option>
                            <option value="asc"<?= $order === 'asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                            <option value="desc"<?= $order === 'desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                            <option value="name_asc" <?= $order === 'name_asc' ? 'selected' : '' ?>>Tên A-Z</option>
                            <option value="name_desc" <?= $order === 'name_desc' ? 'selected' : '' ?>>Tên Z-A</option>
                        </select>
                    </div>               
                    <div class="category-right-content">
                    <?php
                    if ($result_product->num_rows > 0) {
                        // Duyệt qua các sản phẩm và hiển thị thông tin
                        while ($row_product = $result_product->fetch_assoc()) {
                            echo "<div class='category-right-content-item'>";
                            echo "<img src='/admin/uploads/" . $row_product['product_img'] . "' alt='" . $row_product['product_name'] . "'>";
                            echo "<h1>" . $row_product['product_name'] . "</h1>";
                            echo "<p>" . number_format($row_product['product_price_new'], 0, ',', '.') . "<sup>đ</sup></p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Không có sản phẩm nào.</p>";
                    }
                    ?>
                    </div>
                    <div class="category-right-bottom row">
                        <div class="category-right-bottom-items">
                            <p>Hiển thị <?= $products_per_page ?> <span>|</span> <?= $total_products ?> sản phẩm</p>
                        </div>
                        <div class="category-right-bottom-items">
                        <p>
                            <span>&#171;</span> 
                            <?php
                            // Hiển thị các trang
                            for ($i = 1; $i <= $total_pages; $i++) {
                                // Kiểm tra xem trang hiện tại có phải là trang này không
                                if ($i == $current_page) {
                                    echo "<span>$i</span>";
                                } else {
                                    echo "<a href='?category_id=$category_id&order=$order&page=$i'>$i</a>";
                                }
                                if ($i < $total_pages) {
                                    echo " ";
                                }
                            }
                            ?>
                            <span>&#187;</span> Trang cuối
                        </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!----------footer---------->
    <div class="footer-top">
        <li><a href=""><img src="/images/logopage.jpg"></a></li>
        <li><a href="">Liên hệ</a></li>
        <li><a href="">Tuyển dụng</a></li>
        <li><a href="">Giới thiệu</a></li>
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