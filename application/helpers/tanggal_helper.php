<?php
function tanggal_indo($tanggal)
{
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];
    $pecahkan = explode('-', date('Y-m-d', strtotime($tanggal)));

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}


function nama_bulan($angka)
{
    $bulan = [
        1  => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4  => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7  => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
    return $bulan[(int)$angka] ?? '';
}

function format_tanggal_wib($timestamp)
{
    // Daftar nama bulan dalam Bahasa Indonesia
    $bulan = [
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    // Ubah ke timestamp jika input berupa string waktu
    $time = is_numeric($timestamp) ? $timestamp : strtotime($timestamp);

    $tgl = date('j', $time);
    $bln = $bulan[(int)date('n', $time)];
    $thn = date('Y', $time);
    $jam = date('H:i', $time);

    return "{$tgl} {$bln} {$thn} {$jam} WIB";
}
