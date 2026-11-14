<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Return webp version of image path if exists, otherwise fallback to original.
 *
 * @param string $path Path relative to FCPATH (e.g. 'uploads/penginapan/' . $item->thumbnail)
 * @return string Full base_url of webp or fallback image
 */
if (!function_exists('image_webp_url')) {
    function image_webp_url($path)
    {
        if (empty($path)) {
            return base_url($path);
        }

        $clean_path = ltrim($path, '/');
        $path_info = pathinfo($clean_path);

        if (!empty($path_info['dirname']) && !empty($path_info['filename'])) {
            $webp_path = $path_info['dirname'] . '/' . $path_info['filename'] . '.webp';
            if (file_exists(FCPATH . $webp_path)) {
                return base_url($webp_path);
            }
        }

        return base_url($clean_path);
    }
}
