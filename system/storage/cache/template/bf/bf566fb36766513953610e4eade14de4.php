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

/* admin/view/template/customer/customer_list.twig */
class __TwigTemplate_68c9c45c229714ea66fae269b906b38b extends Template
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
        yield "<form id=\"form-customer\" method=\"post\" data-rms-toggle=\"ajax\" data-rms-load=\"";
        yield ($context["action"] ?? null);
        yield "\" data-rms-target=\"#customer\">
  <div class=\"table-responsive\">
    <table class=\"table table-bordered table-hover\">
      <thead>
        <tr>
          <td class=\"text-center\" style=\"width: 1px;\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\'selected\\']').prop('checked', \$(this).prop('checked'));\" class=\"form-check-input\"/></td>
          <td class=\"text-start\"><a href=\"";
        // line 7
        yield ($context["sort_name"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "name")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_name"] ?? null);
        yield "</a></td>
          <td class=\"text-start\"><a href=\"";
        // line 8
        yield ($context["sort_email"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "c.email")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_email"] ?? null);
        yield "</a></td>
          <td class=\"text-start\"><a href=\"";
        // line 9
        yield ($context["sort_customer_group"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "customer_group")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_customer_group"] ?? null);
        yield "</a></td>
          <td class=\"text-start d-none d-lg-table-cell\"><a href=\"";
        // line 10
        yield ($context["sort_date_added"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "c.date_added")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_date_added"] ?? null);
        yield "</a></td>
          <td class=\"text-end\">";
        // line 11
        yield ($context["column_action"] ?? null);
        yield "</td>
        </tr>
      </thead>
      <tbody>
        ";
        // line 15
        if ((($tmp = ($context["customers"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 16
            yield "          ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["customers"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["customer"]) {
                // line 17
                yield "            <tr>
              <td class=\"text-center\"><input type=\"checkbox\" name=\"selected[]\" value=\"";
                // line 18
                yield CoreExtension::getAttribute($this->env, $this->source, $context["customer"], "customer_id", [], "any", false, false, false, 18);
                yield "\" class=\"form-check-input\"/></td>
              <td class=\"text-start\">";
                // line 19
                yield CoreExtension::getAttribute($this->env, $this->source, $context["customer"], "name", [], "any", false, false, false, 19);
                yield "
                <br/>
                ";
                // line 21
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["customer"], "status", [], "any", false, false, false, 21)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 22
                    yield "                  <small class=\"text-success\">";
                    yield ($context["text_enabled"] ?? null);
                    yield "</small>
                ";
                } else {
                    // line 24
                    yield "                  <small class=\"text-danger\">";
                    yield ($context["text_disabled"] ?? null);
                    yield "</small>
                ";
                }
                // line 26
                yield "              </td>
              <td class=\"text-start\">";
                // line 27
                yield CoreExtension::getAttribute($this->env, $this->source, $context["customer"], "email", [], "any", false, false, false, 27);
                yield "</td>
              <td class=\"text-start\">";
                // line 28
                yield CoreExtension::getAttribute($this->env, $this->source, $context["customer"], "customer_group", [], "any", false, false, false, 28);
                yield "</td>
              <td class=\"text-start d-none d-lg-table-cell\">";
                // line 29
                yield CoreExtension::getAttribute($this->env, $this->source, $context["customer"], "date_added", [], "any", false, false, false, 29);
                yield "</td>
              <td class=\"text-end\">
                <div class=\"btn-group dropdown\">
                  <a href=\"";
                // line 32
                yield CoreExtension::getAttribute($this->env, $this->source, $context["customer"], "edit", [], "any", false, false, false, 32);
                yield "\" data-bs-toggle=\"tooltip\" title=\"";
                yield ($context["button_edit"] ?? null);
                yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-pencil\"></i></a>
                  <button type=\"button\" data-bs-toggle=\"dropdown\" class=\"btn btn-primary dropdown-toggle dropdown-toggle-split\"><span class=\"fa-solid fa-caret-down\"></span></button>
                  <ul class=\"dropdown-menu dropdown-menu-end\">
                    <li><h6 class=\"dropdown-header\">";
                // line 35
                yield ($context["text_option"] ?? null);
                yield "</h6></li>
                    ";
                // line 36
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["customer"], "unlock", [], "any", false, false, false, 36)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 37
                    yield "                      <li><a href=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["customer"], "unlock", [], "any", false, false, false, 37);
                    yield "\" class=\"dropdown-item\"><i class=\"fa-solid fa-unlock\"></i> ";
                    yield ($context["text_unlock"] ?? null);
                    yield "</a></li>
                    ";
                } else {
                    // line 39
                    yield "                      <li><a href=\"#\" class=\"dropdown-item disabled\"><i class=\"fa-solid fa-unlock\"></i> ";
                    yield ($context["text_unlock"] ?? null);
                    yield "</a></li>
                    ";
                }
                // line 41
                yield "                    <li>
                      <hr class=\"dropdown-divider\">
                    </li>
                    <li><h6 class=\"dropdown-header\">";
                // line 44
                yield ($context["text_login"] ?? null);
                yield "</h6></li>
                    ";
                // line 45
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["customer"], "store", [], "any", false, false, false, 45));
                foreach ($context['_seq'] as $context["_key"] => $context["store"]) {
                    // line 46
                    yield "                      <li><a href=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["store"], "href", [], "any", false, false, false, 46);
                    yield "\" target=\"_blank\" class=\"dropdown-item\"><i class=\"fa-solid fa-lock\"></i> ";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["store"], "name", [], "any", false, false, false, 46);
                    yield "</a></li>
                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['store'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 48
                yield "                  </ul>
                </div>
              </td>
            </tr>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['customer'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 53
            yield "        ";
        } else {
            // line 54
            yield "          <tr>
            <td class=\"text-center\" colspan=\"7\">";
            // line 55
            yield ($context["text_no_results"] ?? null);
            yield "</td>
          </tr>
        ";
        }
        // line 58
        yield "      </tbody>
    </table>
  </div>
  <div class=\"row\">
    <div class=\"col-sm-6 text-start\">";
        // line 62
        yield ($context["pagination"] ?? null);
        yield "</div>
    <div class=\"col-sm-6 text-end\">";
        // line 63
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
        return "admin/view/template/customer/customer_list.twig";
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
        return array (  241 => 63,  237 => 62,  231 => 58,  225 => 55,  222 => 54,  219 => 53,  209 => 48,  198 => 46,  194 => 45,  190 => 44,  185 => 41,  179 => 39,  171 => 37,  169 => 36,  165 => 35,  157 => 32,  151 => 29,  147 => 28,  143 => 27,  140 => 26,  134 => 24,  128 => 22,  126 => 21,  121 => 19,  117 => 18,  114 => 17,  109 => 16,  107 => 15,  100 => 11,  88 => 10,  76 => 9,  64 => 8,  52 => 7,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/customer/customer_list.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\customer\\customer_list.twig");
    }
}
