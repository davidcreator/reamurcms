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

/* catalog/view/template/account/login.twig */
class __TwigTemplate_0ab9d9c84212d4ca7810482d6727ba8a extends Template
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
<div id=\"account-login\" class=\"container\">
  <ul class=\"breadcrumb\">
    ";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 5
            yield "      <li class=\"breadcrumb-item\"><a href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 5);
            yield "\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 5);
            yield "</a></li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['breadcrumb'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 7
        yield "  </ul>
  ";
        // line 8
        if ((($tmp = ($context["success"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 9
            yield "    <div class=\"alert alert-success alert-dismissible\"><i class=\"fa-solid fa-circle-check\"></i> ";
            yield ($context["success"] ?? null);
            yield " <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>
  ";
        }
        // line 11
        yield "  ";
        if ((($tmp = ($context["error_warning"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 12
            yield "    <div class=\"alert alert-danger alert-dismissible\"><i class=\"fa-solid fa-circle-exclamation\"></i> ";
            yield ($context["error_warning"] ?? null);
            yield " <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>
  ";
        }
        // line 14
        yield "  <div class=\"row\">";
        yield ($context["column_left"] ?? null);
        yield "
    <div id=\"content\" class=\"col\">";
        // line 15
        yield ($context["content_top"] ?? null);
        yield "
      <div class=\"row\">
        <div class=\"col mb-3\">
          <div class=\"border rounded p-3 d-flex flex-column h-100\">
            <h2>";
        // line 19
        yield ($context["text_new_customer"] ?? null);
        yield "</h2>
            <p><strong>";
        // line 20
        yield ($context["text_register"] ?? null);
        yield "</strong></p>
            <p>";
        // line 21
        yield ($context["text_register_account"] ?? null);
        yield "</p>
            <div class=\"text-end\">
              <a href=\"";
        // line 23
        yield ($context["register"] ?? null);
        yield "\" class=\"btn btn-primary\">";
        yield ($context["button_continue"] ?? null);
        yield "</a>
            </div>
          </div>
        </div>
        <div class=\"col mb-3\">
          <div class=\"border rounded p-3 d-flex flex-column h-100\">
            <form id=\"form-login\" action=\"";
        // line 29
        yield ($context["login"] ?? null);
        yield "\" method=\"post\" data-rms-toggle=\"ajax\">
              <h2>";
        // line 30
        yield ($context["text_returning_customer"] ?? null);
        yield "</h2>
              <p><strong>";
        // line 31
        yield ($context["text_i_am_returning_customer"] ?? null);
        yield "</strong></p>
              <div class=\"mb-3\">
                <label for=\"input-email\" class=\"col-form-label\">";
        // line 33
        yield ($context["entry_email"] ?? null);
        yield "</label>
                <input type=\"text\" name=\"email\" value=\"";
        // line 34
        yield ($context["email"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_email"] ?? null);
        yield "\" id=\"input-email\" class=\"form-control\"/>
              </div>
              <div class=\"mb-3\">
                <label for=\"input-password\" class=\"col-form-label\">";
        // line 37
        yield ($context["entry_password"] ?? null);
        yield "</label>
                <input type=\"password\" name=\"password\" value=\"";
        // line 38
        yield ($context["password"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_password"] ?? null);
        yield "\" id=\"input-password\" class=\"form-control mb-1\"/>
                <a href=\"";
        // line 39
        yield ($context["forgotten"] ?? null);
        yield "\">";
        yield ($context["text_forgotten"] ?? null);
        yield "</a>
              </div>
              <div class=\"text-end\">
                <button type=\"submit\" class=\"btn btn-primary\">";
        // line 42
        yield ($context["button_login"] ?? null);
        yield "</button>
              </div>
              ";
        // line 44
        if ((($tmp = ($context["redirect"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 45
            yield "                <input type=\"hidden\" name=\"redirect\" value=\"";
            yield ($context["redirect"] ?? null);
            yield "\"/>
              ";
        }
        // line 47
        yield "            </form>
          </div>
        </div>
      </div>
      ";
        // line 51
        yield ($context["content_bottom"] ?? null);
        yield "</div>
    ";
        // line 52
        yield ($context["column_right"] ?? null);
        yield "</div>
</div>
";
        // line 54
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
        return "catalog/view/template/account/login.twig";
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
        return array (  190 => 54,  185 => 52,  181 => 51,  175 => 47,  169 => 45,  167 => 44,  162 => 42,  154 => 39,  148 => 38,  144 => 37,  136 => 34,  132 => 33,  127 => 31,  123 => 30,  119 => 29,  108 => 23,  103 => 21,  99 => 20,  95 => 19,  88 => 15,  83 => 14,  77 => 12,  74 => 11,  68 => 9,  66 => 8,  63 => 7,  52 => 5,  48 => 4,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "catalog/view/template/account/login.twig", "E:\\wamp64\\www\\reamur\\catalog\\view\\template\\account\\login.twig");
    }
}
