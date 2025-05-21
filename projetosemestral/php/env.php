<?php
$env = parse_ini_file(__DIR__ . '/../.env',false, 
                       INI_SCANNER_TYPED);

if ($env === false) {
    throw new RuntimeException('.env file not found or invalid');
}
return $env;