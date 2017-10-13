<?php

/* index_index.html */
class __TwigTemplate_cb9fbe06df5560acb86dc1cd9c1cee1581ec6afe7588e0272c956c1098a238de extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->getSourceContext(), ($context["user"] ?? null), "user_nicename", array()), "html", null, true);
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
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{{ user.user_nicename }}，{{ helo }}", "index_index.html", "/home/data/wwwroot/yaf/application/views/index_index.html");
    }
}
