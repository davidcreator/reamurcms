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

/* admin/view/template/user/profile.twig */
class __TwigTemplate_0ed848e49b5f0105a7bf24afde16c249 extends Template
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
        <button type=\"submit\" form=\"form-user\" data-bs-toggle=\"tooltip\" title=\"";
        // line 6
        yield ($context["button_save"] ?? null);
        yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-floppy-disk\"></i></button>
        <a href=\"";
        // line 7
        yield ($context["back"] ?? null);
        yield "\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["button_back"] ?? null);
        yield "\" class=\"btn btn-light\"><i class=\"fa-solid fa-reply\"></i></a></div>
      <h1>";
        // line 8
        yield ($context["heading_title"] ?? null);
        yield "</h1>
      <ol class=\"breadcrumb\">
        ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 11
            yield "          <li class=\"breadcrumb-item\"><a href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 11);
            yield "\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 11);
            yield "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['breadcrumb'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        yield "      </ol>
    </div>
  </div>
  <div class=\"container-fluid\">
    <div class=\"card\">
      <div class=\"card-header\"><i class=\"fa-solid fa-pencil\"></i> ";
        // line 18
        yield ($context["text_edit"] ?? null);
        yield "</div>
      <div class=\"card-body\">
        <form id=\"form-user\" action=\"";
        // line 20
        yield ($context["save"] ?? null);
        yield "\" method=\"post\" data-rms-toggle=\"ajax\">
          <fieldset>
            <legend>";
        // line 22
        yield ($context["text_user"] ?? null);
        yield "</legend>
            <div class=\"row mb-3 required\">
              <label for=\"input-username\" class=\"col-sm-2 col-form-label\">";
        // line 24
        yield ($context["entry_username"] ?? null);
        yield "</label>
              <div class=\"col-sm-10\">
                <input type=\"text\" name=\"username\" value=\"";
        // line 26
        yield ($context["username"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_username"] ?? null);
        yield "\" id=\"input-username\" class=\"form-control\"/>
                <div id=\"error-username\" class=\"invalid-feedback\"></div>
              </div>
            </div>
            <div class=\"row mb-3 required\">
              <label for=\"input-firstname\" class=\"col-sm-2 col-form-label\">";
        // line 31
        yield ($context["entry_firstname"] ?? null);
        yield "</label>
              <div class=\"col-sm-10\">
                <input type=\"text\" name=\"firstname\" value=\"";
        // line 33
        yield ($context["firstname"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_firstname"] ?? null);
        yield "\" id=\"input-firstname\" class=\"form-control\"/>
                <div id=\"error-firstname\" class=\"invalid-feedback\"></div>
              </div>
            </div>
            <div class=\"row mb-3 required\">
              <label for=\"input-lastname\" class=\"col-sm-2 col-form-label\">";
        // line 38
        yield ($context["entry_lastname"] ?? null);
        yield "</label>
              <div class=\"col-sm-10\">
                <input type=\"text\" name=\"lastname\" value=\"";
        // line 40
        yield ($context["lastname"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_lastname"] ?? null);
        yield "\" id=\"input-lastname\" class=\"form-control\"/>
                <div id=\"error-lastname\" class=\"invalid-feedback\"></div>
              </div>
            </div>
            <div class=\"row mb-3 required\">
              <label for=\"input-email\" class=\"col-sm-2 col-form-label\">";
        // line 45
        yield ($context["entry_email"] ?? null);
        yield "</label>
              <div class=\"col-sm-10\">
                <input type=\"text\" name=\"email\" value=\"";
        // line 47
        yield ($context["email"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_email"] ?? null);
        yield "\" id=\"input-email\" class=\"form-control\"/>
                <div id=\"error-email\" class=\"invalid-feedback\"></div>
              </div>
            </div>
            <div class=\"row mb-3\">
              <label for=\"input-image\" class=\"col-sm-2 col-form-label\">";
        // line 52
        yield ($context["entry_image"] ?? null);
        yield "</label>
              <div class=\"col-sm-10\">
                <div class=\"card image\">
                  <img src=\"";
        // line 55
        yield ($context["thumb"] ?? null);
        yield "\" alt=\"\" title=\"\" id=\"thumb-image\" data-rms-placeholder=\"";
        yield ($context["placeholder"] ?? null);
        yield "\" class=\"card-img-top\"/> <input type=\"hidden\" name=\"image\" value=\"";
        yield ($context["image"] ?? null);
        yield "\" id=\"input-image\"/>
                  <div class=\"card-body\">
                    <button type=\"button\" data-rms-toggle=\"image\" data-rms-target=\"#input-image\" data-rms-thumb=\"#thumb-image\" class=\"btn btn-primary btn-sm btn-block\"><i class=\"fa-solid fa-pencil\"></i> ";
        // line 57
        yield ($context["button_edit"] ?? null);
        yield "</button>
                    <button type=\"button\" data-rms-toggle=\"clear\" data-rms-target=\"#input-image\" data-rms-thumb=\"#thumb-image\" class=\"btn btn-warning btn-sm btn-block\"><i class=\"fa-regular fa-trash-can\"></i> ";
        // line 58
        yield ($context["button_clear"] ?? null);
        yield "</button>
                  </div>
                </div>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend>";
        // line 65
        yield ($context["text_password"] ?? null);
        yield "</legend>
            <div class=\"row mb-3 required\">
              <label for=\"input-password\" class=\"col-sm-2 col-form-label\">";
        // line 67
        yield ($context["entry_password"] ?? null);
        yield "</label>
              <div class=\"col-sm-10\">
                <input type=\"password\" name=\"password\" value=\"";
        // line 69
        yield ($context["password"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_password"] ?? null);
        yield "\" id=\"input-password\" class=\"form-control\" autocomplete=\"new-password\"/>
                <div id=\"error-password\" class=\"invalid-feedback\"></div>
              </div>
            </div>
            <div class=\"row mb-3 required\">
              <label for=\"input-confirm\" class=\"col-sm-2 col-form-label\">";
        // line 74
        yield ($context["entry_confirm"] ?? null);
        yield "</label>
              <div class=\"col-sm-10\">
                <input type=\"password\" name=\"confirm\" value=\"";
        // line 76
        yield ($context["confirm"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_confirm"] ?? null);
        yield "\" id=\"input-confirm\" class=\"form-control\"/>
                <div id=\"error-confirm\" class=\"invalid-feedback\"></div>
              </div>
            </div>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 86
        yield ($context["footer"] ?? null);
        yield " ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/view/template/user/profile.twig";
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
        return array (  232 => 86,  217 => 76,  212 => 74,  202 => 69,  197 => 67,  192 => 65,  182 => 58,  178 => 57,  169 => 55,  163 => 52,  153 => 47,  148 => 45,  138 => 40,  133 => 38,  123 => 33,  118 => 31,  108 => 26,  103 => 24,  98 => 22,  93 => 20,  88 => 18,  81 => 13,  70 => 11,  66 => 10,  61 => 8,  55 => 7,  51 => 6,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/user/profile.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\user\\profile.twig");
    }
}
