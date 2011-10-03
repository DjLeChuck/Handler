Handler
=======

Handler is a standalone package to manage PHP exceptions and errors.

## Installation

Just download and extract the package. Configures.

## Configuration

All you have to do is to:

1.    set the relative path of your library,
2.    include the GeSHi's file (it lives in geshi's subdirectory),
3.    instantiate GeSHi,
4.    instantiate the handler with the relative path of the file and an instance of GeSHi.

Then configure the PHP handler.

```php
<?php

// Load Handler
$libraryPath = 'path/to/Handler/';
require_once $libraryPath.'loadHandler.php';
require_once $libraryPath.'geshi/geshi.php';

$geshi              = new GeSHi();
$exceptionHandler   = new ExceptionHandler($libraryPath, $geshi);
$errorHandler       = new ErrorHandler($libraryPath, $geshi);

```

GeSHi is used to colorize the code. If you don't want to use it, configure like the following instructions:

```php
<?php

// Load Handler
$libraryPath = 'path/to/Handler/';
require_once $libraryPath.'loadHandler.php';

$exceptionHandler   = new ExceptionHandler($libraryPath);
$errorHandler       = new ErrorHandler($libraryPath);

```

There are two optional arguments: the number of lines to display and the use or not of javascript.
The first is set to 5 by default and the second as true.

You can change it if you want, for example, show 8 lines and do not use javascript:

```php
<?php

// Of course, it's also possible with the error handler...
$exceptionHandler = new ExceptionHandler($libraryPath, $geshi, 8, false);

```

ExceptionHandler is call with "throw new Exception".
ErrorHandler is call with "trigger_error".

## Mechanism

When an exception or an error is caught, Handler does his job and traces the exceptions' stack (there is no stack with errors).


## License

Handler is licensed under the MIT license.
