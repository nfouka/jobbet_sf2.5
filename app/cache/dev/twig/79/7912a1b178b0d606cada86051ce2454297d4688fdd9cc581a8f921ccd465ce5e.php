<?php

/* ErlemJobeetBundle:Job:search.html.twig */
class __TwigTemplate_d4cf5c4d5d8d739cc784d01a883db1050c7073d5288a4dce396704d8ea39a531 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("ErlemJobeetBundle::layout.html.twig", "ErlemJobeetBundle:Job:search.html.twig", 1);
        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "ErlemJobeetBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->displayParentBlock("stylesheets", $context, $blocks);
        echo "
    <link rel=\"stylesheet\" href=";
        // line 5
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/erlemjobeet/css/jobs.css"), "html", null, true);
        echo " type=\"text/css\" media=\"all\" />
";
    }

    // line 8
    public function block_content($context, array $blocks = array())
    {
        // line 9
        echo "    <div id=\"jobs\">
        ";
        // line 10
        $this->loadTemplate("ErlemJobeetBundle:Job:list.html.twig", "ErlemJobeetBundle:Job:search.html.twig", 10)->display(array_merge($context, array("jobs" => (isset($context["jobs"]) ? $context["jobs"] : $this->getContext($context, "jobs")))));
        // line 11
        echo "    </div>
";
    }

    public function getTemplateName()
    {
        return "ErlemJobeetBundle:Job:search.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 11,  49 => 10,  46 => 9,  43 => 8,  37 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }
}
/* {% extends 'ErlemJobeetBundle::layout.html.twig' %}*/
/*  */
/* {% block stylesheets %}*/
/*     {{ parent() }}*/
/*     <link rel="stylesheet" href={{ asset('bundles/erlemjobeet/css/jobs.css') }} type="text/css" media="all" />*/
/* {% endblock %}*/
/*  */
/* {% block content %}*/
/*     <div id="jobs">*/
/*         {% include 'ErlemJobeetBundle:Job:list.html.twig' with {'jobs': jobs} %}*/
/*     </div>*/
/* {% endblock %}*/
