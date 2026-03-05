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

/* admin/view/template/cms/mooc_course_list.twig */
class __TwigTemplate_a7ed4924a7f1a9b1253c0f0b6cfc65a0 extends Template
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
";
        // line 2
        yield ($context["column_left"] ?? null);
        yield "
<div id=\"content\">
  <div class=\"page-header\">
    <div class=\"container-fluid\">
      <div class=\"pull-right\">
        <a href=\"";
        // line 7
        yield ($context["add"] ?? null);
        yield "\" class=\"btn btn-primary\"><i class=\"fa fa-plus\"></i> ";
        yield ($context["text_add"] ?? null);
        yield "</a>
        <button type=\"submit\" form=\"form-course\" formaction=\"";
        // line 8
        yield ($context["approve"] ?? null);
        yield "\" class=\"btn btn-success\"><i class=\"fa fa-check\"></i> ";
        yield ($context["button_approve"] ?? null);
        yield "</button>
        <button type=\"submit\" form=\"form-course\" formaction=\"";
        // line 9
        yield ($context["delete"] ?? null);
        yield "\" class=\"btn btn-danger\" onclick=\"return confirm('Delete selected?');\"><i class=\"fa fa-trash\"></i></button>
      </div>
      <h1>";
        // line 11
        yield ($context["heading_title"] ?? null);
        yield "</h1>
      <ul class=\"breadcrumb\">
        ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 14
            yield "          <li><a href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 14);
            yield "\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 14);
            yield "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['breadcrumb'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        yield "      </ul>
    </div>
  </div>
  <div class=\"container-fluid\">
    ";
        // line 20
        if ((($tmp = ($context["success"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 21
            yield "      <div class=\"alert alert-success\">";
            yield ($context["success"] ?? null);
            yield "</div>
    ";
        }
        // line 23
        yield "    <div class=\"panel panel-default\">
      <div class=\"panel-heading\"><h3 class=\"panel-title\"><i class=\"fa fa-list\"></i> ";
        // line 24
        yield ($context["text_list"] ?? null);
        yield "</h3></div>
      <div class=\"panel-body\">
        <form action=\"";
        // line 26
        yield ($context["delete"] ?? null);
        yield "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-course\">
          <div class=\"table-responsive\">
            <table class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <td style=\"width:1px;\" class=\"text-center\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\\\'selected\\\\']').prop('checked', this.checked);\" /></td>
                  <td>";
        // line 32
        yield ($context["column_title"] ?? null);
        yield "</td>
                  <td>";
        // line 33
        yield ($context["column_category"] ?? null);
        yield "</td>
                  <td>";
        // line 34
        yield ($context["column_instructor"] ?? null);
        yield "</td>
                  <td>";
        // line 35
        yield ($context["column_level"] ?? null);
        yield "</td>
                  <td>";
        // line 36
        yield ($context["column_status"] ?? null);
        yield "</td>
                  <td>";
        // line 37
        yield ($context["column_date"] ?? null);
        yield "</td>
                  <td class=\"text-right\">";
        // line 38
        yield ($context["column_action"] ?? null);
        yield "</td>
                </tr>
              </thead>
              <tbody>
                ";
        // line 42
        if ((($tmp = ($context["courses"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 43
            yield "                  ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["courses"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["course"]) {
                // line 44
                yield "                    <tr>
                      <td class=\"text-center\"><input type=\"checkbox\" name=\"selected[]\" value=\"";
                // line 45
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "course_id", [], "any", false, false, false, 45);
                yield "\" /></td>
                      <td>";
                // line 46
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "title", [], "any", false, false, false, 46);
                yield "</td>
                      <td>";
                // line 47
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "categories", [], "any", false, false, false, 47);
                yield "</td>
                      <td>";
                // line 48
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "instructors", [], "any", false, false, false, 48);
                yield "</td>
                      <td>";
                // line 49
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "level", [], "any", false, false, false, 49);
                yield "</td>
                      <td>
                        ";
                // line 51
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["course"], "status", [], "any", false, false, false, 51) == "published")) {
                    // line 52
                    yield "                          <span class=\"badge bg-success\">";
                    yield ($context["text_published"] ?? null);
                    yield "</span>
                        ";
                } elseif ((CoreExtension::getAttribute($this->env, $this->source,                 // line 53
$context["course"], "status", [], "any", false, false, false, 53) == "draft")) {
                    // line 54
                    yield "                          <span class=\"badge bg-secondary\">";
                    yield ($context["text_draft"] ?? null);
                    yield "</span>
                        ";
                } else {
                    // line 56
                    yield "                          ";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "status", [], "any", false, false, false, 56);
                    yield "
                        ";
                }
                // line 58
                yield "                      </td>
                      <td>";
                // line 59
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "date_added", [], "any", false, false, false, 59);
                yield "</td>
                      <td class=\"text-right\">
                        <a href=\"";
                // line 61
                yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "edit", [], "any", false, false, false, 61);
                yield "\" class=\"btn btn-primary btn-sm\"><i class=\"fa fa-pencil\"></i></a>
                      </td>
                    </tr>
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['course'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 65
            yield "                ";
        } else {
            // line 66
            yield "                  <tr><td colspan=\"8\" class=\"text-center\">";
            yield ($context["text_no_results"] ?? null);
            yield "</td></tr>
                ";
        }
        // line 68
        yield "              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 76
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
        return "admin/view/template/cms/mooc_course_list.twig";
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
        return array (  242 => 76,  232 => 68,  226 => 66,  223 => 65,  213 => 61,  208 => 59,  205 => 58,  199 => 56,  193 => 54,  191 => 53,  186 => 52,  184 => 51,  179 => 49,  175 => 48,  171 => 47,  167 => 46,  163 => 45,  160 => 44,  155 => 43,  153 => 42,  146 => 38,  142 => 37,  138 => 36,  134 => 35,  130 => 34,  126 => 33,  122 => 32,  113 => 26,  108 => 24,  105 => 23,  99 => 21,  97 => 20,  91 => 16,  80 => 14,  76 => 13,  71 => 11,  66 => 9,  60 => 8,  54 => 7,  46 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/cms/mooc_course_list.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\cms\\mooc_course_list.twig");
    }
}
