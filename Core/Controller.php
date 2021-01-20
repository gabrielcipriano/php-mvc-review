<?PHP

namespace Core;

/**
 * Base controller
 * 
 * PHP version 7.4
 */

 abstract class Controller
 {
     /**
      * Params from the matched route
      * @var array
      */
     protected $route_params = [];

    /**
     * @param array $route_params Parameters from the route
     * @return void
     */
    public function __construct($route_params){
        $this->route_params = $route_params;
    }    

        /**
     * Handling calls of unavailable methods
     */
    public function __call($name, $args){
        $method = $name . 'Action';
        if(method_exists($this, $method) ){
            if ($this->before()) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else{
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * @return boolean
     */
    protected function before(){
        //executes before a call
        echo '(before)';
        return true;
    }
    protected function after(){
        echo '(after)';
    }

 }
 