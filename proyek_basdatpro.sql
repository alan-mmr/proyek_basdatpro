-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for proyek_basdatpro
CREATE DATABASE IF NOT EXISTS `proyek_basdatpro` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `proyek_basdatpro`;

-- Dumping structure for table proyek_basdatpro.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `idbarang` int NOT NULL,
  `jenis` char(1) DEFAULT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `idsatuan` int DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `harga` int DEFAULT NULL,
  PRIMARY KEY (`idbarang`),
  KEY `idsatuan` (`idsatuan`),
  CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`idsatuan`) REFERENCES `satuan` (`idsatuan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.barang: ~9 rows (approximately)
INSERT INTO `barang` (`idbarang`, `jenis`, `nama`, `idsatuan`, `status`, `harga`) VALUES
	(1, 'A', 'Baja Ringan 2m', 1, 1, 150000),
	(2, 'B', 'Cat Tembok 5kg', 3, 1, 85000),
	(3, 'A', 'Semen 50kg', 1, 1, 75000),
	(4, 'C', 'Pipa PVC 3/4"', 1, 1, 20000),
	(5, 'B', 'Cat Kayu 1L', 4, 1, 45000),
	(6, 'B', 'kapas', 1, 1, 200000),
	(8, 'D', 'GERGAJI', 3, 1, 100000),
	(9, 'B', 'sapu', 3, 1, 10000),
	(10, 'e', 'pasir', 4, 1, 1);

-- Dumping structure for table proyek_basdatpro.detail_penerimaan
CREATE TABLE IF NOT EXISTS `detail_penerimaan` (
  `iddetail_penerimaan` int NOT NULL,
  `idpenerimaan` int DEFAULT NULL,
  `barang_idbarang` int DEFAULT NULL,
  `jumlah_terima` int DEFAULT NULL,
  `harga_satuan_terima` int DEFAULT NULL,
  `sub_total_terima` int DEFAULT NULL,
  PRIMARY KEY (`iddetail_penerimaan`),
  KEY `idpenerimaan` (`idpenerimaan`),
  KEY `barang_idbarang` (`barang_idbarang`),
  CONSTRAINT `detail_penerimaan_ibfk_1` FOREIGN KEY (`idpenerimaan`) REFERENCES `penerimaan` (`idpenerimaan`),
  CONSTRAINT `detail_penerimaan_ibfk_2` FOREIGN KEY (`barang_idbarang`) REFERENCES `barang` (`idbarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.detail_penerimaan: ~16 rows (approximately)
INSERT INTO `detail_penerimaan` (`iddetail_penerimaan`, `idpenerimaan`, `barang_idbarang`, `jumlah_terima`, `harga_satuan_terima`, `sub_total_terima`) VALUES
	(1, 1, 1, 1, 150000, 150000),
	(2, 1, 5, 1, 45000, 45000),
	(3, 2, 1, 1, 150000, 150000),
	(4, 2, 5, 1, 45000, 45000),
	(5, 3, 8, 1, 90000, 90000),
	(6, 4, 1, 1, 150000, 150000),
	(7, 5, 1, 1, 150000, 150000),
	(8, 5, 8, 1, 100000, 100000),
	(9, 6, 1, 1, 150000, 150000),
	(10, 6, 8, 1, 100000, 100000),
	(11, 7, 5, 1, 45000, 45000),
	(12, 8, 1, 25, 150000, 3750000),
	(13, 8, 5, 25, 45000, 1125000),
	(14, 8, 8, 25, 100000, 2500000),
	(15, 9, 5, 10, 45000, 450000),
	(16, 9, 2, 30, 85000, 2550000);

-- Dumping structure for table proyek_basdatpro.detail_pengadaan
CREATE TABLE IF NOT EXISTS `detail_pengadaan` (
  `iddetail_pengadaan` int NOT NULL,
  `harga_satuan` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `sub_total` int DEFAULT NULL,
  `idbarang` int DEFAULT NULL,
  `idpengadaan` int DEFAULT NULL,
  PRIMARY KEY (`iddetail_pengadaan`),
  KEY `idbarang` (`idbarang`),
  KEY `idpengadaan` (`idpengadaan`),
  CONSTRAINT `detail_pengadaan_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`),
  CONSTRAINT `detail_pengadaan_ibfk_2` FOREIGN KEY (`idpengadaan`) REFERENCES `pengadaan` (`idpengadaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.detail_pengadaan: ~14 rows (approximately)
INSERT INTO `detail_pengadaan` (`iddetail_pengadaan`, `harga_satuan`, `jumlah`, `sub_total`, `idbarang`, `idpengadaan`) VALUES
	(1, 150000, 2, 300000, 1, 1),
	(2, 45000, 2, 90000, 5, 1),
	(3, 90000, 1, 90000, 8, 2),
	(4, 150000, 1, 150000, 1, 3),
	(5, 1, 1, 1, 10, 3),
	(6, 150000, 2, 300000, 1, 4),
	(7, 100000, 2, 200000, 8, 4),
	(8, 45000, 1, 45000, 5, 5),
	(9, 150000, 50, 7500000, 1, 6),
	(10, 45000, 50, 2250000, 5, 6),
	(11, 100000, 50, 5000000, 8, 6),
	(12, 150000, 10, 1500000, 1, 7),
	(13, 45000, 20, 900000, 5, 7),
	(14, 85000, 30, 2550000, 2, 7);

-- Dumping structure for table proyek_basdatpro.detail_penjualan
CREATE TABLE IF NOT EXISTS `detail_penjualan` (
  `iddetail_penjualan` int NOT NULL,
  `harga_satuan` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `subtotal` int DEFAULT NULL,
  `penjualan_idpenjualan` int DEFAULT NULL,
  `idbarang` int DEFAULT NULL,
  PRIMARY KEY (`iddetail_penjualan`),
  KEY `penjualan_idpenjualan` (`penjualan_idpenjualan`),
  KEY `idbarang` (`idbarang`),
  CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`penjualan_idpenjualan`) REFERENCES `penjualan` (`idpenjualan`),
  CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.detail_penjualan: ~7 rows (approximately)
INSERT INTO `detail_penjualan` (`iddetail_penjualan`, `harga_satuan`, `jumlah`, `subtotal`, `penjualan_idpenjualan`, `idbarang`) VALUES
	(1, 100000, 1, 100000, 1, 8),
	(2, 150000, 1, 150000, 2, 1),
	(3, 45000, 1, 45000, 2, 5),
	(4, 100000, 1, 100000, 3, 8),
	(5, 150000, 1, 150000, 3, 1),
	(6, 150000, 5, 750000, 4, 1),
	(7, 100000, 10, 1000000, 4, 8);

-- Dumping structure for table proyek_basdatpro.detail_retur
CREATE TABLE IF NOT EXISTS `detail_retur` (
  `iddetail_retur` int NOT NULL,
  `jumlah` int DEFAULT NULL,
  `alasan` varchar(200) DEFAULT NULL,
  `idretur` int DEFAULT NULL,
  `iddetail_penerimaan` int DEFAULT NULL,
  PRIMARY KEY (`iddetail_retur`),
  KEY `idretur` (`idretur`),
  KEY `iddetail_penerimaan` (`iddetail_penerimaan`),
  CONSTRAINT `detail_retur_ibfk_1` FOREIGN KEY (`idretur`) REFERENCES `retur` (`idretur`),
  CONSTRAINT `detail_retur_ibfk_2` FOREIGN KEY (`iddetail_penerimaan`) REFERENCES `detail_penerimaan` (`iddetail_penerimaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.detail_retur: ~0 rows (approximately)

-- Dumping structure for function proyek_basdatpro.fn_total_margin_penjualan
DELIMITER //
CREATE FUNCTION `fn_total_margin_penjualan`(p_idpenjualan INT) RETURNS double
    DETERMINISTIC
BEGIN
    DECLARE v_total_penjualan INT DEFAULT 0;
    DECLARE v_persen DOUBLE DEFAULT 0;
    DECLARE v_total_margin DOUBLE DEFAULT 0;

    -- Ambil total penjualan dari function sebelumnya
    SET v_total_penjualan = fn_total_penjualan(p_idpenjualan);

    -- Ambil persen margin dari tabel margin_penjualan via relasi
    SELECT 
        COALESCE(mp.persen, 0)
    INTO v_persen
    FROM margin_penjualan mp
    JOIN penjualan p ON p.idmargin_penjualan = mp.idmargin_penjualan
    WHERE p.idpenjualan = p_idpenjualan;

    -- Hitung total margin
    SET v_total_margin = v_total_penjualan * (v_persen / 100);

    RETURN v_total_margin;
END//
DELIMITER ;

-- Dumping structure for function proyek_basdatpro.fn_total_penerimaan
DELIMITER //
CREATE FUNCTION `fn_total_penerimaan`(p_idpenerimaan INT) RETURNS int
    DETERMINISTIC
BEGIN
    DECLARE v_total INT DEFAULT 0;

    SELECT COALESCE(SUM(sub_total_terima), 0)
    INTO v_total
    FROM detail_penerimaan
    WHERE idpenerimaan = p_idpenerimaan;

    RETURN v_total;
END//
DELIMITER ;

-- Dumping structure for function proyek_basdatpro.fn_total_pengadaan
DELIMITER //
CREATE FUNCTION `fn_total_pengadaan`(p_idpengadaan INT) RETURNS int
    DETERMINISTIC
BEGIN
    DECLARE v_total INT DEFAULT 0;

    SELECT COALESCE(SUM(sub_total), 0)
    INTO v_total
    FROM detail_pengadaan
    WHERE idpengadaan = p_idpengadaan;

    RETURN v_total;
END//
DELIMITER ;

-- Dumping structure for function proyek_basdatpro.fn_total_penjualan
DELIMITER //
CREATE FUNCTION `fn_total_penjualan`(p_idpenjualan INT) RETURNS int
    DETERMINISTIC
BEGIN
    DECLARE v_total INT DEFAULT 0;

    SELECT COALESCE(SUM(subtotal), 0)
    INTO v_total
    FROM detail_penjualan
    WHERE penjualan_idpenjualan = p_idpenjualan;

    RETURN v_total;
END//
DELIMITER ;

-- Dumping structure for function proyek_basdatpro.hitung_total_pengadaan
DELIMITER //
CREATE FUNCTION `hitung_total_pengadaan`() RETURNS decimal(15,2)
    READS SQL DATA
BEGIN
    DECLARE v_total DECIMAL(15,2);

    -- Menjumlahkan total_nilai dari tabel pengadaan
    SELECT SUM(total_nilai) 
    INTO v_total 
    FROM pengadaan;

    -- Mengembalikan 0 jika tabel kosong (NULL), atau hasil penjumlahan
    RETURN IFNULL(v_total, 0);
END//
DELIMITER ;

-- Dumping structure for function proyek_basdatpro.hitung_total_penjualan
DELIMITER //
CREATE FUNCTION `hitung_total_penjualan`() RETURNS decimal(15,2)
    READS SQL DATA
BEGIN
    DECLARE v_total DECIMAL(15,2);

    -- Melakukan query penjumlahan dan memasukkannya ke variabel
    SELECT SUM(total_nilai) 
    INTO v_total 
    FROM penjualan;

    -- Mengembalikan 0 jika hasil NULL (tabel kosong), atau nilai total jika ada
    RETURN IFNULL(v_total, 0);
END//
DELIMITER ;

-- Dumping structure for table proyek_basdatpro.kartu_stok
CREATE TABLE IF NOT EXISTS `kartu_stok` (
  `idkartu_stok` int NOT NULL,
  `jenis_transaksi` char(1) DEFAULT NULL,
  `masuk` int DEFAULT NULL,
  `keluar` int DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `idtransaksi` int DEFAULT NULL,
  `idbarang` int DEFAULT NULL,
  PRIMARY KEY (`idkartu_stok`),
  KEY `idbarang` (`idbarang`),
  CONSTRAINT `kartu_stok_ibfk_1` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.kartu_stok: ~23 rows (approximately)
INSERT INTO `kartu_stok` (`idkartu_stok`, `jenis_transaksi`, `masuk`, `keluar`, `stock`, `created_at`, `idtransaksi`, `idbarang`) VALUES
	(1, 'M', 1, NULL, 1, '2025-11-26 16:54:58', 1, 1),
	(2, 'M', 1, NULL, 1, '2025-11-26 16:54:58', 1, 5),
	(3, 'M', 1, NULL, 2, '2025-11-26 17:07:30', 2, 1),
	(4, 'M', 1, NULL, 2, '2025-11-26 17:07:30', 2, 5),
	(5, 'M', 1, NULL, 1, '2025-11-26 17:15:56', 3, 8),
	(6, 'K', NULL, 1, 0, '2025-11-26 18:38:03', 1, 8),
	(7, 'K', NULL, 1, 1, '2025-11-26 18:39:20', 2, 1),
	(8, 'K', NULL, 1, 1, '2025-11-26 18:39:20', 2, 5),
	(9, 'M', 1, NULL, 2, '2025-11-27 01:24:02', 4, 1),
	(10, 'M', 1, NULL, 3, '2025-11-27 01:26:52', 5, 1),
	(11, 'M', 1, NULL, 1, '2025-11-27 01:26:52', 5, 8),
	(12, 'M', 1, NULL, 4, '2025-11-27 01:27:00', 6, 1),
	(13, 'M', 1, NULL, 2, '2025-11-27 01:27:00', 6, 8),
	(14, 'K', NULL, 1, 1, '2025-11-27 01:27:20', 3, 8),
	(15, 'K', NULL, 1, 3, '2025-11-27 01:27:20', 3, 1),
	(16, 'M', 1, NULL, 2, '2025-11-27 01:43:11', 7, 5),
	(17, 'M', 25, NULL, 28, '2025-11-27 02:32:41', 8, 1),
	(18, 'M', 25, NULL, 27, '2025-11-27 02:32:41', 8, 5),
	(19, 'M', 25, NULL, 26, '2025-11-27 02:32:41', 8, 8),
	(20, 'M', 10, NULL, 37, '2025-11-27 02:37:03', 9, 5),
	(21, 'M', 30, NULL, 30, '2025-11-27 02:37:03', 9, 2),
	(22, 'K', NULL, 5, 23, '2025-11-27 02:43:18', 4, 1),
	(23, 'K', NULL, 10, 16, '2025-11-27 02:43:18', 4, 8);

-- Dumping structure for table proyek_basdatpro.margin_penjualan
CREATE TABLE IF NOT EXISTS `margin_penjualan` (
  `idmargin_penjualan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `persen` double DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idmargin_penjualan`),
  KEY `iduser` (`iduser`),
  CONSTRAINT `margin_penjualan_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.margin_penjualan: ~6 rows (approximately)
INSERT INTO `margin_penjualan` (`idmargin_penjualan`, `created_at`, `persen`, `status`, `iduser`, `updated_at`) VALUES
	(1, '2025-09-01 01:00:00', 10, 1, 1, '2025-11-27 01:02:38'),
	(2, '2025-09-02 02:00:00', 12.5, 0, 1, '2025-11-26 18:51:30'),
	(3, '2025-09-03 03:00:00', 8, 0, 3, '2025-09-03 03:00:00'),
	(4, '2025-09-04 04:00:00', 15, 0, 4, '2025-09-04 04:00:00'),
	(5, '2025-09-05 05:00:00', 5, 0, 1, '2025-11-26 18:51:42'),
	(6, '2025-11-26 18:51:56', 11, 0, 1, '2025-11-26 18:51:56');

-- Dumping structure for table proyek_basdatpro.penerimaan
CREATE TABLE IF NOT EXISTS `penerimaan` (
  `idpenerimaan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `idpengadaan` int DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  PRIMARY KEY (`idpenerimaan`),
  KEY `idpengadaan` (`idpengadaan`),
  KEY `iduser` (`iduser`),
  CONSTRAINT `penerimaan_ibfk_1` FOREIGN KEY (`idpengadaan`) REFERENCES `pengadaan` (`idpengadaan`),
  CONSTRAINT `penerimaan_ibfk_2` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.penerimaan: ~9 rows (approximately)
INSERT INTO `penerimaan` (`idpenerimaan`, `created_at`, `status`, `idpengadaan`, `iduser`) VALUES
	(1, '2025-11-26 16:54:58', '1', 1, 1),
	(2, '2025-11-26 17:07:30', '1', 1, 1),
	(3, '2025-11-26 17:15:56', '1', 2, 1),
	(4, '2025-11-27 01:24:02', '1', 3, 1),
	(5, '2025-11-27 01:26:52', '1', 4, 1),
	(6, '2025-11-27 01:27:00', '1', 4, 1),
	(7, '2025-11-27 01:43:11', '1', 5, 1),
	(8, '2025-11-27 02:32:41', '1', 6, 1),
	(9, '2025-11-27 02:37:03', '1', 7, 1);

-- Dumping structure for table proyek_basdatpro.pengadaan
CREATE TABLE IF NOT EXISTS `pengadaan` (
  `idpengadaan` int NOT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  `user_iduser` int DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  `vendor_idvendor` int DEFAULT NULL,
  `subtotal_nilai` int DEFAULT NULL,
  `ppn` int DEFAULT NULL,
  `total_nilai` int DEFAULT NULL,
  PRIMARY KEY (`idpengadaan`),
  KEY `user_iduser` (`user_iduser`),
  KEY `vendor_idvendor` (`vendor_idvendor`),
  CONSTRAINT `pengadaan_ibfk_1` FOREIGN KEY (`user_iduser`) REFERENCES `user` (`iduser`),
  CONSTRAINT `pengadaan_ibfk_2` FOREIGN KEY (`vendor_idvendor`) REFERENCES `vendor` (`idvendor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.pengadaan: ~7 rows (approximately)
INSERT INTO `pengadaan` (`idpengadaan`, `timestamp`, `user_iduser`, `status`, `vendor_idvendor`, `subtotal_nilai`, `ppn`, `total_nilai`) VALUES
	(1, '2025-11-26 13:59:21', 1, '0', 5, 390000, 39000, 429000),
	(2, '2025-11-26 15:55:03', 1, '0', 4, 90000, 9000, 99000),
	(3, '2025-11-27 01:23:02', 1, '0', 2, 150001, 15000, 165001),
	(4, '2025-11-27 01:26:35', 1, '0', 5, 500000, 50000, 550000),
	(5, '2025-11-27 01:42:22', 1, '0', 5, 45000, 4500, 49500),
	(6, '2025-11-27 01:47:52', 1, '0', 2, 14750000, 1475000, 16225000),
	(7, '2025-11-27 02:35:12', 1, '0', 2, 4950000, 495000, 5445000);

-- Dumping structure for table proyek_basdatpro.penjualan
CREATE TABLE IF NOT EXISTS `penjualan` (
  `idpenjualan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `subtotal_nilai` int DEFAULT NULL,
  `ppn` int DEFAULT NULL,
  `total_nilai` int DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  `idmargin_penjualan` int DEFAULT NULL,
  PRIMARY KEY (`idpenjualan`),
  KEY `iduser` (`iduser`),
  KEY `idmargin_penjualan` (`idmargin_penjualan`),
  CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`),
  CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`idmargin_penjualan`) REFERENCES `margin_penjualan` (`idmargin_penjualan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.penjualan: ~4 rows (approximately)
INSERT INTO `penjualan` (`idpenjualan`, `created_at`, `subtotal_nilai`, `ppn`, `total_nilai`, `iduser`, `idmargin_penjualan`) VALUES
	(1, '2025-11-26 18:38:03', 100000, 10000, 110000, 1, 1),
	(2, '2025-11-26 18:39:20', 195000, 19500, 214500, 1, 1),
	(3, '2025-11-27 01:27:20', 250000, 25000, 275000, 1, 1),
	(4, '2025-11-27 02:43:18', 1750000, 175000, 1925000, 1, 1);

-- Dumping structure for table proyek_basdatpro.retur
CREATE TABLE IF NOT EXISTS `retur` (
  `idretur` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `idpenerimaan` int DEFAULT NULL,
  `iduser` int DEFAULT NULL,
  PRIMARY KEY (`idretur`),
  KEY `idpenerimaan` (`idpenerimaan`),
  KEY `iduser` (`iduser`),
  CONSTRAINT `retur_ibfk_1` FOREIGN KEY (`idpenerimaan`) REFERENCES `penerimaan` (`idpenerimaan`),
  CONSTRAINT `retur_ibfk_2` FOREIGN KEY (`iduser`) REFERENCES `user` (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.retur: ~0 rows (approximately)

-- Dumping structure for table proyek_basdatpro.role
CREATE TABLE IF NOT EXISTS `role` (
  `idrole` int NOT NULL,
  `nama_role` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idrole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.role: ~7 rows (approximately)
INSERT INTO `role` (`idrole`, `nama_role`) VALUES
	(1, 'Super Admin'),
	(2, 'Admin'),
	(3, 'Manager'),
	(4, 'Staff'),
	(5, 'Gudang'),
	(7, 'SUPERVISOR'),
	(8, 'CLEANING');

-- Dumping structure for table proyek_basdatpro.satuan
CREATE TABLE IF NOT EXISTS `satuan` (
  `idsatuan` int NOT NULL,
  `nama_satuan` varchar(45) DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  PRIMARY KEY (`idsatuan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.satuan: ~6 rows (approximately)
INSERT INTO `satuan` (`idsatuan`, `nama_satuan`, `status`) VALUES
	(1, 'Pcs', 1),
	(2, 'Kg', 1),
	(3, 'Box', 1),
	(4, 'Liter', 1),
	(5, 'Roll', 1),
	(6, 'liter', 1);

-- Dumping structure for procedure proyek_basdatpro.sp_laporan_penjualan_stok
DELIMITER //
CREATE PROCEDURE `sp_laporan_penjualan_stok`()
BEGIN
    SELECT 
        b.idbarang,
        b.nama AS nama_barang,
        COALESCE(SUM(dp.jumlah), 0) AS jumlah_terjual,
        COALESCE(ks.stock, 0) AS stok_tersisa
    FROM barang b
    LEFT JOIN detail_penjualan dp ON b.idbarang = dp.idbarang
    LEFT JOIN kartu_stok ks ON b.idbarang = ks.idbarang
    GROUP BY b.idbarang, b.nama, ks.stock
    ORDER BY b.idbarang;
END//
DELIMITER ;

-- Dumping structure for procedure proyek_basdatpro.sp_minat_pasar
DELIMITER //
CREATE PROCEDURE `sp_minat_pasar`(IN p_from DATE, IN p_to DATE)
BEGIN
  SELECT
    b.idbarang,
    b.nama AS nama_barang,
    COALESCE(SUM(dp.jumlah), 0) AS jumlah_terjual,
    COALESCE((SELECT MAX(ks.stock) FROM kartu_stok ks WHERE ks.idbarang = b.idbarang), 0) AS stock_tersisa
  FROM barang b
  LEFT JOIN detail_penjualan dp
    ON b.idbarang = dp.idbarang
  LEFT JOIN penjualan pj
    ON dp.penjualan_idpenjualan = pj.idpenjualan
  WHERE
    (p_from IS NULL OR DATE(pj.created_at) >= p_from)
    AND (p_to IS NULL OR DATE(pj.created_at) <= p_to)
  GROUP BY b.idbarang, b.nama
  ORDER BY jumlah_terjual DESC;
END//
DELIMITER ;

-- Dumping structure for table proyek_basdatpro.user
CREATE TABLE IF NOT EXISTS `user` (
  `iduser` int NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `idrole` int DEFAULT NULL,
  PRIMARY KEY (`iduser`),
  KEY `idrole` (`idrole`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.user: ~7 rows (approximately)
INSERT INTO `user` (`iduser`, `username`, `password`, `idrole`) VALUES
	(1, 'superadmin', 'superpass', 1),
	(2, 'admin', 'admin123', 2),
	(3, 'manajer1', 'manajer123', 3),
	(4, 'staff01', 'staffpass', 4),
	(5, 'gudang01', 'gudangpass', 5),
	(6, 'superman', 'superman', 1),
	(7, 'tojik', '123', 2);

-- Dumping structure for table proyek_basdatpro.vendor
CREATE TABLE IF NOT EXISTS `vendor` (
  `idvendor` int NOT NULL,
  `nama_vendor` varchar(100) DEFAULT NULL,
  `badan_hukum` char(1) DEFAULT NULL,
  `status` char(1) DEFAULT NULL,
  PRIMARY KEY (`idvendor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table proyek_basdatpro.vendor: ~6 rows (approximately)
INSERT INTO `vendor` (`idvendor`, `nama_vendor`, `badan_hukum`, `status`) VALUES
	(1, 'PT. Sumber Jaya', 'P', '1'),
	(2, 'CV. Makmur Sentosa', 'C', '1'),
	(3, 'UD. Putra Niaga', 'U', '1'),
	(4, 'PT. Prima Suplai', 'P', '1'),
	(5, 'CV. Amanah', 'C', '1'),
	(6, 'plmarhsa', 'P', '1');

-- Dumping structure for view proyek_basdatpro.view_barang_satuan
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_barang_satuan` (
	`idbarang` INT NOT NULL,
	`jenis` CHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`nama` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`harga` INT NULL,
	`status` TINYINT NULL,
	`idsatuan` INT NULL,
	`nama_satuan` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- Dumping structure for view proyek_basdatpro.view_detail_penerimaan_lengkap
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_detail_penerimaan_lengkap` (
	`iddetail_penerimaan` INT NOT NULL,
	`jumlah_terima` INT NULL,
	`harga_satuan_terima` INT NULL,
	`sub_total_terima` INT NULL,
	`idbarang` INT NULL,
	`nama_barang` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`harga_barang` INT NULL,
	`idpenerimaan` INT NULL,
	`nama_vendor` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- Dumping structure for view proyek_basdatpro.view_detail_pengadaan_lengkap
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_detail_pengadaan_lengkap` (
	`iddetail_pengadaan` INT NOT NULL,
	`harga_satuan` INT NULL,
	`jumlah` INT NULL,
	`sub_total` INT NULL,
	`idbarang` INT NULL,
	`nama_barang` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`harga_barang` INT NULL,
	`idpengadaan` INT NULL,
	`idvendor` INT NULL,
	`nama_vendor` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- Dumping structure for view proyek_basdatpro.view_detail_penjualan_lengkap
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_detail_penjualan_lengkap` (
	`iddetail_penjualan` INT NOT NULL,
	`harga_satuan` INT NULL,
	`jumlah` INT NULL,
	`subtotal` INT NULL,
	`idbarang` INT NULL,
	`nama_barang` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`harga_barang` INT NULL,
	`idpenjualan` INT NULL,
	`total_nilai` INT NULL,
	`nama_user` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- Dumping structure for view proyek_basdatpro.view_kartu_stok_barang
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_kartu_stok_barang` (
	`idkartu_stok` INT NOT NULL,
	`jenis_transaksi` CHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`masuk` INT NULL,
	`keluar` INT NULL,
	`stock` INT NULL,
	`created_at` TIMESTAMP NULL,
	`idtransaksi` INT NULL,
	`idbarang` INT NULL,
	`nama_barang` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`jenis` CHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`harga` INT NULL
) ENGINE=MyISAM;

-- Dumping structure for view proyek_basdatpro.view_penerimaan_pengadaan_user
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_penerimaan_pengadaan_user` (
	`idpenerimaan` INT NOT NULL,
	`created_at` TIMESTAMP NULL,
	`status` CHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`idpengadaan` INT NULL,
	`iduser` INT NULL,
	`tanggal_pengadaan` TIMESTAMP NULL,
	`nama_vendor` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`nama_user` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- Dumping structure for view proyek_basdatpro.view_pengadaan_vendor_user
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_pengadaan_vendor_user` (
	`idpengadaan` INT NOT NULL,
	`timestamp` TIMESTAMP NULL,
	`status` CHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`subtotal_nilai` INT NULL,
	`ppn` INT NULL,
	`total_nilai` INT NULL,
	`idvendor` INT NULL,
	`nama_vendor` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`badan_hukum` CHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`status_vendor` CHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`iduser` INT NULL,
	`nama_user` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- Dumping structure for view proyek_basdatpro.view_penjualan_margin_user
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_penjualan_margin_user` (
	`idpenjualan` INT NOT NULL,
	`created_at` TIMESTAMP NULL,
	`subtotal_nilai` INT NULL,
	`ppn` INT NULL,
	`total_nilai` INT NULL,
	`idmargin_penjualan` INT NULL,
	`margin_persen` DOUBLE NULL,
	`status_margin` TINYINT NULL,
	`iduser` INT NULL,
	`nama_user` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- Dumping structure for view proyek_basdatpro.view_user_role
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_user_role` (
	`iduser` INT NOT NULL,
	`username` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`password` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`idrole` INT NULL,
	`nama_role` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci'
) ENGINE=MyISAM;

-- Dumping structure for view proyek_basdatpro.view_vendor_status
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_vendor_status` (
	`idvendor` INT NOT NULL,
	`nama_vendor` VARCHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`badan_hukum` CHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`status` CHAR(1) NULL COLLATE 'utf8mb4_0900_ai_ci',
	`keterangan_status` VARCHAR(1) NOT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for trigger proyek_basdatpro.trg_after_delete_detail_pengadaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_after_delete_detail_pengadaan` AFTER DELETE ON `detail_pengadaan` FOR EACH ROW BEGIN
  DECLARE v_sub INT DEFAULT 0;
  DECLARE v_ppn INT DEFAULT 0;
  DECLARE v_total INT DEFAULT 0;

  SELECT COALESCE(SUM(sub_total),0) INTO v_sub
  FROM detail_pengadaan
  WHERE idpengadaan = OLD.idpengadaan;

  SET v_ppn = ROUND(v_sub * 0.10);
  SET v_total = v_sub + v_ppn;

  UPDATE pengadaan
  SET subtotal_nilai = v_sub, ppn = v_ppn, total_nilai = v_total
  WHERE idpengadaan = OLD.idpengadaan;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_after_insert_detail_penerimaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_after_insert_detail_penerimaan` AFTER INSERT ON `detail_penerimaan` FOR EACH ROW BEGIN
  DECLARE _last_stock INT DEFAULT 0;
  DECLARE _new_stock INT DEFAULT 0;
  DECLARE _new_id INT DEFAULT 0;

  SELECT ks.stock INTO _last_stock
  FROM kartu_stok ks
  WHERE ks.idbarang = NEW.barang_idbarang
  ORDER BY ks.idkartu_stok DESC
  LIMIT 1;

  IF _last_stock IS NULL THEN
    SET _last_stock = 0;
  END IF;

  SET _new_stock = _last_stock + COALESCE(NEW.jumlah_terima, 0);

  SELECT COALESCE(MAX(idkartu_stok),0) + 1 INTO _new_id FROM kartu_stok;

  INSERT INTO kartu_stok (
    idkartu_stok, jenis_transaksi, masuk, keluar, stock, created_at, idtransaksi, idbarang
  ) VALUES (
    _new_id,
    'M',                       /* M = Masuk (penerimaan) */
    COALESCE(NEW.jumlah_terima,0),
    NULL,
    _new_stock,
    NOW(),
    NEW.idpenerimaan,
    NEW.barang_idbarang
  );
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_after_insert_detail_pengadaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_after_insert_detail_pengadaan` AFTER INSERT ON `detail_pengadaan` FOR EACH ROW BEGIN
  DECLARE v_sub INT DEFAULT 0;
  DECLARE v_ppn INT DEFAULT 0;
  DECLARE v_total INT DEFAULT 0;

  SELECT COALESCE(SUM(sub_total),0) INTO v_sub
  FROM detail_pengadaan
  WHERE idpengadaan = NEW.idpengadaan;

  SET v_ppn = ROUND(v_sub * 0.10);
  SET v_total = v_sub + v_ppn;

  UPDATE pengadaan
  SET subtotal_nilai = v_sub, ppn = v_ppn, total_nilai = v_total
  WHERE idpengadaan = NEW.idpengadaan;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_after_insert_detail_penjualan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_after_insert_detail_penjualan` AFTER INSERT ON `detail_penjualan` FOR EACH ROW BEGIN
  DECLARE _last_stock INT DEFAULT 0;
  DECLARE _new_stock INT DEFAULT 0;
  DECLARE _new_id INT DEFAULT 0;

  SELECT ks.stock INTO _last_stock
  FROM kartu_stok ks
  WHERE ks.idbarang = NEW.idbarang
  ORDER BY ks.idkartu_stok DESC
  LIMIT 1;

  IF _last_stock IS NULL THEN
    SET _last_stock = 0;
  END IF;

  SET _new_stock = _last_stock - COALESCE(NEW.jumlah, 0);

  SELECT COALESCE(MAX(idkartu_stok),0) + 1 INTO _new_id FROM kartu_stok;

  INSERT INTO kartu_stok (
    idkartu_stok, jenis_transaksi, masuk, keluar, stock, created_at, idtransaksi, idbarang
  ) VALUES (
    _new_id,
    'K',                       /* K = Keluar (penjualan) */
    NULL,
    COALESCE(NEW.jumlah,0),
    _new_stock,
    NOW(),
    NEW.penjualan_idpenjualan,
    NEW.idbarang
  );
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_after_update_detail_pengadaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_after_update_detail_pengadaan` AFTER UPDATE ON `detail_pengadaan` FOR EACH ROW BEGIN
  DECLARE v_sub INT DEFAULT 0;
  DECLARE v_ppn INT DEFAULT 0;
  DECLARE v_total INT DEFAULT 0;
  DECLARE v_idpengadaan INT DEFAULT 0;

  SET v_idpengadaan = COALESCE(NEW.idpengadaan, OLD.idpengadaan);

  SELECT COALESCE(SUM(sub_total),0) INTO v_sub
  FROM detail_pengadaan
  WHERE idpengadaan = v_idpengadaan;

  SET v_ppn = ROUND(v_sub * 0.10);
  SET v_total = v_sub + v_ppn;

  UPDATE pengadaan
  SET subtotal_nilai = v_sub, ppn = v_ppn, total_nilai = v_total
  WHERE idpengadaan = v_idpengadaan;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_before_insert_detail_pengadaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_before_insert_detail_pengadaan` BEFORE INSERT ON `detail_pengadaan` FOR EACH ROW BEGIN
  SET NEW.sub_total = COALESCE(NEW.jumlah,0) * COALESCE(NEW.harga_satuan,0);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_before_insert_detail_penjualan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_before_insert_detail_penjualan` BEFORE INSERT ON `detail_penjualan` FOR EACH ROW BEGIN
  DECLARE _last_stock INT DEFAULT 0;
  DECLARE _msg VARCHAR(255);

  SELECT ks.stock INTO _last_stock
  FROM kartu_stok ks
  WHERE ks.idbarang = NEW.idbarang
  ORDER BY ks.idkartu_stok DESC
  LIMIT 1;

  IF _last_stock IS NULL THEN
    SET _last_stock = 0;
  END IF;

  IF _last_stock < COALESCE(NEW.jumlah, 0) THEN
    SET _msg = CONCAT('Insufficient stock for penjualan: available=', _last_stock, ', requested=', COALESCE(NEW.jumlah,0));
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = _msg;
  END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_before_update_detail_pengadaan_calc
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_before_update_detail_pengadaan_calc` BEFORE UPDATE ON `detail_pengadaan` FOR EACH ROW BEGIN
  SET NEW.sub_total = COALESCE(NEW.jumlah,0) * COALESCE(NEW.harga_satuan,0);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_block_delete_detail_penerimaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_block_delete_detail_penerimaan` BEFORE DELETE ON `detail_penerimaan` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'detail_penerimaan is immutable (delete blocked)';
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_block_delete_detail_pengadaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_block_delete_detail_pengadaan` BEFORE DELETE ON `detail_pengadaan` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'detail_pengadaan is immutable (delete blocked)';
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_block_delete_penerimaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_block_delete_penerimaan` BEFORE DELETE ON `penerimaan` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Penerimaan is immutable (delete blocked)';
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_block_delete_pengadaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_block_delete_pengadaan` BEFORE DELETE ON `pengadaan` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pengadaan is immutable (delete blocked)';
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_block_update_detail_penerimaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_block_update_detail_penerimaan` BEFORE UPDATE ON `detail_penerimaan` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'detail_penerimaan is immutable (update blocked)';
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_block_update_detail_pengadaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_block_update_detail_pengadaan` BEFORE UPDATE ON `detail_pengadaan` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'detail_pengadaan is immutable (update blocked)';
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_block_update_penerimaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_block_update_penerimaan` BEFORE UPDATE ON `penerimaan` FOR EACH ROW BEGIN
  SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Penerimaan is immutable (update blocked)';
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_detail_pengadaan_subtotal
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_detail_pengadaan_subtotal` BEFORE INSERT ON `detail_pengadaan` FOR EACH ROW BEGIN
  SET NEW.sub_total = COALESCE(NEW.jumlah,0) * COALESCE(NEW.harga_satuan,0);
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_detail_penjualan_subtotal
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_detail_penjualan_subtotal` BEFORE INSERT ON `detail_penjualan` FOR EACH ROW BEGIN
    -- Ambil harga barang otomatis dari master barang (biar aman)
    DECLARE v_harga INT;
    
    SELECT harga INTO v_harga FROM Barang WHERE idbarang = NEW.idbarang;
    
    -- Set harga satuan dan subtotal otomatis
    SET NEW.harga_satuan = v_harga;
    SET NEW.subtotal = v_harga * NEW.jumlah;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_guard_pengadaan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_guard_pengadaan` BEFORE UPDATE ON `pengadaan` FOR EACH ROW BEGIN
    -- Cek apakah Data Pokok berubah?
    -- Jika Vendor berubah ATAU User berubah ATAU Tanggal berubah...
    IF (NEW.vendor_idvendor <> OLD.vendor_idvendor) OR
       (NEW.user_iduser <> OLD.user_iduser) OR
       (NEW.timestamp <> OLD.timestamp) THEN
       
       -- ...Maka TOLAK dengan pesan Error
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'SECURITY ALERT: Data Pokok Pengadaan (Vendor/User/Waktu) bersifat Immutable (Tidak Boleh Diubah)!';
    END IF;

    -- Jika yang berubah cuma angka (Subtotal/PPN/Total), Trigger diam saja (Mengizinkan).
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_guard_penjualan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_guard_penjualan` BEFORE UPDATE ON `penjualan` FOR EACH ROW BEGIN
    -- Cek apakah Data Pokok berubah? (User atau Tanggal dibuat)
    IF (NEW.iduser <> OLD.iduser) OR
       (NEW.created_at <> OLD.created_at) THEN
       
       -- Jika ada yang coba ubah data pokok -> TOLAK (Error)
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'SECURITY ALERT: Transaksi Penjualan bersifat Immutable (Data Pokok Tidak Boleh Diubah)!';
    END IF;

    -- Jika yang berubah cuma angka (Subtotal/PPN/Total) karena hitungan sistem -> BOLEH (Lanjut)
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_update_total_penjualan
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_update_total_penjualan` AFTER INSERT ON `detail_penjualan` FOR EACH ROW BEGIN
    DECLARE v_subtotal INT DEFAULT 0;
    DECLARE v_ppn INT DEFAULT 0;
    DECLARE v_total INT DEFAULT 0;

    -- 1. Hitung total belanjaan (SUM semua subtotal di detail transaksi ini)
    SELECT COALESCE(SUM(subtotal), 0) INTO v_subtotal
    FROM detail_penjualan
    WHERE penjualan_idpenjualan = NEW.penjualan_idpenjualan;

    -- 2. Hitung PPN 10% (Sesuai aturan dosen)
    SET v_ppn = ROUND(v_subtotal * 0.10);
    
    -- 3. Hitung Total Akhir
    SET v_total = v_subtotal + v_ppn;

    -- 4. Update ke Header Penjualan
    UPDATE penjualan
    SET subtotal_nilai = v_subtotal,
        ppn = v_ppn,
        total_nilai = v_total
    WHERE idpenjualan = NEW.penjualan_idpenjualan;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Dumping structure for trigger proyek_basdatpro.trg_validasi_penerimaan_cicil
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER `trg_validasi_penerimaan_cicil` BEFORE INSERT ON `detail_penerimaan` FOR EACH ROW BEGIN
    DECLARE v_idpengadaan INT;
    DECLARE v_qty_pesan INT DEFAULT 0;
    DECLARE v_qty_sudah_terima INT DEFAULT 0;
    DECLARE v_sisa INT;
    DECLARE msg VARCHAR(255);

    -- 1. Cari ID Pengadaan dari header Penerimaan
    SELECT idpengadaan INTO v_idpengadaan 
    FROM Penerimaan WHERE idpenerimaan = NEW.idpenerimaan;

    -- 2. Cari Qty yang dipesan di Pengadaan
    SELECT COALESCE(jumlah, 0) INTO v_qty_pesan
    FROM Detail_Pengadaan
    WHERE idpengadaan = v_idpengadaan AND idbarang = NEW.barang_idbarang;

    -- 3. Hitung Qty yang SUDAH diterima sebelumnya (dari penerimaan lain utk pengadaan ini)
    SELECT COALESCE(SUM(dp.jumlah_terima), 0) INTO v_qty_sudah_terima
    FROM Detail_Penerimaan dp
    JOIN Penerimaan p ON dp.idpenerimaan = p.idpenerimaan
    WHERE p.idpengadaan = v_idpengadaan 
      AND dp.barang_idbarang = NEW.barang_idbarang;

    -- 4. Validasi: Apakah (Yang Mau Diterima + Sudah Diterima) > Dipesan?
    SET v_sisa = v_qty_pesan - v_qty_sudah_terima;

    IF (NEW.jumlah_terima > v_sisa) THEN
        SET msg = CONCAT('Over-delivery! Barang: ', NEW.barang_idbarang, '. Sisa boleh diterima: ', v_sisa, '. Diinput: ', NEW.jumlah_terima);
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = msg;
    END IF;

    -- 5. Otomatis isi Harga Satuan sesuai Pengadaan (Konsistensi Data)
    --    Ini mencegah user/controller menginput harga yang beda.
    SET NEW.harga_satuan_terima = (
        SELECT harga_satuan FROM Detail_Pengadaan 
        WHERE idpengadaan = v_idpengadaan AND idbarang = NEW.barang_idbarang LIMIT 1
    );
    
    -- 6. Hitung Subtotal Terima otomatis
    SET NEW.sub_total_terima = NEW.jumlah_terima * NEW.harga_satuan_terima;

END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_barang_satuan`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_barang_satuan` AS select `b`.`idbarang` AS `idbarang`,`b`.`jenis` AS `jenis`,`b`.`nama` AS `nama`,`b`.`harga` AS `harga`,`b`.`status` AS `status`,`b`.`idsatuan` AS `idsatuan`,`s`.`nama_satuan` AS `nama_satuan` from (`barang` `b` left join `satuan` `s` on((`b`.`idsatuan` = `s`.`idsatuan`)));

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_detail_penerimaan_lengkap`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_detail_penerimaan_lengkap` AS select `dp`.`iddetail_penerimaan` AS `iddetail_penerimaan`,`dp`.`jumlah_terima` AS `jumlah_terima`,`dp`.`harga_satuan_terima` AS `harga_satuan_terima`,`dp`.`sub_total_terima` AS `sub_total_terima`,`b`.`idbarang` AS `idbarang`,`b`.`nama` AS `nama_barang`,`b`.`harga` AS `harga_barang`,`pe`.`idpenerimaan` AS `idpenerimaan`,`v`.`nama_vendor` AS `nama_vendor` from ((((`detail_penerimaan` `dp` left join `barang` `b` on((`dp`.`barang_idbarang` = `b`.`idbarang`))) left join `penerimaan` `pe` on((`dp`.`idpenerimaan` = `pe`.`idpenerimaan`))) left join `pengadaan` `p` on((`pe`.`idpengadaan` = `p`.`idpengadaan`))) left join `vendor` `v` on((`p`.`vendor_idvendor` = `v`.`idvendor`)));

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_detail_pengadaan_lengkap`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_detail_pengadaan_lengkap` AS select `dp`.`iddetail_pengadaan` AS `iddetail_pengadaan`,`dp`.`harga_satuan` AS `harga_satuan`,`dp`.`jumlah` AS `jumlah`,`dp`.`sub_total` AS `sub_total`,`b`.`idbarang` AS `idbarang`,`b`.`nama` AS `nama_barang`,`b`.`harga` AS `harga_barang`,`p`.`idpengadaan` AS `idpengadaan`,`v`.`idvendor` AS `idvendor`,`v`.`nama_vendor` AS `nama_vendor` from (((`detail_pengadaan` `dp` left join `barang` `b` on((`dp`.`idbarang` = `b`.`idbarang`))) left join `pengadaan` `p` on((`dp`.`idpengadaan` = `p`.`idpengadaan`))) left join `vendor` `v` on((`p`.`vendor_idvendor` = `v`.`idvendor`)));

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_detail_penjualan_lengkap`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_detail_penjualan_lengkap` AS select `dp`.`iddetail_penjualan` AS `iddetail_penjualan`,`dp`.`harga_satuan` AS `harga_satuan`,`dp`.`jumlah` AS `jumlah`,`dp`.`subtotal` AS `subtotal`,`b`.`idbarang` AS `idbarang`,`b`.`nama` AS `nama_barang`,`b`.`harga` AS `harga_barang`,`pj`.`idpenjualan` AS `idpenjualan`,`pj`.`total_nilai` AS `total_nilai`,`u`.`username` AS `nama_user` from (((`detail_penjualan` `dp` left join `barang` `b` on((`dp`.`idbarang` = `b`.`idbarang`))) left join `penjualan` `pj` on((`dp`.`penjualan_idpenjualan` = `pj`.`idpenjualan`))) left join `user` `u` on((`pj`.`iduser` = `u`.`iduser`)));

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_kartu_stok_barang`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_kartu_stok_barang` AS select `ks`.`idkartu_stok` AS `idkartu_stok`,`ks`.`jenis_transaksi` AS `jenis_transaksi`,`ks`.`masuk` AS `masuk`,`ks`.`keluar` AS `keluar`,`ks`.`stock` AS `stock`,`ks`.`created_at` AS `created_at`,`ks`.`idtransaksi` AS `idtransaksi`,`b`.`idbarang` AS `idbarang`,`b`.`nama` AS `nama_barang`,`b`.`jenis` AS `jenis`,`b`.`harga` AS `harga` from (`kartu_stok` `ks` left join `barang` `b` on((`ks`.`idbarang` = `b`.`idbarang`)));

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_penerimaan_pengadaan_user`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_penerimaan_pengadaan_user` AS select `pe`.`idpenerimaan` AS `idpenerimaan`,`pe`.`created_at` AS `created_at`,`pe`.`status` AS `status`,`pe`.`idpengadaan` AS `idpengadaan`,`pe`.`iduser` AS `iduser`,`p`.`timestamp` AS `tanggal_pengadaan`,`v`.`nama_vendor` AS `nama_vendor`,`u`.`username` AS `nama_user` from (((`penerimaan` `pe` left join `pengadaan` `p` on((`pe`.`idpengadaan` = `p`.`idpengadaan`))) left join `vendor` `v` on((`p`.`vendor_idvendor` = `v`.`idvendor`))) left join `user` `u` on((`pe`.`iduser` = `u`.`iduser`)));

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_pengadaan_vendor_user`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_pengadaan_vendor_user` AS select `p`.`idpengadaan` AS `idpengadaan`,`p`.`timestamp` AS `timestamp`,`p`.`status` AS `status`,`p`.`subtotal_nilai` AS `subtotal_nilai`,`p`.`ppn` AS `ppn`,`p`.`total_nilai` AS `total_nilai`,`v`.`idvendor` AS `idvendor`,`v`.`nama_vendor` AS `nama_vendor`,`v`.`badan_hukum` AS `badan_hukum`,`v`.`status` AS `status_vendor`,`u`.`iduser` AS `iduser`,`u`.`username` AS `nama_user` from ((`pengadaan` `p` left join `vendor` `v` on((`p`.`vendor_idvendor` = `v`.`idvendor`))) left join `user` `u` on((`p`.`user_iduser` = `u`.`iduser`)));

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_penjualan_margin_user`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_penjualan_margin_user` AS select `pj`.`idpenjualan` AS `idpenjualan`,`pj`.`created_at` AS `created_at`,`pj`.`subtotal_nilai` AS `subtotal_nilai`,`pj`.`ppn` AS `ppn`,`pj`.`total_nilai` AS `total_nilai`,`m`.`idmargin_penjualan` AS `idmargin_penjualan`,`m`.`persen` AS `margin_persen`,`m`.`status` AS `status_margin`,`u`.`iduser` AS `iduser`,`u`.`username` AS `nama_user` from ((`penjualan` `pj` left join `margin_penjualan` `m` on((`pj`.`idmargin_penjualan` = `m`.`idmargin_penjualan`))) left join `user` `u` on((`pj`.`iduser` = `u`.`iduser`)));

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_user_role`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_user_role` AS select `u`.`iduser` AS `iduser`,`u`.`username` AS `username`,`u`.`password` AS `password`,`u`.`idrole` AS `idrole`,`r`.`nama_role` AS `nama_role` from (`user` `u` left join `role` `r` on((`u`.`idrole` = `r`.`idrole`)));

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_vendor_status`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_vendor_status` AS select `v`.`idvendor` AS `idvendor`,`v`.`nama_vendor` AS `nama_vendor`,`v`.`badan_hukum` AS `badan_hukum`,`v`.`status` AS `status`,(case when (`v`.`status` = '1') then 'Aktif' when (`v`.`status` = '0') then 'Tidak Aktif' else 'Tidak Diketahui' end) AS `keterangan_status` from `vendor` `v`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
