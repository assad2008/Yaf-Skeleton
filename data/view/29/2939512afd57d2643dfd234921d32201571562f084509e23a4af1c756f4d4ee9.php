<?php

/* index_index.html */
class __TwigTemplate_a9f7d68a967bf6aef91e8a8dc2daf4ddf7d27a058099ab60074783c78659c472 extends Twig_Template
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
