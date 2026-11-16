-- =====================================================================
-- UPDATE TABEL VOUCHER - DATA NASABAH BANK JATIM
-- Kediri Half Marathon 2027
-- =====================================================================
-- Jalankan HANYA bila tabel `master_voucher` sudah terlanjur dibuat dengan
-- skema lama (voucher_table.sql versi sebelumnya):
--   mysql -u user -p namadb < voucher_update_bankjatim.sql
--
-- Perubahan form pembuatan voucher di admin:
--   1. Nama nasabah
--   2. Nomor rekening
--   3. Kategori lomba
--   4. Bank Jatim cabang
--   5. Berlaku sampai = 30 November 2026 (dipatok, tidak bisa diubah)
--   * Input QTY dihapus -> 1x submit = 1 voucher (kuota kategori -1).
--
-- Catatan: MySQL tidak mendukung "ADD COLUMN IF NOT EXISTS". Kalau kolom
-- sudah ada, statement terkait akan error 1060 (Duplicate column name) dan
-- boleh diabaikan (lanjutkan statement berikutnya).
-- =====================================================================

ALTER TABLE `master_voucher`
  ADD COLUMN `voucher_nasabah`    VARCHAR(100) DEFAULT NULL COMMENT 'Nama nasabah Bank Jatim' AFTER `voucher_kategori`,
  ADD COLUMN `voucher_norekening` VARCHAR(50)  DEFAULT NULL COMMENT 'Nomor rekening nasabah'  AFTER `voucher_nasabah`,
  ADD COLUMN `voucher_cabang`     VARCHAR(100) DEFAULT NULL COMMENT 'Bank Jatim cabang penerbit' AFTER `voucher_norekening`;

ALTER TABLE `master_voucher`
  ADD INDEX `voucher_nasabah` (`voucher_nasabah`),
  ADD INDEX `voucher_norekening` (`voucher_norekening`);

-- Samakan masa berlaku voucher yang sudah ada dengan aturan baru
-- (akhir November 2026). Lewati baris yang sudah dipakai pelari bila
-- tidak ingin mengubah data historis.
UPDATE `master_voucher`
   SET `voucher_expired` = '2026-11-30 23:59:59'
 WHERE `voucher_used` = 'F';
