<?php

/**
 * Class Application
 * The heart of the app
 */
class Application
{
    /**
     * @var null The controller
     */
    private $url_controller = null;
    /**
     * @var null The method (of the above controller)
     */
    private $url_action = null;
    /**
     * @var null Parameter one
     */
    private $url_parameter_1 = null;
    /**
     * @var null Parameter two
     */
    private $url_parameter_2 = null;
    /**
     * @var null Parameter three
     */
    private $url_parameter_3 = null;
    
    /**
     * Starts the Application
     * TODO: get rid of deep if/else nesting
     */
    public function __construct()
    {
        $this->splitUrl();

        // write URL cookie
        $this->writeUrlCookie(array(
            $this->url_controller, $this->url_action, $this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3
        ));

        // check for controller: is the url_controller NOT empty ?
        if ($this->url_controller) {
            // check for controller: does such an controller exist ?
            if (file_exists(CONTROLLER_PATH . $this->url_controller . '.php')) {
                // if so, then load this file and create this controller
                // example: if controller would be "car", then this line would translate into: $this->car = new car();
                require CONTROLLER_PATH . $this->url_controller . '.php';
                $this->url_controller = new $this->url_controller();

                // check for method: does such a method exist in the controller ?
                if ($this->url_action) {
                    if (method_exists($this->url_controller, $this->url_action)) {

                        // call the method and pass the arguments to it
                        if (isset($this->url_parameter_3)) {
                            $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2, $this->url_parameter_3);
                        } elseif (isset($this->url_parameter_2)) {
                            $this->url_controller->{$this->url_action}($this->url_parameter_1, $this->url_parameter_2);
                        } elseif (isset($this->url_parameter_1)) {
                            $this->url_controller->{$this->url_action}($this->url_parameter_1);
                        } else {
                            // if no parameters given, just call the method without arguments
                            $this->url_controller->{$this->url_action}();
                        }
                    } else {
                        // redirect user to error page (there's a controller for that)
                        header('location: ' . URL . 'error/index');
                    }
                } else {
                    // default/fallback: call the index() method of a selected controller
                    $this->url_controller->index();
                }
            // obviously mistyped controller name, therefore show 404
            } else {
                // redirect user to error page (there's a controller for that)
                header('location: ' . URL . 'error/index');
            }
        // if url_controller is empty, simply show the main page (index/index)
        } else {
            // invalid URL, so simply show home/index
            require CONTROLLER_PATH . 'index.php';
            $controller = new Index();
            $controller->index();
        }
    }

    /**
     * Gets and splits the URL
     */
    private function splitUrl()
    {
        if (isset($_GET['url'])) {

            // split URL
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // Put URL parts into according properties
            // By the way, the syntax here if just a short form of if/else, called "Ternary Operators"
            // http://davidwalsh.name/php-shorthand-if-else-ternary-operators
            $this->url_controller = (isset($url[0]) ? $url[0] : null);
            $this->url_action = (isset($url[1]) ? $url[1] : null);
            $this->url_parameter_1 = (isset($url[2]) ? $url[2] : null);
            $this->url_parameter_2 = (isset($url[3]) ? $url[3] : null);
            $this->url_parameter_3 = (isset($url[4]) ? $url[4] : null);

            // DEBUG
            // echo 'Controller: ' . $this->url_controller . '<br />';
            // echo 'Action: ' . $this->url_action . '<br />';
            // echo 'Parameter 1: ' . $this->url_parameter_1 . '<br />';
            // echo 'Parameter 2: ' . $this->url_parameter_2 . '<br />';
            // echo 'Parameter 3: ' . $this->url_parameter_3 . '<br />';
        }
    }

    /**
     * EXPERIMENTAL!
     * write a cookie that says where exactly the user currently is
     * (to help finding your last location after coming back to the page)
     */
    private function writeUrlCookie($url_array)
    {
        if (count($url_array) > 0) {
            $url = implode("/", $url_array);
        } else {
            $url = "index";
        }
        // set the cookie
        setcookie('lastvisitedpage', $url, time() + COOKIE_RUNTIME, "/", COOKIE_DOMAIN);
    }
}
