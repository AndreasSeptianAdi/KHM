-- =====================================================================
-- MIGRASI SISTEM VOUCHER - Kediri Half Marathon 2027
-- =====================================================================
-- Jalankan sekali di database aplikasi (mysql -u user -p namadb < voucher_table.sql)
--
-- Catatan:
--  * Kuota kategori (master_kategori.kategori_kuota) DIPOTONG saat admin
--    men-generate voucher (1x submit = 1 voucher), bukan saat pelari mendaftar.
--  * 1 voucher = 1 pelari (single use).
--  * Voucher yang belum terpakai dan dihapus admin -> kuota dikembalikan.
--  * Voucher diterbitkan untuk nasabah Bank Jatim, jadi data nasabah
--    (nama, nomor rekening, cabang) ikut disimpan pada tiap baris voucher.
--  * Masa berlaku voucher dipatok sampai akhir November 2026.
-- =====================================================================

CREATE TABLE IF NOT EXISTS `master_voucher` (
  `voucher_id`         INT(11)      NOT NULL AUTO_INCREMENT,
  `voucher_code`       VARCHAR(16)  NOT NULL COMMENT 'Kode alfanumerik 16 digit',
  `voucher_kategori`   INT(11)      NOT NULL COMMENT 'FK ke master_kategori.kategori_id',
  `voucher_nasabah`    VARCHAR(100) DEFAULT NULL COMMENT 'Nama nasabah Bank Jatim',
  `voucher_norekening` VARCHAR(50)  DEFAULT NULL COMMENT 'Nomor rekening nasabah',
  `voucher_cabang`     VARCHAR(100) DEFAULT NULL COMMENT 'Bank Jatim cabang penerbit',
  `voucher_batchcode`  VARCHAR(20)  DEFAULT NULL COMMENT 'ID grouping sekali generate',
  `voucher_batch`      VARCHAR(100) DEFAULT NULL COMMENT 'Label batch, mis. Bank Jatim Cabang Kediri',
  `voucher_note`       VARCHAR(255) DEFAULT NULL,
  `voucher_expired`    DATETIME     DEFAULT NULL COMMENT 'NULL = tidak ada batas waktu',
  `voucher_status`     TINYINT(1)   NOT NULL DEFAULT 1 COMMENT '1 aktif, 0 nonaktif',
  `voucher_used`       ENUM('T','F') NOT NULL DEFAULT 'F',
  `voucher_pelari`     INT(11)      DEFAULT NULL COMMENT 'FK master_pelari.pelari_id',
  `voucher_user`       INT(11)      DEFAULT NULL COMMENT 'FK master_user.user_id',
  `voucher_useddate`   DATETIME     DEFAULT NULL,
  `voucher_created`    DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`voucher_id`),
  UNIQUE KEY `voucher_code` (`voucher_code`),
  KEY `voucher_kategori` (`voucher_kategori`),
  KEY `voucher_batchcode` (`voucher_batchcode`),
  KEY `voucher_used` (`voucher_used`),
  KEY `voucher_nasabah` (`voucher_nasabah`),
  KEY `voucher_norekening` (`voucher_norekening`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
