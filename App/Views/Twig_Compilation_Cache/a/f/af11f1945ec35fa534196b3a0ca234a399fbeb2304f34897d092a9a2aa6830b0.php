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
        echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <title>Document</title>
</head>
<body>
    ";
        // line 8
        if ((isset($context["uData"]) ? $context["uData"] : null)) {
            // line 9
            echo "        ";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["uData"]) ? $context["uData"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["uItem"]) {
                if ((($context["uItem"] % 2) == 0)) {
                    // line 10
                    echo "            ";
                    echo twig_escape_filter($this->env, $context["uItem"]);
                    echo " = 
        ";
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['uItem'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 12
            echo "    ";
        }
        // line 13
        echo "</body>
</html>";
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
        return array (  49 => 13,  46 => 12,  36 => 10,  30 => 9,  28 => 8,  19 => 1,);
    }
}
