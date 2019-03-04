<?php

/* index_index.html */
class __TwigTemplate_10243fd18b17e80c94525ad678f83b87c215390a4090aaece39acfe780942f94 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["user"] ?? null), "user_nicename", []), "html", null, true);
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
