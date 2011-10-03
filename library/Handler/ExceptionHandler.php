<?php

/**
 * An exception handler.
 *
 * Requires PHP 5.3+
 *
 * @author  DE BONA Vivien <debona.vivien@gmail.com>
 * @version 1.0
 */
class ExceptionHandler extends AbstractHandler
{
    /**
     * Constructor
     *
     * @param string    $thisFilePath       Relative path of this file
     * @param Object    $geshi              The instance of GeSHi
     * @param int       $additionnalLines   Number of lines to show
     * @param Boolean   $useJavascript      Use or not javascript
     */
    public function __construct($thisFilePath, GeSHi $geshi = null, $additionnalLines = 5, $useJavascript = true)
    {
        parent::__construct($thisFilePath, $geshi, $additionnalLines, $useJavascript, self::EXCEPTION_TYPE);
    }
    
    /**
     * Prepares the exception's variables
     *
     * @param Exception $e The caughted exception
     */
    public function catchException($e)
    {
        $vars = array(
            'message'   => $e->getMessage(),
            'file'      => $e->getFile(),
            'line'      => $e->getLine(),
            'trace'     => $e->getTrace(),
            'type'      => get_class($e),
        );

        return $this->_catchEmAll($vars);
    }
}
