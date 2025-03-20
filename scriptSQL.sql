-- Create Database
-- CREATE DATABASE QLSV;
USE QLSV;

-- Table: NganhHoc (Majors)
CREATE TABLE NganhHoc (
    MaNganh CHAR(4) PRIMARY KEY,
    TenNganh VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
);

-- Table: SinhVien (Students)
CREATE TABLE SinhVien (
    MaSV CHAR(10) PRIMARY KEY,
    HoTen VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    GioiTinh VARCHAR(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    NgaySinh DATE,
    Hinh VARCHAR(50),
    MaNganh CHAR(4),
    FOREIGN KEY (MaNganh) REFERENCES NganhHoc(MaNganh)
);

-- Table: HocPhan (Courses)
CREATE TABLE HocPhan (
    MaHP CHAR(6) PRIMARY KEY,
    TenHP VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    SoTinChi INT
);

-- Table: DangKy (Registration)
CREATE TABLE DangKy (
    MaDK INT AUTO_INCREMENT PRIMARY KEY,
    NgayDK DATE,
    MaSV CHAR(10),
    FOREIGN KEY (MaSV) REFERENCES SinhVien(MaSV)
);

-- Table: ChiTietDangKy (Registration Details)
CREATE TABLE ChiTietDangKy (
    MaDK INT,
    MaHP CHAR(6),
    PRIMARY KEY (MaDK, MaHP),
    FOREIGN KEY (MaDK) REFERENCES DangKy(MaDK),
    FOREIGN KEY (MaHP) REFERENCES HocPhan(MaHP)
);

-- Insert data into NganhHoc
INSERT INTO NganhHoc (MaNganh, TenNganh) VALUES 
('CNTT', 'Công nghệ thông tin'),
('QTKD', 'Quản trị kinh doanh');

-- Insert data into SinhVien
INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) VALUES 
('2180600176', 'Trần Tuấn Cường', 'Nam', '2003-10-02', '/Content/images/sv1.jpg', 'CNTT'),
('9876543210', 'Nguyễn Thị B', 'Nữ', '2000-07-03', '/Content/images/sv2.jpg', 'QTKD');

-- Insert data into HocPhan
INSERT INTO HocPhan (MaHP, TenHP, SoTinChi) VALUES 
('CNTT01', 'Lập trình C', 3),
('CNTT02', 'Cơ sở dữ liệu', 2),
('QTKD01', 'Kinh tế vi mô', 2),
('QTDK02', 'Xác suất thống kê 1', 3);

-- Select all data
SELECT * FROM SinhVien;
SELECT * FROM NganhHoc;
SELECT * FROM HocPhan;
SELECT * FROM DangKy;
SELECT * FROM ChiTietDangKy;
