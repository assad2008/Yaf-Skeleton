<?php

/* index_index.html */
class __TwigTemplate_90247f17eeee693dfb4bbd6fce136391ae02fe27d8c7fe266ed237440b96c1a9 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "user_nicename", array()), "html", null, true);
        echo "，";
        echo twig_escape_filter($this->env, ($context["helo"] ?? null), "html", null, true);
    }

    public function getTemplateName()
    {
        return "index_index.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{{ user.user_nicename }}，{{ helo }}", "index_index.html", "/www/wwwroot/yaf.yeedev.xyz/application/views/index_index.html");
    }
}
