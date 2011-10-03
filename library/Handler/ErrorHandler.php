<?php

/**
 * An error handler.
 *
 * Requires PHP 5.3+
 *
 * @author  DE BONA Vivien <debona.vivien@gmail.com>
 * @version 1.0
 */
class ErrorHandler extends AbstractHandler
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
        parent::__construct($thisFilePath, $geshi, $additionnalLines, $useJavascript, self::ERROR_TYPE);
    }

    /**
     * Prepares the error's variables
     *
     * @param int       $errNum     The error's number
     * @param string    $errMsg     The error's message
     * @param string    $errFile    The error's file
     * @param string    $errLine    The error's line in the file
     */
    public function catchError($errNum, $errMsg, $errFile, $errLine)
    {
        $vars = array(
            'message'   => $errMsg,
            'file'      => $errFile,
            'line'      => $errLine,
            'trace'     => null,
            'type'      => $this->_getErrorType($errNum),
        );

        return $this->_catchEmAll($vars);
    }
    
    /**
     * Returns the type of the error
     *
     * @param int $errNum Num of the error
     */
    protected function _getErrorType($errNum)
    {
        $codes = array(
            1       => 'E_ERROR',
            2       => 'E_WARNING',
            4       => 'E_PARSE',
            8       => 'E_NOTICE',
            16      => 'E_CORE_ERROR',
            32      => 'E_CORE_WARNING',
            64      => 'E_COMPILE_ERROR',
            128     => 'E_COMPILE_WARNING',
            256     => 'E_USER_ERROR',
            512     => 'E_USER_WARNING',
            1024    => 'E_USER_NOTICE',
            2048    => 'E_STRICT',
            4096    => 'E_RECOVERABLE_ERROR',
            8192    => 'E_DEPRECATED',
            16384   => 'E_USER_DEPRECATED',
            32767   => 'E_ALL',
        );

        return $codes[$errNum];
    }
}
