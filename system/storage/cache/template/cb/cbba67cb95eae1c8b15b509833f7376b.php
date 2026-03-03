<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* install/view/template/common/header.twig */
class __TwigTemplate_d23428f1d98748dc9702bafb3fcc2199 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html lang=\"";
        // line 2
        yield ($context["lang"] ?? null);
        yield "\">
<head>
    <meta charset=\"UTF-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>";
        // line 7
        yield ($context["title"] ?? null);
        yield "</title>
    <base href=\"";
        // line 8
        yield ($context["base_url"] ?? null);
        yield "\">

    <!-- CSS -->
    <link rel=\"stylesheet\" media=\"screen\" href=\"view/css/bootstrap.css\">   
    <link rel=\"stylesheet\" media=\"screen\" href=\"view/css/bootstrap.css\">
    <link rel=\"stylesheet\" media=\"screen\" href=\"view/css/reamur.css\">
    <link rel=\"stylesheet\" media=\"screen\" href=\"view/css/fonts/fontawesome/css/all.css\">

    <!-- JS -->
    <script type=\"text/javascript\" src=\"view/js/jquery/jquery-3.7.1.min.js\"></script>
    <script type=\"text/javascript\" src=\"view/js/bootstrap/js/bootstrap.bundle.js\"></script>
    <script type=\"text/javascript\" src=\"view/js/common.js\"></script>
</head>
<body>
    <div id=\"container\">
        <header id=\"header\" class=\"navbar navbar-expand navbar-light bg-light\">
            <div class=\"container\">
                <a class=\"navbar-brand d-block\" href=\"";
        // line 25
        yield ($context["home"] ?? null);
        yield "\">
                    <img src=\"view/images/reamurcms.png\" alt=\"ReamurCMS\" title=\"ReamurCMS\">
                </a>                
            </div>
        </header>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "install/view/template/common/header.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  77 => 25,  57 => 8,  53 => 7,  45 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "install/view/template/common/header.twig", "E:\\wamp64\\www\\reamur\\install\\view\\template\\common\\header.twig");
    }
}
