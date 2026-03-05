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

/* admin/view/template/cms/mooc_lesson_form.twig */
class __TwigTemplate_06caf8e9c57226070a065c9b94247998 extends Template
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
        <button type=\"submit\" form=\"form-lesson\" class=\"btn btn-primary\"><i class=\"fa-solid fa-save\"></i> ";
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
      <div class=\"card-header\"><i class=\"fa-solid fa-book\"></i> ";
        // line 20
        yield ($context["text_form"] ?? null);
        yield "</div>
      <div class=\"card-body\">
        <form id=\"form-lesson\" method=\"post\" action=\"";
        // line 22
        yield ($context["action"] ?? null);
        yield "\">
          <div class=\"row mb-3\">
            <div class=\"col-md-6\">
              <label class=\"form-label\">";
        // line 25
        yield ($context["entry_course"] ?? null);
        yield "</label>
              <select name=\"course_id\" class=\"form-select\">
                <option value=\"\">";
        // line 27
        yield ($context["text_no_results"] ?? null);
        yield "</option>
                ";
        // line 28
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["courses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["course"]) {
            // line 29
            yield "                  <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "course_id", [], "any", false, false, false, 29);
            yield "\" ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["course"], "course_id", [], "any", false, false, false, 29) == CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "course_id", [], "any", false, false, false, 29))) {
                yield "selected";
            }
            yield ">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["course"], "title", [], "any", false, false, false, 29);
            yield "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['course'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        yield "              </select>
              ";
        // line 32
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "course_id", [], "any", false, false, false, 32)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"text-danger\">";
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "course_id", [], "any", false, false, false, 32);
            yield "</div>";
        }
        // line 33
        yield "            </div>
            <div class=\"col-md-6\">
              <label class=\"form-label\">";
        // line 35
        yield ($context["entry_sort_order"] ?? null);
        yield "</label>
              <input type=\"number\" name=\"sort_order\" value=\"";
        // line 36
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "sort_order", [], "any", false, false, false, 36);
        yield "\" class=\"form-control\">
            </div>
          </div>

          <div class=\"row mb-3\">
            <div class=\"col-md-8\">
              <label class=\"form-label\">";
        // line 42
        yield ($context["entry_title"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"title\" value=\"";
        // line 43
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "title", [], "any", false, false, false, 43);
        yield "\" class=\"form-control\">
              ";
        // line 44
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "title", [], "any", false, false, false, 44)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"text-danger\">";
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "title", [], "any", false, false, false, 44);
            yield "</div>";
        }
        // line 45
        yield "            </div>
            <div class=\"col-md-4\">
              <label class=\"form-label\">";
        // line 47
        yield ($context["entry_slug"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"slug\" value=\"";
        // line 48
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "slug", [], "any", false, false, false, 48);
        yield "\" class=\"form-control\">
            </div>
          </div>

          <div class=\"mb-3\">
            <label class=\"form-label\">";
        // line 53
        yield ($context["entry_summary"] ?? null);
        yield "</label>
            <textarea name=\"summary\" rows=\"3\" class=\"form-control\">";
        // line 54
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "summary", [], "any", false, false, false, 54);
        yield "</textarea>
          </div>

          <div class=\"row mb-3\">
            <div class=\"col-md-4\">
              <label class=\"form-label\">";
        // line 59
        yield ($context["entry_content_type"] ?? null);
        yield "</label>
              <select name=\"content_type\" class=\"form-select\">
                <option value=\"video\" ";
        // line 61
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "content_type", [], "any", false, false, false, 61) == "video")) {
            yield "selected";
        }
        yield ">";
        yield ($context["text_video"] ?? null);
        yield "</option>
                <option value=\"article\" ";
        // line 62
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "content_type", [], "any", false, false, false, 62) == "article")) {
            yield "selected";
        }
        yield ">";
        yield ($context["text_article"] ?? null);
        yield "</option>
                <option value=\"quiz\" ";
        // line 63
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "content_type", [], "any", false, false, false, 63) == "quiz")) {
            yield "selected";
        }
        yield ">";
        yield ($context["text_quiz"] ?? null);
        yield "</option>
                <option value=\"live\" ";
        // line 64
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "content_type", [], "any", false, false, false, 64) == "live")) {
            yield "selected";
        }
        yield ">";
        yield ($context["text_live"] ?? null);
        yield "</option>
                <option value=\"slides\" ";
        // line 65
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "content_type", [], "any", false, false, false, 65) == "slides")) {
            yield "selected";
        }
        yield ">";
        yield ($context["text_slides"] ?? null);
        yield "</option>
                <option value=\"pdf\" ";
        // line 66
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "content_type", [], "any", false, false, false, 66) == "pdf")) {
            yield "selected";
        }
        yield ">";
        yield ($context["text_pdf"] ?? null);
        yield "</option>
                <option value=\"link\" ";
        // line 67
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "content_type", [], "any", false, false, false, 67) == "link")) {
            yield "selected";
        }
        yield ">";
        yield ($context["text_link"] ?? null);
        yield "</option>
                <option value=\"download\" ";
        // line 68
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "content_type", [], "any", false, false, false, 68) == "download")) {
            yield "selected";
        }
        yield ">";
        yield ($context["text_download"] ?? null);
        yield "</option>
              </select>
            </div>
            <div class=\"col-md-4\">
              <label class=\"form-label\">";
        // line 72
        yield ($context["entry_video_url"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"video_url\" value=\"";
        // line 73
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "video_url", [], "any", false, false, false, 73);
        yield "\" class=\"form-control\" placeholder=\"https://...\">
            </div>
            <div class=\"col-md-4\">
              <label class=\"form-label\">";
        // line 76
        yield ($context["entry_external_url"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"external_url\" value=\"";
        // line 77
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "external_url", [], "any", false, false, false, 77);
        yield "\" class=\"form-control\" placeholder=\"https://...\">
            </div>
            <div class=\"col-md-2\">
              <label class=\"form-label\">";
        // line 80
        yield ($context["entry_duration"] ?? null);
        yield "</label>
              <input type=\"number\" name=\"duration_minutes\" value=\"";
        // line 81
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "duration_minutes", [], "any", false, false, false, 81);
        yield "\" class=\"form-control\" min=\"0\">
            </div>
            <div class=\"col-md-2\">
              <label class=\"form-label\">";
        // line 84
        yield ($context["entry_min_time"] ?? null);
        yield "</label>
              <input type=\"number\" name=\"min_seconds\" value=\"";
        // line 85
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "min_seconds", [], "any", false, false, false, 85);
        yield "\" class=\"form-control\" min=\"0\">
            </div>
            <div class=\"col-md-2\">
              <label class=\"form-label\">";
        // line 88
        yield ($context["entry_status"] ?? null);
        yield "</label>
              <select name=\"status\" class=\"form-select\">
                <option value=\"1\" ";
        // line 90
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "status", [], "any", false, false, false, 90)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "selected";
        }
        yield ">Enabled</option>
                <option value=\"0\" ";
        // line 91
        if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "status", [], "any", false, false, false, 91)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "selected";
        }
        yield ">Disabled</option>
              </select>
            </div>
          </div>

          <div class=\"row mb-3\">
            <div class=\"col-md-6\">
              <label class=\"form-label\">";
        // line 98
        yield ($context["entry_auto_complete"] ?? null);
        yield "</label>
              <select name=\"auto_complete\" class=\"form-select\">
                <option value=\"1\" ";
        // line 100
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "auto_complete", [], "any", false, false, false, 100)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "selected";
        }
        yield ">Yes</option>
                <option value=\"0\" ";
        // line 101
        if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "auto_complete", [], "any", false, false, false, 101)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "selected";
        }
        yield ">No</option>
              </select>
            </div>
            <div class=\"col-md-6\">
              <label class=\"form-label\">";
        // line 105
        yield ($context["entry_comments"] ?? null);
        yield "</label>
              <select name=\"comments_enabled\" class=\"form-select\">
                <option value=\"1\" ";
        // line 107
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "comments_enabled", [], "any", false, false, false, 107)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "selected";
        }
        yield ">Yes</option>
                <option value=\"0\" ";
        // line 108
        if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "comments_enabled", [], "any", false, false, false, 108)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "selected";
        }
        yield ">No</option>
              </select>
            </div>
          </div>

          <div class=\"mb-3\">
            <label class=\"form-label\">";
        // line 114
        yield ($context["entry_release_at"] ?? null);
        yield "</label>
            <input type=\"text\" name=\"release_at\" value=\"";
        // line 115
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "release_at", [], "any", false, false, false, 115);
        yield "\" class=\"form-control\" placeholder=\"YYYY-MM-DD HH:MM:SS\">
          </div>

          <div class=\"mb-3\">
            <label class=\"form-label\">";
        // line 119
        yield ($context["entry_content"] ?? null);
        yield "</label>
            <textarea name=\"content\" rows=\"6\" class=\"form-control\">";
        // line 120
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "content", [], "any", false, false, false, 120);
        yield "</textarea>
          </div>

          <div class=\"row mb-3\">
            <div class=\"col-md-6\">
              <label class=\"form-label\">";
        // line 125
        yield ($context["entry_resources"] ?? null);
        yield "</label>
              <textarea name=\"resources\" rows=\"3\" class=\"form-control\">";
        // line 126
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "resources", [], "any", false, false, false, 126);
        yield "</textarea>
            </div>
            <div class=\"col-md-6\">
              <label class=\"form-label\">";
        // line 129
        yield ($context["entry_attachment"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"attachment\" value=\"";
        // line 130
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["lesson"] ?? null), "attachment", [], "any", false, false, false, 130);
        yield "\" class=\"form-control\" placeholder=\"https://...\">
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 139
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
        return "admin/view/template/cms/mooc_lesson_form.twig";
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
        return array (  430 => 139,  418 => 130,  414 => 129,  408 => 126,  404 => 125,  396 => 120,  392 => 119,  385 => 115,  381 => 114,  370 => 108,  364 => 107,  359 => 105,  350 => 101,  344 => 100,  339 => 98,  327 => 91,  321 => 90,  316 => 88,  310 => 85,  306 => 84,  300 => 81,  296 => 80,  290 => 77,  286 => 76,  280 => 73,  276 => 72,  265 => 68,  257 => 67,  249 => 66,  241 => 65,  233 => 64,  225 => 63,  217 => 62,  209 => 61,  204 => 59,  196 => 54,  192 => 53,  184 => 48,  180 => 47,  176 => 45,  170 => 44,  166 => 43,  162 => 42,  153 => 36,  149 => 35,  145 => 33,  139 => 32,  136 => 31,  121 => 29,  117 => 28,  113 => 27,  108 => 25,  102 => 22,  97 => 20,  94 => 19,  88 => 18,  82 => 14,  71 => 12,  67 => 11,  62 => 9,  55 => 7,  51 => 6,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/cms/mooc_lesson_form.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\cms\\mooc_lesson_form.twig");
    }
}
