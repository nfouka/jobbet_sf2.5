<?php

/* ErlemJobeetBundle:Job:index.html.twig */
class __TwigTemplate_a6f35dd8338f50dcbd9dfebe173125df082b8bfcfbd4183a8af72226daa71ed0 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("ErlemJobeetBundle::layout.html.twig", "ErlemJobeetBundle:Job:index.html.twig", 1);
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
        echo "<div id=\"jobs\">
    ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["categories"]) ? $context["categories"] : $this->getContext($context, "categories")));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 11
            echo "    <div class=\"category_";
            echo twig_escape_filter($this->env, $this->getAttribute($context["category"], "slug", array()), "html", null, true);
            echo "\">
     <div class=\"category\">
        <div class=\"feed\">
            <a href=";
            // line 14
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("ErlemJobeetBundle_category", array("slug" => $this->getAttribute($context["category"], "slug", array()), "_format" => "atom")), "html", null, true);
            echo ">Feed</a>
        </div>
        <h1><a href=";
            // line 16
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("ErlemJobeetBundle_category", array("slug" => $this->getAttribute($context["category"], "slug", array()))), "html", null, true);
            echo ">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["category"], "name", array()), "html", null, true);
            echo "</a></h1>
    </div>

    ";
            // line 19
            echo twig_include($this->env, $context, "ErlemJobeetBundle:Job:list.html.twig", array("jobs" => $this->getAttribute($context["category"], "activejobs", array())));
            echo "
    
    ";
            // line 21
            if ($this->getAttribute($context["category"], "morejobs", array())) {
                // line 22
                echo "    <div class=\"more_jobs\">
        ";
                // line 23
                echo $this->env->getExtension('translator')->getTranslator()->trans("and %count% more...", array("%count%" => (((("<a href=\"" . $this->env->getExtension('routing')->getPath("ErlemJobeetBundle_category", array("slug" => $this->getAttribute($context["category"], "slug", array())))) . "\">") . $this->getAttribute($context["category"], "morejobs", array())) . "</a>")), "messages");
                // line 24
                echo "    </div>
    ";
            }
            // line 26
            echo "</div>
";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "ErlemJobeetBundle:Job:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  116 => 28,  101 => 26,  97 => 24,  95 => 23,  92 => 22,  90 => 21,  85 => 19,  77 => 16,  72 => 14,  65 => 11,  48 => 10,  45 => 9,  42 => 8,  36 => 5,  32 => 4,  29 => 3,  11 => 1,);
    }
}
/* {% extends 'ErlemJobeetBundle::layout.html.twig' %}*/
/* */
/* {% block stylesheets %}*/
/* {{ parent() }}*/
/* <link rel="stylesheet" href={{ asset('bundles/erlemjobeet/css/jobs.css') }} type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block content %}*/
/* <div id="jobs">*/
/*     {% for category in categories %}*/
/*     <div class="category_{{ category.slug }}">*/
/*      <div class="category">*/
/*         <div class="feed">*/
/*             <a href={{ path('ErlemJobeetBundle_category', { 'slug': category.slug, '_format': 'atom' }) }}>Feed</a>*/
/*         </div>*/
/*         <h1><a href={{ path('ErlemJobeetBundle_category', { 'slug': category.slug }) }}>{{ category.name }}</a></h1>*/
/*     </div>*/
/* */
/*     {{ include ('ErlemJobeetBundle:Job:list.html.twig', {'jobs': category.activejobs}) }}*/
/*     */
/*     {% if category.morejobs %}*/
/*     <div class="more_jobs">*/
/*         {% trans with {'%count%': '<a href="' ~ path('ErlemJobeetBundle_category', { 'slug': category.slug }) ~ '">' ~  category.morejobs ~ '</a>'} %}and %count% more...{% endtrans %}*/
/*     </div>*/
/*     {% endif %}*/
/* </div>*/
/* {% endfor %}*/
/* </div>*/
/* {% endblock %}*/
