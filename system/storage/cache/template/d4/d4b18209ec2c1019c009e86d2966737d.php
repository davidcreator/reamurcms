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

/* catalog/view/template/account/reward.twig */
class __TwigTemplate_590b46e69821ec0a15561e9e132cfd42 extends Template
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
<div id=\"account-reward\" class=\"container\">
  <ul class=\"breadcrumb\">
    ";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 5
            yield "      <li class=\"breadcrumb-item\"><a href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 5);
            yield "\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 5);
            yield "</a></li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['breadcrumb'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 7
        yield "  </ul>
  <div class=\"row\">";
        // line 8
        yield ($context["column_left"] ?? null);
        yield "
    <div id=\"content\" class=\"col\">";
        // line 9
        yield ($context["content_top"] ?? null);
        yield "
      <h1>";
        // line 10
        yield ($context["heading_title"] ?? null);
        yield "</h1>
      <p>";
        // line 11
        yield ($context["text_total"] ?? null);
        yield " <b>";
        yield ($context["total"] ?? null);
        yield "</b>.</p>
      <div class=\"table-responsive\">
        <table class=\"table table-bordered table-hover\">
          <thead>
            <tr>
              <th class=\"text-start\">";
        // line 16
        yield ($context["column_date_added"] ?? null);
        yield "</th>
              <th class=\"text-start\">";
        // line 17
        yield ($context["column_description"] ?? null);
        yield "</th>
              <th class=\"text-end\">";
        // line 18
        yield ($context["column_points"] ?? null);
        yield "</th>
            </tr>
          </thead>
          <tbody>
            ";
        // line 22
        if ((($tmp = ($context["rewards"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 23
            yield "              ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["rewards"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["reward"]) {
                // line 24
                yield "                <tr>
                  <td class=\"text-start\">";
                // line 25
                yield CoreExtension::getAttribute($this->env, $this->source, $context["reward"], "date_added", [], "any", false, false, false, 25);
                yield "</td>
                  <td class=\"text-start\">";
                // line 26
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["reward"], "order_id", [], "any", false, false, false, 26)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield " <a href=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["reward"], "href", [], "any", false, false, false, 26);
                    yield "\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["reward"], "description", [], "any", false, false, false, 26);
                    yield "</a> ";
                } else {
                    // line 27
                    yield "                      ";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["reward"], "description", [], "any", false, false, false, 27);
                    yield "
                    ";
                }
                // line 28
                yield "</td>
                  <td class=\"text-end\">";
                // line 29
                yield CoreExtension::getAttribute($this->env, $this->source, $context["reward"], "points", [], "any", false, false, false, 29);
                yield "</td>
                </tr>
              ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['reward'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 32
            yield "            ";
        } else {
            // line 33
            yield "              <tr>
                <td class=\"text-center\" colspan=\"3\">";
            // line 34
            yield ($context["text_no_results"] ?? null);
            yield "</td>
              </tr>
            ";
        }
        // line 37
        yield "          </tbody>
        </table>
      </div>
      <div class=\"row mb-3\">
        <div class=\"col-sm-6 text-start\">";
        // line 41
        yield ($context["pagination"] ?? null);
        yield "</div>
        <div class=\"col-sm-6 text-end\">";
        // line 42
        yield ($context["results"] ?? null);
        yield "</div>
      </div>
      <div class=\"text-end\"><a href=\"";
        // line 44
        yield ($context["continue"] ?? null);
        yield "\" class=\"btn btn-primary\">";
        yield ($context["button_continue"] ?? null);
        yield "</a></div>
      ";
        // line 45
        yield ($context["content_bottom"] ?? null);
        yield "</div>
    ";
        // line 46
        yield ($context["column_right"] ?? null);
        yield "</div>
</div>
";
        // line 48
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
        return "catalog/view/template/account/reward.twig";
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
        return array (  185 => 48,  180 => 46,  176 => 45,  170 => 44,  165 => 42,  161 => 41,  155 => 37,  149 => 34,  146 => 33,  143 => 32,  134 => 29,  131 => 28,  125 => 27,  117 => 26,  113 => 25,  110 => 24,  105 => 23,  103 => 22,  96 => 18,  92 => 17,  88 => 16,  78 => 11,  74 => 10,  70 => 9,  66 => 8,  63 => 7,  52 => 5,  48 => 4,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "catalog/view/template/account/reward.twig", "E:\\wamp64\\www\\reamur\\catalog\\view\\template\\account\\reward.twig");
    }
}
