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

/* admin/view/template/marketing/affiliate_list.twig */
class __TwigTemplate_b324342b28afe826cbaca8121a0a3c64 extends Template
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
        yield "<form id=\"form-affiliate\" method=\"post\" data-rms-load=\"";
        yield ($context["action"] ?? null);
        yield "\" data-rms-target=\"#affiliate\">
\t<div class=\"table-responsive\">
\t\t<table class=\"table table-bordered table-hover\">
\t\t\t<thead>
\t\t\t\t<tr>
\t\t\t\t\t<td class=\"text-center\" style=\"width: 1px;\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\'selected\\']').prop('checked', \$(this).prop('checked'));\" class=\"form-check-input\"/></td>
\t\t\t\t\t<td class=\"text-start\"><a href=\"";
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
\t\t\t\t\t<td class=\"text-start d-none d-lg-table-cell\"><a href=\"";
        // line 8
        yield ($context["sort_tracking"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "ca.tracking")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_tracking"] ?? null);
        yield "</a></td>
\t\t\t\t\t<td class=\"text-end\"><a href=\"";
        // line 9
        yield ($context["sort_commission"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "ca.commission")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_commission"] ?? null);
        yield "</a></td>
\t\t\t\t\t<td class=\"text-end d-none d-lg-table-cell\">";
        // line 10
        yield ($context["column_balance"] ?? null);
        yield "</td>
\t\t\t\t\t<td class=\"text-start d-none d-lg-table-cell\"><a href=\"";
        // line 11
        yield ($context["sort_date_added"] ?? null);
        yield "\"";
        if ((($context["sort"] ?? null) == "ca.date_added")) {
            yield " class=\"";
            yield Twig\Extension\CoreExtension::lower($this->env->getCharset(), ($context["order"] ?? null));
            yield "\"";
        }
        yield ">";
        yield ($context["column_date_added"] ?? null);
        yield "</a></td>
\t\t\t\t\t<td class=\"text-end\">";
        // line 12
        yield ($context["column_action"] ?? null);
        yield "</td>
\t\t\t\t</tr>
\t\t\t</thead>
\t\t\t<tbody>
\t\t\t\t";
        // line 16
        if ((($tmp = ($context["affiliates"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 17
            yield "\t\t\t\t\t";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["affiliates"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["affiliate"]) {
                // line 18
                yield "\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t<td class=\"text-center\"><input type=\"checkbox\" name=\"selected[]\" value=\"";
                // line 19
                yield CoreExtension::getAttribute($this->env, $this->source, $context["affiliate"], "customer_id", [], "any", false, false, false, 19);
                yield "\" class=\"form-check-input\"/></td>
\t\t\t\t\t\t\t<td class=\"text-start\"><a href=\"";
                // line 20
                yield CoreExtension::getAttribute($this->env, $this->source, $context["affiliate"], "customer", [], "any", false, false, false, 20);
                yield "\">";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["affiliate"], "name", [], "any", false, false, false, 20);
                yield "</a>
\t\t\t\t\t\t\t\t\t<br/>
\t\t\t\t\t\t\t\t\t";
                // line 22
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["affiliate"], "status", [], "any", false, false, false, 22)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 23
                    yield "\t\t\t\t\t\t\t\t\t\t<small class=\"text-success\">";
                    yield ($context["text_enabled"] ?? null);
                    yield "</small>
\t\t\t\t\t\t\t\t\t";
                } else {
                    // line 25
                    yield "\t\t\t\t\t\t\t\t\t\t<small class=\"text-danger\">";
                    yield ($context["text_disabled"] ?? null);
                    yield "</small>
\t\t\t\t\t\t\t\t\t";
                }
                // line 27
                yield "\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t<td class=\"text-start d-none d-lg-table-cell\">";
                // line 28
                yield CoreExtension::getAttribute($this->env, $this->source, $context["affiliate"], "tracking", [], "any", false, false, false, 28);
                yield "</td>
\t\t\t\t\t\t\t<td class=\"text-end\">";
                // line 29
                yield CoreExtension::getAttribute($this->env, $this->source, $context["affiliate"], "commission", [], "any", false, false, false, 29);
                yield "</td>
\t\t\t\t\t\t\t<td class=\"text-end d-none d-lg-table-cell\">";
                // line 30
                yield CoreExtension::getAttribute($this->env, $this->source, $context["affiliate"], "balance", [], "any", false, false, false, 30);
                yield "</td>
\t\t\t\t\t\t\t<td class=\"text-start d-none d-lg-table-cell\">";
                // line 31
                yield CoreExtension::getAttribute($this->env, $this->source, $context["affiliate"], "date_added", [], "any", false, false, false, 31);
                yield "</td>
\t\t\t\t\t\t\t<td class=\"text-end\"><a href=\"";
                // line 32
                yield CoreExtension::getAttribute($this->env, $this->source, $context["affiliate"], "edit", [], "any", false, false, false, 32);
                yield "\" data-bs-toggle=\"tooltip\" title=\"";
                yield ($context["button_edit"] ?? null);
                yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-pencil\"></i></a></td>
\t\t\t\t\t\t</tr>
\t\t\t\t\t";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['affiliate'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 35
            yield "\t\t\t\t";
        } else {
            // line 36
            yield "\t\t\t\t\t<tr>
\t\t\t\t\t\t<td class=\"text-center\" colspan=\"8\">";
            // line 37
            yield ($context["text_no_results"] ?? null);
            yield "</td>
\t\t\t\t\t</tr>
\t\t\t\t";
        }
        // line 40
        yield "\t\t\t</tbody>
\t\t</table>
\t</div>
\t<div class=\"row\">
\t\t<div class=\"col-sm-6 text-start\">";
        // line 44
        yield ($context["pagination"] ?? null);
        yield "</div>
\t\t<div class=\"col-sm-6 text-end\">";
        // line 45
        yield ($context["results"] ?? null);
        yield "</div>
\t</div>
</form>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/view/template/marketing/affiliate_list.twig";
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
        return array (  198 => 45,  194 => 44,  188 => 40,  182 => 37,  179 => 36,  176 => 35,  165 => 32,  161 => 31,  157 => 30,  153 => 29,  149 => 28,  146 => 27,  140 => 25,  134 => 23,  132 => 22,  125 => 20,  121 => 19,  118 => 18,  113 => 17,  111 => 16,  104 => 12,  92 => 11,  88 => 10,  76 => 9,  64 => 8,  52 => 7,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/marketing/affiliate_list.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\marketing\\affiliate_list.twig");
    }
}
