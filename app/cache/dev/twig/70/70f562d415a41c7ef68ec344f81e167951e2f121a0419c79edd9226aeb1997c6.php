<?php

/* ErlemJobeetBundle:Job:show.html.twig */
class __TwigTemplate_546d462769d70bd18cf8a7e390d51a486ec6d82e61ed56f52e7f0927648da2b9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("ErlemJobeetBundle::layout.html.twig", "ErlemJobeetBundle:Job:show.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
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
    public function block_title($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        echo $this->env->getExtension('translator')->getTranslator()->trans("%company% is looking for a %position%", array("%company%" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "company", array()), "%position%" => $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "position", array())), "messages");
    }

    // line 7
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 8
        echo "    ";
        $this->displayParentBlock("stylesheets", $context, $blocks);
        echo "
    <link rel=\"stylesheet\" href=";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/erlemjobeet/css/job.css"), "html", null, true);
        echo " type=\"text/css\" media=\"all\" />
";
    }

    // line 12
    public function block_content($context, array $blocks = array())
    {
        // line 13
        echo "    ";
        if ($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "request", array()), "get", array(0 => "token"), "method")) {
            // line 14
            echo "        ";
            $this->loadTemplate("ErlemJobeetBundle:Job:admin.html.twig", "ErlemJobeetBundle:Job:show.html.twig", 14)->display(array_merge($context, array("job" => (isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")))));
            // line 15
            echo "    ";
        }
        // line 16
        echo "    <div id=\"job\">
        <h1>";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "company", array()), "html", null, true);
        echo "</h1>
        <h2>";
        // line 18
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "location", array()), "html", null, true);
        echo "</h2>
        <h3>
            ";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "position", array()), "html", null, true);
        echo "
            <small> - ";
        // line 21
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "type", array()), "html", null, true);
        echo "</small>
        </h3>
 
        ";
        // line 24
        if ($this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "logo", array())) {
            // line 25
            echo "            <div class=\"logo\">
                <a href=";
            // line 26
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "url", array()), "html", null, true);
            echo ">
                    <img src=\"/uploads/jobs/";
            // line 27
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "logo", array()), "html", null, true);
            echo "
                        alt=";
            // line 28
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "company", array()), "html", null, true);
            echo " logo\" />
                </a>
            </div>
        ";
        }
        // line 32
        echo " 
        <div class=\"description\">
            ";
        // line 34
        echo nl2br(twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "description", array()), "html", null, true));
        echo "
        </div>
 
        <h4>";
        // line 37
        echo $this->env->getExtension('translator')->getTranslator()->trans("How to apply?", array(), "messages");
        echo "</h4>
 
        <p class=\"how_to_apply\">";
        // line 39
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "howtoapply", array()), "html", null, true);
        echo "</p>
 
        <div class=\"meta\">
            <small>";
        // line 42
        echo $this->env->getExtension('translator')->getTranslator()->trans("posted on %date%", array("%date%" => twig_date_format_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : $this->getContext($context, "entity")), "createdat", array()), "m/d/Y")), "messages");
        echo "</small>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "ErlemJobeetBundle:Job:show.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 42,  121 => 39,  116 => 37,  110 => 34,  106 => 32,  99 => 28,  95 => 27,  91 => 26,  88 => 25,  86 => 24,  80 => 21,  76 => 20,  71 => 18,  67 => 17,  64 => 16,  61 => 15,  58 => 14,  55 => 13,  52 => 12,  46 => 9,  41 => 8,  38 => 7,  33 => 4,  30 => 3,  11 => 1,);
    }
}
/* {% extends 'ErlemJobeetBundle::layout.html.twig' %}*/
/*  */
/* {% block title %}*/
/*     {% trans with {'%company%': entity.company, '%position%': entity.position} %}%company% is looking for a %position%{% endtrans %}*/
/* {% endblock %}*/
/*  */
/* {% block stylesheets %}*/
/*     {{ parent() }}*/
/*     <link rel="stylesheet" href={{ asset('bundles/erlemjobeet/css/job.css') }} type="text/css" media="all" />*/
/* {% endblock %}*/
/*  */
/* {% block content %}*/
/*     {% if app.request.get('token') %}*/
/*         {% include 'ErlemJobeetBundle:Job:admin.html.twig' with {'job': entity} %}*/
/*     {% endif %}*/
/*     <div id="job">*/
/*         <h1>{{ entity.company }}</h1>*/
/*         <h2>{{ entity.location }}</h2>*/
/*         <h3>*/
/*             {{ entity.position }}*/
/*             <small> - {{ entity.type }}</small>*/
/*         </h3>*/
/*  */
/*         {% if entity.logo %}*/
/*             <div class="logo">*/
/*                 <a href={{ entity.url }}>*/
/*                     <img src="/uploads/jobs/{{ entity.logo }}*/
/*                         alt={{ entity.company }} logo" />*/
/*                 </a>*/
/*             </div>*/
/*         {% endif %}*/
/*  */
/*         <div class="description">*/
/*             {{ entity.description|nl2br }}*/
/*         </div>*/
/*  */
/*         <h4>{% trans %}How to apply?{% endtrans %}</h4>*/
/*  */
/*         <p class="how_to_apply">{{ entity.howtoapply }}</p>*/
/*  */
/*         <div class="meta">*/
/*             <small>{% trans with {'%date%': entity.createdat|date('m/d/Y')} %}posted on %date%{% endtrans %}</small>*/
/*         </div>*/
/*     </div>*/
/* {% endblock %}*/
