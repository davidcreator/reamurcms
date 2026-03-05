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

/* catalog/view/template/cms/mooc_list.twig */
class __TwigTemplate_ef85f6e6584e88123940dc9ba8f84d3c extends Template
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
        yield "<h1>";
        yield ($context["heading_title"] ?? null);
        yield "</h1>
";
        // line 2
        if ((($tmp = ($context["courses"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 3
            yield "  <div class=\"course-list\">
    ";
            // line 4
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["courses"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["course"]) {
                // line 5
                yield "      <article class=\"course-card\">
        ";
                // line 6
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["course"], "featured_image", [], "any", false, false, false, 6)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 7
                    yield "          <img src=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "featured_image", [], "any", false, false, false, 7);
                    yield "\" alt=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "title", [], "any", false, false, false, 7);
                    yield "\" class=\"course-thumb\">
        ";
                }
                // line 9
                yield "        <h2><a href=\"";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "href", [], "any", false, false, false, 9);
                yield "\">";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "title", [], "any", false, false, false, 9);
                yield "</a></h2>
        ";
                // line 10
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["course"], "subtitle", [], "any", false, false, false, 10)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<p>";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "subtitle", [], "any", false, false, false, 10);
                    yield "</p>";
                }
                // line 11
                yield "        ";
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["course"], "instructors", [], "any", false, false, false, 11)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<p>";
                    yield ($context["text_instructor"] ?? null);
                    yield ": ";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "instructors", [], "any", false, false, false, 11);
                    yield "</p>";
                }
                // line 12
                yield "        ";
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["course"], "categories", [], "any", false, false, false, 12)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<p>";
                    yield ($context["text_categories"] ?? null);
                    yield ": ";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "categories", [], "any", false, false, false, 12);
                    yield "</p>";
                }
                // line 13
                yield "        <p>";
                yield ($context["text_level"] ?? null);
                yield ": ";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "level", [], "any", false, false, false, 13);
                yield " · ";
                yield ($context["text_duration"] ?? null);
                yield ": ";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "duration_minutes", [], "any", false, false, false, 13);
                yield " min";
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["course"], "is_free", [], "any", false, false, false, 13)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield " · ";
                    yield ($context["text_free"] ?? null);
                } else {
                    yield " · ";
                    yield ($context["text_price"] ?? null);
                    yield " ";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "price", [], "any", false, false, false, 13);
                }
                yield "</p>
      </article>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['course'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 16
            yield "  </div>
";
        } else {
            // line 18
            yield "  <p>";
            yield ($context["text_no_results"] ?? null);
            yield "</p>
";
        }
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "catalog/view/template/cms/mooc_list.twig";
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
        return array (  130 => 18,  126 => 16,  100 => 13,  91 => 12,  82 => 11,  76 => 10,  69 => 9,  61 => 7,  59 => 6,  56 => 5,  52 => 4,  49 => 3,  47 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "catalog/view/template/cms/mooc_list.twig", "E:\\wamp64\\www\\reamur\\catalog\\view\\template\\cms\\mooc_list.twig");
    }
}
