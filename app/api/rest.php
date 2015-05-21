<?php
$autoload_rest_dir = "routes";
//Child classes should be named like $verb . "Route"
//Any request type function can be added just by creating the function appropriately named
//such as get() for GET, post() for POST
//If they have the variable $requiresAuth = true, or $getRequiresAuth(for GET requests)
//Then it requires $user to be set for that call
//available values to verb functions: $this->user, $this->input, $this->verb, $this->id
//$this->id is the value after the noun, like 23 in ?users/23
class rest
{
    const HTTP_OK           = 200;
    const HTTP_NOT_MODIFIED = 304;
    const HTTP_BAD_REQUEST  = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN    = 403;
    const HTTP_NOT_FOUND    = 404;
    const HTTP_TOO_MANY_REQUESTS = 429;
    const HTTP_SERVER_ERROR = 500;

    const CONTENT_JSON      = "application/json";

    protected $user, $input, $verb, $id;
    private $errors = array();
    private $headers = array();
    private $contentType = self::CONTENT_JSON;

    function __construct($input, $verb, $id) {
        $this->input = $input;
        $this->verb = $verb;
        $this->id = $id;
    }

    public function process($user = null) {
        $this->user = $user;
        $results = $this->getResults();
        $this->header("Content-Type: ".$this->contentType);
        if (!empty($this->errors)) {
            return $this->processError();
        }
        foreach ($this->headers as $h) {
            header($h);
        }
        if (is_array($results)) {
            echo json_encode($results);
        } else {
            echo $results;
        }
        return true;
    }

    private function processError() {
        header("HTTP/1.0 ".$this->errors[0]["code"]." ".$this->errors[0]["error"]);
        header("Content-Type: ".self::CONTENT_JSON);
        echo json_encode(array("data" => array(), "error" => $this->errors[0]["error"]));
        return null;
    }

    private function getResults() {
        if (method_exists($this, $this->verb)) {
            if (!$this->isAuthorized()) {
                return $this->notAuthorized();
            }
            $results = $this->{$this->verb}();
            if (empty($results)) return array();
            return $results;
        }
        $this->error("Route not found", self::HTTP_NOT_FOUND);
        return array();
    }

    protected function error($message, $httpcode = self::HTTP_BAD_REQUEST) {
        $this->errors[] = array("error" => $message, "code" => $httpcode);
        return null;
    }

    protected function header($header) {
        $this->headers[] = $header;
        return null;
    }

    protected function contentType($ct) {
        $this->contentType = $ct;
        return null;
    }

    protected function isAuthorized() {
        if ((isset($this->requiresAuth) && $this->requiresAuth) || (isset($this->{$this->verb."RequiresAuth"}) && $this->{$this->verb."RequiresAuth"})) {
            return (!!$this->user);
        }
        return true;
    }

    protected function notAuthorized() {
        $this->error("Not Authorized", self::HTTP_FORBIDDEN);
        return null;
    }

    public static function getRoute($route = "rest") {
        global $autoload_rest_dir;
        $autoload_rest_dir = $route;
        $urlvars = $_SERVER['REQUEST_URI'];
        $urlvars = substr($urlvars, strpos($urlvars,"?")+1);
        $urlvars = array_filter(explode("/", $urlvars));
        $noun = strtolower(array_shift($urlvars));
        $noun = str_replace("/[^0-9a-zA-Z]/", "", $noun);
        $id = null;
        if (!empty($urlvars)) {
            $id = array_shift($urlvars);
            if (!$id) $id = null;
        }
        $verb = strtolower($_SERVER["REQUEST_METHOD"]);
        switch ($verb) {
            case "get":
                $INPUT = $_GET;
                array_shift($INPUT);
                break;
            case "post":
                $INPUT = $_POST;
                break;
            default:
                parse_str(file_get_contents('php://input'), $INPUT);// (array)json_decode(file_get_contents('php://input'));
        }

        if (!empty($urlvars)) {
            $INPUT["urlVariables"] = $urlvars;
        }

        $classname = $noun."Route";
        if (!class_exists($classname) || !in_array($verb, array("get", "put", "post", "delete", "patch"))) {
            return new self($INPUT, $verb, $id);
        }
        return new $classname($INPUT, $verb, $id);
    }
}

function autoload_rest($class) {
    if($routepos = strpos($class,"Route")) {
        global $autoload_rest_dir;
        $class = substr($class, 0, $routepos);
        include_once($autoload_rest_dir . DIRECTORY_SEPARATOR . $class.".php");
    }
}

spl_autoload_register('autoload_rest');
