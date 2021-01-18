<?php
namespace Core;

/**
 * View
 * 
 * PHP version 7.4
 */
class View
{
    /**
     * Render a view file
     * 
     * @param string $view The view file
     * 
     * @return void
     */
    public static function render($view, $args = []){
        extract($args, EXTR_SKIP);
        $file = "../App/Views/$view"; //Relative to Core directory

        if (is_readable($file)){
            require $file;
        }else{
            echo "$file not found";
        }
    }

    /**
     * Render a Twig view template
     * 
     * @param string $template file
     * @param array $args
     * 
     * @return void
     */

     public static function renderTemplate($template, $args = []){
         static $twig = null;

         if ($twig === null) {
             $loader = new \Twig\Loader\FilesystemLoader('../App/Views');
             $twig = new \Twig\Environment($loader);
         }
         echo $twig->render($template, $args);
     }

}
