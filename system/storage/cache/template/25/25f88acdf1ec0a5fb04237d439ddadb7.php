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

/* catalog/view/template/cms/mooc_my.twig */
class __TwigTemplate_2d8754d41758ca43d1f706020d30a5b4 extends Template
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
        yield "<section class=\"my-courses\">
  <h1>";
        // line 2
        yield ($context["heading_title"] ?? null);
        yield "</h1>
  ";
        // line 3
        if ((($tmp = ($context["enrollments"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 4
            yield "    <ul class=\"enrollment-list\">
      ";
            // line 5
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["enrollments"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["enrollment"]) {
                // line 6
                yield "        <li>
          <div class=\"course-name\">";
                // line 7
                yield CoreExtension::getAttribute($this->env, $this->source, $context["enrollment"], "title", [], "any", false, false, false, 7);
                yield "</div>
          <div class=\"meta\">
            <span>";
                // line 9
                yield ($context["text_progress"] ?? null);
                yield ": ";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["enrollment"], "progress_percent", [], "any", false, false, false, 9);
                yield "%</span>
            <a class=\"btn btn-sm btn-primary\" href=\"";
                // line 10
                yield CoreExtension::getAttribute($this->env, $this->source, $context["enrollment"], "href", [], "any", false, false, false, 10);
                yield "\">";
                yield ($context["text_view_course"] ?? null);
                yield "</a>
          </div>
        </li>
      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['enrollment'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 14
            yield "    </ul>
  ";
        } else {
            // line 16
            yield "    <p>";
            yield ($context["text_no_enrollments"] ?? null);
            yield "</p>
  ";
        }
        // line 18
        yield "</section>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "catalog/view/template/cms/mooc_my.twig";
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
        return array (  94 => 18,  88 => 16,  84 => 14,  72 => 10,  66 => 9,  61 => 7,  58 => 6,  54 => 5,  51 => 4,  49 => 3,  45 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "catalog/view/template/cms/mooc_my.twig", "E:\\wamp64\\www\\reamur\\catalog\\view\\template\\cms\\mooc_my.twig");
    }
}
