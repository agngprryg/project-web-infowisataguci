<?php
defined('BASEPATH') or exit('No direct script access allowed');

function tarif_labels()
{
    return array('harga_weekday' => 'Weekday', 'harga_weekend' => 'Weekend', 'harga_high_season' => 'High Season');
}

function tarif_validation_rules()
{
    $rules = array();
    foreach (tarif_labels() as $field => $label) {
        $rules[] = array('field' => $field, 'label' => 'Harga ' . $label,
            'rules' => 'required|regex_match[/^[0-9]+$/]|greater_than_equal_to[0]|less_than_equal_to[2147483647]');
    }
    return $rules;
}

function tarif_display($item)
{
    $html = array();
    foreach (tarif_labels() as $field => $label) {
        $html[] = $label . ': ' . format_rupiah($item->$field);
    }
    return implode('<br>', $html);
}

// Kalender lokal menghindari ketergantungan API ketika halaman dibuka.
function tarif_kalender_indonesia()
{
    static $kalender = NULL;
    if ($kalender === NULL) {
        $config = array();
        require dirname(__DIR__) . '/config/kalender_indonesia.php';
        $kalender = $config['tarif_libur_indonesia'];
    }
    return $kalender;
}

function tarif_hari_ini_display($item)
{
    $CI =& get_instance();
    $CI->config->load('tarif');
    $tanggal = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d');
    $tarif = tarif_for_date($item, $tanggal, $CI->config->item('tarif_high_season'));
    return format_rupiah($tarif['harga']);
}

function tarif_parse_date($value)
{
    if (!is_string($value)) {
        throw new InvalidArgumentException('Tanggal harus berupa teks.');
    }
    $date = DateTime::createFromFormat('!Y-m-d', $value, new DateTimeZone('Asia/Jakarta'));
    if (!$date || $date->format('Y-m-d') !== $value) {
        throw new InvalidArgumentException('Tanggal tidak valid.');
    }
    return $date;
}

function tarif_for_date($item, $tanggal, $periods = array())
{
    $date = tarif_parse_date($tanggal);
    $field = (int) $date->format('N') >= 6 ? 'harga_weekend' : 'harga_weekday';
    foreach ($periods as $period) {
        $start = tarif_parse_date($period['mulai']);
        $end = tarif_parse_date($period['selesai']);
        if ($end < $start) {
            throw new InvalidArgumentException('Rentang high season tidak valid.');
        }
        if ($date >= $start && $date <= $end) {
            $field = 'harga_high_season';
        }
    }
    $kalender = tarif_kalender_indonesia();
    $tahun = (int) $date->format('Y');
    if (isset($kalender[$tahun]) && in_array($tanggal, $kalender[$tahun], TRUE)) {
        $field = 'harga_high_season';
    }
    $labels = tarif_labels();
    return array('kategori' => $field, 'label' => $labels[$field], 'harga' => $item->$field);
}
