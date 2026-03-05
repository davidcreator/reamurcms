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

/* admin/view/template/cms/mooc_quiz_form.twig */
class __TwigTemplate_797689c1c327fafba6626031de167b0c extends Template
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
        <button type=\"submit\" form=\"form-quiz\" class=\"btn btn-primary\"><i class=\"fa-solid fa-save\"></i> ";
        // line 6
        yield ($context["button_save"] ?? null);
        yield "</button>
        <a href=\"";
        // line 7
        yield ($context["cancel"] ?? null);
        yield "\" class=\"btn btn-light\"><i class=\"fa-solid fa-reply\"></i> ";
        yield ($context["button_cancel"] ?? null);
        yield "</a>
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
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "warning", [], "any", false, false, false, 18)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"alert alert-danger\">";
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "warning", [], "any", false, false, false, 18);
            yield "</div>";
        }
        // line 19
        yield "    <div class=\"card\">
      <div class=\"card-header\"><i class=\"fa-solid fa-clipboard-question\"></i> ";
        // line 20
        yield ($context["text_form"] ?? null);
        yield "</div>
      <div class=\"card-body\">
        <form id=\"form-quiz\" method=\"post\" action=\"";
        // line 22
        yield ($context["action"] ?? null);
        yield "\">
          <div class=\"mb-3\">
            <label class=\"form-label\">";
        // line 24
        yield ($context["entry_lesson"] ?? null);
        yield "</label>
            <select name=\"lesson_id\" class=\"form-select\">
              <option value=\"\">";
        // line 26
        yield ($context["text_no_results"] ?? null);
        yield "</option>
              ";
        // line 27
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["lessons"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["lesson"]) {
            // line 28
            yield "                <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["lesson"], "lesson_id", [], "any", false, false, false, 28);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["lesson"], "lesson_id", [], "any", false, false, false, 28) == CoreExtension::getAttribute($this->env, $this->source, ($context["quiz"] ?? null), "lesson_id", [], "any", false, false, false, 28))) {
                yield "selected";
            }
            yield ">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["lesson"], "title", [], "any", false, false, false, 28);
            yield "</option>
              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['lesson'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 30
        yield "            </select>
            ";
        // line 31
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "lesson_id", [], "any", false, false, false, 31)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"text-danger\">";
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "lesson_id", [], "any", false, false, false, 31);
            yield "</div>";
        }
        // line 32
        yield "          </div>
          <div class=\"mb-3\">
            <label class=\"form-label\">";
        // line 34
        yield ($context["entry_title"] ?? null);
        yield "</label>
            <input type=\"text\" name=\"title\" value=\"";
        // line 35
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["quiz"] ?? null), "title", [], "any", false, false, false, 35);
        yield "\" class=\"form-control\">
            ";
        // line 36
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "title", [], "any", false, false, false, 36)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"text-danger\">";
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "title", [], "any", false, false, false, 36);
            yield "</div>";
        }
        // line 37
        yield "          </div>
          <div class=\"mb-3\">
            <label class=\"form-label\">";
        // line 39
        yield ($context["entry_description"] ?? null);
        yield "</label>
            <textarea name=\"description\" rows=\"3\" class=\"form-control\">";
        // line 40
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["quiz"] ?? null), "description", [], "any", false, false, false, 40);
        yield "</textarea>
          </div>
          <div class=\"row mb-3\">
            <div class=\"col-md-4\">
              <label class=\"form-label\">";
        // line 44
        yield ($context["entry_passing"] ?? null);
        yield "</label>
              <input type=\"number\" name=\"passing_score\" value=\"";
        // line 45
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["quiz"] ?? null), "passing_score", [], "any", false, false, false, 45);
        yield "\" class=\"form-control\" min=\"0\" max=\"100\">
            </div>
            <div class=\"col-md-4\">
              <label class=\"form-label\">";
        // line 48
        yield ($context["entry_time_limit"] ?? null);
        yield "</label>
              <input type=\"number\" name=\"time_limit_seconds\" value=\"";
        // line 49
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["quiz"] ?? null), "time_limit_seconds", [], "any", false, false, false, 49);
        yield "\" class=\"form-control\" min=\"0\" placeholder=\"ex: 900\">
            </div>
            <div class=\"col-md-4\">
              <label class=\"form-label\">";
        // line 52
        yield ($context["entry_status"] ?? null);
        yield "</label>
              <select name=\"status\" class=\"form-select\">
                <option value=\"1\" ";
        // line 54
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["quiz"] ?? null), "status", [], "any", false, false, false, 54)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "selected";
        }
        yield ">Enabled</option>
                <option value=\"0\" ";
        // line 55
        if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, ($context["quiz"] ?? null), "status", [], "any", false, false, false, 55)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "selected";
        }
        yield ">Disabled</option>
              </select>
            </div>
          </div>

          <hr>
          <h5>";
        // line 61
        yield ($context["entry_questions"] ?? null);
        yield "</h5>
          <p class=\"text-muted\">Use opções uma por linha. Para múltipla escolha, o gabarito pode ter várias linhas.</p>
          ";
        // line 63
        $context["questions"] = CoreExtension::getAttribute($this->env, $this->source, ($context["quiz"] ?? null), "questions", [], "any", false, false, false, 63);
        // line 64
        yield "          ";
        if ((($tmp =  !($context["questions"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            $context["questions"] = [[]];
        }
        // line 65
        yield "          ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["questions"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["q"]) {
            // line 66
            yield "            ";
            $context["i"] = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index0", [], "any", false, false, false, 66);
            // line 67
            yield "            <div class=\"card mb-3\">
              <div class=\"card-body\">
                <div class=\"row g-3\">
                  <div class=\"col-md-6\">
                    <label class=\"form-label\">";
            // line 71
            yield ($context["entry_questions"] ?? null);
            yield " #";
            yield (($context["i"] ?? null) + 1);
            yield "</label>
                    <textarea name=\"questions[";
            // line 72
            yield ($context["i"] ?? null);
            yield "][question]\" rows=\"2\" class=\"form-control\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["q"], "question", [], "any", false, false, false, 72);
            yield "</textarea>
                  </div>
                  <div class=\"col-md-3\">
                    <label class=\"form-label\">";
            // line 75
            yield ($context["entry_type"] ?? null);
            yield "</label>
                    <select name=\"questions[";
            // line 76
            yield ($context["i"] ?? null);
            yield "][type]\" class=\"form-select\">
                      <option value=\"single\" ";
            // line 77
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["q"], "type", [], "any", false, false, false, 77) == "single")) {
                yield "selected";
            }
            yield ">";
            yield ($context["text_single"] ?? null);
            yield "</option>
                      <option value=\"multiple\" ";
            // line 78
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["q"], "type", [], "any", false, false, false, 78) == "multiple")) {
                yield "selected";
            }
            yield ">";
            yield ($context["text_multiple"] ?? null);
            yield "</option>
                      <option value=\"true_false\" ";
            // line 79
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["q"], "type", [], "any", false, false, false, 79) == "true_false")) {
                yield "selected";
            }
            yield ">";
            yield ($context["text_true_false"] ?? null);
            yield "</option>
                      <option value=\"text\" ";
            // line 80
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["q"], "type", [], "any", false, false, false, 80) == "text")) {
                yield "selected";
            }
            yield ">";
            yield ($context["text_text"] ?? null);
            yield "</option>
                      <option value=\"file\" ";
            // line 81
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["q"], "type", [], "any", false, false, false, 81) == "file")) {
                yield "selected";
            }
            yield ">";
            yield ($context["text_file"] ?? null);
            yield "</option>
                    </select>
                  </div>
                  <div class=\"col-md-3\">
                    <label class=\"form-label\">";
            // line 85
            yield ($context["entry_points"] ?? null);
            yield "</label>
                    <input type=\"number\" name=\"questions[";
            // line 86
            yield ($context["i"] ?? null);
            yield "][points]\" value=\"";
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["q"], "points", [], "any", true, true, false, 86)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["q"], "points", [], "any", false, false, false, 86), 1)) : (1));
            yield "\" class=\"form-control\" min=\"0\">
                  </div>
                  <div class=\"col-md-6\">
                    <label class=\"form-label\">";
            // line 89
            yield ($context["entry_options"] ?? null);
            yield "</label>
                    <textarea name=\"questions[";
            // line 90
            yield ($context["i"] ?? null);
            yield "][options]\" rows=\"3\" class=\"form-control\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["q"], "options", [], "any", false, false, false, 90);
            yield "</textarea>
                  </div>
                  <div class=\"col-md-6\">
                    <label class=\"form-label\">";
            // line 93
            yield ($context["entry_correct"] ?? null);
            yield "</label>
                    <textarea name=\"questions[";
            // line 94
            yield ($context["i"] ?? null);
            yield "][correct_answer]\" rows=\"2\" class=\"form-control\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["q"], "correct_answer", [], "any", false, false, false, 94);
            yield "</textarea>
                  </div>
                  <div class=\"col-md-3\">
                    <label class=\"form-label\">";
            // line 97
            yield ($context["entry_sort_order"] ?? null);
            yield "</label>
                    <input type=\"number\" name=\"questions[";
            // line 98
            yield ($context["i"] ?? null);
            yield "][sort_order]\" value=\"";
            yield ((CoreExtension::getAttribute($this->env, $this->source, $context["q"], "sort_order", [], "any", true, true, false, 98)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["q"], "sort_order", [], "any", false, false, false, 98), ($context["i"] ?? null))) : (($context["i"] ?? null)));
            yield "\" class=\"form-control\">
                  </div>
                  <div class=\"col-md-3\">
                    <label class=\"form-label\">";
            // line 101
            yield ($context["entry_manual_review"] ?? null);
            yield "</label>
                    <select name=\"questions[";
            // line 102
            yield ($context["i"] ?? null);
            yield "][manual_review]\" class=\"form-select\">
                      <option value=\"0\" ";
            // line 103
            if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, $context["q"], "manual_review", [], "any", false, false, false, 103)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "selected";
            }
            yield ">No</option>
                      <option value=\"1\" ";
            // line 104
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["q"], "manual_review", [], "any", false, false, false, 104)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "selected";
            }
            yield ">Yes</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['q'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 111
        yield "        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 116
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
        return "admin/view/template/cms/mooc_quiz_form.twig";
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
        return array (  415 => 116,  408 => 111,  385 => 104,  379 => 103,  375 => 102,  371 => 101,  363 => 98,  359 => 97,  351 => 94,  347 => 93,  339 => 90,  335 => 89,  327 => 86,  323 => 85,  312 => 81,  304 => 80,  296 => 79,  288 => 78,  280 => 77,  276 => 76,  272 => 75,  264 => 72,  258 => 71,  252 => 67,  249 => 66,  231 => 65,  226 => 64,  224 => 63,  219 => 61,  208 => 55,  202 => 54,  197 => 52,  191 => 49,  187 => 48,  181 => 45,  177 => 44,  170 => 40,  166 => 39,  162 => 37,  156 => 36,  152 => 35,  148 => 34,  144 => 32,  138 => 31,  135 => 30,  120 => 28,  116 => 27,  112 => 26,  107 => 24,  102 => 22,  97 => 20,  94 => 19,  88 => 18,  82 => 14,  71 => 12,  67 => 11,  62 => 9,  55 => 7,  51 => 6,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/cms/mooc_quiz_form.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\cms\\mooc_quiz_form.twig");
    }
}
