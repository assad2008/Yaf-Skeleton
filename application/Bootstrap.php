<?php

class Bootstrap extends Yaf_Bootstrap_Abstract
{

    public $config;
    protected $loader;

    public function _initConfig()
    {
        $this->config = Yaf_Application::app()->getConfig()->toArray();
        Yaf_Registry::set('config', $this->config);
        $this->loader = Yaf_Loader::getInstance();
    }

    public function _initComposerAutoLoader()
    {
        $autoload = ROOT_PATH . '/vendor/autoload.php';
        if (file_exists($autoload)) {
            $this->loader->import($autoload);
        }
    }

    public function _initDebugger()
    {
        Tracy\Debugger::enable(Tracy\Debugger::DEVELOPMENT);
        Tracy\Debugger::$strictMode = false;
        Tracy\Debugger::$showBar = false;
    }

    public function _initLoadHelperFunction()
    {
        $this->loader->import(ROOT_PATH . '/library/Helpers.php');
    }

    public function _initRoute(Yaf_Dispatcher $dispatcher)
    {
        $config = require CONFIG_PATH . '/routes.php';
        $dispatcher->getRouter()->addConfig($config);
    }

    public function _initServices()
    {
        $services = [];
        $service_file = APP_PATH . '/Services.php';
        if (file_exists($service_file) && is_readable($service_file)) {
            $services = require $service_file;
        }
        $container = new Pimple\Container($services);
        Yaf_Registry::set('di', $container);
    }

    public function _initListener()
    {
        $listeners = [];
    }

    public function _initDefaultDbAdapter()
    {
        $capsule = new Illuminate\Database\Capsule\Manager();
        $db = $this->config['database'];
        foreach ($db as $key => $value) {
            $capsule->addConnection($value, $key);
        }
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        class_alias("Illuminate\Database\Capsule\Manager", "DB");
    }

    public function _initLoadModels()
    {
        $adapter = new League\Flysystem\Adapter\Local(APP_PATH);
        $filesystem = new League\Flysystem\Filesystem($adapter);
        $contents = $filesystem->listContents('models', true);
        foreach ($contents as $key => $value) {
            $this->loader->import(APP_PATH . '/' . $value["path"]);
        }
    }

    public function _initView(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->autoRender(false);
    }

}
