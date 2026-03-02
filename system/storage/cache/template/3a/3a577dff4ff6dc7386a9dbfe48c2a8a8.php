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

/* install/view/template/error/not_found.twig */
class __TwigTemplate_61558b6cb0a5a5d4a351caab72eb0111 extends Template
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
<div id=\"error-not-found\" class=\"container\">
\t<ul class=\"breadcrumb\">
\t\t";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 5
            yield "\t\t\t<li class=\"breadcrumb-item\"><a href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 5);
            yield "\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 5);
            yield "</a></li>
\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['breadcrumb'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 7
        yield "\t</ul>
\t<div class=\"row\">";
        // line 8
        yield ($context["column_left"] ?? null);
        yield "
\t\t<div id=\"content\" class=\"col\">";
        // line 9
        yield ($context["content_top"] ?? null);
        yield "
\t\t\t<h1>";
        // line 10
        yield ($context["heading_title"] ?? null);
        yield "</h1>
\t\t\t<p>";
        // line 11
        yield ($context["text_error"] ?? null);
        yield "</p>
\t\t\t<div class=\"d-inline-block pt-2 pd-2 w-100\">
\t\t\t\t<div class=\"float-end\"><a href=\"";
        // line 13
        yield ($context["continue"] ?? null);
        yield "\" class=\"btn btn-primary\">";
        yield ($context["button_continue"] ?? null);
        yield "</a></div>
\t\t\t</div>
\t\t\t";
        // line 15
        yield ($context["content_bottom"] ?? null);
        yield "</div>
\t\t";
        // line 16
        yield ($context["column_right"] ?? null);
        yield "</div>
</div>
";
        // line 18
        yield ($context["footer"] ?? null);
        yield "
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "install/view/template/error/not_found.twig";
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
        return array (  99 => 18,  94 => 16,  90 => 15,  83 => 13,  78 => 11,  74 => 10,  70 => 9,  66 => 8,  63 => 7,  52 => 5,  48 => 4,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "install/view/template/error/not_found.twig", "E:\\wamp64\\www\\reamur\\install\\view\\template\\error\\not_found.twig");
    }
}
