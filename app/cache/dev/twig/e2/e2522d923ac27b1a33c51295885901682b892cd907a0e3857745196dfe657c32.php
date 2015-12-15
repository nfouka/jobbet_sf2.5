<?php

/* ErlemJobeetBundle:Job:new.html.twig */
class __TwigTemplate_10c1da30f067fb4fd19a8c6bc641b357f9136e66becb6a45ed384de381aa0f8c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("ErlemJobeetBundle::layout.html.twig", "ErlemJobeetBundle:Job:new.html.twig", 1);
        $this->blocks = array(
            'form_errors' => array($this, 'block_form_errors'),
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
        // line 3
        $this->env->getExtension('form')->renderer->setTheme((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), array(0 => $this));
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_form_errors($context, array $blocks = array())
    {
        // line 6
        ob_start();
        // line 7
        echo "    ";
        if ((twig_length_filter($this->env, (isset($context["errors"]) ? $context["errors"] : $this->getContext($context, "errors"))) > 0)) {
            // line 8
            echo "        <ul class=\"error_list\">
            ";
            // line 9
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["errors"]) ? $context["errors"] : $this->getContext($context, "errors")));
            foreach ($context['_seq'] as $context["_key"] => $context["error"]) {
                // line 10
                echo "                <li>";
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans($this->getAttribute($context["error"], "messageTemplate", array()), $this->getAttribute($context["error"], "messageParameters", array()), "validators"), "html", null, true);
                echo "</li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['error'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 12
            echo "        </ul>
    ";
        }
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    // line 17
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 18
        echo "    ";
        $this->displayParentBlock("stylesheets", $context, $blocks);
        echo "
    <link rel=\"stylesheet\" href=";
        // line 19
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("bundles/erlemjobeet/css/job.css"), "html", null, true);
        echo " type=\"text/css\" media=\"all\" />
";
    }

    // line 22
    public function block_content($context, array $blocks = array())
    {
        // line 23
        echo "    <h1>";
        echo $this->env->getExtension('translator')->getTranslator()->trans("Job creation", array(), "messages");
        echo "</h1>
    <form action=";
        // line 24
        echo $this->env->getExtension('routing')->getPath("erlem_job_create");
        echo " method=\"post\" ";
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'enctype');
        echo ">
        <table id=\"job_form\">
            <tfoot>
                <tr>
                    <td colspan=\"2\">
                        <input type=\"submit\" value=\"Preview your job\" />
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <tr>
                    <th>";
        // line 35
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "category", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 37
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "category", array()), 'errors');
        echo "
                        ";
        // line 38
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "category", array()), 'widget');
        echo "
                    </td>
                </tr>
                <tr>
                    <th>";
        // line 42
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "type", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 44
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "type", array()), 'errors');
        echo "
                        ";
        // line 45
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "type", array()), 'widget');
        echo "
                    </td>
                </tr>
                <tr>
                    <th>";
        // line 49
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "company", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 51
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "company", array()), 'errors');
        echo "
                        ";
        // line 52
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "company", array()), 'widget');
        echo "
                    </td>
                </tr>
                <tr>
                    <th>";
        // line 56
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "file", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 58
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "file", array()), 'errors');
        echo "
                        ";
        // line 59
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "file", array()), 'widget');
        echo "
                    </td>
                </tr>
                <tr>
                    <th>";
        // line 63
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "url", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 65
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "url", array()), 'errors');
        echo "
                        ";
        // line 66
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "url", array()), 'widget');
        echo "
                    </td>
                </tr>
                <tr>
                    <th>";
        // line 70
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "position", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 72
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "position", array()), 'errors');
        echo "
                        ";
        // line 73
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "position", array()), 'widget');
        echo "
                    </td>
                </tr>
                <tr>
                    <th>";
        // line 77
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "location", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 79
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "location", array()), 'errors');
        echo "
                        ";
        // line 80
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "location", array()), 'widget');
        echo "
                    </td>
                </tr>
                <tr>
                    <th>";
        // line 84
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "description", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 86
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "description", array()), 'errors');
        echo "
                        ";
        // line 87
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "description", array()), 'widget');
        echo "
                    </td>
                </tr>
                <tr>
                    <th>";
        // line 91
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "how_to_apply", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 93
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "how_to_apply", array()), 'errors');
        echo "
                        ";
        // line 94
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "how_to_apply", array()), 'widget');
        echo "
                    </td>
                </tr>
                <tr>
                    <th>";
        // line 98
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "is_public", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 100
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "is_public", array()), 'errors');
        echo "
                        ";
        // line 101
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "is_public", array()), 'widget');
        echo "
                        <br /> ";
        // line 102
        echo $this->env->getExtension('translator')->getTranslator()->trans("Whether the job can also be published on affiliate websites or not.", array(), "messages");
        // line 103
        echo "                    </td>
                </tr>
                <tr>
                    <th>";
        // line 106
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "email", array()), 'label');
        echo "</th>
                    <td>
                        ";
        // line 108
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "email", array()), 'errors');
        echo "
                        ";
        // line 109
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), "email", array()), 'widget');
        echo "
                    </td>
                </tr>
            </tbody>
        </table>
    ";
        // line 114
        echo         $this->env->getExtension('form')->renderer->renderBlock((isset($context["form"]) ? $context["form"] : $this->getContext($context, "form")), 'form_end');
        echo "
