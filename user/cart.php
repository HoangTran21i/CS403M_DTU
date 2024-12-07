<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";  // Tên người dùng cơ sở dữ liệu
$password = "";  // Mật khẩu cơ sở dữ liệu
$dbname = "website_bando";  // Tên cơ sở dữ liệu

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy product_id từ URL
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;


if ($product_id > 0) {
    // Truy vấn thông tin sản phẩm theo product_id
    $sql_product = "SELECT * FROM tbl_product WHERE product_id = $product_id";
    $result_product = $conn->query($sql_product);

    if ($result_product->num_rows > 0) {
        $product = $result_product->fetch_assoc();
        echo "<h1>Thêm sản phẩm vào giỏ hàng:</h1>";
        echo "<p>Tên sản phẩm: " . $product['product_name'] . "</p>";
        echo "<p>Giá: " . number_format($product['product_price_new'], 0, ',', '.') . " đ</p>";
        echo "<p>Hình ảnh: <img src='/admin/uploads/" . $product['product_img'] . "' alt='" . $product['product_name'] . "'></p>";
        echo "<a href='/user/category_user.php'>Tiếp tục mua sắm</a>";
    } else {
        echo "Sản phẩm không tồn tại.";
    }
} else {
    echo "ID sản phẩm không hợp lệ.";
}

$conn->close();
?>