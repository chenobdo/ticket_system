<?php

function load_asset($asset_url)
{
    return (env('APP_ENV') === 'production') ? secure_asset($asset_url) : asset($asset_url);
}

function site_name()
{
    $settings = \App\Settings::first();

    $site_name = $settings->site_name;

    return $site_name;
}

function site_url()
{
    $settings = \App\Settings::first();

    $site_url = $settings->site_url;

    return $site_url;
}

function email_from()
{
    $settings = \App\Settings::first();

    $email_from = $settings->email_from;

    return $email_from;
}

function email_to()
{
    $settings = \App\Settings::first();

    $email_to = $settings->email_to;

    return $email_to;
}

function getAccountDay($t, $day)
{
    // 获取下个月
    $month = getNextMonth($t);
    // 获取年份
    $year = $month == '01' ? getNextYear($t) : date('Y', $t);
    // 判断月最后一天
    $ymd = strtotime($year.$month.'01');
    $lastDay = getLastDay($ymd);
    $day = min($day, $lastDay);

    return date('Y/m/d', mktime(0, 0, 0, $month, $day, $year));
}

function getNextMonth($t)
{
    $m = date('m', $t);
    $month = $m == '12' ? 1 : intval($m) + 1;
    return str_pad($month, 2, '0', STR_PAD_LEFT);
}

function getNextYear($t)
{
    return date('Y', strtotime('+1 year', $t));
}

function getLastDay($t)
{
    return date('d', strtotime('+1 month', $t) - 1);
}