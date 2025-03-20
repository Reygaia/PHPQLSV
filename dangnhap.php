<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $maSV = trim($_POST["MaSV"]);

      if (!empty($maSV)) {
            // Kiểm tra xem MSSV có tồn tại trong hệ thống không
            $sql = "SELECT * FROM SinhVien WHERE MaSV = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $maSV);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                  $_SESSION["MaSV"] = $maSV;
                  header("Location: xemhocphan.php");
                  exit();
            } else {
                  $error = "MSSV không tồn tại!";
            }
      } else {
            $error = "Vui lòng nhập MSSV!";
      }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
      <meta charset="UTF-8">
      <title>Đăng Nhập</title>
      <link rel="stylesheet" href="/Assets/css/dangnhap.css">
</head>

<body>
      <h2>Đăng Nhập</h2>
      <form method="post">
            <label for="MaSV">Mã số sinh viên:</label>
            <input type="text" id="MaSV" name="MaSV" required>
            <button type="submit">Đăng Nhập</button>
      </form>
      <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
      <?php endif; ?>
</body>

</html>