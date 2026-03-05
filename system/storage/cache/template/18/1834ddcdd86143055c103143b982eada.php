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

/* admin/view/template/cms/mooc_course_form.twig */
class __TwigTemplate_ecae8e86bad1749d7b674b0b8f50b633 extends Template
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
        <button type=\"submit\" form=\"form-course\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i> ";
        // line 7
        yield ($context["button_save"] ?? null);
        yield "</button>
        <a href=\"";
        // line 8
        yield ($context["cancel"] ?? null);
        yield "\" class=\"btn btn-default\"><i class=\"fa fa-reply\"></i> ";
        yield ($context["button_cancel"] ?? null);
        yield "</a>
      </div>
      <h1>";
        // line 10
        yield ($context["heading_title"] ?? null);
        yield "</h1>
      <ul class=\"breadcrumb\">
        ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 13
            yield "          <li><a href=\"";
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
        yield "      </ul>
    </div>
  </div>
  <div class=\"container-fluid\">
    ";
        // line 19
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "warning", [], "any", false, false, false, 19)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"alert alert-danger\">";
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "warning", [], "any", false, false, false, 19);
            yield "</div>";
        }
        // line 20
        yield "    <div class=\"panel panel-default\">
      <div class=\"panel-heading\"><h3 class=\"panel-title\"><i class=\"fa fa-pencil\"></i> ";
        // line 21
        yield ($context["text_form"] ?? null);
        yield "</h3></div>
      <div class=\"panel-body\">
        <form action=\"";
        // line 23
        yield ($context["action"] ?? null);
        yield "\" method=\"post\" enctype=\"multipart/form-data\" id=\"form-course\" class=\"form-horizontal\">
          <div class=\"form-group required\">
            <label class=\"col-sm-2 control-label\" for=\"input-title\">";
        // line 25
        yield ($context["entry_title"] ?? null);
        yield "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"title\" value=\"";
        // line 27
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "title", [], "any", false, false, false, 27);
        yield "\" id=\"input-title\" class=\"form-control\" />
              ";
        // line 28
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "title", [], "any", false, false, false, 28)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"text-danger\">";
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "title", [], "any", false, false, false, 28);
            yield "</div>";
        }
        // line 29
        yield "            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-slug\">";
        // line 32
        yield ($context["entry_slug"] ?? null);
        yield "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"slug\" value=\"";
        // line 34
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "slug", [], "any", false, false, false, 34);
        yield "\" id=\"input-slug\" class=\"form-control\" />
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-level\">";
        // line 38
        yield ($context["entry_level"] ?? null);
        yield "</label>
            <div class=\"col-sm-10\">
              <select name=\"level\" id=\"input-level\" class=\"form-control\">
                <option value=\"beginner\" ";
        // line 41
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "level", [], "any", false, false, false, 41) == "beginner")) ? ("selected") : (""));
        yield ">";
        yield ($context["text_level_beginner"] ?? null);
        yield "</option>
                <option value=\"intermediate\" ";
        // line 42
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "level", [], "any", false, false, false, 42) == "intermediate")) ? ("selected") : (""));
        yield ">";
        yield ($context["text_level_intermediate"] ?? null);
        yield "</option>
                <option value=\"advanced\" ";
        // line 43
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "level", [], "any", false, false, false, 43) == "advanced")) ? ("selected") : (""));
        yield ">";
        yield ($context["text_level_advanced"] ?? null);
        yield "</option>
                <option value=\"all\" ";
        // line 44
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "level", [], "any", false, false, false, 44) == "all")) ? ("selected") : (""));
        yield ">";
        yield ($context["text_level_all"] ?? null);
        yield "</option>
              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-status\">";
        // line 49
        yield ($context["entry_status"] ?? null);
        yield "</label>
            <div class=\"col-sm-10\">
              <select name=\"status\" id=\"input-status\" class=\"form-control\">
                <option value=\"draft\" ";
        // line 52
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "status", [], "any", false, false, false, 52) == "draft")) ? ("selected") : (""));
        yield ">";
        yield ($context["text_draft"] ?? null);
        yield "</option>
                <option value=\"published\" ";
        // line 53
        yield (((CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "status", [], "any", false, false, false, 53) == "published")) ? ("selected") : (""));
        yield ">";
        yield ($context["text_published"] ?? null);
        yield "</option>
              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\">";
        // line 58
        yield ($context["entry_category"] ?? null);
        yield "</label>
            <div class=\"col-sm-10\">
              <select name=\"category_ids[]\" class=\"form-control\" multiple size=\"5\">
                ";
        // line 61
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 62
            yield "                  <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["category"], "category_id", [], "any", false, false, false, 62);
            yield "\" ";
            yield ((CoreExtension::inFilter(CoreExtension::getAttribute($this->env, $this->source, $context["category"], "category_id", [], "any", false, false, false, 62), CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "category_ids", [], "any", false, false, false, 62))) ? ("selected") : (""));
            yield ">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 62);
            yield "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['category'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 64
        yield "              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\">";
        // line 68
        yield ($context["entry_instructor"] ?? null);
        yield "</label>
            <div class=\"col-sm-10\">
              <select name=\"instructor_ids[]\" class=\"form-control\" multiple size=\"5\">
                ";
        // line 71
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["instructors"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["instructor"]) {
            // line 72
            yield "                  <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["instructor"], "instructor_id", [], "any", false, false, false, 72);
            yield "\" ";
            yield ((CoreExtension::inFilter(CoreExtension::getAttribute($this->env, $this->source, $context["instructor"], "instructor_id", [], "any", false, false, false, 72), CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "instructor_ids", [], "any", false, false, false, 72))) ? ("selected") : (""));
            yield ">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["instructor"], "name", [], "any", false, false, false, 72);
            yield "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['instructor'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 74
        yield "              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-description\">";
        // line 78
        yield ($context["entry_description"] ?? null);
        yield "</label>
            <div class=\"col-sm-10\">
              <textarea name=\"description\" id=\"input-description\" rows=\"10\" class=\"form-control\">";
        // line 80
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "description", [], "any", false, false, false, 80);
        yield "</textarea>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-duration\">";
        // line 84
        yield ($context["entry_duration"] ?? null);
        yield "</label>
            <div class=\"col-sm-10\">
              <input type=\"number\" name=\"duration_minutes\" value=\"";
        // line 86
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "duration_minutes", [], "any", false, false, false, 86);
        yield "\" id=\"input-duration\" class=\"form-control\" />
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-price\">";
        // line 90
        yield ($context["entry_price"] ?? null);
        yield "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"price\" value=\"";
        // line 92
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "price", [], "any", false, false, false, 92);
        yield "\" id=\"input-price\" class=\"form-control\" />
              <div class=\"checkbox\">
                <label><input type=\"checkbox\" name=\"is_free\" value=\"1\" ";
        // line 94
        yield (((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "is_free", [], "any", false, false, false, 94)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("checked") : (""));
        yield " /> ";
        yield ($context["text_free"] ?? null);
        yield "</label>
              </div>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-2 control-label\" for=\"input-featured\">";
        // line 99
        yield ($context["entry_featured_image"] ?? null);
        yield "</label>
            <div class=\"col-sm-10\">
              <input type=\"text\" name=\"featured_image\" value=\"";
        // line 101
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["course"] ?? null), "featured_image", [], "any", false, false, false, 101);
        yield "\" id=\"input-featured\" class=\"form-control\" placeholder=\"https://...\">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 109
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
        return "admin/view/template/cms/mooc_course_form.twig";
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
        return array (  316 => 109,  305 => 101,  300 => 99,  290 => 94,  285 => 92,  280 => 90,  273 => 86,  268 => 84,  261 => 80,  256 => 78,  250 => 74,  237 => 72,  233 => 71,  227 => 68,  221 => 64,  208 => 62,  204 => 61,  198 => 58,  188 => 53,  182 => 52,  176 => 49,  166 => 44,  160 => 43,  154 => 42,  148 => 41,  142 => 38,  135 => 34,  130 => 32,  125 => 29,  119 => 28,  115 => 27,  110 => 25,  105 => 23,  100 => 21,  97 => 20,  91 => 19,  85 => 15,  74 => 13,  70 => 12,  65 => 10,  58 => 8,  54 => 7,  46 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/cms/mooc_course_form.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\cms\\mooc_course_form.twig");
    }
}
