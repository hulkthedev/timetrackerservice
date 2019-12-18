<?php

if (getenv('ENV') === 'prod') {
    http_response_code(404);
    die();
}

phpinfo();
