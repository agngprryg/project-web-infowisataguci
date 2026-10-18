<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Batas awal dan akhir termasuk high season; prioritas di atas weekend.
// Periode tambahan pengelola di luar libur nasional/cuti bersama Indonesia.
// Kalender resmi ada di kalender_indonesia.php. Contoh satu periode:
// array('mulai' => '2026-12-24', 'selesai' => '2027-01-03')
$config['tarif_high_season'] = array();
