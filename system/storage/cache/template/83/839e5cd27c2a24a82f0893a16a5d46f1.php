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

/* admin/view/template/cms/mooc_quiz_list.twig */
class __TwigTemplate_d20fdd0e6c957c03bec32638447a81e2 extends Template
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
        <button type=\"submit\" form=\"form-quiz\" formaction=\"";
        // line 7
        yield ($context["delete"] ?? null);
        yield "\" class=\"btn btn-danger\" onclick=\"return confirm('Delete selected?');\"><i class=\"fa-regular fa-trash-can\"></i></button>
      </div>
      <h1>";
        // line 9
        yield ($context["heading_title"] ?? null);
        yield "</h1>
      <ol class=\"breadcrumb\">
        ";
        // line 11
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 12
            yield "          <li class=\"breadcrumb-item\"><a href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 12);
            yield "\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 12);
            yield "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['breadcrumb'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        yield "      </ol>
    </div>
  </div>
  <div class=\"container-fluid\">
    ";
        // line 18
        if ((($tmp = ($context["success"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 19
            yield "      <div class=\"alert alert-success\">";
            yield ($context["success"] ?? null);
            yield "</div>
    ";
        }
        // line 21
        yield "    <div class=\"card mb-3\">
      <div class=\"card-body\">
        <form method=\"get\" class=\"row g-3\">
          <input type=\"hidden\" name=\"route\" value=\"cms/mooc_quiz\">
          <input type=\"hidden\" name=\"user_token\" value=\"";
        // line 25
        yield ($context["user_token"] ?? null);
        yield "\">
          <div class=\"col-md-6\">
            <label class=\"form-label\">";
        // line 27
        yield ($context["column_lesson"] ?? null);
        yield "</label>
            <select name=\"lesson_id\" class=\"form-select\" onchange=\"this.form.submit()\">
              <option value=\"0\">-- All --</option>
              ";
        // line 30
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["lessons"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["lesson"]) {
            // line 31
            yield "                <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["lesson"], "lesson_id", [], "any", false, false, false, 31);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["lesson"], "lesson_id", [], "any", false, false, false, 31) == ($context["filter_lesson_id"] ?? null))) {
                yield "selected";
            }
            yield ">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["lesson"], "title", [], "any", false, false, false, 31);
            yield "</option>
              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['lesson'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        yield "            </select>
          </div>
        </form>
      </div>
    </div>
    <div class=\"card\">
      <div class=\"card-header\"><i class=\"fa-solid fa-list\"></i> ";
        // line 39
        yield ($context["text_list"] ?? null);
        yield "</div>
      <div class=\"card-body\">
        <form id=\"form-quiz\" method=\"post\">
          <div class=\"table-responsive\">
            <table class=\"table table-bordered table-hover\">
              <thead>
                <tr>
                  <td style=\"width:1%;\" class=\"text-center\"><input type=\"checkbox\" onclick=\"\$('input[name*=\\\\'selected\\\\']').prop('checked', this.checked);\" /></td>
                  <td>";
        // line 47
        yield ($context["column_title"] ?? null);
        yield "</td>
                  <td>";
        // line 48
        yield ($context["column_lesson"] ?? null);
        yield "</td>
                  <td>";
        // line 49
        yield ($context["column_status"] ?? null);
        yield "</td>
                  <td class=\"text-end\">";
        // line 50
        yield ($context["column_action"] ?? null);
        yield "</td>
                </tr>
              </thead>
              <tbody>
                ";
        // line 54
        if ((($tmp = ($context["quizzes"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 55
            yield "                  ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["quizzes"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["quiz"]) {
                // line 56
                yield "                    <tr>
                      <td class=\"text-center\"><input type=\"checkbox\" name=\"selected[]\" value=\"";
                // line 57
                yield CoreExtension::getAttribute($this->env, $this->source, $context["quiz"], "quiz_id", [], "any", false, false, false, 57);
                yield "\"></td>
                      <td>";
                // line 58
                yield CoreExtension::getAttribute($this->env, $this->source, $context["quiz"], "title", [], "any", false, false, false, 58);
                yield "</td>
                      <td>";
                // line 59
                yield CoreExtension::getAttribute($this->env, $this->source, $context["quiz"], "lesson_title", [], "any", false, false, false, 59);
                yield "</td>
                      <td>";
                // line 60
                yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["quiz"], "status", [], "any", false, false, false, 60)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("Enabled") : ("Disabled"));
                yield "</td>
                      <td class=\"text-end\">
                        <a href=\"";
                // line 62
                yield CoreExtension::getAttribute($this->env, $this->source, $context["quiz"], "edit", [], "any", false, false, false, 62);
                yield "\" class=\"btn btn-primary btn-sm\"><i class=\"fa-solid fa-pencil\"></i></a>
                      </td>
                    </tr>
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['quiz'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 66
            yield "                ";
        } else {
            // line 67
            yield "                  <tr><td colspan=\"5\" class=\"text-center\">";
            yield ($context["text_no_results"] ?? null);
            yield "</td></tr>
                ";
        }
        // line 69
        yield "              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 77
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
        return "admin/view/template/cms/mooc_quiz_list.twig";
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
        return array (  226 => 77,  216 => 69,  210 => 67,  207 => 66,  197 => 62,  192 => 60,  188 => 59,  184 => 58,  180 => 57,  177 => 56,  172 => 55,  170 => 54,  163 => 50,  159 => 49,  155 => 48,  151 => 47,  140 => 39,  132 => 33,  117 => 31,  113 => 30,  107 => 27,  102 => 25,  96 => 21,  90 => 19,  88 => 18,  82 => 14,  71 => 12,  67 => 11,  62 => 9,  57 => 7,  51 => 6,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/cms/mooc_quiz_list.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\cms\\mooc_quiz_list.twig");
    }
}
