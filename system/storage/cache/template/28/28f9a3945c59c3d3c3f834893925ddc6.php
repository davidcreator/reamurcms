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

/* admin/view/template/customer/gdpr_list.twig */
class __TwigTemplate_0925d40246da34f4e3f35acd7d21909e extends Template
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
        yield "<form id=\"form-gdpr\" method=\"post\" data-rms-toggle=\"ajax\" data-rms-load=\"";
        yield ($context["action"] ?? null);
        yield "\" data-rms-target=\"#gdpr\">
  <div class=\"table-responsive\">
    <table class=\"table table-bordered table-hover\">
      <thead>
        <tr>
          <td class=\"text-center\" style=\"width: 1px;\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\'selected\\']').prop('checked', \$(this).prop('checked'));\" class=\"form-check-input\"/></td>
          <td class=\"text-start\">";
        // line 7
        yield ($context["column_email"] ?? null);
        yield "</td>
          <td class=\"text-start\">";
        // line 8
        yield ($context["column_request"] ?? null);
        yield "</td>
          <td class=\"text-start\">";
        // line 9
        yield ($context["column_status"] ?? null);
        yield "</td>
          <td class=\"text-start d-none d-lg-table-cell\">";
        // line 10
        yield ($context["column_date_added"] ?? null);
        yield "</td>
          <td class=\"text-end\">";
        // line 11
        yield ($context["column_action"] ?? null);
        yield "</td>
        </tr>
      </thead>
      <tbody>
        ";
        // line 15
        if ((($tmp = ($context["gdprs"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 16
            yield "          ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["gdprs"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["gdpr"]) {
                // line 17
                yield "            <tr>
              <td class=\"text-center\"><input type=\"checkbox\" name=\"selected[]\" value=\"";
                // line 18
                yield CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "gdpr_id", [], "any", false, false, false, 18);
                yield "\" class=\"form-check-input\"/></td>
              <td class=\"text-start\">
                ";
                // line 20
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "edit", [], "any", false, false, false, 20)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 21
                    yield "                  <a href=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "edit", [], "any", false, false, false, 21);
                    yield "\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "email", [], "any", false, false, false, 21);
                    yield "</a>
                ";
                } else {
                    // line 23
                    yield "                  ";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "email", [], "any", false, false, false, 23);
                    yield "
                ";
                }
                // line 25
                yield "              </td>
              <td class=\"text-start\">";
                // line 26
                yield CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "action", [], "any", false, false, false, 26);
                yield "</td>
              <td class=\"text-start\">
                ";
                // line 28
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "status", [], "any", false, false, false, 28) == "-1")) {
                    // line 29
                    yield "                  <span class=\"badge bg-danger\">";
                    yield ($context["text_denied"] ?? null);
                    yield "</span>
                ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 30
$context["gdpr"], "status", [], "any", false, false, false, 30) == "0")) {
                    // line 31
                    yield "                  <span class=\"badge bg-secondary\">";
                    yield ($context["text_unverified"] ?? null);
                    yield "</span>
                ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 32
$context["gdpr"], "status", [], "any", false, false, false, 32) == "1")) {
                    // line 33
                    yield "                  <span class=\"badge bg-warning\">";
                    yield ($context["text_pending"] ?? null);
                    yield "</span>
                ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 34
$context["gdpr"], "status", [], "any", false, false, false, 34) == "2")) {
                    // line 35
                    yield "                  <span class=\"badge bg-info\">";
                    yield ($context["text_processing"] ?? null);
                    yield "</span>
                ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 36
$context["gdpr"], "status", [], "any", false, false, false, 36) == "3")) {
                    // line 37
                    yield "                  <span class=\"badge bg-success\">";
                    yield ($context["text_complete"] ?? null);
                    yield "</span>
                ";
                }
                // line 38
                yield "</td>
              <td class=\"text-start d-none d-lg-table-cell\">";
                // line 39
                yield CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "date_added", [], "any", false, false, false, 39);
                yield "</td>
              <td class=\"text-end text-nowrap\"><button type=\"button\" value=\"";
                // line 40
                yield CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "approve", [], "any", false, false, false, 40);
                yield "\" data-bs-toggle=\"tooltip\" title=\"";
                yield ($context["text_approve"] ?? null);
                yield "\" class=\"btn btn-success\"><i class=\"fa-solid fa-check\"></i></button>
                <button type=\"button\" value=\"";
                // line 41
                yield CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "deny", [], "any", false, false, false, 41);
                yield "\" data-bs-toggle=\"tooltip\" title=\"";
                yield ($context["text_deny"] ?? null);
                yield "\" class=\"btn btn-warning\"><i class=\"fa-solid fa-circle-xmark\"></i></button>
                <button type=\"button\" value=\"";
                // line 42
                yield CoreExtension::getAttribute($this->env, $this->source, $context["gdpr"], "delete", [], "any", false, false, false, 42);
                yield "\" data-bs-toggle=\"tooltip\" title=\"";
                yield ($context["text_delete"] ?? null);
                yield "\" class=\"btn btn-danger\"><i class=\"fa-regular fa-trash-can\"></i></button></td>
            </tr>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['gdpr'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 45
            yield "        ";
        } else {
            // line 46
            yield "          <tr>
            <td class=\"text-center\" colspan=\"6\">";
            // line 47
            yield ($context["text_no_results"] ?? null);
            yield "</td>
          </tr>
        ";
        }
        // line 50
        yield "      </tbody>
    </table>
  </div>
  <div class=\"row\">
    <div class=\"col-sm-6 text-start\">";
        // line 54
        yield ($context["pagination"] ?? null);
        yield "</div>
    <div class=\"col-sm-6 text-end\">";
        // line 55
        yield ($context["results"] ?? null);
        yield "</div>
  </div>
</form>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/view/template/customer/gdpr_list.twig";
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
        return array (  202 => 55,  198 => 54,  192 => 50,  186 => 47,  183 => 46,  180 => 45,  169 => 42,  163 => 41,  157 => 40,  153 => 39,  150 => 38,  144 => 37,  142 => 36,  137 => 35,  135 => 34,  130 => 33,  128 => 32,  123 => 31,  121 => 30,  116 => 29,  114 => 28,  109 => 26,  106 => 25,  100 => 23,  92 => 21,  90 => 20,  85 => 18,  82 => 17,  77 => 16,  75 => 15,  68 => 11,  64 => 10,  60 => 9,  56 => 8,  52 => 7,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/customer/gdpr_list.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\customer\\gdpr_list.twig");
    }
}
