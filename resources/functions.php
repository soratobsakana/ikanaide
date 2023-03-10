<?php

// Cambia los datos de fecha de SQL en un formato escrito: 1000-10-10 -> oct 10, 1000.
function dateFormat ($date) {
    // Este substr consigue 2 caracteres de un string tipo fecha (XXXX-XX-XX) a partir de la posicion 5. Es decir, devuelve los dos dígitos del mes.
    $numericMonth = substr($date, 5, 2);

    switch ($numericMonth) {
        case '01':
            $month = 'Jan';
            break;
        case '02':
            $month = 'Feb';
            break;
        case '03':
            $month = 'Mar';
            break;
        case '04':
            $month = 'Apr';
            break;
        case '05':
            $month = 'May';
            break;
        case '06':
            $month = 'Jun';
            break;
        case '07':
            $month = 'Jul';
            break;
        case '08':
            $month = 'Aug';
            break;
        case '09':
            $month = 'Sep';
            break;
        case '10':
            $month = 'Oct';
            break;
        case '11':
            $month = 'Nov';
            break;
        case '12':
            $month = 'Dec';
            break;
    }

    $year = substr($date, 0, 4);
    $day = substr($date, 8);

    return $month . ' ' . $day . ', ' . $year;
}

// Preformatea el resultado de var_dump y termina el script de después para leer los resultados con mayor claridad.
function pre($v) {
    print '<pre>';
        var_dump($v);
    print '</pre>';
    die();
}

// Intercambia las barrabajas por espacios en el nombre de las columnas de una tabla. (e.g. start_date -> start date).
// $array contiene las keys con barrabaja y en $newArray se guardan las de sin barrabaja.
function replaceUnderscore(array $array,  $newArray) {
    foreach ($array as $key => $value) {
        if (strpos($key, '_') > 0) {
            $key = str_replace('_', ' ', $key);
        }
        $newArray[$key] = $value;
    }
}