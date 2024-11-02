<?php

function method(): string
{
    return strtolower($_SERVER['REQUEST_METHOD']);
}

function requestUrl()
{
    $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
    return '/' . $url;
}

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data)
{
    return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
}

function isCPF($value)
{
    $regex = "/^([0-9]{3}).([0-9]{3}).([0-9]{3})-([0-9]{2})$/";

    return preg_match($regex, $value);
}

function isEmail($value)
{
    return filter_var($value, FILTER_VALIDATE_EMAIL);
}

function isDateFormat($value)
{
    $regex = "/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/";
    return preg_match($regex, $value);
}

function multiObj($obj)
{
    $arr = [];
    foreach ($obj as $u) {
        $arr[] = $u->getData();
    }

    return $arr;
}