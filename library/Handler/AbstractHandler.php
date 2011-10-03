<?php

/**
 * An exception/error handler.
 *
 * Requires PHP 5.3+
 *
 * @author  DE BONA Vivien <debona.vivien@gmail.com>
 * @version 1.0
 */
abstract class AbstractHandler
{
    /** Style for the highlighted line */
    const HIGHLIGHT_STYLE = 'background-color: #FCFFBF;';

    /** Name for exceptions */
    const EXCEPTION_TYPE = 'exception';

    /** Name for errors */
    const ERROR_TYPE = 'error';

    protected   $thisFilePath,
                $geshi,
                $additionnalLines,
                $useJavascript,
                $handlerType;

    /**
     * Constructor
     *
     * @param string    $thisFilePath       Relative path of this file
     * @param Object    $geshi              The instance of GeSHi
     * @param int       $additionnalLines   Number of lines to show
     * @param Boolean   $useJavascript      Use or not javascript
     * @param string    $handlerType        The type of handler
     */
    public function __construct($thisFilePath, GeSHi $geshi, $additionnalLines, $useJavascript, $handlerType)
    {
        $this->thisFilePath     = $thisFilePath;
        $this->geshi            = $geshi;
        $this->additionnalLines = $additionnalLines;
        $this->useJavascript    = $useJavascript;
        $this->handlerType      = $handlerType;

        // Set the right handler
        $handlerFunctionName    = 'set_'.$this->handlerType.'_handler';
        $catchFunctionName      = 'catch'.ucwords($this->handlerType);
        $handlerFunctionName(array(&$this, $catchFunctionName));
    }

    /**
     * Handles exception/error and display them in a beautiful way
     *
     * @param array $vars Array of necessary variables
     */
    protected function _catchEmAll($vars) {
        ob_start();

        extract($vars);

        $thisFilePath   = $this->thisFilePath;
        $useJavascript  = $this->useJavascript;
        $compteur       = 1;
        $code           = self::_trace($line, $file);
        $handlerType    = ucwords($this->handlerType);

        include 'templates/top.html';

        // Trace the main Exception
        include 'templates/middle.html';
        // ... then loop each trace if possible
        if (!empty($trace)) {
            foreach ($trace as $e) {
                $e          = (object) $e;
                $message    = '';
                $file       = $e->file;
                $line       = $e->line;
                $code       = $this->_trace($line, $file);
                $compteur++;
                include 'templates/middle.html';
            }
        }

        include 'templates/bottom.html';

        ob_end_flush();

        exit;
    }

    /**
     * Restores the previous handler
     */
    public function restore()
    {
        $handlerFunctionName = 'restore_'.$this->handlerType.'_handler';
        $handlerFunctionName();
    }

    /**
     * Traces the exception/error
     *
     * @param   int     $line   The line concerned
     * @param   string  $file   The file concerned
     *
     * @return  string  The colored code
     */
    protected function _trace($line, $file)
    {
        try {
            $fileContents   = @file($file);
            $linesToShow    = array();
            $source         = '';

            // Get 5 lines before and after the flawed line
            for ($x = ($line - $this->additionnalLines - 1); $x < ($line + $this->additionnalLines); $x++) {
                if (!empty($fileContents[$x]))
                    $source .= $fileContents[$x];
            }

            return $this->_configureAndLaunchGeshi($line, $source);
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * Configures and launches GeSHi
     *
     * @param   int     $line   The line concerned
     * @param   string  $file   The file concerned
     *
     * @return  string  The colored code
     */
    protected function _configureAndLaunchGeshi($line, $source)
    {
        if (!empty($this->geshi)) {
            $this->geshi->set_language('php');
            $this->geshi->set_source($source);

            $this->geshi->set_header_type(GESHI_HEADER_NONE);
            $this->geshi->highlight_lines_extra(array($this->additionnalLines + 1));
            $this->geshi->set_highlight_lines_extra_style(self::HIGHLIGHT_STYLE);
            $this->geshi->set_language_path(dirname(__FILE__) . DIRECTORY_SEPARATOR.'geshi'.DIRECTORY_SEPARATOR);

            $this->geshi->start_line_numbers_at($line - $this->additionnalLines);
            $this->geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);

            return $this->geshi->parse_code();
        } else {
            return '<pre>'.$source.'</pre>';
        }
    }
}
