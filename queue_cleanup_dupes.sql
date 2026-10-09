-- Bersihkan token antrean ganda / basi di produksi.
-- Jalankan sekali setelah deploy fix token ganda.
-- Menyisakan 1 token terbaru per IP (24 jam terakhir).

DELETE t1 FROM `queue_tokens` t1
JOIN (
  SELECT ip, MAX(id) AS keep_id
  FROM `queue_tokens`
  WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)
  GROUP BY ip
  HAVING COUNT(*) > 1
) t2 ON t1.ip = t2.ip AND t1.id <> t2.keep_id
WHERE t1.created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY);

-- Hapus token kedaluwarsa
DELETE FROM `queue_tokens` WHERE expires_at < NOW();
