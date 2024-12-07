
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

// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Lấy thông tin sản phẩm từ bảng tbl_product
$sql_product = "SELECT * FROM tbl_product WHERE product_id = $product_id";
$result_product = $conn->query($sql_product);
$product = $result_product->fetch_assoc();
if (!$product) {
    die("Sản phẩm không tồn tại.");
}

// Lấy thông tin kích thước và số lượng từ bảng tbl_product_sizes
$sql_sizes = "SELECT * FROM tbl_product_sizes WHERE product_id = $product_id";
$result_sizes = $conn->query($sql_sizes);

// Mảng chứa số lượng của từng kích thước
$sizes = [];
while ($row_size = $result_sizes->fetch_assoc()) {
    $sizes[$row_size['size']] = $row_size['quantity'];
}

// Lấy ảnh mô tả từ bảng tbl_product_img_desc
$sql_desc_images = "SELECT * FROM tbl_product_img_desc WHERE product_id = $product_id";
$result_desc_images = $conn->query($sql_desc_images);

// Lấy brand_id của sản phẩm hiện tại
$brand_id = $product['brand_id'];

// Lấy các sản phẩm cùng thương hiệu từ bảng tbl_product
$sql_related_products = "SELECT * FROM tbl_product WHERE brand_id = $brand_id LIMIT 4"; // Giới hạn lấy 4 sản phẩm liên quan
$result_related_products = $conn->query($sql_related_products);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/1147679ae7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Product</title>
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
                            echo "<li><a href='category_id='>" . $brand . "</a></li>";
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
            <li><a class="fa fa-shopping-bag" href="#"></a></li>
            <li><a class="fa-solid fa-right-from-bracket" href="/logout.php"></a></li>
        </div>
    </header>
    <!----------product---------->
    <section class="product">
        <div class="container">
        </div>
        <div class="product-content row">
            <div class="product-content-left row">
                <div class="product-content-left-big-img">
                    <img src="/admin/uploads/<?php echo $product['product_img']; ?>" alt="">
                </div>
                <div class="product-content-left-small-img">
                <?php
                // Lấy ảnh mô tả từ bảng tbl_product_img_desc
                $sql_desc_images = "SELECT * FROM tbl_product_img_desc WHERE product_id = $product_id";
                $result_desc_images = $conn->query($sql_desc_images);
                while ($desc_image = $result_desc_images->fetch_assoc()) {
                    echo '<img src="/admin/uploads/' . htmlspecialchars($desc_image['product_img_desc']) . '" alt="">';
                }
                ?>
                </div>
            </div>
            <div class="product-content-right">

                <div class="product-content-right-product-name">
                    <h1><?php echo $product['product_name']; ?></h1>
                    <p>HOTS</p>
                </div>

                <div class="product-content-right-product-price">
                    <p><?php echo number_format($product['product_price_new'], 0, ',', '.') . "<sup>đ</sup>"; ?></p>
                </div>

                <div class="product-content-right-product-color">
                    <p><span style="font-weight: bold;">Tình trạng</span>: 
                    <?php 
                        // Kiểm tra tình trạng hàng
                        $total_quantity = array_sum($sizes); // Tính tổng số lượng của tất cả các size
                        if ($total_quantity > 0) {
                            echo "Còn hàng";
                        } else {
                            echo "Hết hàng";
                        }
                    ?>
                    <span style="color: red;">*</span>
                    </p>
                </div>

                <div class="product-content-right-product-size">
                <p style="font-weight: bold; margin-top: 10px;">Size:</p>
                    <div class="size">
                        <form id="size-form">
                        <?php
                        foreach ($sizes as $size => $quantity) {
                            $disabled = $quantity > 0 ? "" : "disabled";
                            echo "<label>
                                    <input type='radio' name='product_size' value='$size' $disabled>
                                    <span>" . htmlspecialchars($size) . "</span>
                                </label>";
                        }
                        ?>
                        </form>
                    </div>
                </div>

                <div class="quantity">
                    <p style="font-weight: bold;">Số lượng:</p>
                    <!-- Người dùng có thể chọn số lượng, max là số lượng của size M -->
                    <input type="number" min="1" max="<?php echo isset($sizes['M']) ? $sizes['M'] : 0; ?>" value="1" id="quantity_input"><br>
                </div>
                <p style="color: red;">Vui lòng chọn số lượng</p>

                <div class="product-content-right-product-button">
                    <button><i class="fas fa-shopping-cart"><a href="/user/cart.php"></i><p>BUY</p></a></button>
                    <button><a href="/user/category_user.php"><p>Tìm tại cửa hàng</p></a></button>
                </div>
                <div class="product-content-right-product-icon">
                    <div class="product-content-right-product-icon-item">
                        <i class="fas fa-phone-alt"><a href="/contact.php"></i><p>HOTLINE</p></a>
                    </div>
                    <div class="product-content-right-product-icon-item">
                        <i class="fas fa-comments"><a href="/contact.php"></i><p>CHAT</p></a>
                    </div>
                    <div class="product-content-right-product-icon-item">
                        <i class="fas fa-envelope"><a href="/contact.php"></i><p>MAIL</p></a>
                    </div>
                </div>
                <div class="product-content-right-product-QR">
                    <img src="images/QRCode.jpg" alt="">
                </div>
                <div class="product-content-right-bottom">
                    <div class="product-content-right-bottom-top">
                        &#8744;
                    </div>
                    <div class="product-content-right-bottom-content-big">
                        <div class="product-content-right-bottom-content-title row">
                            <div class="product-content-right-bottom-content-title-item chitiet">
                                <p><b>Chi tiết</b></p>
                            </div>
                            <div class="product-content-right-bottom-content-title-item baoquan">
                                <p>Mô tả</p>
                            </div>
                        </div>
                        <div class="product-content-right-bottom-content">
                            <div class="product-content-right-bottom-content-chitiet">
                                <?php echo nl2br(htmlspecialchars($product['product_desc'])); ?>
                            </div>
                            <div class="product-content-right-bottom-content-baoquan">                                
                                <p><strong>Tên sản phẩm:</strong> <?php echo $product['product_name']; ?></p>
                                <p><strong>Giá sản phẩm:</strong> <?php echo number_format($product['product_price_new'], 0, ',', '.') . "<sup>đ</sup>"; ?></p>
                                <p><strong>Size:</strong> <span id="selected-size">Chưa chọn</span></p>
                                <p><strong>Số lượng:</strong> <span id="selected-quantity">1</span></p>
                                <p><strong>Tình trạng:</strong> 
                                    <?php 
                                        $total_quantity = array_sum($sizes); // Tính tổng số lượng của tất cả các size
                                        if ($total_quantity > 0) {
                                            echo "Còn hàng";
                                        } else {
                                            echo "Hết hàng";
                                        }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!----------product-related---------->
    <section class="product-related row">
        <div class="product-related-title">
            <p>Sản phẩm liên quan</p>
        </div>
        <?php
        if ($result_related_products->num_rows > 0) {
            while ($related_product = $result_related_products->fetch_assoc()) {
                echo '<div class="product-related-item">';
                echo '<img src="/admin/uploads/' . $related_product['product_img'] . '" alt="">';
                echo '<h1>' . $related_product['product_name'] . '</h1>';
                echo '<p>' . number_format($related_product['product_price_new'], 0, ',', '.') . '<sup>đ</sup></p>';
                echo '</div>';
            }
        } else {
            echo '<p>Không có sản phẩm liên quan.</p>';
        }
        ?>
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
            Địa chỉ: DTU,ĐÀ NẴNG <br>
            Đặt hàng online: <b>0123456</b>.
        </p>
    </div>
    <div class="footer-bottom">
        @DTU All rights reserved
    </div>  
    <script src="/js/script.js"></script>
</body>
</html>