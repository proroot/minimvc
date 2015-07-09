<?php

/* Welcome.php */
class __TwigTemplate_af11f1945ec35fa534196b3a0ca234a399fbeb2304f34897d092a9a2aa6830b0 extends Twig_Template
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
        echo twig_escape_filter($this->env, (isset($context["test"]) ? $context["test"] : null), "html", null, true);
    }

    public function getTemplateName()
    {
        return "Welcome.php";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
