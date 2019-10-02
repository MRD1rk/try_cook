<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.05.2017
 * Time: 17:19
 */

namespace Helpers;


class Converter
{
    public function convertPrice($price)
    {
        return number_format($price, 2, ',', ' ');
    }

    public function displayPrice($value, $prefix = '')
    {
        $decimal_place = 2;
        $decimal_point = '.';
        $thousand_point = ' ';
        return $prefix . preg_replace('/\\.(\\d*)/', '<sup>$1</sup>', number_format($value, (int)$decimal_place, $decimal_point, $thousand_point));
    }

    public function truncate($str, $max_length = 100, $suffix = '...', $strip_tags = true)
    {
        if ($strip_tags)
            $str = strip_tags($str);
        return Tools::truncate($str, $max_length, $suffix);
    }

    public function convertDate($time)
    {
        return date('d/m/Y', strtotime($time));
    }

    public function convertTime($time)
    {
        return date('G:i', strtotime($time));
    }

    public function convertPhone($phone)
    {
        return preg_replace('/\D/', '', $phone);
    }
}