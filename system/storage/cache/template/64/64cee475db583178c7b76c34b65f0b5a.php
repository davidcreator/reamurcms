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

/* catalog/view/template/common/header.twig */
class __TwigTemplate_a8457b15def1eb8677d5cd1cac0bbd53 extends Template
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
        yield "<!DOCTYPE html>
<html dir=\"";
        // line 2
        yield ($context["direction"] ?? null);
        yield "\" lang=\"";
        yield ($context["lang"] ?? null);
        yield "\">
<head>
  <meta charset=\"UTF-8\"/>
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, minimum-scale=1\">
  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
  <title>";
        // line 7
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["title"] ?? null));
        yield "</title>
  <base href=\"";
        // line 8
        yield ($context["base"] ?? null);
        yield "\"/>
  ";
        // line 9
        if ((($tmp = ($context["description"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 10
            yield "    <meta name=\"description\" content=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["description"] ?? null));
            yield "\"/>
  ";
        }
        // line 12
        yield "  ";
        if ((($tmp = ($context["keywords"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 13
            yield "    <meta name=\"keywords\" content=\"";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["keywords"] ?? null));
            yield "\"/>
  ";
        }
        // line 15
        yield "  
  <!-- Preload critical resources with proper crossorigin -->
  <link rel=\"preload\" href=\"";
        // line 17
        yield ($context["bootstrap"] ?? null);
        yield "\" as=\"style\" crossorigin=\"anonymous\">
  <link rel=\"preload\" href=\"";
        // line 18
        yield ($context["jquery"] ?? null);
        yield "\" as=\"script\" crossorigin=\"anonymous\">
  
  <!-- CSS with integrity checks -->
  <link type=\"text/css\" rel=\"stylesheet\" media=\"screen\" href=\"";
        // line 21
        yield ($context["bootstrap"] ?? null);
        yield "\" crossorigin=\"anonymous\"/>
  <link type=\"text/css\" rel=\"stylesheet\" href=\"";
        // line 22
        yield ($context["icons"] ?? null);
        yield "\" crossorigin=\"anonymous\"/>
  <link type=\"text/css\" rel=\"stylesheet\" href=\"";
        // line 23
        yield ($context["reamurcms"] ?? null);
        yield "\" crossorigin=\"anonymous\"/>
  <link type=\"text/css\" rel=\"stylesheet\" href=\"catalog/view/js/jquery/datetimepicker/daterangepicker.css\" crossorigin=\"anonymous\"/>

  <!-- JS with defer and async where appropriate -->
  <script type=\"text/javascript\" src=\"";
        // line 27
        yield ($context["jquery"] ?? null);
        yield "\" defer crossorigin=\"anonymous\"></script>
  <script type=\"text/javascript\" src=\"catalog/view/js/jquery/datetimepicker/moment.min.js\" defer crossorigin=\"anonymous\"></script>
  <script type=\"text/javascript\" src=\"catalog/view/js/jquery/datetimepicker/moment-with-locales.min.js\" defer crossorigin=\"anonymous\"></script>
  <script type=\"text/javascript\" src=\"catalog/view/js/jquery/datetimepicker/daterangepicker.js\" defer crossorigin=\"anonymous\"></script>
  <script type=\"text/javascript\" src=\"catalog/view/js/common.js\" defer crossorigin=\"anonymous\"></script>
  
  ";
        // line 33
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["css"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["style"]) {
            // line 34
            yield "    <link href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["style"], "href", [], "any", false, false, false, 34);
            yield "\" type=\"text/css\" rel=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["style"], "rel", [], "any", false, false, false, 34);
            yield "\" media=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["style"], "media", [], "any", false, false, false, 34);
            yield "\" crossorigin=\"anonymous\"/>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['style'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 36
        yield "  ";
        // line 37
        yield "  <link href=\"catalog/view/css/enhanced-upload.css\" type=\"text/css\" rel=\"stylesheet\" crossorigin=\"anonymous\"/>
  ";
        // line 38
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["js"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["script"]) {
            // line 39
            yield "    <script src=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["script"], "href", [], "any", false, false, false, 39);
            yield "\" type=\"text/javascript\" defer crossorigin=\"anonymous\"></script>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['script'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 41
        yield "  ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["links"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 42
            yield "    <link href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["link"], "href", [], "any", false, false, false, 42);
            yield "\" rel=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["link"], "rel", [], "any", false, false, false, 42);
            yield "\" crossorigin=\"anonymous\"/>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['link'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        yield "  ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["analytics"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["analytic"]) {
            // line 45
            yield "    ";
            yield $context["analytic"];
            yield "
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['analytic'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 47
        yield "</head>
<body>
<div id=\"alert\" class=\"toast-container position-fixed top-0 end-0 p-3\" role=\"alert\" aria-live=\"polite\"></div>
<nav id=\"top\" role=\"navigation\" aria-label=\"Top navigation\">
  <div class=\"container\">
    <div class=\"nav float-start\">
      <ul class=\"list-inline\">
        <li class=\"list-inline-item\">";
        // line 54
        yield ($context["currency"] ?? null);
        yield "</li>
        <li class=\"list-inline-item\">";
        // line 55
        yield ($context["language"] ?? null);
        yield "</li>
      </ul>
    </div>
    <div class=\"nav float-end\">
      <ul class=\"list-inline\">
        <li class=\"list-inline-item\">
          <a href=\"";
        // line 61
        yield ($context["contact"] ?? null);
        yield "\" aria-label=\"Contact us\">
            <i class=\"fa-solid fa-phone\" aria-hidden=\"true\"></i>
            <span class=\"d-none d-md-inline\">";
        // line 63
        yield ($context["telephone"] ?? null);
        yield "</span>
          </a>
        </li>
        <li class=\"list-inline-item\">
          <div class=\"dropdown\">
            <a href=\"";
        // line 68
        yield ($context["account"] ?? null);
        yield "\" class=\"dropdown-toggle\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\" aria-haspopup=\"true\" aria-label=\"Account menu\">
              <i class=\"fa-solid fa-user\" aria-hidden=\"true\"></i>
              <span class=\"d-none d-md-inline\">";
        // line 70
        yield ($context["text_account"] ?? null);
        yield "</span>
              <i class=\"fa-solid fa-caret-down\" aria-hidden=\"true\"></i>
            </a>
            <ul class=\"dropdown-menu dropdown-menu-end\" role=\"menu\">
              ";
        // line 74
        if ((($tmp =  !($context["logged"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 75
            yield "                <li><a href=\"";
            yield ($context["register"] ?? null);
            yield "\" class=\"dropdown-item\" role=\"menuitem\">";
            yield ($context["text_register"] ?? null);
            yield "</a></li>
                <li><a href=\"";
            // line 76
            yield ($context["login"] ?? null);
            yield "\" class=\"dropdown-item\" role=\"menuitem\">";
            yield ($context["text_login"] ?? null);
            yield "</a></li>
              ";
        } else {
            // line 78
            yield "                <li><a href=\"";
            yield ($context["account"] ?? null);
            yield "\" class=\"dropdown-item\" role=\"menuitem\">";
            yield ($context["text_account"] ?? null);
            yield "</a></li>
                <li><a href=\"";
            // line 79
            yield ($context["order"] ?? null);
            yield "\" class=\"dropdown-item\" role=\"menuitem\">";
            yield ($context["text_order"] ?? null);
            yield "</a></li>
                <li><a href=\"";
            // line 80
            yield ($context["transaction"] ?? null);
            yield "\" class=\"dropdown-item\" role=\"menuitem\">";
            yield ($context["text_transaction"] ?? null);
            yield "</a></li>
                <li><a href=\"";
            // line 81
            yield ($context["download"] ?? null);
            yield "\" class=\"dropdown-item\" role=\"menuitem\">";
            yield ($context["text_download"] ?? null);
            yield "</a></li>
                <li><hr class=\"dropdown-divider\"></li>
                <li><a href=\"";
            // line 83
            yield ($context["logout"] ?? null);
            yield "\" class=\"dropdown-item\" role=\"menuitem\">";
            yield ($context["text_logout"] ?? null);
            yield "</a></li>
              ";
        }
        // line 85
        yield "            </ul>
          </div>
        </li>
        <li class=\"list-inline-item\">
          <a href=\"";
        // line 89
        yield ($context["wishlist"] ?? null);
        yield "\" id=\"wishlist-total\" title=\"";
        yield ($context["text_wishlist"] ?? null);
        yield "\" aria-label=\"Wishlist\">
            <i class=\"fa-solid fa-heart\" aria-hidden=\"true\"></i>
            <span class=\"d-none d-md-inline\">";
        // line 91
        yield ($context["text_wishlist"] ?? null);
        yield "</span>
          </a>
        </li>
        <li class=\"list-inline-item\">
          <a href=\"";
        // line 95
        yield ($context["shopping_cart"] ?? null);
        yield "\" title=\"";
        yield ($context["text_shopping_cart"] ?? null);
        yield "\" aria-label=\"Shopping cart\">
            <i class=\"fa-solid fa-cart-shopping\" aria-hidden=\"true\"></i>
            <span class=\"d-none d-md-inline\">";
        // line 97
        yield ($context["text_shopping_cart"] ?? null);
        yield "</span>
          </a>
        </li>
        <li class=\"list-inline-item\">
          <a href=\"";
        // line 101
        yield ($context["checkout"] ?? null);
        yield "\" title=\"";
        yield ($context["text_checkout"] ?? null);
        yield "\" aria-label=\"Checkout\">
            <i class=\"fa-solid fa-share\" aria-hidden=\"true\"></i>
            <span class=\"d-none d-md-inline\">";
        // line 103
        yield ($context["text_checkout"] ?? null);
        yield "</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<header role=\"banner\">
  <div class=\"container\">
    <div class=\"row align-items-center\">
      <div class=\"col-md-3 col-lg-4\">
        <div id=\"logo\">
          ";
        // line 115
        if ((($tmp = ($context["logo"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 116
            yield "            <a href=\"";
            yield ($context["home"] ?? null);
            yield "\" aria-label=\"Home\">
              <img src=\"";
            // line 117
            yield ($context["logo"] ?? null);
            yield "\" title=\"";
            yield ($context["name"] ?? null);
            yield "\" alt=\"";
            yield ($context["name"] ?? null);
            yield "\" class=\"img-fluid\" loading=\"eager\" width=\"180\" height=\"auto\"/>
            </a>
          ";
        } else {
            // line 120
            yield "            <h1><a href=\"";
            yield ($context["home"] ?? null);
            yield "\">";
            yield ($context["name"] ?? null);
            yield "</a></h1>
          ";
        }
        // line 122
        yield "        </div>
      </div>
      <div class=\"col-md-5\">";
        // line 124
        yield ($context["search"] ?? null);
        yield "</div>
      <div id=\"header-cart\" class=\"col-md-4 col-lg-3 mb-2\">";
        // line 125
        yield ($context["cart"] ?? null);
        yield "</div>
    </div>
  </div>
</header>
<main role=\"main\">
  ";
        // line 130
        yield ($context["menu"] ?? null);
        yield "
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "catalog/view/template/common/header.twig";
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
        return array (  376 => 130,  368 => 125,  364 => 124,  360 => 122,  352 => 120,  342 => 117,  337 => 116,  335 => 115,  320 => 103,  313 => 101,  306 => 97,  299 => 95,  292 => 91,  285 => 89,  279 => 85,  272 => 83,  265 => 81,  259 => 80,  253 => 79,  246 => 78,  239 => 76,  232 => 75,  230 => 74,  223 => 70,  218 => 68,  210 => 63,  205 => 61,  196 => 55,  192 => 54,  183 => 47,  174 => 45,  169 => 44,  158 => 42,  153 => 41,  144 => 39,  140 => 38,  137 => 37,  135 => 36,  122 => 34,  118 => 33,  109 => 27,  102 => 23,  98 => 22,  94 => 21,  88 => 18,  84 => 17,  80 => 15,  74 => 13,  71 => 12,  65 => 10,  63 => 9,  59 => 8,  55 => 7,  45 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "catalog/view/template/common/header.twig", "E:\\wamp64\\www\\reamur\\catalog\\view\\template\\common\\header.twig");
    }
}
