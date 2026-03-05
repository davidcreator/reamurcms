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

/* admin/view/template/common/login.twig */
class __TwigTemplate_9fd180a3001efa855cb1d4cb4c8fe7c6 extends Template
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
<div id=\"content\" class=\"login-page\">
  <div class=\"login-container\">
    <div class=\"login-card\">
      <div class=\"login-header\">       
        <h2 class=\"login-title\">";
        // line 6
        yield ($context["text_login"] ?? null);
        yield "</h2>
      </div>
      
      <div class=\"login-body\">
        <form id=\"form-login\" action=\"";
        // line 10
        yield ($context["login"] ?? null);
        yield "\" method=\"post\" data-rms-toggle=\"ajax\">
          ";
        // line 11
        if ((($tmp = ($context["error_warning"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 12
            yield "            <div class=\"alert alert-danger alert-dismissible fade show\">
              <i class=\"fa-solid fa-circle-exclamation\"></i> ";
            // line 13
            yield ($context["error_warning"] ?? null);
            yield "
              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
            </div>
          ";
        }
        // line 17
        yield "          
          ";
        // line 18
        if ((($tmp = ($context["success"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 19
            yield "            <div class=\"alert alert-success alert-dismissible fade show\">
              <i class=\"fa-solid fa-check-circle\"></i> ";
            // line 20
            yield ($context["success"] ?? null);
            yield "
              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button>
            </div>
          ";
        }
        // line 24
        yield "          
          <div class=\"form-group floating\">
            <input type=\"text\" name=\"username\" id=\"input-username\" class=\"form-control\" placeholder=\" \" required>
            <label for=\"input-username\" class=\"floating-label\">";
        // line 27
        yield ($context["entry_username"] ?? null);
        yield "</label>
            <div class=\"form-icon\">
              <i class=\"fa-solid fa-user\"></i>
            </div>
          </div>
          
          <div class=\"form-group floating\">
            <input type=\"password\" name=\"password\" id=\"input-password\" class=\"form-control\" placeholder=\" \" required>
            <label for=\"input-password\" class=\"floating-label\">";
        // line 35
        yield ($context["entry_password"] ?? null);
        yield "</label>
            <div class=\"form-icon\">
              <i class=\"fa-solid fa-lock\"></i>
            </div>
          </div>
          
          ";
        // line 41
        if ((($tmp = ($context["forgotten"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 42
            yield "            <div class=\"forgot-password\">
              <a href=\"";
            // line 43
            yield ($context["forgotten"] ?? null);
            yield "\">";
            yield ($context["text_forgotten"] ?? null);
            yield "</a>
            </div>
          ";
        }
        // line 46
        yield "          
          <div class=\"form-group\">
            <button type=\"submit\" class=\"btn btn-primary btn-block btn-login\">
              <i class=\"fa-solid fa-key\"></i> ";
        // line 49
        yield ($context["button_login"] ?? null);
        yield "
            </button>
          </div>
          
          ";
        // line 53
        if ((($tmp = ($context["redirect"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 54
            yield "            <input type=\"hidden\" name=\"redirect\" value=\"";
            yield ($context["redirect"] ?? null);
            yield "\"/>
          ";
        }
        // line 56
        yield "        </form>
      </div>
    </div>
  </div>
</div>
";
        // line 61
        yield ($context["footer"] ?? null);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/view/template/common/login.twig";
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
        return array (  153 => 61,  146 => 56,  140 => 54,  138 => 53,  131 => 49,  126 => 46,  118 => 43,  115 => 42,  113 => 41,  104 => 35,  93 => 27,  88 => 24,  81 => 20,  78 => 19,  76 => 18,  73 => 17,  66 => 13,  63 => 12,  61 => 11,  57 => 10,  50 => 6,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/common/login.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\common\\login.twig");
    }
}
