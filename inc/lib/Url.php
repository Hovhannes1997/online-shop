<?php
class Url{  
    public $type = "";
    public $PATH = "";
    public $DIR = "";
    public $DIRS = "";
    public $PAGE = "";
    public $GET = [];
    public $GET_STR = "";
    public $POST = [];
    public $REQUEST = [];
    
    public function __construct() {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->type = 'ajax';
        }
        
        $url = urldecode($_SERVER['REQUEST_URI']);
        $url = strip_tags($url);
        $url = ltrim($url, '/');
        $url = explode('?', $url);
        
        if(isset($url[0])){
            $this->DIR = explode('/', $url[0]);
            $this->PAGE = array_pop($this->DIR);
            $this->DIR_STR = ltrim(implode('/', $this->DIR)."/", '/');
            $this->PATH = $this->DIR_STR.$this->PAGE;
        }
        if(isset($url[1])){
            $this->GET_STR = $url[1];
        }
        if(isset($_GET) && !empty($_GET)){
            $this->GET = $_GET;
        }
        if(isset($_POST) && !empty($_POST)){
            $this->POST = $_POST;
        }
        if(isset($_REQUEST) && !empty($_REQUEST)){
            $this->REQUEST = $_REQUEST;
        }
    } 
    public function cleanURL($url) {
        $url = str_replace(",", " ", $url);
        $url = str_replace(".", " ", $url);
        $url = str_replace("․", " ", $url);
        $url = str_replace("…", " ", $url);
        $url = str_replace("՝", " ", $url);
        $url = str_replace("`", " ", $url);
        $url = str_replace("՞", " ", $url);
        $url = str_replace("?", " ", $url);
        $url = str_replace("!", " ", $url);
        $url = str_replace(":", " ", $url);
        $url = str_replace("։", " ", $url);
        $url = str_replace(";", " ", $url);
        $url = str_replace(",", " ", $url);
        $url = str_replace("•", " ", $url);
        $url = str_replace("+", " ", $url);
        $url = str_replace("/", " ", $url);
        $url = str_replace("-", " ", $url);
        $url = str_replace("'", " ", $url);
        $url = str_replace("“", " ", $url);
        $url = str_replace("”", " ", $url);
        $url = str_replace("՛՛", " ", $url);
        $url = str_replace("#", " ", $url);
        $url = str_replace("@", " ", $url);
        $url = str_replace("&", " ", $url);
        $url = str_replace("%", " ", $url);
        $url = str_replace("$", " ", $url);
        $url = str_replace("(", " ", $url);
        $url = str_replace(")", " ", $url);
        $url = str_replace("«", " ", $url);
        $url = str_replace("»", " ", $url);
        $url = str_replace("\n", " ", $url);
        $url = str_replace("\r", " ", $url);
        $url = str_replace("\r\n", " ", $url);
        $url = str_replace(" ", "-", $url);
        $url = str_replace("--", "-", $url);
        $url = str_replace("--", "-", $url);
        $url = str_replace("--", "-", $url);
        $url = trim($url, '-');
        $url = mb_strtolower($url);
        return $url;
    }
}
?>