<?php

namespace Core;

use Exception;

/**
 * Error and exception handler
 *
 * PHP version 5.4
 */
class Error
{

    /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level  Error level
     * @param string $message  Error message
     * @param string $file  Filename the error was raised in
     * @param int $line  Line number in the file
     *
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {  // to keep the @ operator working
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Displays an exception
     * 
     * @return void
     */
    private static function displayException(Exception $exception){
        echo "<h1>Fatal error</h1>";
        echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
        echo "<p>Message: '" . $exception->getMessage() . "'</p>";
        echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
        echo "<p>Thrown in '" . $exception->getFile() . "' on line " . 
             $exception->getLine() . "</p>";
    }

    /**
     * Save an error in the Log
     * 
     * @return void
     */
    private static function saveErrorInLogfile(Exception $exception, int $exceptionCode){
        $log = dirname(__DIR__) . '/logs/' . date('Y-m-d') . '.txt';
        ini_set('error_log', $log);

        $message = "Uncaught exception: '" . get_class($exception) . "'";
        $message .= " with message '" . $exception->getMessage() . "'";
        $message .= "\nStack trace: " . $exception->getTraceAsString();
        $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

        error_log($message);

        View::renderTemplate("Errors/$exceptionCode.html");
    }

    /**
     * Exception handler.
     *
     * @param Exception $exception  The exception
     *
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        $exceptionCode = $exception->getCode();
        if ($exceptionCode != 404) {
            $exceptionCode = 500; //general error code
        }
        http_response_code($exceptionCode);

        if(\App\Config::SHOW_ERRORS){
            self::displayException($exception);
        } else{
            self::saveErrorInLogfile($exception, $exceptionCode);
        }
        
    }
}
