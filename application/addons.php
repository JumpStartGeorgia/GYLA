<?php

function fuzzy_span_geo($timestamp, $local_timestamp = NULL)
{
    is_integer($timestamp) OR $timestamp = strtotime($timestamp);
    $local_timestamp = ($local_timestamp === NULL) ? time() : (int) $local_timestamp;
    if ($timestamp > $local_timestamp)
        return date('Y-m-d H:i:s', $timestamp);
    $offset = abs($local_timestamp - $timestamp);
    if ($offset <= Date::MINUTE)
    {
        $span = 'სულ ცოტახნის';
    }
    elseif ($offset < (Date::MINUTE * 20))
    {
        $span = 'რამდენიმე წუთის';
    }
    elseif ($offset < Date::HOUR)
    {
        $span = 'ერთ საათზე ნაკლები ხნის';
    }
    elseif ($offset < (Date::HOUR * 4))
    {
        $span = 'რამდენიმე საათის';
    }
    elseif ($offset < Date::DAY)
    {
        $span = 'ერთ დღეზე ნაკლები ხნის';
    }
    elseif ($offset < (Date::DAY * 2))
    {
        $span = 'ერთი დღის';
    }
    elseif ($offset < (Date::DAY * 4))
    {
        $span = 'რამდენიმე დღის';
    }
    elseif ($offset < Date::WEEK)
    {
        $span = 'ერთ კვირაზე ნაკლები ხნის';
    }
    elseif ($offset < (Date::WEEK * 2))
    {
        $span = 'ერთი კვირის';
    }
    elseif ($offset < Date::MONTH)
    {
        $span = 'ერთ თვეზე ნაკლები ხნის';
    }
    elseif ($offset < (Date::MONTH * 2))
    {
        $span = 'ერთი თვის';
    }
    elseif ($offset < (Date::MONTH * 4))
    {
        $span = 'რამოდენიმე თვის';
    }
    elseif ($offset < Date::YEAR)
    {
        $span = 'ერთ წელზე ნაკლები ხნის';
    }
    elseif ($offset < (Date::YEAR * 2))
    {
        $span = 'ერთი წლის';
    }
    elseif ($offset < (Date::YEAR * 4))
    {
        $span = 'რამდენიმე წლის';
    }
    elseif ($offset < (Date::YEAR * 8))
    {
        $span = 'წლების';
    }
    elseif ($offset < (Date::YEAR * 12))
    {
        $span = 'ერთი დეკადის';
    }
    elseif ($offset < (Date::YEAR * 24))
    {
        $span = 'რამდენიმე დეკადის';
    }
    else
    {
        $span = 'ძალიან დიდი ხნის';
    }
    return $span . ' წინ';
}

