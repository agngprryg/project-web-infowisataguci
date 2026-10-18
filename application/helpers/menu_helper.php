<?php

function is_active($segment, $value)
{
    return $segment == $value
        ? 'bg-[#002247] text-white fill-white rounded-lg px-3 py-1.5 text-[#3a3aee] font-semibold'
        : 'hover:text-[#4a4a6a] transition-colors';
}

function trim_words($text, $word_limit = 2)
{
    $text = strip_tags($text); // Remove HTML tags
    $words = explode(' ', $text);
    $trimmed = array_slice($words, 0, $word_limit);
    return implode(' ', $trimmed) . '...';
}
