<?php

class ActionBase extends Yaf_Action_Abstract
{

    public $config = [];
    public $request;
    public $view;
    public $di;
    public $logger;

    public function _init()
    {
        $this->config = Yaf_Registry::get('config');
        $this->di = Yaf_Registry::get("di");
        $this->logger = $this->di["log"];
        $this->request = $this->getRequest();
        $this->_view();
    }

    public function _before()
    {

    }

    public function _after()
    {

    }

    final public function execute()
    {
        $this->_init();
        try {
            $this->_before();
            $this->_exe();
            $this->_after();
        } catch (Exception $e) {
            \Tracy\Debugger::dump($e);
            exit();
        }
    }

    public function params($param = null, $defaultValue = null)
    {
        if ($param === null) {
            return array_merge($this->request->getQuery(), $this->request->getParams());
        }

        $value = $this->request->getParam($param);
        if ($value === null) {
            return $this->request->getQuery($param, $defaultValue);
        }

        return $value;
    }

    public function post($param = null, $defaultValue = null)
    {
        if ($param === null) {
            return $this->request->getPost();
        }

        return $this->request->getPost($param, $defaultValue);
    }

    public function get($param = null, $defaultValue = null)
    {
        if ($param === null) {
            return $_REQUEST;
        }

        return isset($_REQUEST[$param]) ? $_REQUEST[$param] : $defaultValue;
    }

    public function cookie($param = null, $defaultValue = null)
    {
        if ($param === null) {
            return $this->request->getCookie();
        }

        return $this->request->getCookie($param, $defaultValue);
    }

    public function server($param = null, $defaultValue = null)
    {
        if ($param === null) {
            return $this->request->getServer();
        }

        return $this->request->getServer($param, $defaultValue);
    }

    public function method()
    {
        return $this->request->getMethod();
    }

    public function isDelete()
    {
        return $this->request->getServer('REQUEST_METHOD') == 'DELETE';
    }

    public function isAjax()
    {
        return $this->request->isXmlHttpRequest();
    }

    private function _view()
    {
        $view_config = $this->config["application"]["view"];
        $options = [
            "cache" => $view_config["cachedir"],
            "debug" => true,
            "charset" => "UTF-8",
        ];
        $this->view = new ViewBase($view_config["dir"], $options);
    }
}
