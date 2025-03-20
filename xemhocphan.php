<?php
session_start();
include 'config.php';

// Kiểm tra nếu MaSV có trong URL
if (!isset($_GET["MaSV"])) {
      die("Không có Mã Sinh Viên trong URL!");
} else {
      echo "Mã Sinh Viên: " . $_GET["MaSV"]; // Debug kiểm tra
}

$MaSV = $_GET["MaSV"];

// Lấy danh sách học phần đã đăng ký
$sql = "SELECT dk.MaDK, hp.MaHP, hp.TenHP, hp.SoTinChi 
        FROM ChiTietDangKy ctdk
        INNER JOIN DangKy dk ON ctdk.MaDK = dk.MaDK
        INNER JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP
        WHERE dk.MaSV = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $MaSV); // SỬA LỖI Ở ĐÂY
$stmt->execute();
$result = $stmt->get_result();
$danhSachHP = $result->fetch_all(MYSQLI_ASSOC);

$soHP = count($danhSachHP);
$tongTinChi = array_sum(array_column($danhSachHP, 'SoTinChi'));

// Xử lý xóa từng học phần
if (isset($_GET['xoaHP'])) {
      $maHP = $_GET['xoaHP'];
      $sql = "DELETE FROM ChiTietDangKy WHERE MaHP = ? AND MaDK IN (SELECT MaDK FROM DangKy WHERE MaSV = ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $maHP, $MaSV); // SỬA LỖI Ở ĐÂY
      $stmt->execute();
      header("Location: xemhocphan.php?MaSV=$MaSV"); // ĐẢM BẢO GIỮ LẠI MaSV
      exit();
}

// Xử lý xóa toàn bộ đăng ký
if (isset($_GET['xoaAll'])) {
      $sql = "DELETE FROM ChiTietDangKy WHERE MaDK IN (SELECT MaDK FROM DangKy WHERE MaSV = ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $MaSV); // SỬA LỖI Ở ĐÂY
      $stmt->execute();
      header("Location: xemhocphan.php?MaSV=$MaSV"); // ĐẢM BẢO GIỮ LẠI MaSV
      exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
      <meta charset="UTF-8">
      <title>Danh Sách Học Phần Đã Đăng Ký</title>
      <link rel="stylesheet" href="/Assets/css/hocphandangky.css">
</head>

<body>
      <h2>Danh Sách Học Phần Đã Đăng Ký</h2>
      <table border="1">
            <tr>
                  <th>Mã HP</th>
                  <th>Tên Học Phần</th>
                  <th>Số Tín Chỉ</th>
                  <th>Hành động</th>
            </tr>
            <?php foreach ($danhSachHP as $hp): ?>
                  <tr>
                        <td><?= $hp["MaHP"] ?></td>
                        <td><?= $hp["TenHP"] ?></td>
                        <td><?= $hp["SoTinChi"] ?></td>
                        <td><a href="?MaSV=<?= $MaSV ?>&xoaHP=<?= $hp["MaHP"] ?>"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                        </td>
                  </tr>
            <?php endforeach; ?>
      </table>

      <p style="color: red;">Số học phần: <?= $soHP ?> </p>
      <p style="color: red;">Tổng số tín chỉ: <?= $tongTinChi ?> </p>

      <a href="?MaSV=<?= $MaSV ?>&xoaAll=true" onclick="return confirm('Bạn có chắc chắn muốn xóa tất cả học phần?')">🗑
            Xóa Đăng Ký</a>
      <a href="dangkyHP.php?MaSV=<?= $MaSV ?>">📋 Đăng Ký Học Phần</a>
</body>

</html>