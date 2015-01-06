<?php

// Custom error handling for hhvm
function error_handler ($errorNumber, $message, $errfile, $errline) {
  switch ($errorNumber) {
    case E_ERROR :
    $errorLevel = 'Error';
    break;

    case E_WARNING :
    $errorLevel = 'Warning';
    break;

    case E_NOTICE :
    $errorLevel = 'Notice';
    break;

    default :
    $errorLevel = 'Undefined';
  }

  echo '<br/><b>' . $errorLevel . '</b>: ' . $message . ' in <b>'.$errfile . '</b> on line <b>' . $errline . '</b><br/>';
}
