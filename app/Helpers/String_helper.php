<?php

function slugify($string)
{
    $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç'];
    $english = ['i', 'g', 'u', 's', 'o', 'c'];

    $slug = str_replace('İ', 'i', $string);
    $slug = mb_strtolower(trim(preg_replace('/[[:^alnum:]]/iu', '-', $slug), '-'));
    $slug = str_replace($turkish, $english, $slug);

    return $slug;
}

function truncate($source, $size)
{
    return strlen($source) > $size ? substr($source, 0, $size - 1) . '...' : $source;
}