<?php

/* ErlemJobeetBundle:Job:admin.html.twig */
class __TwigTemplate_cb8bdbf479c125b98129d390a9c0b2d2dcd73a405908c7d139d39837da123a78 extends Twig_Template
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
        echo "<div id=\"job_actions\">
    <h3>Admin</h3>
    <ul>
        ";
        // line 4
        if ( !$this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "isActivated", array())) {
            // line 5
            echo "            <ul>
                <li><a href=";
            // line 6
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("erlem_job_edit", array("token" => $this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "token", array()))), "html", null, true);
            echo ">";
            echo $this->env->getExtension('translator')->getTranslator()->trans("Edit", array(), "messages");
            echo "</a></li>
                <li>
                    <form action=";
            // line 8
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("erlem_job_publish", array("token" => $this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "token", array()))), "html", null, true);
            echo " method=\"post\">
                        ";
            // line 9
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["publish_form"]) ? $context["publish_form"] : $this->getContext($context, "publish_form")), 'widget');
            echo "
                            <button type=\"submit\">";
            // line 10
            echo $this->env->getExtension('translator')->getTranslator()->trans("Publish", array(), "messages");
            echo "</button>
                    </form>
                </li>
            </ul>
        ";
        }
        // line 15
        echo "        <li>
            <form action=";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("erlem_job_delete", array("token" => $this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "token", array()))), "html", null, true);
        echo " method=\"post\">
                ";
        // line 17
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["delete_form"]) ? $context["delete_form"] : $this->getContext($context, "delete_form")), 'widget');
        echo "
                    <button type=\"submit\" onclick=\"if(!confirm('";
        // line 18
        echo $this->env->getExtension('translator')->getTranslator()->trans("Are you sure?", array(), "messages");
        echo "')) { return false; }\">";
        echo $this->env->getExtension('translator')->getTranslator()->trans("Delete", array(), "messages");
        echo "</button>
            </form>
        </li>
        ";
        // line 21
        if ($this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "isActivated", array())) {
            // line 22
            echo "            <li ";
            if ($this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "expiresSoon", array())) {
                echo " class=\"expires_soon\" ";
            }
            echo ">
                ";
            // line 23
            if ($this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "isExpired", array())) {
                // line 24
                echo "                    ";
                echo $this->env->getExtension('translator')->getTranslator()->trans("Expired", array(), "messages");
                // line 25
                echo "                ";
            } else {
                // line 26
                echo "                    ";
                echo $this->env->getExtension('translator')->getTranslator()->trans("Expires in %count% days", array("%count%" => (("<strong>" . $this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "getDaysBeforeExpires", array())) . "</strong>")), "messages");
                // line 27
                echo "                ";
            }
            // line 28
            echo " 
                ";
            // line 29
            if ($this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "expiresSoon", array())) {
                // line 30
                echo "                    <form action=";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("erlem_job_extend", array("token" => $this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "token", array()))), "html", null, true);
                echo " method=\"post\">
                        ";
                // line 31
                echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["extend_form"]) ? $context["extend_form"] : $this->getContext($context, "extend_form")), 'widget');
                echo "
                            <button type=\"submit\" value=\"Extend\">";
                // line 32
                echo $this->env->getExtension('translator')->getTranslator()->trans("Extend", array(), "messages");
                echo "</button> ";
                echo $this->env->getExtension('translator')->getTranslator()->trans("for another 30 days", array(), "messages");
                // line 33
                echo "                    </form>
                ";
            }
            // line 35
            echo "            </li>
        ";
        } else {
            // line 37
            echo "            <li>
                [";
            // line 38
            echo $this->env->getExtension('translator')->getTranslator()->trans("Bookmark this %url% to manage this job in the future", array("%url%" => (("<a href=\"" . $this->env->getExtension('routing')->getUrl("erlem_job_preview", array("token" => $this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "token", array()), "company" => $this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "companyslug", array()), "location" => $this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "locationslug", array()), "position" => $this->getAttribute((isset($context["job"]) ? $context["job"] : $this->getContext($context, "job")), "positionslug", array())))) . "\">URL</a>")), "messages");
            echo ".]
            </li>
        ";
        }
        // line 41
        echo "    </ul>
</div>";
    }

    public function getTemplateName()
    {
        return "ErlemJobeetBundle:Job:admin.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  129 => 41,  123 => 38,  120 => 37,  116 => 35,  112 => 33,  108 => 32,  104 => 31,  99 => 30,  97 => 29,  94 => 28,  91 => 27,  88 => 26,  85 => 25,  82 => 24,  80 => 23,  73 => 22,  71 => 21,  63 => 18,  59 => 17,  55 => 16,  52 => 15,  44 => 10,  40 => 9,  36 => 8,  29 => 6,  26 => 5,  24 => 4,  19 => 1,);
    }
}
/* <div id="job_actions">*/
/*     <h3>Admin</h3>*/
/*     <ul>*/
/*         {% if not job.isActivated %}*/
/*             <ul>*/
/*                 <li><a href={{ path('erlem_job_edit', { 'token': job.token }) }}>{% trans %}Edit{% endtrans %}</a></li>*/
/*                 <li>*/
/*                     <form action={{ path('erlem_job_publish', { 'token': job.token }) }} method="post">*/
/*                         {{ form_widget(publish_form) }}*/
/*                             <button type="submit">{% trans %}Publish{% endtrans %}</button>*/
/*                     </form>*/
/*                 </li>*/
/*             </ul>*/
/*         {% endif %}*/
/*         <li>*/
/*             <form action={{ path('erlem_job_delete', { 'token': job.token }) }} method="post">*/
/*                 {{ form_widget(delete_form) }}*/
/*                     <button type="submit" onclick="if(!confirm('{% trans %}Are you sure?{% endtrans %}')) { return false; }">{% trans %}Delete{% endtrans %}</button>*/
/*             </form>*/
/*         </li>*/
/*         {% if job.isActivated %}*/
/*             <li {% if job.expiresSoon %} class="expires_soon" {% endif %}>*/
/*                 {% if job.isExpired %}*/
/*                     {% trans %}Expired{% endtrans %}*/
/*                 {% else %}*/
/*                     {% trans with {'%count%':'<strong>' ~ job.getDaysBeforeExpires ~ '</strong>' } %}Expires in %count% days{% endtrans %}*/
/*                 {% endif %}*/
/*  */
/*                 {% if job.expiresSoon %}*/
/*                     <form action={{ path('erlem_job_extend', { 'token': job.token }) }} method="post">*/
/*                         {{ form_widget(extend_form) }}*/
/*                             <button type="submit" value="Extend">{% trans %}Extend{% endtrans %}</button> {% trans %}for another 30 days{% endtrans %}*/
/*                     </form>*/
/*                 {% endif %}*/
/*             </li>*/
/*         {% else %}*/
/*             <li>*/
/*                 [{% trans with {'%url%': '<a href="' ~ url('erlem_job_preview', { 'token': job.token, 'company': job.companyslug, 'location': job.locationslug, 'position': job.positionslug }) ~ '">URL</a>'} %}Bookmark this %url% to manage this job in the future{% endtrans %}.]*/
/*             </li>*/
/*         {% endif %}*/
/*     </ul>*/
/* </div>*/
