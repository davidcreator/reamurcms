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

/* admin/view/template/cms/blog_settings.twig */
class __TwigTemplate_573a96d214db89905b59ece2246ffe96 extends Template
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
        <button type=\"submit\" form=\"form-blog-settings\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i> ";
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
        if ((($tmp = ($context["error_warning"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 20
            yield "      <div class=\"alert alert-danger\">";
            yield ($context["error_warning"] ?? null);
            yield "</div>
    ";
        }
        // line 22
        yield "    <div class=\"panel panel-default\">
      <div class=\"panel-heading\"><h3 class=\"panel-title\"><i class=\"fa fa-cog\"></i> ";
        // line 23
        yield ($context["heading_general"] ?? null);
        yield "</h3></div>
      <div class=\"panel-body\">
        <form action=\"";
        // line 25
        yield ($context["action"] ?? null);
        yield "\" method=\"post\" id=\"form-blog-settings\" class=\"form-horizontal\">
          <div class=\"form-group\">
            <label class=\"col-sm-3 control-label\" for=\"input-auto-approve\">";
        // line 27
        yield ($context["entry_comment_auto_approve"] ?? null);
        yield "</label>
            <div class=\"col-sm-9\">
              <select name=\"blog_comment_auto_approve\" id=\"input-auto-approve\" class=\"form-control\">
                <option value=\"1\" ";
        // line 30
        yield (((($tmp = ($context["blog_comment_auto_approve"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("selected") : (""));
        yield ">";
        yield ($context["text_enabled"] ?? null);
        yield "</option>
                <option value=\"0\" ";
        // line 31
        yield (((($tmp =  !($context["blog_comment_auto_approve"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("selected") : (""));
        yield ">";
        yield ($context["text_disabled"] ?? null);
        yield "</option>
              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-3 control-label\" for=\"input-require-login\">";
        // line 36
        yield ($context["entry_comment_require_login"] ?? null);
        yield "</label>
            <div class=\"col-sm-9\">
              <select name=\"blog_comment_require_login\" id=\"input-require-login\" class=\"form-control\">
                <option value=\"1\" ";
        // line 39
        yield (((($tmp = ($context["blog_comment_require_login"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("selected") : (""));
        yield ">";
        yield ($context["text_enabled"] ?? null);
        yield "</option>
                <option value=\"0\" ";
        // line 40
        yield (((($tmp =  !($context["blog_comment_require_login"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("selected") : (""));
        yield ">";
        yield ($context["text_disabled"] ?? null);
        yield "</option>
              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-3 control-label\" for=\"input-spam-words\">";
        // line 45
        yield ($context["entry_comment_spam_words"] ?? null);
        yield "</label>
            <div class=\"col-sm-9\">
              <textarea name=\"blog_comment_spam_words\" id=\"input-spam-words\" rows=\"3\" class=\"form-control\">";
        // line 47
        yield ($context["blog_comment_spam_words"] ?? null);
        yield "</textarea>
              <p class=\"help-block\">";
        // line 48
        yield ($context["help_spam_words"] ?? null);
        yield "</p>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-3 control-label\" for=\"input-rate-limit\">";
        // line 52
        yield ($context["entry_comment_rate_limit"] ?? null);
        yield "</label>
            <div class=\"col-sm-9\">
              <input type=\"number\" name=\"blog_comment_rate_limit\" value=\"";
        // line 54
        yield ($context["blog_comment_rate_limit"] ?? null);
        yield "\" id=\"input-rate-limit\" class=\"form-control\" min=\"0\"/>
              <p class=\"help-block\">";
        // line 55
        yield ($context["help_comment_rate_limit"] ?? null);
        yield "</p>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-3 control-label\" for=\"input-share-img\">";
        // line 59
        yield ($context["entry_share_default_image"] ?? null);
        yield "</label>
            <div class=\"col-sm-9\">
              <input type=\"text\" name=\"blog_share_default_image\" value=\"";
        // line 61
        yield ($context["blog_share_default_image"] ?? null);
        yield "\" id=\"input-share-img\" class=\"form-control\" placeholder=\"https://...\">
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-3 control-label\" for=\"input-schema-auto\">";
        // line 65
        yield ($context["entry_schema_auto"] ?? null);
        yield "</label>
            <div class=\"col-sm-9\">
              <select name=\"blog_schema_auto\" id=\"input-schema-auto\" class=\"form-control\">
                <option value=\"1\" ";
        // line 68
        yield (((($tmp = ($context["blog_schema_auto"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("selected") : (""));
        yield ">";
        yield ($context["text_enabled"] ?? null);
        yield "</option>
                <option value=\"0\" ";
        // line 69
        yield (((($tmp =  !($context["blog_schema_auto"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("selected") : (""));
        yield ">";
        yield ($context["text_disabled"] ?? null);
        yield "</option>
              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-3 control-label\" for=\"input-rss\">";
        // line 74
        yield ($context["entry_rss_enabled"] ?? null);
        yield "</label>
            <div class=\"col-sm-9\">
              <select name=\"blog_rss_enabled\" id=\"input-rss\" class=\"form-control\">
                <option value=\"1\" ";
        // line 77
        yield (((($tmp = ($context["blog_rss_enabled"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("selected") : (""));
        yield ">";
        yield ($context["text_enabled"] ?? null);
        yield "</option>
                <option value=\"0\" ";
        // line 78
        yield (((($tmp =  !($context["blog_rss_enabled"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("selected") : (""));
        yield ">";
        yield ($context["text_disabled"] ?? null);
        yield "</option>
              </select>
            </div>
          </div>
          <div class=\"form-group\">
            <label class=\"col-sm-3 control-label\" for=\"input-cache-ttl\">";
        // line 83
        yield ($context["entry_cache_ttl"] ?? null);
        yield "</label>
            <div class=\"col-sm-9\">
              <input type=\"number\" name=\"blog_cache_ttl\" value=\"";
        // line 85
        yield ($context["blog_cache_ttl"] ?? null);
        yield "\" id=\"input-cache-ttl\" class=\"form-control\" min=\"60\" step=\"60\"/>
              <p class=\"help-block\">";
        // line 86
        yield ($context["help_cache_ttl"] ?? null);
        yield "</p>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 94
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
        return "admin/view/template/cms/blog_settings.twig";
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
        return array (  264 => 94,  253 => 86,  249 => 85,  244 => 83,  234 => 78,  228 => 77,  222 => 74,  212 => 69,  206 => 68,  200 => 65,  193 => 61,  188 => 59,  181 => 55,  177 => 54,  172 => 52,  165 => 48,  161 => 47,  156 => 45,  146 => 40,  140 => 39,  134 => 36,  124 => 31,  118 => 30,  112 => 27,  107 => 25,  102 => 23,  99 => 22,  93 => 20,  91 => 19,  85 => 15,  74 => 13,  70 => 12,  65 => 10,  58 => 8,  54 => 7,  46 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/cms/blog_settings.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\cms\\blog_settings.twig");
    }
}
