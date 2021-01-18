<?PHP

namespace App\Controllers\Admin;

class Users extends \Core\Controller{
    
    protected function before(){
        //make sure an admin is logged in
        return true;
    }

    public function indexAction(){
        echo 'User admin index';
    }

}
