<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout {
    public $data = array();
    public $view = null;
    public $viewFolder = null;
    public $layoutsFodler = 'layouts';
    public $layout = 'default';
    var $obj;

    function __construct() {
        $this->obj =& get_instance();
    }

    function setLayout($layout) {
        $this->layout = $layout;
    }

    function setLayoutFolder($layoutFolder) {
        $this->layoutsFodler = $layoutFolder;
    }

    function render() {

        $controller = $this->obj->router->fetch_class();
        $method = $this->obj->router->fetch_method();
        $viewFolder = !($this->viewFolder) ? $controller.'.views' : $this->viewFolder . '.views';
        $view = !($this->view) ? $method : $this->view;

        $loadedData = array();
        $loadedData['view'] = $viewFolder.'/'.$view;
        $loadedData['data'] = $this->data;

        $layoutPath = '/'.$this->layoutsFodler.'/'.$this->layout;
        $this->obj->load->view($layoutPath, $loadedData);
    }
}