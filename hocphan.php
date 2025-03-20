<?php
include 'config.php';

// Truy vấn danh sách học phần
$sql = "SELECT * FROM HocPhan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Danh Sách Học Phần</title>
      <link rel="stylesheet" href="/Assets/css/hocphan.css">
</head>

<body>
      <div class="container">
            <h2>DANH SÁCH HỌC PHẦN</h2>
            <table>
                  <thead>
                        <tr>
                              <th>Mã Học Phần</th>
                              <th>Tên Học Phần</th>
                              <th>Số Tín Chỉ</th>
                              <th>Đăng Ký</th>
                        </tr>
                  </thead>
                  <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                              <tr>
                                    <td><?= $row["MaHP"] ?></td>
                                    <td><?= $row["TenHP"] ?></td>
                                    <td><?= $row["SoTinChi"] ?></td>
                                    <td><a href="dangky.php?MaHP=<?= $row["MaHP"] ?>" class="btn">Đăng Ký</a></td>
                              </tr>
                        <?php endwhile; ?>
                  </tbody>
            </table>
      </div>
</body>

</html>