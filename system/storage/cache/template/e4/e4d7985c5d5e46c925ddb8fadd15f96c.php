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

/* admin/view/template/cms/mooc_instructor_form.twig */
class __TwigTemplate_3c8888db184055649cb6578db58f0ddb extends Template
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
        <button type=\"submit\" form=\"form-instructor\" class=\"btn btn-primary\"><i class=\"fa-solid fa-save\"></i> ";
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
      <div class=\"card-header\"><i class=\"fa-solid fa-user\"></i> ";
        // line 20
        yield ($context["text_form"] ?? null);
        yield "</div>
      <div class=\"card-body\">
        <form id=\"form-instructor\" method=\"post\" action=\"";
        // line 22
        yield ($context["action"] ?? null);
        yield "\">
          <div class=\"mb-3\">
            <label class=\"form-label\">";
        // line 24
        yield ($context["entry_name"] ?? null);
        yield "</label>
            <input type=\"text\" name=\"name\" value=\"";
        // line 25
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["instructor"] ?? null), "name", [], "any", false, false, false, 25);
        yield "\" class=\"form-control\">
            ";
        // line 26
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "name", [], "any", false, false, false, 26)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "<div class=\"text-danger\">";
            yield CoreExtension::getAttribute($this->env, $this->source, ($context["errors"] ?? null), "name", [], "any", false, false, false, 26);
            yield "</div>";
        }
        // line 27
        yield "          </div>
          <div class=\"mb-3\">
            <label class=\"form-label\">";
        // line 29
        yield ($context["entry_headline"] ?? null);
        yield "</label>
            <input type=\"text\" name=\"headline\" value=\"";
        // line 30
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["instructor"] ?? null), "headline", [], "any", false, false, false, 30);
        yield "\" class=\"form-control\">
          </div>
          <div class=\"mb-3\">
            <label class=\"form-label\">";
        // line 33
        yield ($context["entry_bio"] ?? null);
        yield "</label>
            <textarea name=\"bio\" rows=\"4\" class=\"form-control\">";
        // line 34
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["instructor"] ?? null), "bio", [], "any", false, false, false, 34);
        yield "</textarea>
          </div>
          <div class=\"mb-3\">
            <label class=\"form-label\">";
        // line 37
        yield ($context["entry_photo"] ?? null);
        yield "</label>
            <input type=\"text\" name=\"photo\" value=\"";
        // line 38
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["instructor"] ?? null), "photo", [], "any", false, false, false, 38);
        yield "\" class=\"form-control\" placeholder=\"https://...\">
          </div>
          <div class=\"row\">
            <div class=\"col\">
              <label class=\"form-label\">";
        // line 42
        yield ($context["entry_linkedin"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"linkedin\" value=\"";
        // line 43
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["instructor"] ?? null), "linkedin", [], "any", false, false, false, 43);
        yield "\" class=\"form-control\">
            </div>
            <div class=\"col\">
              <label class=\"form-label\">";
        // line 46
        yield ($context["entry_twitter"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"twitter\" value=\"";
        // line 47
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["instructor"] ?? null), "twitter", [], "any", false, false, false, 47);
        yield "\" class=\"form-control\">
            </div>
            <div class=\"col\">
              <label class=\"form-label\">";
        // line 50
        yield ($context["entry_website"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"website\" value=\"";
        // line 51
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["instructor"] ?? null), "website", [], "any", false, false, false, 51);
        yield "\" class=\"form-control\">
            </div>
          </div>
          <div class=\"mt-3\">
            <label class=\"form-label\">";
        // line 55
        yield ($context["entry_user_id"] ?? null);
        yield "</label>
            <input type=\"number\" name=\"user_id\" value=\"";
        // line 56
        yield CoreExtension::getAttribute($this->env, $this->source, ($context["instructor"] ?? null), "user_id", [], "any", false, false, false, 56);
        yield "\" class=\"form-control\">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 63
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
        return "admin/view/template/cms/mooc_instructor_form.twig";
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
        return array (  201 => 63,  191 => 56,  187 => 55,  180 => 51,  176 => 50,  170 => 47,  166 => 46,  160 => 43,  156 => 42,  149 => 38,  145 => 37,  139 => 34,  135 => 33,  129 => 30,  125 => 29,  121 => 27,  115 => 26,  111 => 25,  107 => 24,  102 => 22,  97 => 20,  94 => 19,  88 => 18,  82 => 14,  71 => 12,  67 => 11,  62 => 9,  55 => 7,  51 => 6,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/cms/mooc_instructor_form.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\cms\\mooc_instructor_form.twig");
    }
}
