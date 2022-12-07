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

/* base.html.twig */
class __TwigTemplate_c35fc0c55b0621eded9e99b1f1985f91 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'head' => [$this, 'block_head'],
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
            'footer' => [$this, 'block_footer'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        ";
        // line 4
        $this->displayBlock('head', $context, $blocks);
        // line 12
        echo "    </head>
    <body>
        ";
        // line 14
        $this->displayBlock('content', $context, $blocks);
        // line 15
        echo "        <div id=\"footer\">
            ";
        // line 16
        $this->displayBlock('footer', $context, $blocks);
        // line 21
        echo "        </div>
        <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js\"></script>
    </body>
</html>";
    }

    // line 4
    public function block_head($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        echo "            <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
            <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js\"></script>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
            <link rel=\"icon\" type=\"image/x-icon\" href=\"/favicon.ico\">
            <title>";
        // line 10
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
    }

    public function block_title($context, array $blocks = [])
    {
        $macros = $this->macros;
        echo twig_escape_filter($this->env, twig_upper_filter($this->env, ($context["title"] ?? null)), "html", null, true);
    }

    // line 14
    public function block_content($context, array $blocks = [])
    {
        $macros = $this->macros;
    }

    // line 16
    public function block_footer($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 17
        echo "                <footer class=\"bg-dark text-center text-white fixed-bottom\">
                    <p>";
        // line 18
        echo twig_escape_filter($this->env, ($context["author"] ?? null), "html", null, true);
        echo "</p>
                </footer>
            ";
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  102 => 18,  99 => 17,  95 => 16,  89 => 14,  77 => 10,  70 => 5,  66 => 4,  59 => 21,  57 => 16,  54 => 15,  52 => 14,  48 => 12,  46 => 4,  41 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "base.html.twig", "/opt/lampp/irianna/core/views/templates/base.html.twig");
    }
}
