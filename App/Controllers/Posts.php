<?php
/** Posts controller
 * 
 * PHP version 7.4.12
 */
namespace App\Controllers;

use \Core\View;
use \App\Models\Post;

class Posts extends \Core\Controller
{
    /** Show the index page
     * 
     * @return void
     */
    public function indexAction()
    {
        $posts = Post::getAll();

        View::renderTemplate('Posts/index.html', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the add new page
     * @return void
     */
    public function addNewAction()
    {
        echo "It's the add-new page in the Posts controller";
    }

    public function editAction()
    {
        echo 'edit page';
        echo '<p>Route parameters: <pre>'
            . htmlspecialchars(print_r($this->route_params, true))
            . '</pre></p>';
        echo '<p> query string parameters: <pre>' 
            . htmlspecialchars(print_r($_GET, true)) 
            . '</pre><p>';
    }
}
