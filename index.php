<?php
include 'config.php';

$sql = "SELECT * FROM SinhVien";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
      <meta charset="utf-8">
      <title>Danh sách Sinh Viên</title>
      <link rel="stylesheet" href="/Assets/css/index.css">
</head>

<body>
      <h2>Danh sách Sinh Viên</h2>
      <div class="btn-container">
            <a href="create.php" class="btn-action">➕ Thêm Sinh Viên</a>
            <a href="dangnhap.php" class="btn-login">🔑 Đăng Nhập</a>
      </div>


      <table>
            <tr>
                  <th>Mã SV</th>
                  <th>Họ Tên</th>
                  <th>Giới Tính</th>
                  <th>Ngày Sinh</th>
                  <th>Hình</th>
                  <th>Hành động</th>
                  <th>Đăng ký học phần</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                        <td><?= $row["MaSV"] ?></td>
                        <td><?= $row["HoTen"] ?></td>
                        <td><?= $row["GioiTinh"] ?></td>
                        <td><?= $row["NgaySinh"] ?></td>
                        <td><img src="<?= $row["Hinh"] ?>" width="50" height="50"></td>
                        <td>
                              <a href="detail.php?MaSV=<?= $row["MaSV"] ?>">👁 Xem</a> |
                              <a href="edit.php?MaSV=<?= $row["MaSV"] ?>">✏ Sửa</a> |
                              <a href="delete.php?MaSV=<?= $row["MaSV"] ?>" style="background-color: #dc3545;">❌ Xóa</a>
                        </td>
                        <td>
                              <a href="dangkyHP.php?MaSV=<?= $row["MaSV"] ?>" class="btn-dangky">📚 Đăng ký</a>
                        </td>
                  </tr>
            <?php endwhile; ?>
      </table>
</body>

</html>