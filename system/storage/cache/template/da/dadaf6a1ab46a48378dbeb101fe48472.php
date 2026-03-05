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

/* catalog/view/template/account/account.twig */
class __TwigTemplate_6e7a376195c2aa69d80820642243c2e6 extends Template
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
<div id=\"account-account\" class=\"container\">
  ";
        // line 4
        yield "  <nav aria-label=\"breadcrumb\">
    <ul class=\"breadcrumb\">
      ";
        // line 6
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 7
            yield "        <li class=\"breadcrumb-item\">
          <a href=\"";
            // line 8
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 8);
            yield "\" ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "last", [], "any", false, false, false, 8)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "aria-current=\"page\"";
            }
            yield ">
            ";
            // line 9
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 9);
            yield "
          </a>
        </li>
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
        unset($context['_seq'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 13
        yield "    </ul>
  </nav>

  ";
        // line 17
        yield "  ";
        if ((($tmp = ($context["success"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 18
            yield "    <div class=\"alert alert-success alert-dismissible\" role=\"alert\">
      <i class=\"fa-solid fa-circle-check\" aria-hidden=\"true\"></i>
      <span>";
            // line 20
            yield ($context["success"] ?? null);
            yield "</span>
      <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
    </div>
  ";
        }
        // line 24
        yield "
  <div class=\"row\">
    ";
        // line 26
        yield ($context["column_left"] ?? null);
        yield "
    <div id=\"content\" class=\"col\">
      ";
        // line 28
        yield ($context["content_top"] ?? null);
        yield "

      ";
        // line 31
        yield "      <section aria-labelledby=\"account-heading\">
        <h2 id=\"account-heading\">";
        // line 32
        yield ($context["text_my_account"] ?? null);
        yield "</h2>
        <ul class=\"list-unstyled\">
          <li><a href=\"";
        // line 34
        yield ($context["edit"] ?? null);
        yield "\" class=\"account-link\">";
        yield ($context["text_edit"] ?? null);
        yield "</a></li>
          <li><a href=\"";
        // line 35
        yield ($context["password"] ?? null);
        yield "\" class=\"account-link\">";
        yield ($context["text_password"] ?? null);
        yield "</a></li>
          <li><a href=\"";
        // line 36
        yield ($context["address"] ?? null);
        yield "\" class=\"account-link\">";
        yield ($context["text_address"] ?? null);
        yield "</a></li>
          <li><a href=\"";
        // line 37
        yield ($context["wishlist"] ?? null);
        yield "\" class=\"account-link\">";
        yield ($context["text_wishlist"] ?? null);
        yield "</a></li>
        </ul>
      </section>

      ";
        // line 42
        yield "      <section aria-labelledby=\"orders-heading\">
        <h2 id=\"orders-heading\">";
        // line 43
        yield ($context["text_my_orders"] ?? null);
        yield "</h2>
        <ul class=\"list-unstyled\">
          <li><a href=\"";
        // line 45
        yield ($context["order"] ?? null);
        yield "\" class=\"account-link\">";
        yield ($context["text_order"] ?? null);
        yield "</a></li>
          <li><a href=\"";
        // line 46
        yield ($context["subscription"] ?? null);
        yield "\" class=\"account-link\">";
        yield ($context["text_subscription"] ?? null);
        yield "</a></li>
          <li><a href=\"";
        // line 47
        yield ($context["download"] ?? null);
        yield "\" class=\"account-link\">";
        yield ($context["text_download"] ?? null);
        yield "</a></li>
          ";
        // line 48
        if ((($tmp = ($context["reward"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 49
            yield "            <li><a href=\"";
            yield ($context["reward"] ?? null);
            yield "\" class=\"account-link\">";
            yield ($context["text_reward"] ?? null);
            yield "</a></li>
          ";
        }
        // line 51
        yield "          <li><a href=\"";
        yield ($context["return"] ?? null);
        yield "\" class=\"account-link\">";
        yield ($context["text_return"] ?? null);
        yield "</a></li>
          <li><a href=\"";
        // line 52
        yield ($context["transaction"] ?? null);
        yield "\" class=\"account-link\">";
        yield ($context["text_transaction"] ?? null);
        yield "</a></li>
        </ul>
      </section>

      ";
        // line 57
        yield "      ";
        if ((($tmp = ($context["affiliate"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 58
            yield "        <section aria-labelledby=\"affiliate-heading\">
          <h2 id=\"affiliate-heading\">";
            // line 59
            yield ($context["text_my_affiliate"] ?? null);
            yield "</h2>
          <ul class=\"list-unstyled\">
            ";
            // line 61
            if ((($tmp =  !($context["tracking"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 62
                yield "              <li><a href=\"";
                yield ($context["affiliate"] ?? null);
                yield "\" class=\"account-link\">";
                yield ($context["text_affiliate_add"] ?? null);
                yield "</a></li>
            ";
            } else {
                // line 64
                yield "              <li><a href=\"";
                yield ($context["affiliate"] ?? null);
                yield "\" class=\"account-link\">";
                yield ($context["text_affiliate_edit"] ?? null);
                yield "</a></li>
              <li><a href=\"";
                // line 65
                yield ($context["tracking"] ?? null);
                yield "\" class=\"account-link\">";
                yield ($context["text_tracking"] ?? null);
                yield "</a></li>
            ";
            }
            // line 67
            yield "          </ul>
        </section>
      ";
        }
        // line 70
        yield "
      ";
        // line 72
        yield "      <section aria-labelledby=\"newsletter-heading\">
        <h2 id=\"newsletter-heading\">";
        // line 73
        yield ($context["text_my_newsletter"] ?? null);
        yield "</h2>
        <ul class=\"list-unstyled\">
          <li><a href=\"";
        // line 75
        yield ($context["newsletter"] ?? null);
        yield "\" class=\"account-link\">";
        yield ($context["text_newsletter"] ?? null);
        yield "</a></li>
        </ul>
      </section>

      ";
        // line 79
        yield ($context["content_bottom"] ?? null);
        yield "
    </div>
    ";
        // line 81
        yield ($context["column_right"] ?? null);
        yield "
  </div>
</div>
";
        // line 84
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
        return "catalog/view/template/account/account.twig";
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
        return array (  288 => 84,  282 => 81,  277 => 79,  268 => 75,  263 => 73,  260 => 72,  257 => 70,  252 => 67,  245 => 65,  238 => 64,  230 => 62,  228 => 61,  223 => 59,  220 => 58,  217 => 57,  208 => 52,  201 => 51,  193 => 49,  191 => 48,  185 => 47,  179 => 46,  173 => 45,  168 => 43,  165 => 42,  156 => 37,  150 => 36,  144 => 35,  138 => 34,  133 => 32,  130 => 31,  125 => 28,  120 => 26,  116 => 24,  109 => 20,  105 => 18,  102 => 17,  97 => 13,  79 => 9,  71 => 8,  68 => 7,  51 => 6,  47 => 4,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "catalog/view/template/account/account.twig", "E:\\wamp64\\www\\reamur\\catalog\\view\\template\\account\\account.twig");
    }
}
