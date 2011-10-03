<?php

// Load ExceptionHandler
$libraryPath = './library/Handler/';
require_once $libraryPath.'loadLibrary.php';
require_once $libraryPath.'geshi/geshi.php';

$geshi              = new GeSHi();
$exceptionHandler   = new ExceptionHandler($libraryPath, $geshi);
$errorHandler       = new ErrorHandler($libraryPath, $geshi);

// Error
trigger_error('Sorry, this function is deprecated!', 16384);

// or Exception

$arg = 'MyArgument';
throw new InvalidArgumentException(sprintf('Oops, an error occurred! The argument "%s" is invalid!', $arg));
