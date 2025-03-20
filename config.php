<?php
$servername = "localhost";
$username = "root"; // Đổi nếu cần
$password = ""; // Đổi nếu có mật khẩu
$dbname = "QLSV";

// Kết nối MySQL
$conn = new mysqli("127.0.0.1", "root", "", "QLSV");
if ($conn->connect_error) {
      die("Kết nối thất bại: " . $conn->connect_error);
}
?>