<?php

function d($uData, $uLabel = '')
{
    dPrint(dTrace(), $uData, $uLabel);
}

function dd($uData, $uLabel = '')
{
    e(dPrint(dTrace(), $uData, $uLabel));
}

function dPrint($dTrace, $uData, $uLabel = '')
{
    $uPrint = '<div style="background:#fafafa; margin:5px; padding: 5px; border: solid grey 1px;">';
    
    if ( ! empty($uLabel))
    {
        $uPrint .= '<strong>' . $uLabel . '</strong> <br>';
    }

    $uPrint .= $dTrace;
    $uPrint .= '<pre style="margin: 0px; padding: 0px; padding-top: 7px; font-size: 14px;">';
    $uPrint .= print_r($uData, true);
    $uPrint .= '</pre>';
    $uPrint .= '</div>';

    echo $uPrint;
}

function dTrace()
{
    $uBt = debug_backtrace();
    
    $uTrace    = $uBt[1];
    $uLine     = $uTrace['line'];
    $uFile     = $uTrace['file'];
    $uFunction = $uTrace['function'];
    $uClass    = (isset($uBt[2]['class'])) ? $uBt[2]['class'] : $uFile;
    $uType     = (isset($uBt[2]['class'])) ? $uBt[2]['type'] : ' ';
    $uFunction = (isset($uBt[2]['function'])) ? $uBt[2]['function'] : '';

    return sprintf(
        '%s%s%s() строка %s <small>(в %s)</small>',
        $uClass, $uType, $uFunction, $uLine, $uFile
    );
}

function view($uFile, array $uData = [], $uEXT = null)
{
    return (new Core\View($uFile, $uData, $uEXT))->render();
}

function redirect($uURL)
{
    header('Location: ' . $uURL);
    
    e();
}

function e($uData = null)
{
    exit($uData);
}
