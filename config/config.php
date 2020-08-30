<?php

return [
    'API_BASE_URL' => 'http://' . (getenv('API_BASE_URL') ?: 'localhost:8080/'),
    'DB_HOST' => getenv('DB_HOST'),
    'DB_USERNAME' => getenv('DB_USERNAME'),
    'DB_PASSWORD' => getenv('DB_PASSWORD'),
    'DB_NAME' => getenv('DB_NAME'),
];
