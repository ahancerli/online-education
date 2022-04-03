<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 16.08.2020
 * Time: 01:01
 */

namespace App\Helpers;

class SystemParameter
{
    public const OFFLINE_COURSE = 100;
    public const LIVE_COURSE = 101;
    public const FORMAL_EDUCATION = 102;
    public const DOCUMENT_COURSE = 103;

    public const COURSE_TYPES = [
        self::OFFLINE_COURSE => 'Çevrimdışı Ders',
        self::LIVE_COURSE => 'Canlı Ders',
        self::FORMAL_EDUCATION => 'Yüzyüze Eğitim',
        self::DOCUMENT_COURSE => 'Döküman'
    ];
}