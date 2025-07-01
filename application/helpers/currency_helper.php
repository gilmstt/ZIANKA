<?php

function to_currency($number)
{
    return '$' . number_format((float)$number, 2, '.', ',');
}

function to_currency_no_money($number) {
    return number_format($number, 2, '.', '');
}

?>