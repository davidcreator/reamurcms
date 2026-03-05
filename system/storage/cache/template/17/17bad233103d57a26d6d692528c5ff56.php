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

/* admin/view/template/marketplace/event_list.twig */
class __TwigTemplate_aef76711f2fb67b6ce5e1e22d37d3639 extends Template
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
        yield "<form id=\"form-event\" method=\"post\" data-rms-toggle=\"ajax\" data-rms-load=\"";
        yield ($context["action"] ?? null);
        yield "\" data-rms-target=\"#event\">
  <div class=\"table-responsive\">
    <table class=\"table table-bordered table-hover\">
      <thead>
        <tr>
          <td class=\"text-center\" style=\"width: 1px;\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\'selected\\']').prop('checked', \$(this).prop('checked'));\" class=\"form-check-input\"/></td>
          <td class=\"text-start\"><a href=\"";
        // line 7
        yield ($context["sort_code"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "code")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_code"] ?? null);
        yield "</a></td>
          <td class=\"text-end d-none d-lg-table-cell\"><a href=\"";
        // line 8
        yield ($context["sort_sort_order"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "sort_order")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_sort_order"] ?? null);
        yield "</a></td>
          <td class=\"text-end\">";
        // line 9
        yield ($context["column_action"] ?? null);
        yield "</td>
        </tr>
      </thead>
      <tbody>
        ";
        // line 13
        if ((($tmp = ($context["events"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 14
            yield "          ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["events"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                // line 15
                yield "            <tr>
              <td class=\"text-center\"><input type=\"checkbox\" name=\"selected[]\" value=\"";
                // line 16
                yield CoreExtension::getAttribute($this->env, $this->source, $context["event"], "event_id", [], "any", false, false, false, 16);
                yield "\" class=\"form-check-input\"/></td>
              <td class=\"text-start\">";
                // line 17
                yield CoreExtension::getAttribute($this->env, $this->source, $context["event"], "code", [], "any", false, false, false, 17);
                yield "</td>
              <td class=\"text-end d-none d-lg-table-cell\">";
                // line 18
                yield CoreExtension::getAttribute($this->env, $this->source, $context["event"], "sort_order", [], "any", false, false, false, 18);
                yield "</td>
              <td class=\"text-end text-nowrap\"><button type=\"button\" data-rms-description=\"";
                // line 19
                yield CoreExtension::getAttribute($this->env, $this->source, $context["event"], "description", [], "any", false, false, false, 19);
                yield "\" data-rms-trigger=\"";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["event"], "trigger", [], "any", false, false, false, 19);
                yield "\" data-rms-action=\"";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["event"], "action", [], "any", false, false, false, 19);
                yield "\" class=\"btn btn-info\"><i class=\"fa-solid fa-info-circle\"></i></button>
                ";
                // line 20
                if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, $context["event"], "status", [], "any", false, false, false, 20)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 21
                    yield "                  <button type=\"button\" value=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["event"], "enable", [], "any", false, false, false, 21);
                    yield "\" data-bs-toggle=\"tooltip\" title=\"";
                    yield ($context["button_enable"] ?? null);
                    yield "\" class=\"btn btn-success\"><i class=\"fa-solid fa-plus-circle\"></i></button>
                ";
                } else {
                    // line 23
                    yield "                  <button type=\"button\" value=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["event"], "disable", [], "any", false, false, false, 23);
                    yield "\" data-bs-toggle=\"tooltip\" title=\"";
                    yield ($context["button_disable"] ?? null);
                    yield "\" class=\"btn btn-danger\"><i class=\"fa-solid fa-minus-circle\"></i></button>
                ";
                }
                // line 24
                yield "</td>
            </tr>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['event'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 27
            yield "        ";
        } else {
            // line 28
            yield "          <tr>
            <td class=\"text-center\" colspan=\"4\">";
            // line 29
            yield ($context["text_no_results"] ?? null);
            yield "</td>
          </tr>
        ";
        }
        // line 32
        yield "      </tbody>
    </table>
  </div>
  <div class=\"row\">
    <div class=\"col-sm-6 text-start\">";
        // line 36
        yield ($context["pagination"] ?? null);
        yield "</div>
    <div class=\"col-sm-6 text-end\">";
        // line 37
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
        return "admin/view/template/marketplace/event_list.twig";
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
        return array (  161 => 37,  157 => 36,  151 => 32,  145 => 29,  142 => 28,  139 => 27,  131 => 24,  123 => 23,  115 => 21,  113 => 20,  105 => 19,  101 => 18,  97 => 17,  93 => 16,  90 => 15,  85 => 14,  83 => 13,  76 => 9,  64 => 8,  52 => 7,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/marketplace/event_list.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\marketplace\\event_list.twig");
    }
}
