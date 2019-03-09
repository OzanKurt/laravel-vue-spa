<?php

if (!function_exists('_dd')) {
    function _dd()
    {
        http_response_code(500);
        dd(...func_get_args());
    }
}
