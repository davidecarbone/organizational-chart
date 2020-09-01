<?php

return [
    'API_BASE_URL' => 'http://' . (getenv('API_BASE_URL') ?: 'localhost:8080/'),
    'DB_HOST' => getenv('DB_HOST') ?: 'localhost:3306',
    'DB_USERNAME' => getenv('DB_USERNAME') ?: 'root',
    'DB_PASSWORD' => getenv('DB_PASSWORD') ?: 'password',
    'DB_NAME' => getenv('DB_NAME') ?: 'organizational_chart',
];
