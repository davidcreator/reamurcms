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

/* admin/view/template/customer/customer_form.twig */
class __TwigTemplate_65829534a030423d0f1f2d808a774693 extends Template
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
        ";
        // line 6
        if ((($tmp = ($context["orders"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 7
            yield "          <a href=\"";
            yield ($context["orders"] ?? null);
            yield "\" data-bs-toggle=\"tooltip\" title=\"";
            yield ($context["button_order"] ?? null);
            yield "\" class=\"btn btn-warning\"><i class=\"fa-solid fa-receipt\"></i></a>
        ";
        }
        // line 9
        yield "        <button type=\"submit\" form=\"form-customer\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["button_save"] ?? null);
        yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-floppy-disk\"></i></button>
        <a href=\"";
        // line 10
        yield ($context["back"] ?? null);
        yield "\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["button_back"] ?? null);
        yield "\" class=\"btn btn-light\"><i class=\"fa-solid fa-reply\"></i></a></div>
      <h1>";
        // line 11
        yield ($context["heading_title"] ?? null);
        yield "</h1>
      <ol class=\"breadcrumb\">
        ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 14
            yield "          <li class=\"breadcrumb-item\"><a href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 14);
            yield "\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 14);
            yield "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['breadcrumb'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        yield "      </ol>
    </div>
  </div>
  <div class=\"container-fluid\">
    <div class=\"card\">
      <div class=\"card-header\"><i class=\"fa-solid fa-pencil\"></i> ";
        // line 21
        yield ($context["text_form"] ?? null);
        yield "</div>
      <div class=\"card-body\">
        <form id=\"form-customer\" action=\"";
        // line 23
        yield ($context["save"] ?? null);
        yield "\" method=\"post\" data-rms-toggle=\"ajax\">
          <ul class=\"nav nav-tabs\">
            <li class=\"nav-item\"><a href=\"#tab-general\" data-bs-toggle=\"tab\" class=\"nav-link active\">";
        // line 25
        yield ($context["tab_general"] ?? null);
        yield "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-address\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 26
        yield ($context["tab_address"] ?? null);
        yield "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-payment\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 27
        yield ($context["tab_payment_method"] ?? null);
        yield "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-history\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 28
        yield ($context["tab_history"] ?? null);
        yield "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-transaction\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 29
        yield ($context["tab_transaction"] ?? null);
        yield "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-reward\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 30
        yield ($context["tab_reward"] ?? null);
        yield "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-ip\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 31
        yield ($context["tab_ip"] ?? null);
        yield "</a></li>
          </ul>
          <div class=\"tab-content\">
            <div id=\"tab-general\" class=\"tab-pane active\">
              <fieldset>
                <legend>";
        // line 36
        yield ($context["text_customer"] ?? null);
        yield "</legend>
                <div class=\"row mb-3\">
                  <label for=\"input-store\" class=\"col-sm-2 col-form-label\">";
        // line 38
        yield ($context["entry_store"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <select name=\"store_id\" id=\"input-store\" class=\"form-select\">
                      ";
        // line 41
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["stores"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["store"]) {
            // line 42
            yield "                        <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 42);
            yield "\"";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 42) == ($context["store_id"] ?? null))) {
                yield " selected";
            }
            yield ">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["store"], "name", [], "any", false, false, false, 42);
            yield "</option>
                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['store'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        yield "                    </select>
                  </div>
                </div>
                <div class=\"row mb-3\">
                  <label for=\"input-customer-group\" class=\"col-sm-2 col-form-label\">";
        // line 48
        yield ($context["entry_customer_group"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <select name=\"customer_group_id\" id=\"input-customer-group\" class=\"form-select\">
                      ";
        // line 51
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["customer_groups"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["customer_group"]) {
            // line 52
            yield "                        <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["customer_group"], "customer_group_id", [], "any", false, false, false, 52);
            yield "\"";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["customer_group"], "customer_group_id", [], "any", false, false, false, 52) == ($context["customer_group_id"] ?? null))) {
                yield " selected";
            }
            yield ">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["customer_group"], "name", [], "any", false, false, false, 52);
            yield "</option>
                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['customer_group'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        yield "                    </select>
                  </div>
                </div>
                <div class=\"row mb-3 required\">
                  <label for=\"input-firstname\" class=\"col-sm-2 col-form-label\">";
        // line 58
        yield ($context["entry_firstname"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"firstname\" value=\"";
        // line 60
        yield ($context["firstname"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_firstname"] ?? null);
        yield "\" id=\"input-firstname\" class=\"form-control\"/>
                    <div id=\"error-firstname\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
                <div class=\"row mb-3 required\">
                  <label for=\"input-lastname\" class=\"col-sm-2 col-form-label\">";
        // line 65
        yield ($context["entry_lastname"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"lastname\" value=\"";
        // line 67
        yield ($context["lastname"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_lastname"] ?? null);
        yield "\" id=\"input-lastname\" class=\"form-control\"/>
                    <div id=\"error-lastname\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
                <div class=\"row mb-3 required\">
                  <label for=\"input-email\" class=\"col-sm-2 col-form-label\">";
        // line 72
        yield ($context["entry_email"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"email\" value=\"";
        // line 74
        yield ($context["email"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_email"] ?? null);
        yield "\" id=\"input-email\" class=\"form-control\"/>
                    <div id=\"error-email\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
                <div class=\"row mb-3";
        // line 78
        if ((($tmp = ($context["config_telephone_required"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " required";
        }
        yield "\">
                  <label for=\"input-telephone\" class=\"col-sm-2 col-form-label\">";
        // line 79
        yield ($context["entry_telephone"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"telephone\" value=\"";
        // line 81
        yield ($context["telephone"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_telephone"] ?? null);
        yield "\" id=\"input-telephone\" class=\"form-control\"/>
                    <div id=\"error-telephone\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
                ";
        // line 85
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["custom_fields"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["custom_field"]) {
            // line 86
            yield "
                  ";
            // line 87
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "location", [], "any", false, false, false, 87) == "account")) {
                // line 88
                yield "
                    ";
                // line 89
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 89) == "select")) {
                    // line 90
                    yield "                      <div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 90);
                    yield "\">
                        <label for=\"input-custom-field-";
                    // line 91
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 91);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 91);
                    yield "</label>
                        <div class=\"col-sm-10\">
                          <select name=\"custom_field[";
                    // line 93
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 93);
                    yield "]\" id=\"input-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 93);
                    yield "\" class=\"form-select\">
                            <option value=\"\">";
                    // line 94
                    yield ($context["text_select"] ?? null);
                    yield "</option>
                            ";
                    // line 95
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 95));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 96
                        yield "                              <option value=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 96);
                        yield "\"";
                        if (((($_v0 = ($context["account_custom_field"] ?? null)) && is_array($_v0) || $_v0 instanceof ArrayAccess ? ($_v0[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 96)] ?? null) : null) && (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 96) == (($_v1 = ($context["account_custom_field"] ?? null)) && is_array($_v1) || $_v1 instanceof ArrayAccess ? ($_v1[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 96)] ?? null) : null)))) {
                            yield " selected";
                        }
                        yield ">";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 96);
                        yield "</option>
                            ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['custom_field_value'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 98
                    yield "                          </select>
                          <div id=\"error-custom-field-";
                    // line 99
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 99);
                    yield "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 103
                yield "
                    ";
                // line 104
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 104) == "radio")) {
                    // line 105
                    yield "                      <div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 105);
                    yield "\">
                        <label class=\"col-sm-2 col-form-label\">";
                    // line 106
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 106);
                    yield "</label>
                        <div class=\"col-sm-10\">
                          <div id=\"input-custom-field-";
                    // line 108
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 108);
                    yield "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">
                            ";
                    // line 109
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 109));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 110
                        yield "                              <div class=\"form-check\">
                                <input type=\"radio\" name=\"custom_field[";
                        // line 111
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 111);
                        yield "]\" value=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 111);
                        yield "\" id=\"input-custom-value-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 111);
                        yield "\" class=\"form-check-input\"";
                        if (((($_v2 = ($context["account_custom_field"] ?? null)) && is_array($_v2) || $_v2 instanceof ArrayAccess ? ($_v2[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 111)] ?? null) : null) && (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 111) == (($_v3 = ($context["account_custom_field"] ?? null)) && is_array($_v3) || $_v3 instanceof ArrayAccess ? ($_v3[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 111)] ?? null) : null)))) {
                            yield " checked";
                        }
                        yield "/> <label for=\"input-custom-value-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 111);
                        yield "\" class=\"form-check-label\">";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 111);
                        yield "</label>
                              </div>
                            ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['custom_field_value'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 114
                    yield "                          </div>
                          <div id=\"error-custom-field-";
                    // line 115
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 115);
                    yield "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 119
                yield "
                    ";
                // line 120
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 120) == "checkbox")) {
                    // line 121
                    yield "                      <div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 121);
                    yield "\">
                        <label class=\"col-sm-2 col-form-label\">";
                    // line 122
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 122);
                    yield "</label>
                        <div class=\"col-sm-10\">
                          <div id=\"input-custom-field-";
                    // line 124
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 124);
                    yield "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">
                            ";
                    // line 125
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 125));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 126
                        yield "                              <div class=\"form-check\">
                                <input type=\"checkbox\" name=\"custom_field[";
                        // line 127
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 127);
                        yield "][]\" value=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 127);
                        yield "\" id=\"input-custom-value-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 127);
                        yield "\" class=\"form-check-input\"";
                        if (((($_v4 = ($context["account_custom_field"] ?? null)) && is_array($_v4) || $_v4 instanceof ArrayAccess ? ($_v4[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 127)] ?? null) : null) && CoreExtension::inFilter(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 127), (($_v5 = ($context["account_custom_field"] ?? null)) && is_array($_v5) || $_v5 instanceof ArrayAccess ? ($_v5[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 127)] ?? null) : null)))) {
                            yield " checked";
                        }
                        yield "/> <label for=\"input-custom-value-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 127);
                        yield "\" class=\"form-check-label\">";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 127);
                        yield "</label>
                              </div>
                            ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['custom_field_value'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 130
                    yield "                          </div>
                          <div id=\"error-custom-field-";
                    // line 131
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 131);
                    yield "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 135
                yield "
                    ";
                // line 136
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 136) == "text")) {
                    // line 137
                    yield "                      <div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 137);
                    yield "\">
                        <label for=\"input-custom-field-";
                    // line 138
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 138);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 138);
                    yield "</label>
                        <div class=\"col-sm-10\">
                          <input type=\"text\" name=\"custom_field[";
                    // line 140
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 140);
                    yield "]\" value=\"";
                    yield (((($tmp = (($_v6 = ($context["account_custom_field"] ?? null)) && is_array($_v6) || $_v6 instanceof ArrayAccess ? ($_v6[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 140)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v7 = ($context["account_custom_field"] ?? null)) && is_array($_v7) || $_v7 instanceof ArrayAccess ? ($_v7[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 140)] ?? null) : null)) : (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 140)));
                    yield "\" placeholder=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 140);
                    yield "\" id=\"input-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 140);
                    yield "\" class=\"form-control\"/>
                          <div id=\"error-custom-field-";
                    // line 141
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 141);
                    yield "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 145
                yield "
                    ";
                // line 146
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 146) == "textarea")) {
                    // line 147
                    yield "                      <div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 147);
                    yield "\">
                        <label for=\"input-custom-field-";
                    // line 148
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 148);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 148);
                    yield "</label>
                        <div class=\"col-sm-10\">
                          <textarea name=\"custom_field[";
                    // line 150
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 150);
                    yield "]\" rows=\"5\" placeholder=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 150);
                    yield "\" id=\"input-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 150);
                    yield "\" class=\"form-control\">";
                    yield (((($tmp = (($_v8 = ($context["account_custom_field"] ?? null)) && is_array($_v8) || $_v8 instanceof ArrayAccess ? ($_v8[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 150)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v9 = ($context["account_custom_field"] ?? null)) && is_array($_v9) || $_v9 instanceof ArrayAccess ? ($_v9[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 150)] ?? null) : null)) : (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 150)));
                    yield "</textarea>
                          <div id=\"error-custom-field-";
                    // line 151
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 151);
                    yield "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 155
                yield "
                    ";
                // line 156
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 156) == "file")) {
                    // line 157
                    yield "                      <div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 157);
                    yield "\">
                        <label class=\"col-sm-2 col-form-label\">";
                    // line 158
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 158);
                    yield "</label>
                        <div class=\"col-sm-10\">

                          <div class=\"input-group\">
                            <button type=\"button\" data-rms-toggle=\"upload\" data-rms-url=\"";
                    // line 162
                    yield ($context["upload"] ?? null);
                    yield "\" data-rms-target=\"#input-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 162);
                    yield "\" data-rms-size-max=\"";
                    yield ($context["config_file_max_size"] ?? null);
                    yield "\" data-rms-size-error=\"";
                    yield ($context["error_upload_size"] ?? null);
                    yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-upload\"></i> ";
                    yield ($context["button_upload"] ?? null);
                    yield "</button>
                            <input type=\"text\" name=\"custom_field[";
                    // line 163
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 163);
                    yield "]\" value=\"";
                    yield (((($tmp = (($_v10 = ($context["account_custom_field"] ?? null)) && is_array($_v10) || $_v10 instanceof ArrayAccess ? ($_v10[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 163)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v11 = ($context["account_custom_field"] ?? null)) && is_array($_v11) || $_v11 instanceof ArrayAccess ? ($_v11[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 163)] ?? null) : null)) : (""));
                    yield "\" id=\"input-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 163);
                    yield "\" class=\"form-control\" readonly/>
                            <button type=\"button\" data-rms-toggle=\"download\" data-rms-target=\"#input-custom-field-";
                    // line 164
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 164);
                    yield "\"";
                    if ((($tmp =  !(($_v12 = ($context["account_custom_field"] ?? null)) && is_array($_v12) || $_v12 instanceof ArrayAccess ? ($_v12[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 164)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " disabled";
                    }
                    yield " class=\"btn btn-outline-secondary\"><i class=\"fa-solid fa-download\"></i> ";
                    yield ($context["button_download"] ?? null);
                    yield "</button>
                            <button type=\"button\" data-rms-toggle=\"clear\" data-bs-toggle=\"tooltip\" title=\"";
                    // line 165
                    yield ($context["button_clear"] ?? null);
                    yield "\" data-rms-target=\"#input-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 165);
                    yield "\"";
                    if ((($tmp =  !(($_v13 = ($context["account_custom_field"] ?? null)) && is_array($_v13) || $_v13 instanceof ArrayAccess ? ($_v13[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 165)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " disabled";
                    }
                    yield " class=\"btn btn-outline-danger\"><i class=\"fa-solid fa-eraser\"></i></button>
                          </div>

                          <div id=\"error-custom-field-";
                    // line 168
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 168);
                    yield "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 172
                yield "
                    ";
                // line 173
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 173) == "date")) {
                    // line 174
                    yield "                      <div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 174);
                    yield "\">
                        <label for=\"input-custom-field-";
                    // line 175
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 175);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 175);
                    yield "</label>
                        <div class=\"col-sm-10\">
                          <div class=\"input-group\">
                            <input type=\"text\" name=\"custom_field[";
                    // line 178
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 178);
                    yield "]\" value=\"";
                    yield (((($tmp = (($_v14 = ($context["account_custom_field"] ?? null)) && is_array($_v14) || $_v14 instanceof ArrayAccess ? ($_v14[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 178)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v15 = ($context["account_custom_field"] ?? null)) && is_array($_v15) || $_v15 instanceof ArrayAccess ? ($_v15[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 178)] ?? null) : null)) : (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 178)));
                    yield "\" placeholder=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 178);
                    yield "\" id=\"input-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 178);
                    yield "\" class=\"form-control date\"/>
                            <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                          </div>
                          <div id=\"error-custom-field-";
                    // line 181
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 181);
                    yield "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 185
                yield "
                    ";
                // line 186
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 186) == "time")) {
                    // line 187
                    yield "                      <div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 187);
                    yield "\">
                        <label for=\"input-custom-field-";
                    // line 188
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 188);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 188);
                    yield "</label>
                        <div class=\"col-sm-10\">
                          <div class=\"input-group\">
                            <input type=\"text\" name=\"custom_field[";
                    // line 191
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 191);
                    yield "]\" value=\"";
                    yield (((($tmp = (($_v16 = ($context["account_custom_field"] ?? null)) && is_array($_v16) || $_v16 instanceof ArrayAccess ? ($_v16[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 191)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v17 = ($context["account_custom_field"] ?? null)) && is_array($_v17) || $_v17 instanceof ArrayAccess ? ($_v17[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 191)] ?? null) : null)) : (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 191)));
                    yield "\" placeholder=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 191);
                    yield "\" id=\"input-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 191);
                    yield "\" class=\"form-control time\"/>
                            <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                          </div>
                          <div id=\"error-custom-field-";
                    // line 194
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 194);
                    yield "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 198
                yield "
                    ";
                // line 199
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 199) == "datetime")) {
                    // line 200
                    yield "                      <div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 200);
                    yield "\">
                        <label for=\"input-custom-field-";
                    // line 201
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 201);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 201);
                    yield "</label>
                        <div class=\"col-sm-10\">
                          <div class=\"input-group\">
                            <input type=\"text\" name=\"custom_field[";
                    // line 204
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 204);
                    yield "]\" value=\"";
                    yield (((($tmp = (($_v18 = ($context["account_custom_field"] ?? null)) && is_array($_v18) || $_v18 instanceof ArrayAccess ? ($_v18[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 204)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v19 = ($context["account_custom_field"] ?? null)) && is_array($_v19) || $_v19 instanceof ArrayAccess ? ($_v19[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 204)] ?? null) : null)) : (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 204)));
                    yield "\" placeholder=\"";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 204);
                    yield "\" id=\"input-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 204);
                    yield "\" class=\"form-control datetime\"/>
                            <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                          </div>
                          <div id=\"error-custom-field-";
                    // line 207
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 207);
                    yield "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 211
                yield "
                  ";
            }
            // line 213
            yield "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['custom_field'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 214
        yield "              </fieldset>
              <fieldset>
                <legend>";
        // line 216
        yield ($context["text_password"] ?? null);
        yield "</legend>
                <div class=\"row mb-3 required\">
                  <label for=\"input-password\" class=\"col-sm-2 col-form-label\">";
        // line 218
        yield ($context["entry_password"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"password\" name=\"password\" value=\"";
        // line 220
        yield ($context["password"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_password"] ?? null);
        yield "\" id=\"input-password\" class=\"form-control\" autocomplete=\"new-password\"/>
                    <div id=\"error-password\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
                <div class=\"row mb-3 required\">
                  <label for=\"input-confirm\" class=\"col-sm-2 col-form-label\">";
        // line 225
        yield ($context["entry_confirm"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"password\" name=\"confirm\" value=\"";
        // line 227
        yield ($context["confirm"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_confirm"] ?? null);
        yield "\" id=\"input-confirm\" class=\"form-control\"/>
                    <div id=\"error-confirm\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>";
        // line 233
        yield ($context["text_other"] ?? null);
        yield "</legend>
                <div class=\"row mb-3\">
                  <label class=\"col-sm-2 col-form-label\">";
        // line 235
        yield ($context["entry_newsletter"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <div class=\"form-check form-switch form-switch-lg\">
                      <input type=\"hidden\" name=\"newsletter\" value=\"0\"/> <input type=\"checkbox\" name=\"newsletter\" value=\"1\" id=\"input-newsletter\" class=\"form-check-input\"";
        // line 238
        if ((($tmp = ($context["newsletter"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " checked";
        }
        yield "/>
                    </div>
                  </div>
                </div>
                <div class=\"row mb-3\">
                  <label class=\"col-sm-2 col-form-label\">";
        // line 243
        yield ($context["entry_status"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <div class=\"form-check form-switch form-switch-lg\">
                      <input type=\"hidden\" name=\"status\" value=\"0\"/> <input type=\"checkbox\" name=\"status\" value=\"1\" id=\"input-status\" class=\"form-check-input\"";
        // line 246
        if ((($tmp = ($context["status"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " checked";
        }
        yield "/>
                    </div>
                  </div>
                </div>
                <div class=\"row mb-3\">
                  <label class=\"col-sm-2 col-form-label\">";
        // line 251
        yield ($context["entry_safe"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <div class=\"form-check form-switch form-switch-lg\">
                      <input type=\"hidden\" name=\"safe\" value=\"0\"/> <input type=\"checkbox\" name=\"safe\" value=\"1\" id=\"input-safe\" class=\"form-check-input\"";
        // line 254
        if ((($tmp = ($context["safe"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " checked";
        }
        yield "/>
                    </div>
                    <div class=\"form-text\">";
        // line 256
        yield ($context["help_safe"] ?? null);
        yield "</div>
                  </div>
                </div>
              </fieldset>
            </div>
            <div id=\"tab-address\" class=\"tab-pane\">
              ";
        // line 262
        $context["address_row"] = 0;
        // line 263
        yield "              ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["addresses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["address"]) {
            // line 264
            yield "                <fieldset id=\"address-row-";
            yield ($context["address_row"] ?? null);
            yield "\">
                  <legend>";
            // line 265
            yield ($context["text_address"] ?? null);
            yield " ";
            yield (($context["address_row"] ?? null) + 1);
            yield " <button type=\"button\" onclick=\"\$('#address-row-";
            yield ($context["address_row"] ?? null);
            yield "').remove();\" data-bs-toggle=\"tooltip\" title=\"";
            yield ($context["button_remove"] ?? null);
            yield "\" class=\"btn btn-danger btn-sm float-end\"><i class=\"fa-solid fa-minus-circle\"></i></button></legend>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 267
            yield ($context["address_row"] ?? null);
            yield "-firstname\" class=\"col-sm-2 col-form-label\">";
            yield ($context["entry_firstname"] ?? null);
            yield "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 269
            yield ($context["address_row"] ?? null);
            yield "][firstname]\" value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["address"], "firstname", [], "any", false, false, false, 269);
            yield "\" placeholder=\"";
            yield ($context["entry_firstname"] ?? null);
            yield "\" id=\"input-address-";
            yield ($context["address_row"] ?? null);
            yield "-firstname\" class=\"form-control\"/>
                      <div id=\"error-address-";
            // line 270
            yield ($context["address_row"] ?? null);
            yield "-firstname\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 274
            yield ($context["address_row"] ?? null);
            yield "-lastname\" class=\"col-sm-2 col-form-label\">";
            yield ($context["entry_lastname"] ?? null);
            yield "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 276
            yield ($context["address_row"] ?? null);
            yield "][lastname]\" value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["address"], "lastname", [], "any", false, false, false, 276);
            yield "\" placeholder=\"";
            yield ($context["entry_lastname"] ?? null);
            yield "\" id=\"input-address-";
            yield ($context["address_row"] ?? null);
            yield "-lastname\" class=\"form-control\"/>
                      <div id=\"error-address-";
            // line 277
            yield ($context["address_row"] ?? null);
            yield "-lastname\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3\">
                    <label for=\"input-address-";
            // line 281
            yield ($context["address_row"] ?? null);
            yield "-company\" class=\"col-sm-2 col-form-label\">";
            yield ($context["entry_company"] ?? null);
            yield "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 283
            yield ($context["address_row"] ?? null);
            yield "][company]\" value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["address"], "company", [], "any", false, false, false, 283);
            yield "\" placeholder=\"";
            yield ($context["entry_company"] ?? null);
            yield "\" id=\"input-address-";
            yield ($context["address_row"] ?? null);
            yield "-company\" class=\"form-control\"/>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 287
            yield ($context["address_row"] ?? null);
            yield "-address-1\" class=\"col-sm-2 col-form-label\">";
            yield ($context["entry_address_1"] ?? null);
            yield "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 289
            yield ($context["address_row"] ?? null);
            yield "][address_1]\" value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["address"], "address_1", [], "any", false, false, false, 289);
            yield "\" placeholder=\"";
            yield ($context["entry_address_1"] ?? null);
            yield "\" id=\"input-address-";
            yield ($context["address_row"] ?? null);
            yield "-address-1\" class=\"form-control\"/>
                      <div id=\"error-address-";
            // line 290
            yield ($context["address_row"] ?? null);
            yield "-address-1\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3\">
                    <label for=\"input-address-";
            // line 294
            yield ($context["address_row"] ?? null);
            yield "-address-2\" class=\"col-sm-2 col-form-label\">";
            yield ($context["entry_address_2"] ?? null);
            yield "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 296
            yield ($context["address_row"] ?? null);
            yield "][address_2]\" value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["address"], "address_2", [], "any", false, false, false, 296);
            yield "\" placeholder=\"";
            yield ($context["entry_address_2"] ?? null);
            yield "\" id=\"input-address-";
            yield ($context["address_row"] ?? null);
            yield "-address-2\" class=\"form-control\"/>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 300
            yield ($context["address_row"] ?? null);
            yield "-city\" class=\"col-sm-2 col-form-label\">";
            yield ($context["entry_city"] ?? null);
            yield "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 302
            yield ($context["address_row"] ?? null);
            yield "][city]\" value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["address"], "city", [], "any", false, false, false, 302);
            yield "\" placeholder=\"";
            yield ($context["entry_city"] ?? null);
            yield "\" id=\"input-address-";
            yield ($context["address_row"] ?? null);
            yield "-city\" class=\"form-control\"/>
                      <div id=\"error-address-";
            // line 303
            yield ($context["address_row"] ?? null);
            yield "-city\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 307
            yield ($context["address_row"] ?? null);
            yield "-postcode\" class=\"col-sm-2 col-form-label\">";
            yield ($context["entry_postcode"] ?? null);
            yield "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 309
            yield ($context["address_row"] ?? null);
            yield "][postcode]\" value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["address"], "postcode", [], "any", false, false, false, 309);
            yield "\" placeholder=\"";
            yield ($context["entry_postcode"] ?? null);
            yield "\" id=\"input-address-";
            yield ($context["address_row"] ?? null);
            yield "-postcode\" class=\"form-control\"/>
                      <div id=\"error-address-";
            // line 310
            yield ($context["address_row"] ?? null);
            yield "-postcode\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 314
            yield ($context["address_row"] ?? null);
            yield "-country\" class=\"col-sm-2 col-form-label\">";
            yield ($context["entry_country"] ?? null);
            yield "</label>
                    <div class=\"col-sm-10\">
                      <select name=\"address[";
            // line 316
            yield ($context["address_row"] ?? null);
            yield "][country_id]\" id=\"input-address-";
            yield ($context["address_row"] ?? null);
            yield "-country\" class=\"form-select\" data-address-row=\"";
            yield ($context["address_row"] ?? null);
            yield "\" data-zone-id=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["address"], "zone_id", [], "any", false, false, false, 316);
            yield "\" disabled>
                        <option value=\"0\">";
            // line 317
            yield ($context["text_select"] ?? null);
            yield "</option>
                        ";
            // line 318
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["countries"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
                // line 319
                yield "                          <option value=\"";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 319);
                yield "\"";
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 319) == CoreExtension::getAttribute($this->env, $this->source, $context["address"], "country_id", [], "any", false, false, false, 319))) {
                    yield " selected";
                }
                yield ">";
                yield CoreExtension::getAttribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 319);
                yield "</option>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['country'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 321
            yield "                      </select>
                      <div id=\"error-address-";
            // line 322
            yield ($context["address_row"] ?? null);
            yield "-country\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 326
            yield ($context["address_row"] ?? null);
            yield "-zone\" class=\"col-sm-2 col-form-label\">";
            yield ($context["entry_zone"] ?? null);
            yield "</label>
                    <div class=\"col-sm-10\">
                      <select name=\"address[";
            // line 328
            yield ($context["address_row"] ?? null);
            yield "][zone_id]\" id=\"input-address-";
            yield ($context["address_row"] ?? null);
            yield "-zone\" class=\"form-select\" disabled></select>
                      <div id=\"error-address-";
            // line 329
            yield ($context["address_row"] ?? null);
            yield "-zone\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>

                  ";
            // line 333
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["custom_fields"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["custom_field"]) {
                // line 334
                yield "                    ";
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "location", [], "any", false, false, false, 334) == "address")) {
                    // line 335
                    yield "
                      ";
                    // line 336
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 336) == "select")) {
                        // line 337
                        yield "                        <div class=\"row mb-3 custom-field custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 337);
                        yield "\">
                          <label for=\"input-address-";
                        // line 338
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 338);
                        yield "\" class=\"col-sm-2 col-form-label\">";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 338);
                        yield "</label>
                          <div class=\"col-sm-10\">
                            <select name=\"address[";
                        // line 340
                        yield ($context["address_row"] ?? null);
                        yield "][custom_field][";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 340);
                        yield "]\" id=\"input-address-";
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 340);
                        yield "\" class=\"form-select\">
                              <option value=\"\">";
                        // line 341
                        yield ($context["text_select"] ?? null);
                        yield "</option>
                              ";
                        // line 342
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 342));
                        foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                            // line 343
                            yield "                                <option value=\"";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 343);
                            yield "\"";
                            if (((($_v20 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 343)) && is_array($_v20) || $_v20 instanceof ArrayAccess ? ($_v20[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 343)] ?? null) : null) && (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 343) == (($_v21 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 343)) && is_array($_v21) || $_v21 instanceof ArrayAccess ? ($_v21[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 343)] ?? null) : null)))) {
                                yield " selected";
                            }
                            yield ">";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 343);
                            yield "</option>
                              ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_key'], $context['custom_field_value'], $context['_parent']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 345
                        yield "                            </select>
                            <div id=\"error-address-";
                        // line 346
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 346);
                        yield "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 350
                    yield "
                      ";
                    // line 351
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 351) == "radio")) {
                        // line 352
                        yield "                        <div class=\"row mb-3 custom-field custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 352);
                        yield "\">
                          <label class=\"col-sm-2 col-form-label\">";
                        // line 353
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 353);
                        yield "</label>
                          <div class=\"col-sm-10\">
                            <div id=\"input-address-";
                        // line 355
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 355);
                        yield "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">
                              ";
                        // line 356
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 356));
                        foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                            // line 357
                            yield "                                <div class=\"form-check\">
                                  <input type=\"radio\" name=\"address[";
                            // line 358
                            yield ($context["address_row"] ?? null);
                            yield "][custom_field][";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 358);
                            yield "]\" value=\"";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 358);
                            yield "\" id=\"input-custom-value-";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 358);
                            yield "\" class=\"form-check-input\"";
                            if (((($_v22 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 358)) && is_array($_v22) || $_v22 instanceof ArrayAccess ? ($_v22[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 358)] ?? null) : null) && (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 358) == (($_v23 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 358)) && is_array($_v23) || $_v23 instanceof ArrayAccess ? ($_v23[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 358)] ?? null) : null)))) {
                                yield " checked";
                            }
                            yield "/> <label for=\"input-custom-value-";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 358);
                            yield "\" class=\"form-check-label\">";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 358);
                            yield "</label>
                                </div>
                              ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_key'], $context['custom_field_value'], $context['_parent']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 361
                        yield "                            </div>
                            <div id=\"error-address-";
                        // line 362
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 362);
                        yield "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 366
                    yield "
                      ";
                    // line 367
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 367) == "checkbox")) {
                        // line 368
                        yield "                        <div class=\"row mb-3 custom-field custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 368);
                        yield "\">
                          <label class=\"col-sm-2 col-form-label\">";
                        // line 369
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 369);
                        yield "</label>
                          <div class=\"col-sm-10\">
                            <div id=\"input-address-";
                        // line 371
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 371);
                        yield "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">
                              ";
                        // line 372
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 372));
                        foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                            // line 373
                            yield "                                <div class=\"form-check\">
                                  <input type=\"checkbox\" name=\"address[";
                            // line 374
                            yield ($context["address_row"] ?? null);
                            yield "][custom_field][";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 374);
                            yield "][]\" value=\"";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 374);
                            yield "\" id=\"input-custom-value-";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 374);
                            yield "\" class=\"form-check-input\"";
                            if (((($_v24 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 374)) && is_array($_v24) || $_v24 instanceof ArrayAccess ? ($_v24[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 374)] ?? null) : null) && CoreExtension::inFilter(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 374), (($_v25 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 374)) && is_array($_v25) || $_v25 instanceof ArrayAccess ? ($_v25[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 374)] ?? null) : null)))) {
                                yield " checked";
                            }
                            yield "/> <label for=\"input-custom-value-";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 374);
                            yield "\" class=\"form-check-label\">";
                            yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 374);
                            yield "</label>
                                </div>
                              ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_key'], $context['custom_field_value'], $context['_parent']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 377
                        yield "                            </div>
                            <div id=\"error-address-";
                        // line 378
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 378);
                        yield "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 382
                    yield "
                      ";
                    // line 383
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 383) == "text")) {
                        // line 384
                        yield "                        <div class=\"row mb-3 custom-field custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 384);
                        yield "\">
                          <label for=\"input-address-";
                        // line 385
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 385);
                        yield "\" class=\"col-sm-2 col-form-label\">";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 385);
                        yield "</label>
                          <div class=\"col-sm-10\">
                            <input type=\"text\" name=\"address[";
                        // line 387
                        yield ($context["address_row"] ?? null);
                        yield "][custom_field][";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 387);
                        yield "]\" value=\"";
                        yield (((($tmp = (($_v26 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 387)) && is_array($_v26) || $_v26 instanceof ArrayAccess ? ($_v26[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 387)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v27 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 387)) && is_array($_v27) || $_v27 instanceof ArrayAccess ? ($_v27[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 387)] ?? null) : null)) : (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 387)));
                        yield "\" placeholder=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 387);
                        yield "\" id=\"input-address-";
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 387);
                        yield "\" class=\"form-control\"/>
                            <div id=\"error-address-";
                        // line 388
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 388);
                        yield "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 392
                    yield "
                      ";
                    // line 393
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 393) == "textarea")) {
                        // line 394
                        yield "                        <div class=\"row mb-3 custom-field custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 394);
                        yield "\">
                          <label for=\"input-address-";
                        // line 395
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 395);
                        yield "\" class=\"col-sm-2 col-form-label\">";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 395);
                        yield "</label>
                          <div class=\"col-sm-10\">
                            <textarea name=\"address[";
                        // line 397
                        yield ($context["address_row"] ?? null);
                        yield "][custom_field][";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 397);
                        yield "]\" rows=\"5\" placeholder=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 397);
                        yield "\" id=\"input-address-";
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 397);
                        yield "\" class=\"form-control\">";
                        yield (((($tmp = (($_v28 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 397)) && is_array($_v28) || $_v28 instanceof ArrayAccess ? ($_v28[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 397)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v29 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 397)) && is_array($_v29) || $_v29 instanceof ArrayAccess ? ($_v29[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 397)] ?? null) : null)) : (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 397)));
                        yield "</textarea>
                            <div id=\"error-address-";
                        // line 398
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 398);
                        yield "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 402
                    yield "
                      ";
                    // line 403
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 403) == "file")) {
                        // line 404
                        yield "                        <div class=\"row mb-3 custom-field custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 404);
                        yield "\">
                          <label class=\"col-sm-2 col-form-label\">";
                        // line 405
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 405);
                        yield "</label>
                          <div class=\"col-sm-10\">
                            <div class=\"input-group\">
                              <button type=\"button\" data-rms-toggle=\"upload\" data-rms-url=\"";
                        // line 408
                        yield ($context["upload"] ?? null);
                        yield "\" data-rms-target=\"#input-address-";
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 408);
                        yield "\" data-rms-size-max=\"";
                        yield ($context["config_file_max_size"] ?? null);
                        yield "\" data-rms-size-error=\"";
                        yield ($context["error_upload_size"] ?? null);
                        yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-upload\"></i> ";
                        yield ($context["button_upload"] ?? null);
                        yield "</button>
                              <input type=\"text\" name=\"address[";
                        // line 409
                        yield ($context["address_row"] ?? null);
                        yield "][custom_field][";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 409);
                        yield "]\" value=\"";
                        yield (((($tmp = (($_v30 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 409)) && is_array($_v30) || $_v30 instanceof ArrayAccess ? ($_v30[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 409)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v31 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 409)) && is_array($_v31) || $_v31 instanceof ArrayAccess ? ($_v31[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 409)] ?? null) : null)) : (""));
                        yield "\" id=\"input-address-";
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 409);
                        yield "\" class=\"form-control\" readonly/>
                              <button type=\"button\" data-rms-toggle=\"download\" data-rms-target=\"#input-address-";
                        // line 410
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 410);
                        yield "\" class=\"btn btn-outline-secondary\"";
                        if ((($tmp =  !(($_v32 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 410)) && is_array($_v32) || $_v32 instanceof ArrayAccess ? ($_v32[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 410)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                            yield " disabled";
                        }
                        yield "><i class=\"fa-solid fa-download\"></i> ";
                        yield ($context["button_download"] ?? null);
                        yield "</button>
                              <button type=\"button\" data-rms-toggle=\"clear\" data-rms-target=\"#input-address-";
                        // line 411
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 411);
                        yield "\" data-bs-toggle=\"tooltip\" title=\"";
                        yield ($context["button_clear"] ?? null);
                        yield "\" class=\"btn btn-outline-danger\"";
                        if ((($tmp =  !(($_v33 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 411)) && is_array($_v33) || $_v33 instanceof ArrayAccess ? ($_v33[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 411)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                            yield " disabled";
                        }
                        yield "><i class=\"fa-solid fa-eraser\"></i></button>
                            </div>
                            <div id=\"error-address-";
                        // line 413
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 413);
                        yield "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 417
                    yield "
                      ";
                    // line 418
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 418) == "date")) {
                        // line 419
                        yield "                        <div class=\"row mb-3 custom-field custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 419);
                        yield "\">
                          <label for=\"input-address-";
                        // line 420
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 420);
                        yield "\" class=\"col-sm-2 col-form-label\">";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 420);
                        yield "</label>
                          <div class=\"col-sm-10\">
                            <div class=\"input-group\">
                              <input type=\"text\" name=\"address[";
                        // line 423
                        yield ($context["address_row"] ?? null);
                        yield "][custom_field][";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 423);
                        yield "]\" value=\"";
                        yield (((($tmp = (($_v34 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 423)) && is_array($_v34) || $_v34 instanceof ArrayAccess ? ($_v34[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 423)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v35 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 423)) && is_array($_v35) || $_v35 instanceof ArrayAccess ? ($_v35[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 423)] ?? null) : null)) : (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 423)));
                        yield "\" placeholder=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 423);
                        yield "\" id=\"input-address-";
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 423);
                        yield "\" class=\"form-control date\"/>
                              <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                            </div>
                            <div id=\"error-address-";
                        // line 426
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 426);
                        yield "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 430
                    yield "
                      ";
                    // line 431
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 431) == "time")) {
                        // line 432
                        yield "                        <div class=\"row mb-3 custom-field custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 432);
                        yield "\">
                          <label for=\"input-address-";
                        // line 433
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 433);
                        yield "\" class=\"col-sm-2 col-form-label\">";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 433);
                        yield "</label>
                          <div class=\"col-sm-10\">
                            <div class=\"input-group\">
                              <input type=\"text\" name=\"address[";
                        // line 436
                        yield ($context["address_row"] ?? null);
                        yield "][custom_field][";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 436);
                        yield "]\" value=\"";
                        yield (((($tmp = (($_v36 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 436)) && is_array($_v36) || $_v36 instanceof ArrayAccess ? ($_v36[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 436)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v37 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 436)) && is_array($_v37) || $_v37 instanceof ArrayAccess ? ($_v37[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 436)] ?? null) : null)) : (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 436)));
                        yield "\" placeholder=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 436);
                        yield "\" id=\"input-address-";
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 436);
                        yield "\" class=\"form-control time\"/>
                              <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                            </div>
                            <div id=\"error-address-";
                        // line 439
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 439);
                        yield "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 443
                    yield "
                      ";
                    // line 444
                    if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 444) == "datetime")) {
                        // line 445
                        yield "                        <div class=\"row mb-3 custom-field custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 445);
                        yield "\">
                          <label for=\"input-address-";
                        // line 446
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 446);
                        yield "\" class=\"col-sm-2 col-form-label\">";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 446);
                        yield "</label>
                          <div class=\"col-sm-10\">
                            <div class=\"input-group\">
                              <input type=\"text\" name=\"address[";
                        // line 449
                        yield ($context["address_row"] ?? null);
                        yield "][custom_field][";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 449);
                        yield "]\" value=\"";
                        yield (((($tmp = (($_v38 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 449)) && is_array($_v38) || $_v38 instanceof ArrayAccess ? ($_v38[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 449)] ?? null) : null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ((($_v39 = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 449)) && is_array($_v39) || $_v39 instanceof ArrayAccess ? ($_v39[CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 449)] ?? null) : null)) : (CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 449)));
                        yield "\" placeholder=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 449);
                        yield "\" id=\"input-address-";
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 449);
                        yield "\" class=\"form-control datetime\"/>
                              <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                            </div>
                            <div id=\"error-address-";
                        // line 452
                        yield ($context["address_row"] ?? null);
                        yield "-custom-field-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 452);
                        yield "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 456
                    yield "
                    ";
                }
                // line 458
                yield "
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['custom_field'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 460
            yield "
                  <div class=\"row mb-3\">
                    <label for=\"input-address-";
            // line 462
            yield ($context["address_row"] ?? null);
            yield "-default\" class=\"col-sm-2 col-form-label\">";
            yield ($context["entry_default"] ?? null);
            yield "</label>
                    <div class=\"col-sm-10\">
                      <div class=\"form-check\">
                        <input type=\"radio\" name=\"address[";
            // line 465
            yield ($context["address_row"] ?? null);
            yield "][default]\" value=\"1\" id=\"input-address-";
            yield ($context["address_row"] ?? null);
            yield "-default\" class=\"form-check-input\"";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["address"], "default", [], "any", false, false, false, 465)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield " checked";
            }
            yield "/>
                      </div>
                    </div>
                  </div>
                  <input type=\"hidden\" name=\"address[";
            // line 469
            yield ($context["address_row"] ?? null);
            yield "][address_id]\" value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["address"], "address_id", [], "any", false, false, false, 469);
            yield "\"/>
                </fieldset>
                ";
            // line 471
            $context["address_row"] = (($context["address_row"] ?? null) + 1);
            // line 472
            yield "              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['address'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 473
        yield "              <div class=\"text-end\">
                <button type=\"button\" id=\"button-address\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus-circle\"></i> ";
        // line 474
        yield ($context["button_address_add"] ?? null);
        yield "</button>
              </div>
              <input type=\"hidden\" name=\"customer_id\" value=\"";
        // line 476
        yield ($context["customer_id"] ?? null);
        yield "\" id=\"input-customer-id\"/>
            </div>

            <div id=\"tab-payment\" class=\"tab-pane\">
              <fieldset>
                <legend>";
        // line 481
        yield ($context["text_payment_method"] ?? null);
        yield "</legend>
                <div id=\"payment-method\">";
        // line 482
        yield ($context["payment_method"] ?? null);
        yield "</div>
              </fieldset>
            </div>
            <div id=\"tab-history\" class=\"tab-pane\">
              <fieldset>
                <legend>";
        // line 487
        yield ($context["text_history"] ?? null);
        yield "</legend>
                <div id=\"history\">";
        // line 488
        yield ($context["history"] ?? null);
        yield "</div>
              </fieldset>
              <fieldset>
                <legend>";
        // line 491
        yield ($context["text_history_add"] ?? null);
        yield "</legend>
                <div class=\"row mb-3\">
                  <label for=\"input-history\" class=\"col-sm-2 col-form-label\">";
        // line 493
        yield ($context["entry_comment"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <textarea name=\"comment\" rows=\"8\" placeholder=\"";
        // line 495
        yield ($context["entry_comment"] ?? null);
        yield "\" id=\"input-history\" class=\"form-control\"></textarea>
                  </div>
                </div>
                <div class=\"text-end\">
                  <button type=\"button\" id=\"button-history\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus-circle\"></i> ";
        // line 499
        yield ($context["button_history_add"] ?? null);
        yield "</button>
                </div>
              </fieldset>
            </div>

            <div id=\"tab-transaction\" class=\"tab-pane\">
              <fieldset>
                <legend>";
        // line 506
        yield ($context["text_transaction"] ?? null);
        yield "</legend>
                <div id=\"transaction\">";
        // line 507
        yield ($context["transaction"] ?? null);
        yield "</div>
              </fieldset>
              <fieldset>
                <legend>";
        // line 510
        yield ($context["text_transaction_add"] ?? null);
        yield "</legend>
                <div class=\"row mb-3\">
                  <label for=\"input-transaction\" class=\"col-sm-2 col-form-label\">";
        // line 512
        yield ($context["entry_description"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"description\" value=\"\" placeholder=\"";
        // line 514
        yield ($context["entry_description"] ?? null);
        yield "\" id=\"input-transaction\" class=\"form-control\"/>
                  </div>
                </div>
                <div class=\"row mb-3\">
                  <label for=\"input-amount\" class=\"col-sm-2 col-form-label\">";
        // line 518
        yield ($context["entry_amount"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"amount\" value=\"\" placeholder=\"";
        // line 520
        yield ($context["entry_amount"] ?? null);
        yield "\" id=\"input-amount\" class=\"form-control\"/>
                  </div>
                </div>
                <div class=\"text-end\">
                  <button type=\"button\" id=\"button-transaction\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus-circle\"></i> ";
        // line 524
        yield ($context["button_transaction_add"] ?? null);
        yield "</button>
                </div>
              </fieldset>
            </div>
            <div id=\"tab-reward\" class=\"tab-pane\">
              <fieldset>
                <legend>";
        // line 530
        yield ($context["text_reward"] ?? null);
        yield "</legend>
                <div id=\"reward\">";
        // line 531
        yield ($context["reward"] ?? null);
        yield "</div>
              </fieldset>
              <fieldset>
                <legend>";
        // line 534
        yield ($context["text_reward_add"] ?? null);
        yield "</legend>
                <div class=\"row mb-3\">
                  <label for=\"input-reward\" class=\"col-sm-2 col-form-label\">";
        // line 536
        yield ($context["entry_description"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"description\" value=\"\" placeholder=\"";
        // line 538
        yield ($context["entry_description"] ?? null);
        yield "\" id=\"input-reward\" class=\"form-control\"/>
                  </div>
                </div>
                <div class=\"row mb-3\">
                  <label for=\"input-points\" class=\"col-sm-2 col-form-label\">";
        // line 542
        yield ($context["entry_points"] ?? null);
        yield "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"points\" value=\"\" placeholder=\"";
        // line 544
        yield ($context["entry_points"] ?? null);
        yield "\" id=\"input-points\" class=\"form-control\"/>
                    <div class=\"form-text\">";
        // line 545
        yield ($context["help_points"] ?? null);
        yield "</div>
                  </div>
                </div>
                <div class=\"text-end\">
                  <button type=\"button\" id=\"button-reward\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus-circle\"></i> ";
        // line 549
        yield ($context["button_reward_add"] ?? null);
        yield "</button>
                </div>
              </fieldset>
            </div>
            <div id=\"tab-ip\" class=\"tab-pane\">
              <fieldset>
                <legend>";
        // line 555
        yield ($context["text_ip"] ?? null);
        yield "</legend>
                <div id=\"ip\">";
        // line 556
        yield ($context["ip"] ?? null);
        yield "</div>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type=\"text/javascript\"><!--
\$('#input-customer-group').on('change', function () {
    \$.ajax({
        url: 'index.php?route=customer/customer.customfield&user_token=";
        // line 568
        yield ($context["user_token"] ?? null);
        yield "&customer_group_id=' + this.value,
        dataType: 'json',
        success: function (json) {
            \$('.custom-field').hide();
            \$('.custom-field').removeClass('required');

            for (i = 0; i < json.length; i++) {
                custom_field = json[i];

                \$('.custom-field-' + custom_field['custom_field_id']).show();

                if (custom_field['required']) {
                    \$('.custom-field-' + custom_field['custom_field_id']).addClass('required');
                }
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

\$('#input-customer-group').trigger('change');

var address_row = ";
        // line 592
        yield ($context["address_row"] ?? null);
        yield ";

\$('#button-address').on('click', function (e) {
    e.preventDefault();

    html = '<fieldset id=\"address-row-' + address_row + '\">';
    html += '  <legend>";
        // line 598
        yield ($context["text_address"] ?? null);
        yield " ' + (address_row + 1) + ' <button type=\"button\" onclick=\"\$(\\'#address-row-' + address_row + '\\').remove();\" data-bs-toggle=\"tooltip\" title=\"";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["button_remove"] ?? null), "js");
        yield "\" class=\"btn btn-danger btn-sm float-end\"><i class=\"fa-solid fa-minus-circle\"></i></button></legend>';
    html += '  <input type=\"hidden\" name=\"address[' + address_row + '][address_id]\" value=\"\" />';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-firstname\" class=\"col-sm-2 col-form-label\">";
        // line 602
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_firstname"] ?? null), "js");
        yield "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][firstname]\" value=\"\" placeholder=\"";
        // line 604
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_firstname"] ?? null), "js");
        yield "\" id=\"input-address-' + address_row + '-firstname\" class=\"form-control\"/>';
    html += '      <div id=\"error-address-' + address_row + '-firstname\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-lastname\" class=\"col-sm-2 col-form-label\">";
        // line 610
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_lastname"] ?? null), "js");
        yield "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][lastname]\" value=\"\" placeholder=\"";
        // line 612
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_lastname"] ?? null), "js");
        yield "\" id=\"input-address-' + address_row + '-lastname\" class=\"form-control\"/>';
    html += '      <div id=\"error-address-' + address_row + '-lastname\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3\">';
    html += '    <label for=\"input-address-' + address_row + '-company\" class=\"col-sm-2 col-form-label\">";
        // line 618
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_company"] ?? null), "js");
        yield "</label>';
    html += '    <div class=\"col-sm-10\"><input type=\"text\" name=\"address[' + address_row + '][company]\" value=\"\" placeholder=\"";
        // line 619
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_company"] ?? null), "js");
        yield "\" id=\"input-address-' + address_row + '-company\" class=\"form-control\"/></div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-address-1\" class=\"col-sm-2 col-form-label\">";
        // line 623
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_address_1"] ?? null), "js");
        yield "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][address_1]\" value=\"\" placeholder=\"";
        // line 625
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_address_1"] ?? null), "js");
        yield "\" id=\"input-address-' + address_row + '-address-1\" class=\"form-control\"/>';
    html += '      <div id=\"error-address-' + address_row + '-address-1\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3\">';
    html += '    <label for=\"input-address-' + address_row + '-address-2\" class=\"col-sm-2 col-form-label\">";
        // line 631
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_address_2"] ?? null), "js");
        yield "</label>';
    html += '    <div class=\"col-sm-10\"><input type=\"text\" name=\"address[' + address_row + '][address_2]\" value=\"\" placeholder=\"";
        // line 632
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_address_2"] ?? null), "js");
        yield "\" id=\"input-address-' + address_row + '-address-2\" class=\"form-control\"/></div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-city\" class=\"col-sm-2 col-form-label\">";
        // line 636
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_city"] ?? null), "js");
        yield "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][city]\" value=\"\" placeholder=\"";
        // line 638
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_city"] ?? null), "js");
        yield "\" id=\"input-address-' + address_row + '-city\" class=\"form-control\"/>';
    html += '      <div id=\"error-address-' + address_row + '-city\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-postcode\" class=\"col-sm-2 col-form-label\">";
        // line 644
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_postcode"] ?? null), "js");
        yield "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][postcode]\" value=\"\" placeholder=\"";
        // line 646
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_postcode"] ?? null), "js");
        yield "\" id=\"input-address-' + address_row + '-postcode\" class=\"form-control\"/>';
    html += '      <div id=\"error-address-' + address_row + '-postcode\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-country\" class=\"col-sm-2 col-form-label\">";
        // line 652
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_country"] ?? null), "js");
        yield "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '       <select name=\"address[' + address_row + '][country_id]\" id=\"input-address-' + address_row + '-country\" data-address-row=\"' + address_row + '\" data-zone-id=\"0\" class=\"form-select\" disabled>';
    html += '         <option value=\"0\">";
        // line 655
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text_select"] ?? null), "js");
        yield "</option>';
  ";
        // line 656
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["countries"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 657
            yield "    html += '         <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 657);
            yield "\">";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 657), "js");
            yield "</option>';
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['country'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 659
        yield "    html += '      </select>';
    html += '      <div id=\"error-address-' + address_row + '-country\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-zone\" class=\"col-sm-2 col-form-label\">";
        // line 665
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_zone"] ?? null), "js");
        yield "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <select name=\"address[' + address_row + '][zone_id]\" id=\"input-address-' + address_row + '-zone\" class=\"form-select\" disabled><option value=\"\">";
        // line 667
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text_none"] ?? null), "js");
        yield "</option></select>';
    html += '      <div id=\"error-address-' + address_row + '-zone\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    // Custom Fields
  ";
        // line 673
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["custom_fields"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["custom_field"]) {
            // line 674
            yield "  ";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "location", [], "any", false, false, false, 674) == "address")) {
                // line 675
                yield "  ";
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 675) == "select")) {
                    // line 676
                    yield "
    html += '<div class=\"row mb-3 custom-field custom-field-";
                    // line 677
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 677);
                    yield "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 678
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 678);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 678), "js");
                    yield "</label>';
    html += '\t <div class=\"col-sm-10\">';
    html += '    <select name=\"address[' + address_row + '][custom_field][";
                    // line 680
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 680);
                    yield "]\" id=\"input-address-' + address_row + '-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 680);
                    yield "\" class=\"form-select\">';
    html += '      <option value=\"\">";
                    // line 681
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text_select"] ?? null), "js");
                    yield "</option>';

  ";
                    // line 683
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 683));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 684
                        yield "    html += '\t\t   <option value=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 684);
                        yield "\">";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 684), "js");
                        yield "</option>';
  ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['custom_field_value'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 686
                    yield "
    html += '\t   </select>';
    html += '    <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 688
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 688);
                    yield "\" class=\"invalid-feedback\"></div>';
    html += '\t </div>';
    html += '</div>';
  ";
                }
                // line 692
                yield "
  ";
                // line 693
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 693) == "radio")) {
                    // line 694
                    yield "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 694);
                    yield "\">';
    html += '  <label class=\"col-sm-2 col-form-label\">";
                    // line 695
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 695), "js");
                    yield "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div id=\"input-address-' + address_row + '-custom-field-";
                    // line 697
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 697);
                    yield "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">';

  ";
                    // line 699
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 699));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 700
                        yield "    html += '  \t\t     <div class=\"form-check\">';
    html += '  \t\t       <input type=\"radio\" name=\"address[' + address_row + '][custom_field][";
                        // line 701
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 701);
                        yield "]\" value=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 701);
                        yield "\" id=\"input-custom-value-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 701);
                        yield "\" class=\"form-check-input\"/>';
    html += '  \t\t       <label for=\"input-custom-value-";
                        // line 702
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 702);
                        yield "\" class=\"form-check-label\">";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 702), "js");
                        yield "</label>';
    html += '\t\t       </div>';
  ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['custom_field_value'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 705
                    yield "
    html += '\t\t </div>';
    html += '    <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 707
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 707);
                    yield "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 711
                yield "
  ";
                // line 712
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 712) == "checkbox")) {
                    // line 713
                    yield "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 713);
                    yield "\">';
    html += '  <label class=\"col-sm-2 col-form-label\">";
                    // line 714
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 714), "js");
                    yield "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div id=\"input-address-' + address_row + '-custom-field-";
                    // line 716
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 716);
                    yield "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">';

  ";
                    // line 718
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 718));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 719
                        yield "    html += '      <div class=\"form-check\">';
    html += '        <input type=\"checkbox\" name=\"address[";
                        // line 720
                        yield ($context["address_row"] ?? null);
                        yield "][custom_field][";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 720);
                        yield "][]\" value=\"";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 720);
                        yield "\" id=\"input-custom-value-";
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 720);
                        yield "\" class=\"form-check-input\"/>';
    html += '        <label for=\"input-custom-value-";
                        // line 721
                        yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 721);
                        yield "\" class=\"form-check-label\">";
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 721), "js");
                        yield "</label>';
    html += '\t\t   </div>';
  ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['custom_field_value'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 724
                    yield "
    html += '\t\t </div>';
    html += '    <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 726
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 726);
                    yield "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 730
                yield "
  ";
                // line 731
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 731) == "text")) {
                    // line 732
                    yield "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 732);
                    yield "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 733
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 733);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 733), "js");
                    yield "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <input type=\"text\" name=\"address[' + address_row + '][custom_field][";
                    // line 735
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 735);
                    yield "]\" value=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 735), "js");
                    yield "\" placeholder=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 735), "js");
                    yield "\" id=\"input-address-' + address_row + '-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 735);
                    yield "\" class=\"form-control\"/>';
    html += '  </div>';
    html += '  <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 737
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 737);
                    yield "\" class=\"invalid-feedback\"></div>';
    html += '</div>';
  ";
                }
                // line 740
                yield "
  ";
                // line 741
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 741) == "textarea")) {
                    // line 742
                    yield "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 742);
                    yield "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 743
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 743);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 743), "js");
                    yield "</label>';
    html += '\t <div class=\"col-sm-10\">';
    html += '\t   <textarea name=\"address[' + address_row + '][custom_field][";
                    // line 745
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 745);
                    yield "]\" rows=\"5\" placeholder=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 745), "js");
                    yield "\" id=\"input-address-' + address_row + '-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 745);
                    yield "\" class=\"form-control\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 745), "js");
                    yield "</textarea>';
    html += '\t   <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 746
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 746);
                    yield "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 750
                yield "
  ";
                // line 751
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 751) == "file")) {
                    // line 752
                    yield "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 752);
                    yield "\">';
    html += '  <label class=\"col-sm-2 col-form-label\">";
                    // line 753
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 753), "js");
                    yield "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div class=\"input-group\">';
    html += '      <button type=\"button\" data-rms-toggle=\"upload\" data-rms-url=\"";
                    // line 756
                    yield ($context["upload"] ?? null);
                    yield "\" data-rms-target=\"#input-address-' + address_row + '-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 756);
                    yield "\" data-rms-size-max=\"";
                    yield ($context["config_file_max_size"] ?? null);
                    yield "\" data-rms-size-error=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["error_upload_size"] ?? null), "js");
                    yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-upload\"></i> ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["button_upload"] ?? null), "js");
                    yield "</button>';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][custom_field][";
                    // line 757
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 757);
                    yield "]\" value=\"\" id=\"input-address-' + address_row + '-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 757);
                    yield "\" class=\"form-control\" readonly/>';
    html += '      <button type=\"button\" data-rms-toggle=\"download\" data-rms-target=\"#input-address-' + address_row + '-custom-field-";
                    // line 758
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 758);
                    yield "\" class=\"btn btn-outline-secondary\" disabled><i class=\"fa-solid fa-download\"></i> ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["button_download"] ?? null), "js");
                    yield "</button>';
    html += '      <button type=\"button\" data-rms-toggle=\"clear\" data-bs-toggle=\"tooltip\" title=\"";
                    // line 759
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["button_clear"] ?? null), "js");
                    yield "\" data-rms-target=\"#input-address-' + address_row + '-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 759);
                    yield "\" class=\"btn btn-outline-danger\" disabled><i class=\"fa-solid fa-eraser\"></i></button>';
    html += '    </div>';
    html += '\t   <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 761
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 761);
                    yield "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 765
                yield "
  ";
                // line 766
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 766) == "date")) {
                    // line 767
                    yield "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 767);
                    yield "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 768
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 768);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 768), "js");
                    yield "</label>';
    html += '\t <div class=\"col-sm-10\">';
    html += '\t\t <div class=\"input-group\">';
    html += '\t\t   <input type=\"text\" name=\"address[' + address_row + '][custom_field][";
                    // line 771
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 771);
                    yield "]\" value=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 771), "js");
                    yield "\" placeholder=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 771), "js");
                    yield "\" id=\"input-address-' + address_row + '-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 771);
                    yield "\" class=\"form-control date\"/><div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>';
    html += '\t\t </div>';
    html += '\t   <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 773
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 773);
                    yield "\" class=\"invalid-feedback\"></div>';
    html += '\t </div>';
    html += '</div>';
  ";
                }
                // line 777
                yield "
  ";
                // line 778
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 778) == "time")) {
                    // line 779
                    yield "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 779);
                    yield "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 780
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 780);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 780), "js");
                    yield "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div class=\"input-group\">';
    html += '\t\t   <input type=\"text\" name=\"address[' + address_row + '][custom_field][";
                    // line 783
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 783);
                    yield "]\" value=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 783), "js");
                    yield "\" placeholder=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 783), "js");
                    yield "\" id=\"input-address-' + address_row + '-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 783);
                    yield "\" class=\"form-control time\"/><div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>';
    html += '    </div>';
    html += '\t   <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 785
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 785);
                    yield "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 789
                yield "
  ";
                // line 790
                if ((CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 790) == "datetime")) {
                    // line 791
                    yield "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 791);
                    yield "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 792
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 792);
                    yield "\" class=\"col-sm-2 col-form-label\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 792), "js");
                    yield "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div class=\"input-group\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][custom_field][";
                    // line 795
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 795);
                    yield "]\" value=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 795), "js");
                    yield "\" placeholder=\"";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 795), "js");
                    yield "\" id=\"input-address-' + address_row + '-custom-field-";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 795);
                    yield "\" class=\"form-control datetime\"/><div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>';
    html += '    </div>';
    html += '\t   <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 797
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 797);
                    yield "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 801
                yield "
  ";
            }
            // line 803
            yield "  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['custom_field'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 804
        yield "
    html += '<div class=\"row mb-3\">';
    html += '  <label for=\"input-address-' + address_row + '-default\" class=\"col-sm-2 col-form-label\">";
        // line 806
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["entry_default"] ?? null), "js");
        yield "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div class=\"form-check\"><input type=\"radio\" name=\"address[' + address_row + '][default]\" value=\"1\" id=\"input-address-' + address_row + '-default\" class=\"form-check-label\"/></div>';
    html += '  </div>';
    html += '</div>';

    html += '</fieldset>';

    \$(this).parent().before(html);

    \$('#input-customer-group').trigger('change');

    \$('select[name=\\'address[' + address_row + '][country_id]\\']').trigger('change');

    address_row++;
});

