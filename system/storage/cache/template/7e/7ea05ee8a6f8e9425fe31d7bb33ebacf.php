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

/* admin/view/template/cms/mooc_instructor_list.twig */
class __TwigTemplate_2a872f0ed2cec64f63169bbf48cd2085 extends Template
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
        yield ($context["column_left"] ?? null);
        yield "
<div id=\"content\">
  <div class=\"page-header\">
    <div class=\"container-fluid\">
      <div class=\"float-end\">
        <a href=\"";
        // line 6
        yield ($context["add"] ?? null);
        yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus\"></i> ";
        yield ($context["text_add"] ?? null);
        yield "</a>
        <button type=\"submit\" form=\"form-instructor\" formaction=\"";
        // line 7
        yield ($context["approve"] ?? null);
        yield "\" class=\"btn btn-success\"><i class=\"fa-solid fa-check\"></i> ";
        yield ($context["button_approve"] ?? null);
        yield "</button>
        <button type=\"submit\" form=\"form-instructor\" formaction=\"";
        // line 8
        yield ($context["delete"] ?? null);
        yield "\" class=\"btn btn-danger\" onclick=\"return confirm('Delete selected?');\"><i class=\"fa-regular fa-trash-can\"></i></button>
      </div>
      <h1>";
        // line 10
        yield ($context["heading_title"] ?? null);
        yield "</h1>
      <ol class=\"breadcrumb\">
        ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 13
            yield "          <li class=\"breadcrumb-item\"><a href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 13);
            yield "\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 13);
            yield "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['breadcrumb'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 15
        yield "      </ol>
    </div>
  </div>
  <div class=\"container-fluid\">
    ";
        // line 19
        if ((($tmp = ($context["success"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 20
            yield "      <div class=\"alert alert-success\">";
            yield ($context["success"] ?? null);
            yield "</div>
    ";
        }
        // line 22
        yield "    <div class=\"card\">
      <div class=\"card-header\"><i class=\"fa-solid fa-users\"></i> ";
        // line 23
        yield ($context["text_list"] ?? null);
        yield "</div>
      <div class=\"card-body\">
        <form id=\"form-instructor\" method=\"post\">
          <div class=\"table-responsive\">
            <table class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <td style=\"width:1%;\" class=\"text-center\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\\\'selected\\\\']').prop('checked', this.checked);\" /></td>
                  <td>";
        // line 31
        yield ($context["column_name"] ?? null);
        yield "</td>
                  <td>";
        // line 32
        yield ($context["column_headline"] ?? null);
        yield "</td>
                  <td>";
        // line 33
        yield ($context["column_user"] ?? null);
        yield "</td>
                  <td>";
        // line 34
        yield ($context["column_status"] ?? null);
        yield "</td>
                  <td class=\"text-end\">";
        // line 35
        yield ($context["column_action"] ?? null);
        yield "</td>
                </tr>
              </thead>
              <tbody>
                ";
        // line 39
        if ((($tmp = ($context["instructors"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 40
            yield "                  ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["instructors"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["instructor"]) {
                // line 41
                yield "                    <tr>
                      <td class=\"text-center\"><input type=\"checkbox\" name=\"selected[]\" value=\"";
                // line 42
                yield CoreExtension::getAttribute($this->env, $this->source, $context["instructor"], "instructor_id", [], "any", false, false, false, 42);
                yield "\"></td>
                      <td>";
                // line 43
                yield CoreExtension::getAttribute($this->env, $this->source, $context["instructor"], "name", [], "any", false, false, false, 43);
                yield "</td>
                      <td>";
                // line 44
                yield CoreExtension::getAttribute($this->env, $this->source, $context["instructor"], "headline", [], "any", false, false, false, 44);
                yield "</td>
                      <td>";
                // line 45
                yield CoreExtension::getAttribute($this->env, $this->source, $context["instructor"], "user_id", [], "any", false, false, false, 45);
                yield "</td>
                      <td>";
                // line 46
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["instructor"], "approved", [], "any", false, false, false, 46)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield "<span class=\"badge bg-success\">";
                    yield ($context["text_approved"] ?? null);
                    yield "</span>";
                } else {
                    yield "<span class=\"badge bg-warning\">";
                    yield ($context["text_pending"] ?? null);
                    yield "</span>";
                }
                yield "</td>
                      <td class=\"text-end\"><a href=\"";
                // line 47
                yield CoreExtension::getAttribute($this->env, $this->source, $context["instructor"], "edit", [], "any", false, false, false, 47);
                yield "\" class=\"btn btn-primary btn-sm\"><i class=\"fa-solid fa-pencil\"></i></a></td>
                    </tr>
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['instructor'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 50
            yield "                ";
        } else {
            // line 51
            yield "                  <tr>
                    <td class=\"text-center\" colspan=\"6\">";
            // line 52
            yield ($context["text_no_results"] ?? null);
            yield "</td>
                  </tr>
                ";
        }
        // line 55
        yield "              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

";
        // line 64
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
        return "admin/view/template/cms/mooc_instructor_list.twig";
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
        return array (  209 => 64,  198 => 55,  192 => 52,  189 => 51,  186 => 50,  177 => 47,  165 => 46,  161 => 45,  157 => 44,  153 => 43,  149 => 42,  146 => 41,  141 => 40,  139 => 39,  132 => 35,  128 => 34,  124 => 33,  120 => 32,  116 => 31,  105 => 23,  102 => 22,  96 => 20,  94 => 19,  88 => 15,  77 => 13,  73 => 12,  68 => 10,  63 => 8,  57 => 7,  51 => 6,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/cms/mooc_instructor_list.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\cms\\mooc_instructor_list.twig");
    }
}
