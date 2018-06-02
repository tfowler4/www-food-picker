<?php

/**
 * add a log entry
 *
 * @param  int    $severity [ level of severity integer ]
 * @param  string $message  [ log message ]
 * @param  string $user     [ client type ]
 *
 * @return void
 */
function logger($severity, $message, $user = 'user') {
    $logger = new Logger();
    $logger->log($severity, $message, $user = 'user');
}

function redirect($address) {
    header('Location: ' . $address);
    die();
}

function convertRankToMedal($rank) {
    switch ( $rank ) {
        case '1':
            $rank = '<i class="fa fa-trophy fa-fw fa-lg" style="color:#FFD700"></i>';
            break;
        case '2':
            $rank = '<i class="fa fa-trophy fa-fw fa-lg" style="color:#C0C0C0"></i>';
            break;
        case '3':
            $rank = '<i class="fa fa-trophy fa-fw fa-lg" style="color:#CD7F32"></i>';
            break;
        default:
            break;
    }

    return $rank;
}

function convertToOrdinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');

    if ( (($number % 100) >= 11) && (($number%100) <= 13) ) {
        return $number. 'th';
    } else{
        return $number. $ends[$number % 10];
    }
}