var zone = [];

\$('#tab-address').on('change', 'select[name\$=\\'[country_id]\\']', function () {
    var element = this;

    \$(element).prop('disabled', true);

    \$('select[name=\\'address[' + \$(element).attr('data-address-row') + '][zone_id]\\']').prop('disabled', false);

    if (!zone[\$(element).val()]) {
        \$.ajax({
            url: 'index.php?route=localisation/country.country&user_token=";
        // line 834
        yield ($context["user_token"] ?? null);
        yield "&country_id=' + \$(element).val(),
            dataType: 'json',
            beforeSend: function () {
                \$(element).prop('disabled', true);
            },
            complete: function () {
                \$(element).prop('disabled', false);
            },
            success: function (json) {
                zone[\$(element).val()] = json;

                if (json['postcode_required'] == '1') {
                    \$('#input-address-' + \$(element).attr('data-address-row') + '-postcode').parent().parent().addClass('required');
                } else {
                    \$('#input-address-' + \$(element).attr('data-address-row') + '-postcode').parent().parent().removeClass('required');
                }

                html = '<option value=\"\">";
        // line 851
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text_select"] ?? null), "js");
        yield "</option>';

                if (json['zone'] && json['zone'] != '') {
                    for (i = 0; i < json['zone'].length; i++) {
                        html += '<option value=\"' + json['zone'][i]['zone_id'] + '\"';

                        if (json['zone'][i]['zone_id'] == \$(element).attr('data-zone-id')) {
                            html += ' selected';
                        }

                        html += '>' + json['zone'][i]['name'] + '</option>';
                    }
                } else {
                    html += '<option value=\"0\" selected>";
        // line 864
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text_none"] ?? null), "js");
        yield "</option>';
                }

                \$('#tab-address select[name=\\'address[' + \$(element).attr('data-address-row') + '][zone_id]\\']').html(html);

                \$('#tab-address select[name=\\'address[' + \$(element).attr('data-address-row') + '][zone_id]\\']').prop('disabled', false);

                \$(element).prop('disabled', false);

                \$('#tab-address select[name\$=\\'[country_id]\\']:disabled:first').trigger('change');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
            }
        });
    } else {
        html = '<option value=\"\">";
        // line 880
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text_select"] ?? null), "js");
        yield "</option>';

        if (zone[\$(element).val()]['zone'] && zone[\$(element).val()]['zone'] != '') {
            for (i = 0; i < zone[\$(element).val()]['zone'].length; i++) {
                html += '<option value=\"' + zone[\$(element).val()]['zone'][i]['zone_id'] + '\"';

                if (zone[\$(element).val()]['zone'][i]['zone_id'] == \$(element).attr('data-zone-id')) {
                    html += ' selected';
                }

                html += '>' + zone[\$(element).val()]['zone'][i]['name'] + '</option>';
            }
        } else {
            html += '<option value=\"0\">";
        // line 893
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text_none"] ?? null), "js");
        yield "</option>';
        }

        \$('#tab-address select[name=\\'address[' + \$(element).attr('data-address-row') + '][zone_id]\\']').html(html);

        \$('#tab-address select[name=\\'address[' + \$(element).attr('data-address-row') + '][zone_id]\\']').prop('disabled', false);

        \$(element).prop('disabled', false);

        \$('#tab-address select[name\$=\\'[country_id]\\']:disabled:first').trigger('change');
    }
});

