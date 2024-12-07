-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 07, 2024 lúc 09:43 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `website_bando`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin_data`
--

CREATE TABLE `tbl_admin_data` (
  `admin_id` int(11) NOT NULL,
  `email_admin` varchar(255) NOT NULL,
  `password_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin_data`
--

INSERT INTO `tbl_admin_data` (`admin_id`, `email_admin`, `password_admin`) VALUES
(5, 'admin2@gmail.com', '$2y$10$XprlvuoU171mEeUoqprHaeLbCUyQsH2FxJZobgZkO1hPj5HFo07bq');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_brand`
--

CREATE TABLE `tbl_brand` (
  `brand_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_brand`
--

INSERT INTO `tbl_brand` (`brand_id`, `category_id`, `brand_name`) VALUES
(13, 1, 'Áo nam'),
(14, 1, 'Quần nam'),
(15, 2, 'Áo nữ'),
(17, 1, 'Áo khoác nam'),
(18, 2, 'Chân Váy'),
(19, 2, 'Quần nữ'),
(20, 1, 'Phụ kiện nam'),
(21, 2, 'Đồ bộ nữ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`) VALUES
(1, 'Nam'),
(2, 'Nữ '),
(3, 'Outlet Sale - Sale up to 70%'),
(4, 'Bộ sưu tập'),
(5, 'Liên hệ'),
(6, 'Tin tức'),
(7, 'Tuyển dụng'),
(8, 'Về chúng tôi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product`
--

CREATE TABLE `tbl_product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_price_new` varchar(255) NOT NULL,
  `product_desc` varchar(5000) NOT NULL,
  `product_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product`
--

INSERT INTO `tbl_product` (`product_id`, `product_name`, `category_id`, `brand_id`, `product_price`, `product_price_new`, `product_desc`, `product_img`) VALUES
(1, 'Polo Regular', 1, 13, '450000', '300000', 'HƯỚNG DẪN BẢO QUẢN\r\n\r\n- Khi giặt không ngâm quá lâu\r\n- Giặt máy với chu kỳ trung bình, vòng quay ngắn (nếu kỹ hơn có thể giặt tay để giữ độ bền)\r\n- Nên kết hợp nước xả vải để sản phẩm mềm mại và phẳng hơn\r\n- Không sử dụng hóa chất tẩy để giặt\r\n- Phơi trong bóng mát. Sấy khô ở nhiệt độ thấp\r\n- Lộn ngược mặt trái để giặt và tránh giặt với sản phẩm khác màu\r\n\r\nLƯU Ý\r\n\r\n- Giao hàng tận nơi\r\n- Kiểm tra hàng trước khi thanh toán\r\n____', 'polo_regular.avif'),
(3, 'Cargo nhiều túi', 1, 14, '400000', '370000', 'Quần Cargo nhiều túi ZARA', 'cargo.jpg'),
(4, 'Áo khoác dạ nam dáng ngắn', 1, 17, '899000', '800000', 'Áo khoác dạ nam dáng ngắn LIZARD chất liệu cao cấp', 'aokhoacdanam.jpg'),
(5, 'Áo nữ 22SF6818170', 2, 15, '697000', '299000', 'Áo nữ 22SF6818170/SP2210\r\n', 'ao_nu.jpg'),
(6, 'Váy nữ đẹp cao cấp', 2, 18, '710000', '700000', 'Đầm, Váy nữ đẹp cao cấp - Váy đầm sang trọng', 'vaynu.webp'),
(7, 'Quần dài nữ Intage Pants', 2, 19, '400000', '250000', 'Chất liệu: Caro Lăng cao cấp, chất dày dặn, đứng form ít nhăn., Form dáng: Quần lưng cao, dáng Baggy. Chi tiết xếp ly sắc xảo tạo điểm nhấn ở phần lai ...', 'quannu.webp'),
(8, 'Combo 2 đôi tất Nam Dệt Họa Tiết', 1, 20, '20000', '15000', 'Sản phẩm tất nam với chất liệu đa dạng, thoải mái với độ co giãn, đàn hồi trên mọi hoạt động. Thiết kế họa tiết độc đáo giúp bạn thể hiện phong cách riêng và tạo điểm nhấn cho trang phục.', 'tatnam.webp'),
(9, 'Bộ Đông Nữ Hoodie In Hình', 2, 21, '899000', '809100', 'Siêu giữ ấm cho mùa lạnh với bộ đồ hoodie dành cho các chị em. Thiết kế áo hoodie cùng quần nỉ dày dặn, giữ ấm tốt. Kết cấu sợi tạo nên mặt vải đanh chắc, không bị bai dão, ít xù. Khả năng co giãn nhẹ giúp thoải mái trong mọi hoạt động di chuyển. Thiết kế basic nhưng có hình in tạo điểm nhấn riêng biệt, ấn tượng.', 'dobonu.webp'),
(10, ' Áo Ba Lỗ Nam Cơ Bản Gấu Thêu Slogan', 1, 13, '129000', '116000', 'Áo ba lỗ làm từ sợi cotton mềm mại, thoáng mát, thấm hút mồ hôi tốt thích hợp cho mọi hoạt động. Độ dày dặn vừa phải giúp áo giữ form tốt, không bai dão. Thiết kế basic đơn giản, điểm nhấn thêu slogan cá tính, phù hợp cho nhiều phong cách và hoàn cảnh.', 'aobalonam.webp'),
(11, ' Quần Sooc Nam Túi Cạnh Sườn', 1, 14, '379000', '341000', 'Thoải mái hoạt động với vải mềm mại, thấm hút nhanh. Túi cạnh sườn tiện lợi đừng đồ dùng cá nhân nhỏ gọn. Thích hợp mặc ở nhà, đi làm hay đi chơi. Thiếu kế ngang đầu gối, dáng cơ bản', 'quansoocnam.webp'),
(12, ' Áo Polo Nam Pique Mắt Chim Basic Co Giãn Thoáng Khí', 1, 13, '400000', '345000', 'Vải dệt 2 màu tạo nên hiệu ứng mắt chim độc đáo. Độ bền cao, thám hút tốt, thoáng khí giúp bạn luôn cảm thấy mát mẻ, dễ chịu. Phần cổ và bo tay áo được thiết kế tỉ mỉ, tinh tế giúp tôn dáng.', 'aopolonam.webp'),
(13, ' Áo Len Nam Thu Đông Cổ 3 Cm', 1, 17, '399000', '279300', 'Áo len dáng suông vừa phải, ôm gọn gàng khi mặc. Thoải mái cử động cho người mặc, giữ ấm tốt nhờ chất liệu viscose cùng kiểu dệt giữ nhiệt hiệu quả. Thiết kế cổ 3cm trẻ trung giữ ấm.', 'aolennam.webp'),
(14, 'Áo Len Nam Regular Cổ Tròn Thấp Bện Thừng', 1, 13, '499000', '450000', 'Giữ ấm hiệu quả với chất liệu len vặn thừng cao cấp. Vải mềm mịn, co giãn tốt, không xù, không bai màu mang đến cảm giác thoải mái, tự tin. Thiết kế đơn giản, dễ phối đồ phù hợp với nhiều phong cách.', 'aolennam1.webp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product_img_desc`
--

CREATE TABLE `tbl_product_img_desc` (
  `product_id` int(11) NOT NULL,
  `product_img_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product_img_desc`
--

INSERT INTO `tbl_product_img_desc` (`product_id`, `product_img_desc`) VALUES
(1, 'polo_regular_desc.jpg'),
(3, 'cargo_desc.jpg'),
(4, 'aokhoacdanam_desc.jpg'),
(5, 'ao_nu_desc.jpg'),
(6, 'vaynu_desc.webp'),
(7, 'quannu_desc.webp'),
(8, 'tatnam_desc.webp'),
(9, 'dobonu_desc.webp'),
(10, 'aobalonam_desc.webp'),
(11, 'quansoocnam_desc.webp'),
(12, 'aopolonam_desc.webp'),
(13, 'aolennam_desc.webp'),
(14, 'aolennam1_desc.webp');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_product_sizes`
--

CREATE TABLE `tbl_product_sizes` (
  `size_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_product_sizes`
--

INSERT INTO `tbl_product_sizes` (`size_id`, `product_id`, `size`, `quantity`) VALUES
(1, 1, 'M', 10),
(3, 1, 'L', 10),
(4, 1, 'XL', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_user_data`
--

CREATE TABLE `tbl_user_data` (
  `user_id` int(11) NOT NULL,
  `email_user` int(11) NOT NULL,
  `password_user` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_user_data`
--

INSERT INTO `tbl_user_data` (`user_id`, `email_user`, `password_user`) VALUES
(6, 0, '$2y$10$MFxj0GPhSgIFroSDO/JeAO7CsJOGYTN.Qw0RoXDwiFbp51MhozJRm');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_admin_data`
--
ALTER TABLE `tbl_admin_data`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Chỉ mục cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `tbl_product_sizes`
--
ALTER TABLE `tbl_product_sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Chỉ mục cho bảng `tbl_user_data`
--
ALTER TABLE `tbl_user_data`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_admin_data`
--
ALTER TABLE `tbl_admin_data`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `tbl_brand`
--
ALTER TABLE `tbl_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `tbl_product_sizes`
--
ALTER TABLE `tbl_product_sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `tbl_user_data`
--
ALTER TABLE `tbl_user_data`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
