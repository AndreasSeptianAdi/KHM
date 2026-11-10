<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class QueueFairHook {
    public function check_queue() {
        // 1. Definisikan path absolut ke folder QueueFairAdapter baru Anda
        $adapter_file = APPPATH . 'third_party/QueueFairAdapter/QueueFairAdapter.php';
        $config_file  = APPPATH . 'third_party/QueueFairAdapter/QueueFairConfig.php';

        // Validasi keberadaan file agar tidak memicu fatal error jika salah ketik folder
        if (!file_exists($adapter_file) || !file_exists($config_file)) {
            log_message('error', 'File QueueFairAdapter atau QueueFairConfig tidak ditemukan di folder third_party/QueueFairAdapter.');
            return;
        }

        // 2. Muat kedua file esensial Queue-Fair
        require_once $config_file;
        require_once $adapter_file;

        // 3. Inisialisasi Class Utama
        // Karena diletakkan di dalam hook, kita bungkus dalam try-catch untuk menjaga stabilitas web
        try {
            if (class_exists('QueueFairAdapter')) {
                // Di dalam QueueFairConfig.php bawaan SDK, Anda harusnya sudah mengisi account & secret key.
                // Jika belum diisi di file config, Anda bisa mengisinya manual di sini:
                $account = QueueFairConfig::$account; 
                $secret  = QueueFairConfig::$accountSecret;

                // Inisialisasi adapter
                $adapter = new QueueFairAdapter($account, $secret);

                // Jalankan validasi antrean virtual
                if (!$adapter->isPassed()) {
                    exit(); // Otomatis me-redirect user jika antrean sedang penuh
                }
            } else {
                log_message('error', 'Class QueueFairAdapter tetap tidak ditemukan meski file sudah di-require.');
            }
        } catch (Exception $e) {
            log_message('error', 'Queue-Fair Error: ' . $e->getMessage());
        }
    }
}

