<?php
include 'config.php';

if (!isset($_GET["MaSV"])) {
      die("Thiếu mã sinh viên!");
}

$MaSV = $_GET["MaSV"];
$sql = "SELECT * FROM SinhVien WHERE MaSV='$MaSV'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if (!$row) {
      die("Không tìm thấy sinh viên!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $HoTen = $_POST["HoTen"];
      $GioiTinh = $_POST["GioiTinh"];
      $NgaySinh = $_POST["NgaySinh"];
      $MaNganh = $_POST["MaNganh"];

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

      $sql = "UPDATE SinhVien SET HoTen='$HoTen', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', Hinh='$Hinh', MaNganh='$MaNganh' WHERE MaSV='$MaSV'";

      if ($conn->query($sql) === TRUE) {
            header("Location: index.php");
            exit;
      } else {
            echo "Lỗi cập nhật: " . $conn->error;
      }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="/Assets/css/edit.css">
      <title>Sửa Sinh Viên</title>
</head>

<body>
      <div class="container">
            <h2>Sửa Sinh Viên</h2>
            <div class="form-container">
                  <form method="post" enctype="multipart/form-data">
                        <input type="text" name="HoTen" value="<?= htmlspecialchars($row['HoTen']) ?>"
                              placeholder="Họ Tên" required>

                        <select name="GioiTinh">
                              <option value="" disabled>Chọn Giới Tính</option>
                              <option value="Nam" <?= ($row["GioiTinh"] == "Nam") ? "selected" : "" ?>>Nam</option>
                              <option value="Nữ" <?= ($row["GioiTinh"] == "Nữ") ? "selected" : "" ?>>Nữ</option>
                        </select>

                        <input type="date" name="NgaySinh" value="<?= htmlspecialchars($row['NgaySinh']) ?>">

                        <input type="file" name="Hinh" accept="image/*">
                        <?php if (!empty($row["Hinh"])): ?>
                              <img src="<?= htmlspecialchars($row["Hinh"]) ?>" alt="Hình Sinh Viên" class="preview-img">
                        <?php endif; ?>

                        <input type="text" name="MaNganh" value="<?= htmlspecialchars($row['MaNganh']) ?>"
                              placeholder="Mã Ngành">

                        <input type="submit" value="Lưu">
                  </form>
            </div>
      </div>
</body>

</html>