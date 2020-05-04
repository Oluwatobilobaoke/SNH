<?php


function genTxref()
{
    $txref = "txref_";
    for ($i = 0; $i < 7; $i++) {
        $txref .= mt_rand(0, 6);
    }
    return $txref;
}
