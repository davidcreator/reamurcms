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

/* admin/view/template/localisation/tax_rate_list.twig */
class __TwigTemplate_30311887673c946343986208b287a257 extends Template
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
        yield "<form id=\"form-tax-rate\" method=\"post\" data-rms-toggle=\"ajax\" data-rms-load=\"";
        yield ($context["action"] ?? null);
        yield "\" data-rms-target=\"#tax-rate\">
  <div class=\"table-responsive\">
    <table class=\"table table-bordered table-hover\">
      <thead>
        <tr>
          <td class=\"text-center\" style=\"width: 1px;\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\'selected\\']').prop('checked', \$(this).prop('checked'));\" class=\"form-check-input\"/></td>
          <td class=\"text-start\"><a href=\"";
        // line 7
        yield ($context["sort_name"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "tr.name")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_name"] ?? null);
        yield "</a></td>
          <td class=\"text-end\"><a href=\"";
        // line 8
        yield ($context["sort_rate"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "tr.rate")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_rate"] ?? null);
        yield "</a></td>
          <td class=\"text-start\"><a href=\"";
        // line 9
        yield ($context["sort_type"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "tr.type")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_type"] ?? null);
        yield "</a></td>
          <td class=\"text-start\"><a href=\"";
        // line 10
        yield ($context["sort_geo_zone"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "gz.name")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_geo_zone"] ?? null);
        yield "</a></td>
          <td class=\"text-start d-none d-lg-table-cell\"><a href=\"";
        // line 11
        yield ($context["sort_date_added"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "tr.date_added")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_date_added"] ?? null);
        yield "</a></td>
          <td class=\"text-start d-none d-lg-table-cell\"><a href=\"";
        // line 12
        yield ($context["sort_date_modified"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "tr.date_modified")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_date_modified"] ?? null);
        yield "</a></td>
          <td class=\"text-end\">";
        // line 13
        yield ($context["column_action"] ?? null);
        yield "</td>
        </tr>
      </thead>
      <tbody>
        ";
        // line 17
        if ((($tmp = ($context["tax_rates"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 18
            yield "          ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["tax_rates"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["tax_rate"]) {
                // line 19
                yield "            <tr>
              <td class=\"text-center\"><input type=\"checkbox\" name=\"selected[]\" value=\"";
                // line 20
                yield CoreExtension::getAttribute($this->env, $this->source, $context["tax_rate"], "tax_rate_id", [], "any", false, false, false, 20);
                yield "\" class=\"form-check-input\"/></td>
              <td class=\"text-start\">";
                // line 21
                yield CoreExtension::getAttribute($this->env, $this->source, $context["tax_rate"], "name", [], "any", false, false, false, 21);
                yield "</td>
              <td class=\"text-end\">";
                // line 22
                yield CoreExtension::getAttribute($this->env, $this->source, $context["tax_rate"], "rate", [], "any", false, false, false, 22);
                yield "</td>
              <td class=\"text-start\">";
                // line 23
                yield CoreExtension::getAttribute($this->env, $this->source, $context["tax_rate"], "type", [], "any", false, false, false, 23);
                yield "</td>
              <td class=\"text-start\">";
                // line 24
                yield CoreExtension::getAttribute($this->env, $this->source, $context["tax_rate"], "geo_zone", [], "any", false, false, false, 24);
                yield "</td>
              <td class=\"text-start d-none d-lg-table-cell\">";
                // line 25
                yield CoreExtension::getAttribute($this->env, $this->source, $context["tax_rate"], "date_added", [], "any", false, false, false, 25);
                yield "</td>
              <td class=\"text-start d-none d-lg-table-cell\">";
                // line 26
                yield CoreExtension::getAttribute($this->env, $this->source, $context["tax_rate"], "date_modified", [], "any", false, false, false, 26);
                yield "</td>
              <td class=\"text-end\"><a href=\"";
                // line 27
                yield CoreExtension::getAttribute($this->env, $this->source, $context["tax_rate"], "edit", [], "any", false, false, false, 27);
                yield "\" data-bs-toggle=\"tooltip\" title=\"";
                yield ($context["button_edit"] ?? null);
                yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-pencil\"></i></a></td>
            </tr>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['tax_rate'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 30
            yield "        ";
        } else {
            // line 31
            yield "          <tr>
            <td class=\"text-center\" colspan=\"9\">";
            // line 32
            yield ($context["text_no_results"] ?? null);
            yield "</td>
          </tr>
        ";
        }
        // line 35
        yield "      </tbody>
    </table>
  </div>
  <div class=\"row\">
    <div class=\"col-sm-6 text-start\">";
        // line 39
        yield ($context["pagination"] ?? null);
        yield "</div>
    <div class=\"col-sm-6 text-end\">";
        // line 40
        yield ($context["results"] ?? null);
        yield "</div>
  </div>
</form>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/view/template/localisation/tax_rate_list.twig";
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
        return array (  202 => 40,  198 => 39,  192 => 35,  186 => 32,  183 => 31,  180 => 30,  169 => 27,  165 => 26,  161 => 25,  157 => 24,  153 => 23,  149 => 22,  145 => 21,  141 => 20,  138 => 19,  133 => 18,  131 => 17,  124 => 13,  112 => 12,  100 => 11,  88 => 10,  76 => 9,  64 => 8,  52 => 7,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/localisation/tax_rate_list.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\localisation\\tax_rate_list.twig");
    }
}
