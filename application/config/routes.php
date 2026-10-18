<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'CPages/pelanggan';
$route['login'] = 'CAuth';
$route['register'] = 'CAuth/register';
$route['logout'] = 'CAuth/logout';

//======== PAGE PELANGGAN ========//
$route['beranda'] = 'CPages/pelanggan';
$route['penginapan'] = 'CPelanggan/penginapan_page';
$route['penginapan/detail/(:num)'] = 'CPelanggan/detail_penginapan_page/$1';
$route['wisata'] = 'CPelanggan/wisata_page';
$route['wisata/detail/(:num)'] = 'CPelanggan/detail_wisata_page/$1';
$route['transportasi'] = 'CPelanggan/transportasi_page';
$route['transportasi/detail/(:num)'] = 'CPelanggan/detail_transportasi_page/$1';
$route['pesan-tiket'] = 'CPelanggan/pesan_tiket_page';
$route['detail-tiket/(:num)'] = 'CPelanggan/detail_tiket_page/$1';
$route['pesan-tiket/submit'] = 'CPelanggan/pesan_tiket_submit';
$route['detail-pembayaran'] = 'CPelanggan/detail_pembayaran_page';
$route['sukses'] = 'CPelanggan/sukses_page';
$route['tiket-saya/(:num)'] = 'CPelanggan/tiket_saya_page/$1';
$route['detail-tiket-saya/(:num)'] = 'CPelanggan/detail_tiket_saya_page/$1';

$route['admin/dashboard'] = 'CPages/admin';

//======== DATA WISATA ========//
$route['admin/data-wisata'] = 'CDataWisata';
$route['admin/data-wisata/create'] = 'CDataWisata/create';
$route['admin/data-wisata/store'] = 'CDataWisata/store';
$route['admin/data-wisata/hapus_gambar'] = 'CDataWisata/hapus_gambar';
$route['admin/data-wisata/edit/(:num)'] = 'CDataWisata/edit/$1';
$route['admin/data-wisata/update/(:num)'] = 'CDataWisata/update/$1';
$route['admin/data-wisata/delete/(:num)'] = 'CDataWisata/delete/$1';

//======== DATA PENGINAPAN ========//
$route['admin/data-penginapan'] = 'CDataPenginapan';
$route['admin/data-penginapan/create'] = 'CDataPenginapan/create';
$route['admin/data-penginapan/store'] = 'CDataPenginapan/store';
$route['admin/data-penginapan/hapus_gambar'] = 'CDataPenginapan/hapus_gambar';
$route['admin/data-penginapan/edit/(:num)'] = 'CDataPenginapan/edit/$1';
$route['admin/data-penginapan/update/(:num)'] = 'CDataPenginapan/update/$1';
$route['admin/data-penginapan/delete/(:num)'] = 'CDataPenginapan/delete/$1';

//======== DATA Transportasi ========//
$route['admin/data-transportasi'] = 'CDataTransportasi';
$route['admin/data-transportasi/create'] = 'CDataTransportasi/create';
$route['admin/data-transportasi/store'] = 'CDataTransportasi/store';
$route['admin/data-transportasi/hapus_gambar'] = 'CDataTransportasi/hapus_gambar';
$route['admin/data-transportasi/edit/(:num)'] = 'CDataTransportasi/edit/$1';
$route['admin/data-transportasi/update/(:num)'] = 'CDataTransportasi/update/$1';
$route['admin/data-transportasi/delete/(:num)'] = 'CDataTransportasi/delete/$1';

//======== DATA KATEGORI ========//
$route['admin/data-kategori'] = 'CDataKategori';
$route['admin/data-kategori/create'] = 'CDataKategori/create';
$route['admin/data-kategori/store'] = 'CDataKategori/store';
$route['admin/data-kategori/edit/(:num)'] = 'CDataKategori/edit/$1';
$route['admin/data-kategori/update/(:num)'] = 'CDataKategori/update/$1';
$route['admin/data-kategori/delete/(:num)'] = 'CDataKategori/delete/$1';

//======== DATA FASILITAS ========//
$route['admin/data-fasilitas'] = 'CDataFasilitas';
$route['admin/data-fasilitas/create'] = 'CDataFasilitas/create';
$route['admin/data-fasilitas/store'] = 'CDataFasilitas/store';
$route['admin/data-fasilitas/edit/(:num)'] = 'CDataFasilitas/edit/$1';
$route['admin/data-fasilitas/update/(:num)'] = 'CDataFasilitas/update/$1';
$route['admin/data-fasilitas/delete/(:num)'] = 'CDataFasilitas/delete/$1';




$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
