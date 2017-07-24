<?php

class ViewBase implements Yaf_View_Interface
{

    protected $loader;
    protected $twig;
    protected $variables = array();

    public function __construct($templateDir, array $options = array())
    {
        $this->loader = new \Twig_Loader_Filesystem($templateDir);
        $this->twig = new \Twig_Environment($this->loader, $options);
    }

    public function __isset($name)
    {
        return isset($this->variables[$name]);
    }

    public function __set($name, $value)
    {
        $this->variables[$name] = $value;
    }

    public function __get($name)
    {
        return $this->variables[$name];
    }

    public function __unset($name)
    {
        unset($this->variables[$name]);
    }

    public function getTwig()
    {
        return $this->twig;
    }

    public function assign($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $k => $v) {
                $this->variables[$k] = $v;
            }
        } else {
            $this->variables[$name] = $value;
        }
    }

    public function display($template, $variables = null)
    {
        echo $this->render($template, $variables);
    }

    public function fetch($template, $variables = null)
    {
        return $this->render($template, $variables);
    }

    public function getScriptPath()
    {
        $paths = $this->loader->getPaths();
        return reset($paths);
    }

    public function render($template, $variables = null)
    {
        if (is_array($variables)) {
            $this->variables = array_merge($this->variables, $variables);
        }

        return $this->twig->loadTemplate($template)->render($this->variables);
    }

    public function setScriptPath($templateDir)
    {
        $this->loader->setPaths($templateDir);
    }
}
