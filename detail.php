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
?>

<!DOCTYPE html>
<html lang="vi">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="/Assets/css/detail.css">
      <title>Chi Tiết Sinh Viên</title>
</head>

<body>
      <div class="container">
            <h2>Thông Tin Sinh Viên</h2>
            <div class="info-box">
                  <div class="image">
                        <?php if (!empty($row["Hinh"])): ?>
                              <img src="<?= htmlspecialchars($row["Hinh"]) ?>" alt="Hình Sinh Viên">
                        <?php else: ?>
                              <img src="/Assets/img/default-avatar.png" alt="Hình Mặc Định">
                        <?php endif; ?>
                  </div>
                  <div class="details">
                        <p><strong>Họ Tên:</strong> <?= htmlspecialchars($row["HoTen"]) ?></p>
                        <p><strong>Giới Tính:</strong> <?= htmlspecialchars($row["GioiTinh"]) ?></p>
                        <p><strong>Ngày Sinh:</strong> <?= htmlspecialchars($row["NgaySinh"]) ?></p>
                        <p><strong>Mã Ngành:</strong> <?= htmlspecialchars($row["MaNganh"]) ?></p>
                  </div>
            </div>
            <a href="edit.php?MaSV=<?= $MaSV ?>" class="edit-btn">Chỉnh sửa</a>
            <a href="index.php" class="back-btn">Quay lại</a>
      </div>
</body>

</html>