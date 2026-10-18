<?php
function generate_breadcrumb()
{
    $ci = &get_instance();
    $segments = $ci->uri->segment_array();

    // Skip breadcrumb if we're on the homepage
    if (empty($segments) || (count($segments) === 1 && $segments[1] === 'admin')) {
        return '';
    }

    $breadcrumb = '<nav class="flex" aria-label="Breadcrumb">';
    $breadcrumb .= '<ol class="inline-flex items-center space-x-1 md:space-x-2">';

    // Always start with Home
    $breadcrumb .= '<li class="inline-flex items-center">';
    $breadcrumb .= '<p class="inline-flex items-center text-sm font-medium text-gray-500">';
    $breadcrumb .= '<svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">';
    $breadcrumb .= '<path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>';
    $breadcrumb .= '</svg>';
    $breadcrumb .= 'Home</p>';
    $breadcrumb .= '</li>';

    $path = '';
    foreach ($segments as $index => $segment) {
        // Skip the first segment if it's 'admin' since we already have Home
        if ($index === 1 && $segment === 'admin') {
            continue;
        }

        $path .= $segment . '/';
        $is_last = $index === array_key_last($segments);

        // Get label and icon from mapping or default
        $item = $label_map[$segment] ?? [
            'label' => ucwords(str_replace('-', ' ', $segment)),
            'icon' => null
        ];


        $breadcrumb .= '<li>';
        $breadcrumb .= '<div class="flex items-center">';
        $breadcrumb .= '<svg class="w-5 h-5 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">';
        $breadcrumb .= '<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>';
        $breadcrumb .= '</svg>';

        if ($is_last) {
            $breadcrumb .= '<span class="ml-1 text-sm font-medium text-gray-700 md:ml-2">';
            if ($item['icon']) {
                $breadcrumb .= '<svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">';
                $breadcrumb .= get_icon_path($item['icon']);
                $breadcrumb .= '</svg>';
            }
            $breadcrumb .= $item['label'] . '</span>';
        } else {
            $breadcrumb .= '<p class="ml-1 text-sm font-medium text-gray-500 md:ml-2">';
            if ($item['icon']) {
                $breadcrumb .= '<svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">';
                $breadcrumb .= get_icon_path($item['icon']);
                $breadcrumb .= '</svg>';
            }
            $breadcrumb .= $item['label'] . '</p>';
        }

        $breadcrumb .= '</div>';
        $breadcrumb .= '</li>';
    }

    $breadcrumb .= '</ol>';
    $breadcrumb .= '</nav>';

    return $breadcrumb;
}

// Helper function for icons
function get_icon_path($icon)
{
    $icons = [
        'home' => '<path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>',
        'package' => '<path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path><path d="M8 2.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path><path d="M12.5 5a.5.5 0 00-.5.5v1a.5.5 0 00.5.5h1a.5.5 0 00.5-.5v-1a.5.5 0 00-.5-.5h-1z"></path><path d="M5 3.5a.5.5 0 01.5-.5h9a.5.5 0 010 1h-9a.5.5 0 01-.5-.5z"></path><path fill-rule="evenodd" d="M2.5 6a.5.5 0 00-.5.5v9a.5.5 0 00.5.5h11a.5.5 0 00.5-.5v-9a.5.5 0 00-.5-.5h-11zm1 1h9v8h-9V7z" clip-rule="evenodd"></path>',
        'users' => '<path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>',
        'settings' => '<path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>',
        'file-text' => '<path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>'
    ];

    return $icons[$icon] ?? '';
}
