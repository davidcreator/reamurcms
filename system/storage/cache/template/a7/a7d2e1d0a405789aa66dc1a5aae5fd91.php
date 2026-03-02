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

/* install/view/template/common/language.twig */
class __TwigTemplate_082adcc1d89b01453e15b3999496b4a3 extends Template
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
        yield "<div class=\"float-end dropdown\">
  <button class=\"btn btn-light dropdown-toggle\" type=\"button\" id=\"languageDropdown\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\" aria-label=\"";
        // line 2
        yield ($context["text_language"] ?? null);
        yield "\">
    ";
        // line 3
        yield ($context["text_language"] ?? null);
        yield " <i class=\"fa-solid fa-caret-down fa-fw\" aria-hidden=\"true\"></i>
  </button>
  <ul class=\"dropdown-menu dropdown-menu-end\" aria-labelledby=\"languageDropdown\">
    ";
        // line 6
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["languages"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
            // line 7
            yield "      <li>
        <a href=\"";
            // line 8
            yield CoreExtension::getAttribute($this->env, $this->source, $context["language"], "href", [], "any", false, false, false, 8);
            yield "\" class=\"dropdown-item";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 8) == ($context["code"] ?? null))) {
                yield " active";
            }
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 8) == ($context["code"] ?? null))) {
                yield "aria-current=\"true\"";
            }
            yield ">
          <img src=\"language/";
            // line 9
            yield CoreExtension::getAttribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 9);
            yield "/";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["language"], "code", [], "any", false, false, false, 9);
            yield ".png\" alt=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["language"], "text", [], "any", false, false, false, 9);
            yield "\" width=\"16\" height=\"11\" loading=\"lazy\"/> 
          <span>";
            // line 10
            yield CoreExtension::getAttribute($this->env, $this->source, $context["language"], "text", [], "any", false, false, false, 10);
            yield "</span>
        </a>
      </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['language'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        yield "  </ul>
</div>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "install/view/template/common/language.twig";
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
        return array (  92 => 14,  82 => 10,  74 => 9,  62 => 8,  59 => 7,  55 => 6,  49 => 3,  45 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "install/view/template/common/language.twig", "E:\\wamp64\\www\\reamur\\install\\view\\template\\common\\language.twig");
    }
}
