<?php
include "header.php";
include "slider.php";
include "class/product_class.php";
?>

<?php
$product = new product;
if($_SERVER['REQUEST_METHOD']=== 'POST'){
    // var_dump($_POST,$_FILES);

    // echo '<pre>';
    // echo print_r($_POST);
    // echo '<pre>';

    $insert_product = $product -> insert_product($_POST, $_FILES);
}
?>

<div class="admin-content-right">
<div class="admin-content-right-product_add">
                <h1>Thêm sản phẩm</h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Nhập tên sản phẩm <span style="color: red;">*</span></label>
                    <input name="product_name" required type="text">
                    <label for="">Chọn danh mục <span style="color: red;">*</span></label>
                    <select name="category_id" id="category_id">
                        <option value="#">--Chọn--</option>
                        <?php 
                            $show_category = $product -> show_category();
                            if($show_category) {while($result = $show_category -> fetch_assoc()) {
                        ?>
                        <option value="<?php echo $result['category_id'] ?> "><?php echo $result['category_name'] ?></option>
                        <?php 
                            }}
                        ?>
                    </select>
                    <label for="">Chọn loại sản phẩm <span style="color: red;">*</span></label>
                    <select name="brand_id" id="brand_id">
                        <label for="">Chọn loại sản phẩm <span style="color: red;">*</span></label>
                        <option value="#">--Chọn--</option>
                    </select>
                    <label for="">Giá sản phẩm <span style="color: red;">*</span></label>
                    <input name="product_price" type="text">
                    <label for="">Giá khuyến mãi <span style="color: red;">*</span></label>
                    <input name="product_price_new" type="text">
                    <label for="">Mô tả sản phẩm <span style="color: red;">*</span></label>
                    <textarea required name="product_desc" id="" cols="30" rows="10" ></textarea>
                    <label for="">Ảnh sản phẩm <span style="color: red;">*</span></label>
                    <input name="product_img" type="file">
                    <label for="">Ảnh mô tả <span style="color: red;">*</span></label>
                    <input name="product_img_desc" multiple type="file">
                    <button type="submit">Thêm</button>
                </form>
            </div>
        </div>
    </section>

</body>

<!-- <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
            
                CKEDITOR.replace( 'editor1', {
	filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
	filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'
} );
</script> -->

<script>
    // Ajax để cập nhật danh sách loại sản phẩm khi chọn danh mục
    $(document).ready(function(){
        $("#category_id").change(function(){
            var category_id = $(this).val();
            if(category_id != '#') {
                $.get("productadd_ajax.php", {category_id: category_id}, function(data){
                    $("#brand_id").html(data);  // Cập nhật danh sách thương hiệu
                });
            } else {
                $("#brand_id").html("<option value='#'>--Chọn--</option>");
            }
        });
    });
</script>
</html>