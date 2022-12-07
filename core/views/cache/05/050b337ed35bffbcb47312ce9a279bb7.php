<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* login/login.html.twig */
class __TwigTemplate_8b09f654ac8694bc8c0f2764b32819fe extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.html.twig", "login/login.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 4
        echo "    <div class=\"container-xs container-sm container-md container-xl w-100\">
        <div class=\"row w-100 mt-5\">
            <div class=\"col-xs-1 col-sm-2 col-md-3 col-xl-4\"></div>
            <div class=\"col-xs-10 col-sm-8 col-md-6 col-xl-4\">
                <h1 class=\"h1 w-100 m-1\" id=\"main-page-h1\">";
        // line 8
        echo twig_escape_filter($this->env, ($context["message"] ?? null), "html", null, true);
        echo "</h1>
            </div>
            <div class=\"col-xs-1 col-sm-2 col-md-3 col-xl-4\"></div>
        </div>

        <div class=\"row w-100 mt-5\">
            <div class=\"col-xs-1 col-sm-2 col-md-3 col-xl-4\"></div>
            <div class=\"col-xs-10 col-sm-8 col-md-6 col-xl-4\">
                <div class=\"input-group w-100 mb-2\">
                    <span class=\"input-group-text w-25\">Login</span>
                    <input type=\"text\" class=\"form-control\" aria-label=\"Sizing example input\" aria-describedby=\"inputGroup-sizing-default\">
                </div>
                <div class=\"input-group w-100 mb-2\">
                    <span class=\"input-group-text w-25\">Password</span>
                    <input type=\"text\" class=\"form-control\" aria-label=\"Sizing example input\"
                        aria-describedby=\"inputGroup-sizing-default\">
                </div>
                <div class=\"input-group w-100 mb-2\">
                    <button type=\"button\" class=\"btn btn-success w-100\">Login</button>
                </div>
                <div class=\"input-group w-100 mb-2\">
                    <button type=\"button\" class=\"btn btn-secondary w-100\">Register</button>
                </div>
            </div>
            <div class=\"col-xs-1 col-sm-2 col-md-3 col-xl-4\"></div>
        </div>
    </div>
";
    }

    public function getTemplateName()
    {
        return "login/login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  56 => 8,  50 => 4,  46 => 3,  35 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "login/login.html.twig", "/opt/lampp/irianna/core/views/templates/login/login.html.twig");
    }
}
