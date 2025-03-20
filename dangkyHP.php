<?php
include 'config.php';

$MaSV = $_GET["MaSV"];

// Lấy thông tin sinh viên
$sql_sv = "SELECT * FROM SinhVien WHERE MaSV = '$MaSV'";
$result_sv = $conn->query($sql_sv);
$sinhvien = $result_sv->fetch_assoc();

if (!$sinhvien) {
      die("Không tìm thấy sinh viên!");
}

// Lấy danh sách học phần
$sql_hp = "SELECT * FROM HocPhan";
$result_hp = $conn->query($sql_hp);

// Xử lý khi sinh viên đăng ký học phần
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["MaHP"])) {
      $MaHP = $_POST["MaHP"];

      // Bước 1: Kiểm tra xem sinh viên đã có MaDK chưa
      $check_sql = "SELECT MaDK FROM DangKy WHERE MaSV='$MaSV'";
      $check_result = $conn->query($check_sql);

      if ($check_result->num_rows == 0) {
            // Nếu chưa có, thêm vào DangKy trước
            $insert_dangky = "INSERT INTO DangKy (MaSV) VALUES ('$MaSV')";
            $conn->query($insert_dangky);
            $MaDK = $conn->insert_id; // Lấy ID mới chèn vào
      } else {
            // Nếu đã có, lấy MaDK hiện tại
            $row = $check_result->fetch_assoc();
            $MaDK = $row['MaDK'];
      }

      // Bước 2: Kiểm tra xem học phần đã được đăng ký chưa
      $check_ct = "SELECT * FROM ChiTietDangKy WHERE MaDK='$MaDK' AND MaHP='$MaHP'";
      $result_ct = $conn->query($check_ct);

      if ($result_ct->num_rows == 0) {
            // Chưa đăng ký, thực hiện INSERT vào ChiTietDangKy
            $sql_dk = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$MaDK', '$MaHP')";
            if ($conn->query($sql_dk) === TRUE) {
                  echo "<script>alert('Đăng ký thành công!');</script>";
            } else {
                  echo "Lỗi: " . $conn->error;
            }
      } else {
            echo "<script>alert('Bạn đã đăng ký học phần này!');</script>";
      }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
      <meta charset="UTF-8">
      <title>Đăng ký Học Phần</title>
      <link rel="stylesheet" href="/Assets/css/dangkyHP.css">
</head>

<body>
      <h2>Đăng ký Học Phần</h2>
      <p><b>Mã Sinh Viên:</b> <?= $sinhvien["MaSV"] ?></p>
      <p><b>Họ Tên:</b> <?= $sinhvien["HoTen"] ?></p>

      <form method="post">
            <label for="MaHP">Chọn học phần:</label>
            <select name="MaHP" id="MaHP" required>
                  <?php while ($row_hp = $result_hp->fetch_assoc()): ?>
                        <option value="<?= $row_hp["MaHP"] ?>"><?= $row_hp["TenHP"] ?> (<?= $row_hp["SoTinChi"] ?> tín chỉ)
                        </option>
                  <?php endwhile; ?>
            </select>
            <button type="submit">Đăng ký</button>
      </form>
      <div style="text-align: center; margin-top: 20px;">
            <a href="xemhocphan.php?MaSV=<?= $MaSV ?>" class="view-button">Xem Học Phần Đã Đăng Ký</a>
      </div>

</body>

</html>