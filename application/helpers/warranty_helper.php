<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function generate_timezone_list() {
    static $regions = array(
        DateTimeZone::AFRICA,
        DateTimeZone::AMERICA,
        DateTimeZone::ANTARCTICA,
        DateTimeZone::ASIA,
        DateTimeZone::ATLANTIC,
        DateTimeZone::AUSTRALIA,
        DateTimeZone::EUROPE,
        DateTimeZone::INDIAN,
        DateTimeZone::PACIFIC,
    );

    $timezones = array();
    foreach ($regions as $region) {
        $timezones = array_merge($timezones, DateTimeZone::listIdentifiers($region));
    }

    $timezone_offsets = array();
    foreach ($timezones as $timezone) {
        $tz = new DateTimeZone($timezone);
        $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
    }

    // sort timezone by offset
    asort($timezone_offsets);

    $timezone_list = array();
    foreach ($timezone_offsets as $timezone => $offset) {
        $offset_prefix = $offset < 0 ? '-' : '+';
        $offset_formatted = gmdate('H:i', abs($offset));

        $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

        $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
    }

    return $timezone_list;
}

function generate_strong_password() {
    $chr = array_merge(
            range('A', 'N'), range('P', 'Z'), range('a', 'n'), range('p', 'z'), range(2, 9), str_split('@~#[]{}+&*%()$\/<>')
    );
    //  try this one https://www.dougv.com/2010/03/a-strong-password-generator-written-in-php/
    $password = $chr[mt_rand(0, 24)] . $chr[mt_rand(25, 49)]
            . $chr[mt_rand(50, 57)] . $chr[mt_rand(58, 76)];

    for ($i = rand(4, 8); $i >= 0; $i--) {
        $password .= $chr[mt_rand(0, count($chr) - 1)];
    }

    return str_shuffle($password);
}
