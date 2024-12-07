<?php
include "header.php";
include "slider.php";
include "class/product_class.php";
?>
<?php
$product = new product;
$product_id = $_GET['product_id'];
    $get_product = $product -> get_product($product_id);
    if($get_product) {
        $result = $get_product -> fetch_assoc(); 
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $update_product = $product->update_product($product_id, $_POST, $_FILES);
    }
?>
<div class="admin-content-right">
            <div class="admin-content-right-product_add">
                <h1>Thêm sản phẩm</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Nhập tên sản phẩm <span style="color: red;">*</span></label>
                    <input name="product_name" type="text" value="<?php echo $result['product_name']; ?>">
                    <label for="">Chọn danh mục <span style="color: red;">*</span></label>
                    <select name="category_id" id="category_id">
                        <option value="#">--Chọn--</option>
                        <?php
                            $show_category = $product->show_category();
                            if ($show_category) {
                                while ($category = $show_category->fetch_assoc()) {
                                    $selected = ($category['category_id'] == $result['category_id']) ? 'selected' : '';
                                    echo "<option value='{$category['category_id']}' $selected>{$category['category_name']}</option>";
                                }
                            }
                        ?>
                    </select>
                    <label for="">Chọn loại sản phẩm <span style="color: red;">*</span></label>
                    <select name="brand_id" id="brand_id">
                        <option value="#">--Chọn--</option>
                        <?php
                        $show_brand = $product->show_brand_ajax($result['category_id']);
                        if ($show_brand) {
                            while ($brand = $show_brand->fetch_assoc()) {
                                $selected = ($brand['brand_id'] == $result['brand_id']) ? 'selected' : '';
                                echo "<option value='{$brand['brand_id']}' $selected>{$brand['brand_name']}</option>";
                            }
                        }
                        ?>
                    </select>
                    <label for="">Giá sản phẩm <span style="color: red;">*</span></label>
                    <input name="product_price" type="text" value="<?php echo $result['product_price']; ?>">
                    <label for="">Giá khuyến mãi <span style="color: red;">*</span></label>
                    <input name="product_price_new" type="text" value="<?php echo $result['product_price_new']; ?>">
                    <label for="">Mô tả sản phẩm <span style="color: red;">*</span></label>
                    <textarea name="product_desc" cols="30" rows="10"><?php echo $result['product_desc']; ?></textarea>
                    <label for="">Ảnh sản phẩm <span style="color: red;">*</span></label>
                    <img src="uploads/<?php echo $result['product_img']; ?>" width="100" height="100" alt="Product Image">
                    <label for="">Ảnh mô tả <span style="color: red;">*</span></label>
                    <input name="product_img_desc[]" multiple type="file">
                    <?php
                    $show_product_desc = $product->show_product_img_desc($product_id);
                    if ($show_product_desc) {
                        while ($desc = $show_product_desc->fetch_assoc()) {
                            echo '<img src="images_desc/' . $desc['product_img_desc'] . '" width="50" height="50" alt="Description Image">';
                        }
                    }
                    ?>
                    <button type="submit">Sửa</button>
                </form>
            </div>
        </div>
        <script>
    // Thay đổi danh mục sẽ load lại loại sản phẩm
    $(document).ready(function() {
        $("#category_id").change(function() {
            var category_id = $(this).val();
            $.get("productadd_ajax.php", { category_id: category_id }, function(data) {
                $("#brand_id").html(data);
            });
        });
    });
</script>
    </section>
</body>
</html>