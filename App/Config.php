<?php

namespace App;
/**
 * Application configuration
 * 
 * PHP version 7
 */
class Config{
    /**
     * DB host
     * @var string
     */
    const DB_HOST = 'localhost';
    /**
     * DB name
     * @var string
     */
    const DB_NAME = 'mvcreview';

    /**
     * DB user
     * @var string
     */
    const DB_USER = "root";

    /**
     * DB password
     * @var string
     */
    const DB_PASSWORD = "root";
    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = false;
}