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

/* catalog/view/template/account/transaction.twig */
class __TwigTemplate_b3705dbe6f042997274a4d8fa558091d extends Template
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
<div id=\"account-transaction\" class=\"container\">
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
      <table class=\"table table-bordered table-hover\">
        <thead>
          <tr>
            <td class=\"text-start\">";
        // line 15
        yield ($context["column_date_added"] ?? null);
        yield "</td>
            <td class=\"text-start\">";
        // line 16
        yield ($context["column_description"] ?? null);
        yield "</td>
            <td class=\"text-end\">";
        // line 17
        yield ($context["column_amount"] ?? null);
        yield "</td>
          </tr>
        </thead>
        <tbody>
          ";
        // line 21
        if ((($tmp = ($context["transactions"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 22
            yield "            ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["transactions"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["transaction"]) {
                // line 23
                yield "              <tr>
                <td class=\"text-start\">";
                // line 24
                yield CoreExtension::getAttribute($this->env, $this->source, $context["transaction"], "date_added", [], "any", false, false, false, 24);
                yield "</td>
                <td class=\"text-start\">";
                // line 25
                yield CoreExtension::getAttribute($this->env, $this->source, $context["transaction"], "description", [], "any", false, false, false, 25);
                yield "</td>
                <td class=\"text-end\">";
                // line 26
                yield CoreExtension::getAttribute($this->env, $this->source, $context["transaction"], "amount", [], "any", false, false, false, 26);
                yield "</td>
              </tr>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['transaction'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 29
            yield "          ";
        } else {
            // line 30
            yield "            <tr>
              <td class=\"text-center\" colspan=\"5\">";
            // line 31
            yield ($context["text_no_results"] ?? null);
            yield "</td>
            </tr>
          ";
        }
        // line 34
        yield "        </tbody>
      </table>
      <div class=\"row mb-3\">
        <div class=\"col-sm-6 text-start\">";
        // line 37
        yield ($context["pagination"] ?? null);
        yield "</div>
        <div class=\"col-sm-6 text-end\">";
        // line 38
        yield ($context["results"] ?? null);
        yield "</div>
      </div>
      <div class=\"text-end\"><a href=\"";
        // line 40
        yield ($context["continue"] ?? null);
        yield "\" class=\"btn btn-primary\">";
        yield ($context["button_continue"] ?? null);
        yield "</a></div>
      ";
        // line 41
        yield ($context["content_bottom"] ?? null);
        yield "</div>
    ";
        // line 42
        yield ($context["column_right"] ?? null);
        yield "</div>
</div>
";
        // line 44
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
        return "catalog/view/template/account/transaction.twig";
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
        return array (  170 => 44,  165 => 42,  161 => 41,  155 => 40,  150 => 38,  146 => 37,  141 => 34,  135 => 31,  132 => 30,  129 => 29,  120 => 26,  116 => 25,  112 => 24,  109 => 23,  104 => 22,  102 => 21,  95 => 17,  91 => 16,  87 => 15,  78 => 11,  74 => 10,  70 => 9,  66 => 8,  63 => 7,  52 => 5,  48 => 4,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "catalog/view/template/account/transaction.twig", "E:\\wamp64\\www\\reamur\\catalog\\view\\template\\account\\transaction.twig");
    }
}
