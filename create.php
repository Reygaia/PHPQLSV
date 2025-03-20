<?php
include 'config.php';

// Hiển thị lỗi để dễ debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = ""; // Biến lưu thông báo lỗi hoặc thành công

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $MaSV = $_POST["MaSV"];
      $HoTen = $_POST["HoTen"];
      $GioiTinh = $_POST["GioiTinh"];
      $NgaySinh = $_POST["NgaySinh"];
      $MaNganh = $_POST["MaNganh"];

      // Thư mục lưu ảnh
      $target_dir = "Assets/images/";
      if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
      }

      // Mặc định ảnh
      $Hinh = "Assets/images/default.jpg";

      // Kiểm tra nếu có file ảnh được chọn
      if (isset($_FILES["Hinh"]) && $_FILES["Hinh"]["error"] == UPLOAD_ERR_OK) {
            $fileName = basename($_FILES["Hinh"]["name"]);
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowed_types = ["jpg", "jpeg", "png", "gif"];

            if (in_array($fileType, $allowed_types)) {
                  // Đặt tên file tránh trùng lặp
                  $newFileName = uniqid("img_", true) . "." . $fileType;
                  $target_file = $target_dir . $newFileName;

                  // Kiểm tra di chuyển file có thành công không
                  if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file)) {
                        $Hinh = $target_file; // Lưu đường dẫn ảnh vào database
                  } else {
                        $message = "Lỗi: Không thể lưu file ảnh.";
                  }
            } else {
                  $message = "Lỗi: Chỉ hỗ trợ file JPG, JPEG, PNG, GIF.";
            }
      }

      // Nếu không có lỗi thì lưu vào database
      if (empty($message)) {
            $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) 
                VALUES ('$MaSV', '$HoTen', '$GioiTinh', '$NgaySinh', '$Hinh', '$MaNganh')";
            if ($conn->query($sql) === TRUE) {
                  header("Location: index.php");
                  exit();
            } else {
                  $message = "Lỗi SQL: " . $conn->error;
            }
      }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
      <link rel="stylesheet" href="/Assets/css/create.css">
      <title>Thêm Sinh Viên</title>
</head>

<body>
      <div class="container">
            <h2>Thêm Sinh Viên</h2>
            <?php if (!empty($message))
                  echo "<p style='color: red;'>$message</p>"; ?>

            <form method="POST" enctype="multipart/form-data">
                  <input type="text" name="MaSV" placeholder="Mã SV" required>
                  <input type="text" name="HoTen" placeholder="Họ Tên" required>
                  <select name="GioiTinh">
                        <option value="Nam">Nam</option>
                        <option value="Nữ">Nữ</option>
                  </select>
                  <input type="date" name="NgaySinh">
                  <input type="file" name="Hinh" accept="image/*">
                  <input type="text" name="MaNganh" placeholder="Mã Ngành">
                  <input type="submit" value="Thêm">
            </form>

            <a href="index.php">⬅ Quay lại danh sách</a>
      </div>
</body>

</html>