";
    }

    public function getTemplateName()
    {
        return "ErlemJobeetBundle:Job:new.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  283 => 114,  275 => 109,  271 => 108,  266 => 106,  261 => 103,  259 => 102,  255 => 101,  251 => 100,  246 => 98,  239 => 94,  235 => 93,  230 => 91,  223 => 87,  219 => 86,  214 => 84,  207 => 80,  203 => 79,  198 => 77,  191 => 73,  187 => 72,  182 => 70,  175 => 66,  171 => 65,  166 => 63,  159 => 59,  155 => 58,  150 => 56,  143 => 52,  139 => 51,  134 => 49,  127 => 45,  123 => 44,  118 => 42,  111 => 38,  107 => 37,  102 => 35,  86 => 24,  81 => 23,  78 => 22,  72 => 19,  67 => 18,  64 => 17,  57 => 12,  48 => 10,  44 => 9,  41 => 8,  38 => 7,  36 => 6,  33 => 5,  29 => 1,  27 => 3,  11 => 1,);
    }
}
/* {% extends 'ErlemJobeetBundle::layout.html.twig' %}*/
/*  */
/* {% form_theme form _self %}*/
/*  */
/* {% block form_errors %}*/
/* {% spaceless %}*/
/*     {% if errors|length > 0 %}*/
/*         <ul class="error_list">*/
/*             {% for error in errors %}*/
/*                 <li>{{ error.messageTemplate|trans(error.messageParameters, 'validators') }}</li>*/
/*             {% endfor %}*/
/*         </ul>*/
/*     {% endif %}*/
/* {% endspaceless %}*/
/* {% endblock form_errors %}*/
/*  */
/* {% block stylesheets %}*/
/*     {{ parent() }}*/
/*     <link rel="stylesheet" href={{ asset('bundles/erlemjobeet/css/job.css') }} type="text/css" media="all" />*/
/* {% endblock %}*/
/*  */
/* {% block content %}*/
/*     <h1>{% trans %}Job creation{% endtrans %}</h1>*/
/*     <form action={{ path('erlem_job_create') }} method="post" {{ form_enctype(form) }}>*/
/*         <table id="job_form">*/
/*             <tfoot>*/
/*                 <tr>*/
/*                     <td colspan="2">*/
/*                         <input type="submit" value="Preview your job" />*/
/*                     </td>*/
/*                 </tr>*/
/*             </tfoot>*/
/*             <tbody>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.category) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.category) }}*/
/*                         {{ form_widget(form.category) }}*/
/*                     </td>*/
/*                 </tr>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.type) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.type) }}*/
/*                         {{ form_widget(form.type) }}*/
/*                     </td>*/
/*                 </tr>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.company) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.company) }}*/
/*                         {{ form_widget(form.company) }}*/
/*                     </td>*/
/*                 </tr>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.file) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.file) }}*/
/*                         {{ form_widget(form.file) }}*/
/*                     </td>*/
/*                 </tr>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.url) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.url) }}*/
/*                         {{ form_widget(form.url) }}*/
/*                     </td>*/
/*                 </tr>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.position) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.position) }}*/
/*                         {{ form_widget(form.position) }}*/
/*                     </td>*/
/*                 </tr>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.location) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.location) }}*/
/*                         {{ form_widget(form.location) }}*/
/*                     </td>*/
/*                 </tr>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.description) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.description) }}*/
/*                         {{ form_widget(form.description) }}*/
/*                     </td>*/
/*                 </tr>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.how_to_apply) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.how_to_apply) }}*/
/*                         {{ form_widget(form.how_to_apply) }}*/
/*                     </td>*/
/*                 </tr>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.is_public) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.is_public) }}*/
/*                         {{ form_widget(form.is_public) }}*/
/*                         <br /> {% trans %}Whether the job can also be published on affiliate websites or not.{% endtrans %}*/
/*                     </td>*/
/*                 </tr>*/
/*                 <tr>*/
/*                     <th>{{ form_label(form.email) }}</th>*/
/*                     <td>*/
/*                         {{ form_errors(form.email) }}*/
/*                         {{ form_widget(form.email) }}*/
/*                     </td>*/
/*                 </tr>*/
/*             </tbody>*/
/*         </table>*/
/*     {{ form_end(form) }}*/
/* {% endblock %}*/
