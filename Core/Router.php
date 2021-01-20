<?php

namespace Core;

class Router
{
    protected $routes = [];
    protected $params = [];

    public function add($route, $params = []){
        // $this->routes[$route] = $params;
        // converting the route to a regexp - escaping forward slashes
        $route = preg_replace('/\//', '\\/', $route);
        
        // convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // convert variables with custom regex e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;

    }

    public function addByStrings($route, $controller, $action){
        $this->add($route, ['controller' => $controller, 'action' => $action]);
    }

    public function getRoutes(){
        return $this->routes;
    }

    protected function populateParamsList($matches,$params){
        foreach ($matches as $key => $match) {
            if(is_string($key)){
                $params[$key] = $match;
            }
        }
        return $params;
    }

    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                $this->params = $this->populateParamsList($matches, $params);
                return true;
            }
        }

        return false;
    }


    public function getParams(){
        return $this->params;
    }

    /**
     * hello-word -> HelloWord     
     * @param string
     * @return string
     */
    protected function toStudlyCaps($str){
        $str = ucwords($str, '-');
        $str = str_replace('-', '', $str);
        return $str;
    }

    /**
     * hello-word -> helloWord
     * @param string
     * @return string
     */
    protected function toCamelCase($str){
        $str = $this->toStudlyCaps($str);
        return lcfirst($str);
    }

    protected function thereIsNoActionSufix($action){
        if(preg_match('/action$/i', $action)){
            throw new \Exception(
                "Method $action in controller cannot 
                be called directly - remove the 
                Action suffix to call this method");
            return false;
        } else {
            return true;
        }
    }

    public function dispatch($url){
        $url = $this->removeQueryStringVariable($url);

        if($this->match($url)){
            $controller = $this->params['controller'];
            $controller = $this->toStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_obj = new $controller($this->params);
                $action = $this->params['action'];
                $action = $this->toCamelCase($action);

                if ($this->thereIsNoActionSufix($action)){
                    $controller_obj->$action();
                }else{
                    throw new \Exception("Method $action in controller $controller not found");
                }
            } else {
                throw new \Exception("Controller $controller not found");
                echo "Controller class $controller not found";
            }
        } else {
            throw new \Exception("No route matched.", 404);
        }
    }


    /**
     * @param string  url
     * @return string url without query string
     */
    protected function removeQueryStringVariable($url){
        if ($url != '') {
            $parts = explode('&', $url, 2);
            $url = (strpos($parts[0], '=')) ? '' : $parts[0];
        }
        return $url;
    }

    /**
     * Get the namespace for the controller class 
     * from the route parameters if present.
     * 
     *  @return string The request URL
     */
    protected function getNamespace(){
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)){
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }


};