\$('#tab-address select[name\$=\\'[country_id]\\']:first').trigger('change');

\$('#payment-method').on('click', '.pagination a', function (e) {
    e.preventDefault();

    \$('#payment-method').load(this.href);
});

\$('#payment-method').on('click', 'button', function (e) {
    e.preventDefault();

    var element = this;

    \$.ajax({
        url: \$(element).val(),
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded',
        beforeSend: function () {
            \$(element).button('loading');
        },
        complete: function () {
            \$(element).button('reset');
        },
        success: function (json) {
            \$('.alert-dismissible').remove();

            if (json['error']) {
                \$('#alert').prepend('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa-solid fa-circle-exclamation\"></i> ' + json['error'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');
            }

            if (json['success']) {
                \$('#alert').prepend('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa-solid fa-check-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');

                \$('#payment-method').load('index.php?route=customer/customer.getPayment&user_token=";
        // line 939
        yield ($context["user_token"] ?? null);
        yield "&customer_id=' + \$('#input-customer-id').val());
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

\$('#payment-method').on('change', 'input[name=\\'status\\']', function (e) {
    e.preventDefault();

    var element = this;

    \$.ajax({
        url: 'index.php?route=customer/customer.disablePayment&user_token=";
        // line 954
        yield ($context["user_token"] ?? null);
        yield "&customer_id=' + \$('#input-customer-id').val(),
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded',
        beforeSend: function () {
            \$(element).prop('disabled', true);
        },
        complete: function () {
            \$(element).prop('disabled', false);
        },
        success: function (json) {
            \$('.alert-dismissible').remove();

            if (json['error']) {
                \$('#alert').prepend('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa-solid fa-circle-exclamation\"></i> ' + json['error'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');
            }

            if (json['success']) {
                \$('#alert').prepend('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa-solid fa-check-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');

                \$('#payment-method').load('index.php?route=customer/customer.getPayment&user_token=";
        // line 973
        yield ($context["user_token"] ?? null);
        yield "&customer_id=' + \$('#input-customer-id').val());
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

\$('#history').on('click', '.pagination a', function (e) {
    e.preventDefault();

    \$('#history').load(this.href);
});

\$('#button-history').on('click', function (e) {
    e.preventDefault();

    \$.ajax({
        url: 'index.php?route=customer/customer.addHistory&user_token=";
        // line 992
        yield ($context["user_token"] ?? null);
        yield "&customer_id=' + \$('#input-customer-id').val(),
        type: 'post',
        data: 'comment=' + encodeURIComponent(\$('#input-history').val()),
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded',
        beforeSend: function () {
            \$('#button-history').button('loading');
        },
        complete: function () {
            \$('#button-history').button('reset');
        },
        success: function (json) {
            \$('.alert-dismissible').remove();

            if (json['error']) {
                \$('#alert').prepend('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa-solid fa-circle-exclamation\"></i> ' + json['error'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');
            }

            if (json['success']) {
                \$('#alert').prepend('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa-solid fa-check-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');

                \$('#history').load('index.php?route=customer/customer.history&user_token=";
        // line 1013
        yield ($context["user_token"] ?? null);
        yield "&customer_id=' + \$('#input-customer-id').val());

                \$('#input-history').val('');
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

\$('#transaction').on('click', '.pagination a', function (e) {
    e.preventDefault();

    \$('#transaction').load(this.href);
});

\$('#button-transaction').on('click', function (e) {
    e.preventDefault();

    \$.ajax({
        url: 'index.php?route=customer/customer.addTransaction&user_token=";
        // line 1034
        yield ($context["user_token"] ?? null);
        yield "&customer_id=' + \$('#input-customer-id').val(),
        type: 'post',
        data: 'description=' + encodeURIComponent(\$('#input-transaction').val()) + '&amount=' + \$('#input-amount').val(),
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded',
        beforeSend: function () {
            \$('#button-transaction').button('loading');
        },
        complete: function () {
            \$('#button-transaction').button('reset');
        },
        success: function (json) {
            \$('.alert-dismissible').remove();

            if (json['error']) {
                \$('#alert').prepend('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa-solid fa-circle-exclamation\"></i> ' + json['error'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');
            }

            if (json['success']) {
                \$('#alert').prepend('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa-solid fa-check-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');

                \$('#transaction').load('index.php?route=customer/customer.transaction&user_token=";
        // line 1055
        yield ($context["user_token"] ?? null);
        yield "&customer_id=' + \$('#input-customer-id').val());

                \$('#input-transaction').val('');
                \$('#input-amount').val('');
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

\$('#reward').on('click', '.pagination a', function (e) {
    e.preventDefault();

    \$('#reward').load(this.href);
});

\$('#button-reward').on('click', function (e) {
    e.preventDefault();

    \$.ajax({
        url: 'index.php?route=customer/customer.addReward&user_token=";
        // line 1077
        yield ($context["user_token"] ?? null);
        yield "&customer_id=' + \$('#input-customer-id').val(),
        type: 'post',
        data: 'description=' + encodeURIComponent(\$('#input-reward').val()) + '&points=' + \$('#input-points').val(),
        dataType: 'json',
        contentType: 'application/x-www-form-urlencoded',
        beforeSend: function () {
            \$('#button-reward').button('loading');
        },
        complete: function () {
            \$('#button-reward').button('reset');
        },
        success: function (json) {
            \$('.alert-dismissible').remove();

            if (json['error']) {
                \$('#alert').prepend('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa-solid fa-circle-exclamation\"></i> ' + json['error'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');
            }

            if (json['success']) {
                \$('#alert').prepend('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa-solid fa-check-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');

                \$('#reward').load('index.php?route=customer/customer.reward&user_token=";
        // line 1098
        yield ($context["user_token"] ?? null);
        yield "&customer_id=' + \$('#input-customer-id').val());

                \$('#input-reward').val('');
                \$('#input-points').val('');
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

\$('#ip').on('click', '.pagination a', function (e) {
    e.preventDefault();

    \$('#ip').load(this.href);
});
//--></script>
";
        // line 1116
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
        return "admin/view/template/customer/customer_form.twig";
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
        return array (  2745 => 1116,  2724 => 1098,  2700 => 1077,  2675 => 1055,  2651 => 1034,  2627 => 1013,  2603 => 992,  2581 => 973,  2559 => 954,  2541 => 939,  2492 => 893,  2476 => 880,  2457 => 864,  2441 => 851,  2421 => 834,  2390 => 806,  2386 => 804,  2380 => 803,  2376 => 801,  2369 => 797,  2358 => 795,  2350 => 792,  2345 => 791,  2343 => 790,  2340 => 789,  2333 => 785,  2322 => 783,  2314 => 780,  2309 => 779,  2307 => 778,  2304 => 777,  2297 => 773,  2286 => 771,  2278 => 768,  2273 => 767,  2271 => 766,  2268 => 765,  2261 => 761,  2254 => 759,  2248 => 758,  2242 => 757,  2230 => 756,  2224 => 753,  2219 => 752,  2217 => 751,  2214 => 750,  2207 => 746,  2197 => 745,  2190 => 743,  2185 => 742,  2183 => 741,  2180 => 740,  2174 => 737,  2163 => 735,  2156 => 733,  2151 => 732,  2149 => 731,  2146 => 730,  2139 => 726,  2135 => 724,  2124 => 721,  2114 => 720,  2111 => 719,  2107 => 718,  2102 => 716,  2097 => 714,  2092 => 713,  2090 => 712,  2087 => 711,  2080 => 707,  2076 => 705,  2065 => 702,  2057 => 701,  2054 => 700,  2050 => 699,  2045 => 697,  2040 => 695,  2035 => 694,  2033 => 693,  2030 => 692,  2023 => 688,  2019 => 686,  2008 => 684,  2004 => 683,  1999 => 681,  1993 => 680,  1986 => 678,  1982 => 677,  1979 => 676,  1976 => 675,  1973 => 674,  1969 => 673,  1960 => 667,  1955 => 665,  1947 => 659,  1936 => 657,  1932 => 656,  1928 => 655,  1922 => 652,  1913 => 646,  1908 => 644,  1899 => 638,  1894 => 636,  1887 => 632,  1883 => 631,  1874 => 625,  1869 => 623,  1862 => 619,  1858 => 618,  1849 => 612,  1844 => 610,  1835 => 604,  1830 => 602,  1821 => 598,  1812 => 592,  1785 => 568,  1770 => 556,  1766 => 555,  1757 => 549,  1750 => 545,  1746 => 544,  1741 => 542,  1734 => 538,  1729 => 536,  1724 => 534,  1718 => 531,  1714 => 530,  1705 => 524,  1698 => 520,  1693 => 518,  1686 => 514,  1681 => 512,  1676 => 510,  1670 => 507,  1666 => 506,  1656 => 499,  1649 => 495,  1644 => 493,  1639 => 491,  1633 => 488,  1629 => 487,  1621 => 482,  1617 => 481,  1609 => 476,  1604 => 474,  1601 => 473,  1595 => 472,  1593 => 471,  1586 => 469,  1573 => 465,  1565 => 462,  1561 => 460,  1554 => 458,  1550 => 456,  1541 => 452,  1525 => 449,  1515 => 446,  1510 => 445,  1508 => 444,  1505 => 443,  1496 => 439,  1480 => 436,  1470 => 433,  1465 => 432,  1463 => 431,  1460 => 430,  1451 => 426,  1435 => 423,  1425 => 420,  1420 => 419,  1418 => 418,  1415 => 417,  1406 => 413,  1393 => 411,  1381 => 410,  1369 => 409,  1355 => 408,  1349 => 405,  1344 => 404,  1342 => 403,  1339 => 402,  1330 => 398,  1316 => 397,  1307 => 395,  1302 => 394,  1300 => 393,  1297 => 392,  1288 => 388,  1274 => 387,  1265 => 385,  1260 => 384,  1258 => 383,  1255 => 382,  1246 => 378,  1243 => 377,  1220 => 374,  1217 => 373,  1213 => 372,  1207 => 371,  1202 => 369,  1197 => 368,  1195 => 367,  1192 => 366,  1183 => 362,  1180 => 361,  1157 => 358,  1154 => 357,  1150 => 356,  1144 => 355,  1139 => 353,  1134 => 352,  1132 => 351,  1129 => 350,  1120 => 346,  1117 => 345,  1102 => 343,  1098 => 342,  1094 => 341,  1084 => 340,  1075 => 338,  1070 => 337,  1068 => 336,  1065 => 335,  1062 => 334,  1058 => 333,  1051 => 329,  1045 => 328,  1038 => 326,  1031 => 322,  1028 => 321,  1013 => 319,  1009 => 318,  1005 => 317,  995 => 316,  988 => 314,  981 => 310,  971 => 309,  964 => 307,  957 => 303,  947 => 302,  940 => 300,  927 => 296,  920 => 294,  913 => 290,  903 => 289,  896 => 287,  883 => 283,  876 => 281,  869 => 277,  859 => 276,  852 => 274,  845 => 270,  835 => 269,  828 => 267,  817 => 265,  812 => 264,  807 => 263,  805 => 262,  796 => 256,  789 => 254,  783 => 251,  773 => 246,  767 => 243,  757 => 238,  751 => 235,  746 => 233,  735 => 227,  730 => 225,  720 => 220,  715 => 218,  710 => 216,  706 => 214,  700 => 213,  696 => 211,  689 => 207,  677 => 204,  669 => 201,  664 => 200,  662 => 199,  659 => 198,  652 => 194,  640 => 191,  632 => 188,  627 => 187,  625 => 186,  622 => 185,  615 => 181,  603 => 178,  595 => 175,  590 => 174,  588 => 173,  585 => 172,  578 => 168,  566 => 165,  556 => 164,  548 => 163,  536 => 162,  529 => 158,  524 => 157,  522 => 156,  519 => 155,  512 => 151,  502 => 150,  495 => 148,  490 => 147,  488 => 146,  485 => 145,  478 => 141,  468 => 140,  461 => 138,  456 => 137,  454 => 136,  451 => 135,  444 => 131,  441 => 130,  420 => 127,  417 => 126,  413 => 125,  409 => 124,  404 => 122,  399 => 121,  397 => 120,  394 => 119,  387 => 115,  384 => 114,  363 => 111,  360 => 110,  356 => 109,  352 => 108,  347 => 106,  342 => 105,  340 => 104,  337 => 103,  330 => 99,  327 => 98,  312 => 96,  308 => 95,  304 => 94,  298 => 93,  291 => 91,  286 => 90,  284 => 89,  281 => 88,  279 => 87,  276 => 86,  272 => 85,  263 => 81,  258 => 79,  252 => 78,  243 => 74,  238 => 72,  228 => 67,  223 => 65,  213 => 60,  208 => 58,  202 => 54,  187 => 52,  183 => 51,  177 => 48,  171 => 44,  156 => 42,  152 => 41,  146 => 38,  141 => 36,  133 => 31,  129 => 30,  125 => 29,  121 => 28,  117 => 27,  113 => 26,  109 => 25,  104 => 23,  99 => 21,  92 => 16,  81 => 14,  77 => 13,  72 => 11,  66 => 10,  61 => 9,  53 => 7,  51 => 6,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/customer/customer_form.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\customer\\customer_form.twig");
    }
}
