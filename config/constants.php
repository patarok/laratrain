<?php

if(env('APP_DEBUG') == true)
{
    define('CCC_TIME', 2);
}
else
{
    define('CCC_TIME', 86400);
}
