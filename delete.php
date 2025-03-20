<?php
include 'config.php';

$MaSV = $_GET["MaSV"];
$sql = "DELETE FROM SinhVien WHERE MaSV='$MaSV'";

if ($conn->query($sql) === TRUE) {
      header("Location: index.php");
}
?>