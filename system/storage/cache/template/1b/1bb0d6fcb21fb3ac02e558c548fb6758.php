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

/* catalog/view/template/product/product.twig */
class __TwigTemplate_38eaafb3799d736ffceefb298df9405c extends Template
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
<div id=\"product-info\" class=\"container\">
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
  <div class=\"row\">";
        // line 8
        yield ($context["column_left"] ?? null);
        yield "
    <div id=\"content\" class=\"col\">
      ";
        // line 10
        yield ($context["content_top"] ?? null);
        yield "

      <div class=\"row mb-3\">

        ";
        // line 14
        if ((($context["thumb"] ?? null) || ($context["images"] ?? null))) {
            // line 15
            yield "          <div class=\"col-sm\">
            <div class=\"image magnific-popup\">

              ";
            // line 18
            if ((($tmp = ($context["thumb"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 19
                yield "                <a href=\"";
                yield ($context["popup"] ?? null);
                yield "\" title=\"";
                yield ($context["heading_title"] ?? null);
                yield "\"><img src=\"";
                yield ($context["thumb"] ?? null);
                yield "\" title=\"";
                yield ($context["heading_title"] ?? null);
                yield "\" alt=\"";
                yield ($context["heading_title"] ?? null);
                yield "\" class=\"img-thumbnail mb-3\"/></a>
              ";
            }
            // line 21
            yield "
              ";
            // line 22
            if ((($tmp = ($context["images"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 23
                yield "                <div>
                  ";
                // line 24
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(($context["images"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
                    // line 25
                    yield "                    <a href=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["image"], "popup", [], "any", false, false, false, 25);
                    yield "\" title=\"";
                    yield ($context["heading_title"] ?? null);
                    yield "\"><img src=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["image"], "thumb", [], "any", false, false, false, 25);
                    yield "\" title=\"";
                    yield ($context["heading_title"] ?? null);
                    yield "\" alt=\"";
                    yield ($context["heading_title"] ?? null);
                    yield "\" class=\"img-thumbnail\"/></a>&nbsp;
                  ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['image'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 27
                yield "                </div>
              ";
            }
            // line 29
            yield "
            </div>
          </div>
        ";
        }
        // line 33
        yield "
        <div class=\"col-sm\">
          <h1>";
        // line 35
        yield ($context["heading_title"] ?? null);
        yield "</h1>
          <ul class=\"list-unstyled\">

            ";
        // line 38
        if ((($tmp = ($context["manufacturer"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 39
            yield "              <li>";
            yield ($context["text_manufacturer"] ?? null);
            yield " <a href=\"";
            yield ($context["manufacturers"] ?? null);
            yield "\">";
            yield ($context["manufacturer"] ?? null);
            yield "</a></li>
            ";
        }
        // line 41
        yield "
            <li>";
        // line 42
        yield ($context["text_model"] ?? null);
        yield " ";
        yield ($context["model"] ?? null);
        yield "</li>

            ";
        // line 44
        if ((($tmp = ($context["reward"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 45
            yield "              <li>";
            yield ($context["text_reward"] ?? null);
            yield " ";
            yield ($context["reward"] ?? null);
            yield "</li>
            ";
        }
        // line 47
        yield "
            <li>";
        // line 48
        yield ($context["text_stock"] ?? null);
        yield " ";
        yield ($context["stock"] ?? null);
        yield "</li>
          </ul>

          ";
        // line 51
        if ((($tmp = ($context["price"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 52
            yield "            <ul class=\"list-unstyled\">
              ";
            // line 53
            if ((($tmp =  !($context["special"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 54
                yield "                <li>
                  <h2><span class=\"price-new\">";
                // line 55
                yield ($context["price"] ?? null);
                yield "</span></h2>
                </li>
              ";
            } else {
                // line 58
                yield "                <li><span class=\"price-old\">";
                yield ($context["price"] ?? null);
                yield "</span></li>
                <li><h2><span class=\"price-new\">";
                // line 59
                yield ($context["special"] ?? null);
                yield "</span></h2></li>
              ";
            }
            // line 61
            yield "
              ";
            // line 62
            if ((($tmp = ($context["tax"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 63
                yield "                <li>";
                yield ($context["text_tax"] ?? null);
                yield " ";
                yield ($context["tax"] ?? null);
                yield "</li>
              ";
            }
            // line 65
            yield "
              ";
            // line 66
            if ((($tmp = ($context["points"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 67
                yield "                <li>";
                yield ($context["text_points"] ?? null);
                yield " ";
                yield ($context["points"] ?? null);
                yield "</li>
              ";
            }
            // line 69
            yield "
              ";
            // line 70
            if ((($tmp = ($context["discounts"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 71
                yield "                <li>
                  <hr>
                </li>
                ";
                // line 74
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(($context["discounts"] ?? null));
                foreach ($context['_seq'] as $context["_key"] => $context["discount"]) {
                    // line 75
                    yield "                  <li>";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["discount"], "quantity", [], "any", false, false, false, 75);
                    yield ($context["text_discount"] ?? null);
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["discount"], "price", [], "any", false, false, false, 75);
                    yield "</li>
                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['discount'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 77
                yield "              ";
            }
            // line 78
            yield "            </ul>
          ";
        }
        // line 80
        yield "
          <form method=\"post\" data-rms-toggle=\"ajax\">
            <div class=\"btn-group\">
              <button type=\"submit\" formaction=\"";
        // line 83
        yield ($context["add_to_wishlist"] ?? null);
        yield "\" data-bs-toggle=\"tooltip\" class=\"btn btn-light\" title=\"";
        yield ($context["button_wishlist"] ?? null);
        yield "\"><i class=\"fa-solid fa-heart\"></i></button>
              <button type=\"submit\" formaction=\"";
        // line 84
        yield ($context["add_to_compare"] ?? null);
        yield "\" data-bs-toggle=\"tooltip\" class=\"btn btn-light\" title=\"";
        yield ($context["button_compare"] ?? null);
        yield "\"><i class=\"fa-solid fa-arrow-right-arrow-left\"></i></button>
            </div>
            <input type=\"hidden\" name=\"product_id\" value=\"";
        // line 86
        yield ($context["product_id"] ?? null);
        yield "\"/>
          </form>
          <br/>
          <div id=\"product\">
            <form id=\"form-product\">
              ";
        // line 91
        if ((($tmp = ($context["options"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 92
            yield "            <hr>
              <h3>";
            // line 93
            yield ($context["text_option"] ?? null);
            yield "</h3>
              <div>
                ";
            // line 95
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["options"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
                // line 96
                yield "
                  ";
                // line 97
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 97) == "select")) {
                    // line 98
                    yield "                    <div class=\"mb-3";
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 98)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " required";
                    }
                    yield "\">
                      <label for=\"input-option-";
                    // line 99
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 99);
                    yield "\" class=\"form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 99);
                    yield "</label>
                      <select name=\"option[";
                    // line 100
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 100);
                    yield "]\" id=\"input-option-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 100);
                    yield "\" class=\"form-select\">
                        <option value=\"\">";
                    // line 101
                    yield ($context["text_select"] ?? null);
                    yield "</option>
                        ";
                    // line 102
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_value", [], "any", false, false, false, 102));
                    foreach ($context['_seq'] as $context["_key"] => $context["option_value"]) {
                        // line 103
                        yield "                          <option value=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 103);
                        yield "\">";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 103);
                        yield "
                            ";
                        // line 104
                        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 104)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                            // line 105
                            yield "                              (";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price_prefix", [], "any", false, false, false, 105);
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 105);
                            yield ")
                            ";
                        }
                        // line 106
                        yield "</option>
                        ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['option_value'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 108
                    yield "                      </select>
                      <div id=\"error-option-";
                    // line 109
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 109);
                    yield "\" class=\"invalid-feedback\"></div>
                    </div>
                  ";
                }
                // line 112
                yield "
                  ";
                // line 113
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 113) == "radio")) {
                    // line 114
                    yield "                    <div class=\"mb-3";
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 114)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " required";
                    }
                    yield "\">
                      <label class=\"form-label\">";
                    // line 115
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 115);
                    yield "</label>
                      <div id=\"input-option-";
                    // line 116
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 116);
                    yield "\">
                        ";
                    // line 117
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_value", [], "any", false, false, false, 117));
                    foreach ($context['_seq'] as $context["_key"] => $context["option_value"]) {
                        // line 118
                        yield "                          <div class=\"form-check\">
                            <input type=\"radio\" name=\"option[";
                        // line 119
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 119);
                        yield "]\" value=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 119);
                        yield "\" id=\"input-option-value-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 119);
                        yield "\" class=\"form-check-input\"/>
                            <label for=\"input-option-value-";
                        // line 120
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 120);
                        yield "\" class=\"form-check-label\">";
                        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "image", [], "any", false, false, false, 120)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                            yield "<img src=\"";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "image", [], "any", false, false, false, 120);
                            yield "\" alt=\"";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 120);
                            yield " ";
                            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 120)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                                yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price_prefix", [], "any", false, false, false, 120);
                                yield " ";
                                yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 120);
                            }
                            yield "\" class=\"img-thumbnail\"/>";
                        }
                        // line 121
                        yield "                              ";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 121);
                        yield "
                              ";
                        // line 122
                        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 122)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                            // line 123
                            yield "                                (";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price_prefix", [], "any", false, false, false, 123);
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 123);
                            yield ")
                              ";
                        }
                        // line 125
                        yield "                            </label>
                          </div>
                        ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['option_value'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 128
                    yield "                      </div>
                      <div id=\"error-option-";
                    // line 129
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 129);
                    yield "\" class=\"invalid-feedback\"></div>
                    </div>
                  ";
                }
                // line 132
                yield "
                  ";
                // line 133
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 133) == "checkbox")) {
                    // line 134
                    yield "                    <div class=\"mb-3";
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 134)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " required";
                    }
                    yield "\">
                      <label class=\"form-label\">";
                    // line 135
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 135);
                    yield "</label>
                      <div id=\"input-option-";
                    // line 136
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 136);
                    yield "\">
                        ";
                    // line 137
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_value", [], "any", false, false, false, 137));
                    foreach ($context['_seq'] as $context["_key"] => $context["option_value"]) {
                        // line 138
                        yield "                          <div class=\"form-check\">
                            <input type=\"checkbox\" name=\"option[";
                        // line 139
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 139);
                        yield "][]\" value=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 139);
                        yield "\" id=\"input-option-value-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 139);
                        yield "\" class=\"form-check-input\"/>
                            <label for=\"input-option-value-";
                        // line 140
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "product_option_value_id", [], "any", false, false, false, 140);
                        yield "\" class=\"form-check-label\">
                              ";
                        // line 141
                        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "image", [], "any", false, false, false, 141)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                            // line 142
                            yield "                                <img src=\"";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "image", [], "any", false, false, false, 142);
                            yield "\" alt=\"";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 142);
                            yield " ";
                            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 142)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                                yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price_prefix", [], "any", false, false, false, 142);
                                yield " ";
                                yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 142);
                            }
                            yield "\" class=\"img-thumbnail\"/>";
                        }
                        // line 143
                        yield "                              ";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "name", [], "any", false, false, false, 143);
                        yield "
                              ";
                        // line 144
                        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 144)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                            // line 145
                            yield "                                (";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price_prefix", [], "any", false, false, false, 145);
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["option_value"], "price", [], "any", false, false, false, 145);
                            yield ")
                              ";
                        }
                        // line 146
                        yield "</label>
                          </div>
                        ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['option_value'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 149
                    yield "                      </div>
                      <div id=\"error-option-";
                    // line 150
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 150);
                    yield "\" class=\"invalid-feedback\"></div>
                    </div>
                  ";
                }
                // line 153
                yield "
                  ";
                // line 154
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 154) == "text")) {
                    // line 155
                    yield "                    <div class=\"mb-3";
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 155)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " required";
                    }
                    yield "\">
                      <label for=\"input-option-";
                    // line 156
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 156);
                    yield "\" class=\"form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 156);
                    yield "</label>
                      <input type=\"text\" name=\"option[";
                    // line 157
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 157);
                    yield "]\" value=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 157);
                    yield "\" placeholder=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 157);
                    yield "\" id=\"input-option-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 157);
                    yield "\" class=\"form-control\"/>
                      <div id=\"error-option-";
                    // line 158
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 158);
                    yield "\" class=\"invalid-feedback\"></div>
                    </div>
                  ";
                }
                // line 161
                yield "
                  ";
                // line 162
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 162) == "textarea")) {
                    // line 163
                    yield "                    <div class=\"mb-3";
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 163)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " required";
                    }
                    yield "\">
                      <label for=\"input-option-";
                    // line 164
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 164);
                    yield "\" class=\"form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 164);
                    yield "</label>
                      <textarea name=\"option[";
                    // line 165
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 165);
                    yield "]\" rows=\"5\" placeholder=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 165);
                    yield "\" id=\"input-option-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 165);
                    yield "\" class=\"form-control\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 165);
                    yield "</textarea>
                      <div id=\"error-option-";
                    // line 166
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 166);
                    yield "\" class=\"invalid-feedback\"></div>
                    </div>
                  ";
                }
                // line 169
                yield "
                  ";
                // line 170
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 170) == "file")) {
                    // line 171
                    yield "                    <div class=\"mb-3";
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 171)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " required";
                    }
                    yield "\">
                      <label for=\"button-upload-";
                    // line 172
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 172);
                    yield "\" class=\"form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 172);
                    yield "</label>
                      <div>
                        <button type=\"button\" id=\"button-upload-";
                    // line 174
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 174);
                    yield "\" data-rms-toggle=\"upload\" data-rms-url=\"";
                    yield ($context["upload"] ?? null);
                    yield "\" data-rms-target=\"#input-option-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 174);
                    yield "\" data-rms-size-max=\"";
                    yield ($context["config_file_max_size"] ?? null);
                    yield "\" data-rms-size-error=\"";
                    yield ($context["error_upload_size"] ?? null);
                    yield "\" class=\"btn btn-light btn-block\"><i class=\"fa-solid fa-upload\"></i> ";
                    yield ($context["button_upload"] ?? null);
                    yield "</button>
                        <input type=\"hidden\" name=\"option[";
                    // line 175
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 175);
                    yield "]\" value=\"\" id=\"input-option-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 175);
                    yield "\"/>
                      </div>
                      <div id=\"error-option-";
                    // line 177
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 177);
                    yield "\" class=\"invalid-feedback\"></div>
                    </div>
                  ";
                }
                // line 180
                yield "
                  ";
                // line 181
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 181) == "date")) {
                    // line 182
                    yield "                    <div class=\"mb-3";
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 182)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " required";
                    }
                    yield "\">
                      <label for=\"input-option-";
                    // line 183
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 183);
                    yield "\" class=\"form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 183);
                    yield "</label>
                      <div class=\"input-group\">
                        <input type=\"text\" name=\"option[";
                    // line 185
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 185);
                    yield "]\" value=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 185);
                    yield "\" id=\"input-option-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 185);
                    yield "\" class=\"form-control date\"/>
                        <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                      </div>
                      <div id=\"error-option-";
                    // line 188
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 188);
                    yield "\" class=\"invalid-feedback\"></div>
                    </div>
                  ";
                }
                // line 191
                yield "
                  ";
                // line 192
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 192) == "datetime")) {
                    // line 193
                    yield "                    <div class=\"mb-3";
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 193)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " required";
                    }
                    yield "\">
                      <label for=\"input-option-";
                    // line 194
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 194);
                    yield "\" class=\"form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 194);
                    yield "</label>
                      <div class=\"input-group\">
                        <input type=\"text\" name=\"option[";
                    // line 196
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 196);
                    yield "]\" value=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 196);
                    yield "\" id=\"input-option-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 196);
                    yield "\" class=\"form-control datetime\"/>
                        <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                      </div>
                      <div id=\"error-option-";
                    // line 199
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 199);
                    yield "\" class=\"invalid-feedback\"></div>
                    </div>
                  ";
                }
                // line 202
                yield "
                  ";
                // line 203
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["option"], "type", [], "any", false, false, false, 203) == "time")) {
                    // line 204
                    yield "                    <div class=\"mb-3";
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["option"], "required", [], "any", false, false, false, 204)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " required";
                    }
                    yield "\">
                      <label for=\"input-option-";
                    // line 205
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 205);
                    yield "\" class=\"form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 205);
                    yield "</label>
                      <div class=\"input-group\">
                        <input type=\"text\" name=\"option[";
                    // line 207
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 207);
                    yield "]\" value=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 207);
                    yield "\" id=\"input-option-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 207);
                    yield "\" class=\"form-control time\"/>
                        <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                      </div>
                      <div id=\"error-option-";
                    // line 210
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["option"], "product_option_id", [], "any", false, false, false, 210);
                    yield "\" class=\"invalid-feedback\"></div>
                    </div>
                  ";
                }
                // line 213
                yield "
                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['option'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 215
            yield "                ";
        }
        // line 216
        yield "
                ";
        // line 217
        if ((($tmp = ($context["subscription_plans"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 218
            yield "                  <hr/>
                  <h3>";
            // line 219
            yield ($context["text_subscription"] ?? null);
            yield "</h3>
                  <div class=\"mb-3 required\">

                    <select name=\"subscription_plan_id\" id=\"input-subscription\" class=\"form-select\">
                      <option value=\"\">";
            // line 223
            yield ($context["text_select"] ?? null);
            yield "</option>
                      ";
            // line 224
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["subscription_plans"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["subscription_plan"]) {
                // line 225
                yield "                        <option value=\"";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["subscription_plan"], "subscription_plan_id", [], "any", false, false, false, 225);
                yield "\">";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["subscription_plan"], "name", [], "any", false, false, false, 225);
                yield "</option>
                      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['subscription_plan'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 227
            yield "                    </select>

                    ";
            // line 229
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["subscription_plans"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["subscription_plan"]) {
                // line 230
                yield "                      <div id=\"subscription-description-";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["subscription_plan"], "subscription_plan_id", [], "any", false, false, false, 230);
                yield "\" class=\"form-text subscription d-none\">";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["subscription_plan"], "description", [], "any", false, false, false, 230);
                yield "</div>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['subscription_plan'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 232
            yield "                    <div id=\"error-subscription\" class=\"invalid-feedback\"></div>

                  </div>
                ";
        }
        // line 236
        yield "
                <div class=\"mb-3\">
                  <label for=\"input-quantity\" class=\"form-label\">";
        // line 238
        yield ($context["entry_qty"] ?? null);
        yield "</label>
                  <input type=\"text\" name=\"quantity\" value=\"";
        // line 239
        yield ($context["minimum"] ?? null);
        yield "\" size=\"2\" id=\"input-quantity\" class=\"form-control\"/>
                  <input type=\"hidden\" name=\"product_id\" value=\"";
        // line 240
        yield ($context["product_id"] ?? null);
        yield "\" id=\"input-product-id\"/>
                  <div id=\"error-quantity\" class=\"form-text\"></div>
                  <br/>
                  <button type=\"submit\" id=\"button-cart\" class=\"btn btn-primary btn-lg btn-block\">";
        // line 243
        yield ($context["button_cart"] ?? null);
        yield "</button>
                </div>

                ";
        // line 246
        if ((($context["minimum"] ?? null) > 1)) {
            // line 247
            yield "                  <div class=\"alert alert-info\"><i class=\"fa-solid fa-circle-info\"></i> ";
            yield ($context["text_minimum"] ?? null);
            yield "</div>
                ";
        }
        // line 249
        yield "              </div>
              ";
        // line 250
        if ((($tmp = ($context["review_status"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 251
            yield "                <div class=\"rating\">
                  <p>";
            // line 252
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(1, 5));
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 253
                yield "                      ";
                if ((($context["rating"] ?? null) < $context["i"])) {
                    // line 254
                    yield "                        <span class=\"fa-stack\"><i class=\"fa-regular fa-star fa-stack-1x\"></i></span>
                      ";
                } else {
                    // line 256
                    yield "                        <span class=\"fa-stack\"><i class=\"fa-solid fa-star fa-stack-1x\"></i><i class=\"fa-regular fa-star fa-stack-1x\"></i></span>
                      ";
                }
                // line 258
                yield "                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['i'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 259
            yield "                    <a href=\"\" onclick=\"\$('a[href=\\'#tab-review\\']').tab('show'); return false;\">";
            yield ($context["text_reviews"] ?? null);
            yield "</a> / <a href=\"\" onclick=\"\$('a[href=\\'#tab-review\\']').tab('show'); return false;\">";
            yield ($context["text_write"] ?? null);
            yield "</a></p>
                </div>
              ";
        }
        // line 262
        yield "            </form>
          </div>
        </div>
        <ul class=\"nav nav-tabs\">
          <li class=\"nav-item\"><a href=\"#tab-description\" data-bs-toggle=\"tab\" class=\"nav-link active\">";
        // line 266
        yield ($context["tab_description"] ?? null);
        yield "</a></li>

          ";
        // line 268
        if ((($tmp = ($context["attribute_groups"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 269
            yield "            <li class=\"nav-item\"><a href=\"#tab-specification\" data-bs-toggle=\"tab\" class=\"nav-link\">";
            yield ($context["tab_attribute"] ?? null);
            yield "</a></li>
          ";
        }
        // line 271
        yield "
          ";
        // line 272
        if ((($tmp = ($context["review_status"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 273
            yield "            <li class=\"nav-item\"><a href=\"#tab-review\" data-bs-toggle=\"tab\" class=\"nav-link\">";
            yield ($context["tab_review"] ?? null);
            yield "</a></li>
          ";
        }
        // line 275
        yield "
        </ul>
        <div class=\"tab-content\">

          <div id=\"tab-description\" class=\"tab-pane fade show active mb-4\">";
        // line 279
        yield ($context["description"] ?? null);
        yield "</div>

          ";
        // line 281
        if ((($tmp = ($context["attribute_groups"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 282
            yield "            <div id=\"tab-specification\" class=\"tab-pane fade\">
              <div class=\"table-responsive\">
                <table class=\"table table-bordered\">
                  ";
            // line 285
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["attribute_groups"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["attribute_group"]) {
                // line 286
                yield "                    <thead>
                      <tr>
                        <td colspan=\"2\"><strong>";
                // line 288
                yield CoreExtension::getAttribute($this->env, $this->source, $context["attribute_group"], "name", [], "any", false, false, false, 288);
                yield "</strong></td>
                      </tr>
                    </thead>
                    <tbody>
                      ";
                // line 292
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["attribute_group"], "attribute", [], "any", false, false, false, 292));
                foreach ($context['_seq'] as $context["_key"] => $context["attribute"]) {
                    // line 293
                    yield "                        <tr>
                          <td>";
                    // line 294
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["attribute"], "name", [], "any", false, false, false, 294);
                    yield "</td>
                          <td>";
                    // line 295
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["attribute"], "text", [], "any", false, false, false, 295);
                    yield "</td>
                        </tr>
                      ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['attribute'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 298
                yield "                    </tbody>
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['attribute_group'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 300
            yield "                </table>
              </div>
            </div>
          ";
        }
        // line 304
        yield "
          ";
        // line 305
        if ((($tmp = ($context["review_status"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 306
            yield "            <div id=\"tab-review\" class=\"tab-pane fade mb-4\">";
            yield ($context["review"] ?? null);
            yield "</div>
          ";
        }
        // line 308
        yield "
        </div>
      </div>

      ";
        // line 312
        if ((($tmp = ($context["products"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 313
            yield "        <h3>";
            yield ($context["text_related"] ?? null);
            yield "</h3>
        <div class=\"row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4\">
          ";
            // line 315
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["products"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
                // line 316
                yield "            <div class=\"col mb-3\">";
                yield $context["product"];
                yield "</div>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['product'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 318
            yield "        </div>
      ";
        }
        // line 320
        yield "
      ";
        // line 321
        if ((($tmp = ($context["tags"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 322
            yield "        <p>";
            yield ($context["text_tags"] ?? null);
            yield "
          ";
            // line 323
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(range(0, (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["tags"] ?? null)) - 1)));
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
            foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                // line 324
                yield "            <a href=\"";
                yield CoreExtension::getAttribute($this->env, $this->source, (($_v0 = ($context["tags"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[$context["i"]] ?? null) : null), "href", [], "any", false, false, false, 324);
                yield "\">";
                yield CoreExtension::getAttribute($this->env, $this->source, (($_v1 = ($context["tags"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[$context["i"]] ?? null) : null), "tag", [], "any", false, false, false, 324);
                yield "</a>";
                if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "end", [], "any", false, false, false, 324)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield ",";
                }
                // line 325
                yield "          ";
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
            unset($context['_seq'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 326
            yield "        </p>
      ";
        }
        // line 328
        yield "
      ";
        // line 329
        yield ($context["content_bottom"] ?? null);
        yield "</div>
    ";
        // line 330
        yield ($context["column_right"] ?? null);
        yield "</div>
</div>
<script type=\"text/javascript\"><!--
\$('#input-subscription').on('change', function(e) {
    var element = this;

    \$('.subscription').addClass('d-none');

    \$('#subscription-description-' + \$(element).val()).removeClass('d-none');
});

\$('#form-product').on('submit', function(e) {
    e.preventDefault();

    \$.ajax({
        url: 'index.php?route=checkout/cart.add&language=";
        // line 345
        yield ($context["language"] ?? null);
        yield "',
        type: 'post',
        data: \$('#form-product').serialize(),
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded',
        cache: false,
        processData: false,
        beforeSend: function() {
            \$('#button-cart').button('loading');
        },
        complete: function() {
            \$('#button-cart').button('reset');
        },
        success: function(json) {
            console.log(json);

            \$('#form-product').find('.is-invalid').removeClass('is-invalid');
            \$('#form-product').find('.invalid-feedback').removeClass('d-block');

            if (json['error']) {
                for (key in json['error']) {
                    \$('#input-' + key.replaceAll('_', '-')).addClass('is-invalid').find('.form-control, .form-select, .form-check-input, .form-check-label').addClass('is-invalid');
                    \$('#error-' + key.replaceAll('_', '-')).html(json['error'][key]).addClass('d-block');
                }
            }

            if (json['success']) {
                \$('#alert').prepend('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa-solid fa-circle-check\"></i> ' + json['success'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');

                \$('#header-cart').load('index.php?route=common/cart.info');
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

\$(document).ready(function() {
    \$('.magnific-popup').magnificPopup({
        type: 'image',
        delegate: 'a',
        gallery: {
            enabled: true
        }
    });
});
//--></script>
";
        // line 393
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
        return "catalog/view/template/product/product.twig";
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
        return array (  1174 => 393,  1123 => 345,  1105 => 330,  1101 => 329,  1098 => 328,  1094 => 326,  1080 => 325,  1071 => 324,  1054 => 323,  1049 => 322,  1047 => 321,  1044 => 320,  1040 => 318,  1031 => 316,  1027 => 315,  1021 => 313,  1019 => 312,  1013 => 308,  1007 => 306,  1005 => 305,  1002 => 304,  996 => 300,  989 => 298,  980 => 295,  976 => 294,  973 => 293,  969 => 292,  962 => 288,  958 => 286,  954 => 285,  949 => 282,  947 => 281,  942 => 279,  936 => 275,  930 => 273,  928 => 272,  925 => 271,  919 => 269,  917 => 268,  912 => 266,  906 => 262,  897 => 259,  891 => 258,  887 => 256,  883 => 254,  880 => 253,  876 => 252,  873 => 251,  871 => 250,  868 => 249,  862 => 247,  860 => 246,  854 => 243,  848 => 240,  844 => 239,  840 => 238,  836 => 236,  830 => 232,  819 => 230,  815 => 229,  811 => 227,  800 => 225,  796 => 224,  792 => 223,  785 => 219,  782 => 218,  780 => 217,  777 => 216,  774 => 215,  767 => 213,  761 => 210,  751 => 207,  744 => 205,  737 => 204,  735 => 203,  732 => 202,  726 => 199,  716 => 196,  709 => 194,  702 => 193,  700 => 192,  697 => 191,  691 => 188,  681 => 185,  674 => 183,  667 => 182,  665 => 181,  662 => 180,  656 => 177,  649 => 175,  635 => 174,  628 => 172,  621 => 171,  619 => 170,  616 => 169,  610 => 166,  600 => 165,  594 => 164,  587 => 163,  585 => 162,  582 => 161,  576 => 158,  566 => 157,  560 => 156,  553 => 155,  551 => 154,  548 => 153,  542 => 150,  539 => 149,  531 => 146,  524 => 145,  522 => 144,  517 => 143,  504 => 142,  502 => 141,  498 => 140,  490 => 139,  487 => 138,  483 => 137,  479 => 136,  475 => 135,  468 => 134,  466 => 133,  463 => 132,  457 => 129,  454 => 128,  446 => 125,  439 => 123,  437 => 122,  432 => 121,  416 => 120,  408 => 119,  405 => 118,  401 => 117,  397 => 116,  393 => 115,  386 => 114,  384 => 113,  381 => 112,  375 => 109,  372 => 108,  365 => 106,  358 => 105,  356 => 104,  349 => 103,  345 => 102,  341 => 101,  335 => 100,  329 => 99,  322 => 98,  320 => 97,  317 => 96,  313 => 95,  308 => 93,  305 => 92,  303 => 91,  295 => 86,  288 => 84,  282 => 83,  277 => 80,  273 => 78,  270 => 77,  259 => 75,  255 => 74,  250 => 71,  248 => 70,  245 => 69,  237 => 67,  235 => 66,  232 => 65,  224 => 63,  222 => 62,  219 => 61,  214 => 59,  209 => 58,  203 => 55,  200 => 54,  198 => 53,  195 => 52,  193 => 51,  185 => 48,  182 => 47,  174 => 45,  172 => 44,  165 => 42,  162 => 41,  152 => 39,  150 => 38,  144 => 35,  140 => 33,  134 => 29,  130 => 27,  113 => 25,  109 => 24,  106 => 23,  104 => 22,  101 => 21,  87 => 19,  85 => 18,  80 => 15,  78 => 14,  71 => 10,  66 => 8,  63 => 7,  52 => 5,  48 => 4,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "catalog/view/template/product/product.twig", "E:\\wamp64\\www\\reamur\\catalog\\view\\template\\product\\product.twig");
    }
}
