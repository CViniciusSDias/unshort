<?php

declare(strict_types=1);

if ($argc < 2) {
    $executable = str_ends_with($argv[0], '.php') ? "php $argv[0]" : $argv[0];
    echo "Usage: $executable <url>\n";
    exit(1);
}

$url = $argv[1];

if (filter_var($url, FILTER_VALIDATE_URL) === false) {
    echo "Invalid URL: $url\n";
    exit(1);
}

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_HEADER, true);
curl_setopt($curl, CURLOPT_NOBODY, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = curl_exec($curl);
preg_match_all('/[Ll]ocation: (.+?)\r\n/', $headers, $matches);

$redirects = $matches[1];
echo "\033[1mRedirects\033[0m\n";
foreach ($redirects as $redirect) {
    echo "* $redirect\n";
}

