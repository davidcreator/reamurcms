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

/* install/view/template/install/step_1.twig */
class __TwigTemplate_5f687ef06ad7602a1d511275eb3ed048 extends Template
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
        yield ($context["header"] ?? null);
        yield "
<main id=\"content\" role=\"main\">
\t<div class=\"page-header\">
\t\t<div class=\"container\">
\t\t\t<div class=\"float-end\">";
        // line 5
        yield ($context["language"] ?? null);
        yield "</div>
\t\t\t<h1>";
        // line 6
        yield ($context["heading_title"] ?? null);
        yield "</h1>
\t\t</div>
\t</div>
\t<div class=\"container\">
\t\t<div class=\"card\">
\t\t\t<div class=\"card-header\">
\t\t\t\t<i class=\"fab fa-reamurcms\" aria-hidden=\"true\"></i>
\t\t\t\t<span class=\"ms-2\">";
        // line 13
        yield ($context["text_step_1"] ?? null);
        yield "</span>
\t\t\t</div>
\t\t\t<div class=\"card-body\">
\t\t\t\t<div class=\"form-control overflow-auto\" style=\"max-height: 300px;\" tabindex=\"0\" aria-label=\"";
        // line 16
        yield ($context["text_step_1"] ?? null);
        yield "\">
\t\t\t\t\t";
        // line 17
        yield ($context["text_terms"] ?? null);
        yield "
\t\t\t\t</div>
\t\t\t\t<div class=\"row mt-3\">
\t\t\t\t\t<div class=\"col text-end\">
\t\t\t\t\t\t<a href=\"";
        // line 21
        yield ($context["continue"] ?? null);
        yield "\" class=\"btn btn-primary\" role=\"button\">";
        yield ($context["button_continue"] ?? null);
        yield "</a>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
</main>
";
        // line 28
        yield ($context["footer"] ?? null);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "install/view/template/install/step_1.twig";
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
        return array (  92 => 28,  80 => 21,  73 => 17,  69 => 16,  63 => 13,  53 => 6,  49 => 5,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "install/view/template/install/step_1.twig", "E:\\wamp64\\www\\reamur\\install\\view\\template\\install\\step_1.twig");
    }
}
