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

/* admin/view/template/marketing/affiliate.twig */
class __TwigTemplate_bfe3ade36afb136c41d3dee5948f1380 extends Template
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

        <button type=\"button\" data-bs-toggle=\"tooltip\" title=\"";
        // line 7
        yield ($context["button_filter"] ?? null);
        yield "\" onclick=\"\$('#filter-affiliate').toggleClass('d-none');\" class=\"btn btn-light d-md-none\"><i class=\"fa-solid fa-filter\"></i></button>

        <button type=\"button\" id=\"button-calculate\" data-bs-toggle=\"tooltip\" title=\"";
        // line 9
        yield ($context["button_calculate"] ?? null);
        yield "\" class=\"btn btn-warning\"><i class=\"fa-solid fa-sync\"></i></button>

        <button type=\"submit\" form=\"form-affiliate\" formaction=\"";
        // line 11
        yield ($context["csv"] ?? null);
        yield "\" id=\"button-csv\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["button_csv"] ?? null);
        yield "\" class=\"btn btn-info\"><i class=\"fa-solid fa-file-csv\"></i></button>

        <button type=\"submit\" form=\"form-affiliate\" formaction=\"";
        // line 13
        yield ($context["complete"] ?? null);
        yield "\" data-rms-toggle=\"ajax\" id=\"button-complete\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["button_complete"] ?? null);
        yield "\" class=\"btn btn-success\"><i class=\"fa-solid fa-credit-card\"></i></button>

        <a href=\"";
        // line 15
        yield ($context["add"] ?? null);
        yield "\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["button_add"] ?? null);
        yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus\"></i></a>

        <button type=\"submit\" form=\"form-affiliate\" formaction=\"";
        // line 17
        yield ($context["delete"] ?? null);
        yield "\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["button_delete"] ?? null);
        yield "\" onclick=\"return confirm('";
        yield ($context["text_confirm"] ?? null);
        yield "');\" class=\"btn btn-danger\"><i class=\"fa-regular fa-trash-can\"></i></button>

      </div>
      <h1>";
        // line 20
        yield ($context["heading_title"] ?? null);
        yield "</h1>
      <ol class=\"breadcrumb\">
        ";
        // line 22
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 23
            yield "          <li class=\"breadcrumb-item\"><a href=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 23);
            yield "\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 23);
            yield "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['breadcrumb'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        yield "      </ol>
    </div>
  </div>
  <div class=\"container-fluid\">
    <div class=\"row\">
      <div id=\"filter-affiliate\" class=\"col-lg-3 col-md-12 order-lg-last d-none d-lg-block mb-3\">
        <div class=\"card\">
          <div class=\"card-header\"><i class=\"fa-solid fa-filter\"></i> ";
        // line 32
        yield ($context["text_filter"] ?? null);
        yield "</div>
          <div class=\"card-body\">
            <div class=\"mb-3\">
              <label class=\"form-label\">";
        // line 35
        yield ($context["entry_customer"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"filter_customer\" value=\"";
        // line 36
        yield ($context["filter_customer"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_customer"] ?? null);
        yield "\" id=\"input-customer\" data-rms-target=\"autocomplete-customer\" class=\"form-control\" autocomplete=\"off\"/>
              <ul id=\"autocomplete-customer\" class=\"dropdown-menu\"></ul>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-tracking\" class=\"form-label\">";
        // line 40
        yield ($context["entry_tracking"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"filter_tracking\" value=\"";
        // line 41
        yield ($context["filter_tracking"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_tracking"] ?? null);
        yield "\" id=\"input-tracking\" class=\"form-control\"/>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-payment-method\" class=\"form-label\">";
        // line 44
        yield ($context["entry_payment_method"] ?? null);
        yield "</label>
              <select name=\"filter_payment_method\" id=\"input-payment-method\" class=\"form-select\">
                <option value=\"\"></option>
                ";
        // line 47
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["payment_methods"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["payment_method"]) {
            // line 48
            yield "                  <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["payment_method"], "value", [], "any", false, false, false, 48);
            yield "\"";
            if ((($context["filter_payment_method"] ?? null) == CoreExtension::getAttribute($this->env, $this->source, $context["payment_method"], "value", [], "any", false, false, false, 48))) {
                yield " selected";
            }
            yield ">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["payment_method"], "text", [], "any", false, false, false, 48);
            yield "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['payment_method'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 50
        yield "              </select>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-commission\" class=\"form-label\">";
        // line 53
        yield ($context["entry_commission"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"filter_commission\" value=\"";
        // line 54
        yield ($context["filter_commission"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_commission"] ?? null);
        yield "\" id=\"input-commission\" class=\"form-control\"/>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-date-from\" class=\"form-label\">";
        // line 57
        yield ($context["entry_date_from"] ?? null);
        yield "</label>
              <div class=\"input-group\">
                <input type=\"text\" name=\"filter_date_from\" value=\"";
        // line 59
        yield ($context["filter_date_from"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_date_from"] ?? null);
        yield "\" id=\"input-date-from\" class=\"form-control date\"/>
                <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
              </div>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-date-to\" class=\"form-label\">";
        // line 64
        yield ($context["entry_date_to"] ?? null);
        yield "</label>
              <div class=\"input-group\">
                <input type=\"text\" name=\"filter_date_to\" value=\"";
        // line 66
        yield ($context["filter_date_to"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_date_to"] ?? null);
        yield "\" id=\"input-date-to\" class=\"form-control date\"/>
                <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
              </div>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-status\" class=\"form-label\">";
        // line 71
        yield ($context["entry_status"] ?? null);
        yield "</label>
              <select name=\"filter_status\" id=\"input-status\" class=\"form-select\">
                <option value=\"\"></option>
                <option value=\"1\"";
        // line 74
        if ((($context["filter_status"] ?? null) == "1")) {
            yield " selected";
        }
        yield ">";
        yield ($context["text_enabled"] ?? null);
        yield "</option>
                <option value=\"0\"";
        // line 75
        if ((($context["filter_status"] ?? null) == "0")) {
            yield " selected";
        }
        yield ">";
        yield ($context["text_disabled"] ?? null);
        yield "</option>
              </select>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-limit\" class=\"form-label\">";
        // line 79
        yield ($context["entry_limit"] ?? null);
        yield "</label>
              <select name=\"limit\" id=\"input-limit\" class=\"form-select\">
                ";
        // line 81
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable($context["limits"]);
        foreach ($context['_seq'] as $context["_key"] => $context["limits"]) {
            // line 82
            yield "                  <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["limits"], "value", [], "any", false, false, false, 82);
            yield "\"";
            if ((CoreExtension::getAttribute($this->env, $this->source, $context["limits"], "value", [], "any", false, false, false, 82) == ($context["limit"] ?? null))) {
                yield " selected";
            }
            yield ">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["limits"], "text", [], "any", false, false, false, 82);
            yield "</option>
                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['limits'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 84
        yield "              </select>
            </div>
            <div class=\"text-end\">
              <button type=\"button\" id=\"button-filter\" class=\"btn btn-light\"><i class=\"fa-solid fa-filter\"></i> ";
        // line 87
        yield ($context["button_filter"] ?? null);
        yield "</button>
            </div>
          </div>
        </div>
      </div>
      <div class=\"col-lg-9 col-md-12\">
        <div class=\"card\">
          <div class=\"card-header\"><i class=\"fa-solid fa-list\"></i> ";
        // line 94
        yield ($context["text_list"] ?? null);
        yield "</div>
          <div id=\"affiliate\" class=\"card-body\">";
        // line 95
        yield ($context["list"] ?? null);
        yield "</div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type=\"text/javascript\"><!--
\$('#affiliate').on('click', 'thead a, .pagination a', function(e) {
    e.preventDefault();

    \$('#affiliate').load(this.href);
});

\$('#button-filter').on('click', function() {
    url = '';

    var filter_customer = \$('#input-customer').val();

    if (filter_customer) {
        url += '&filter_customer=' + encodeURIComponent(filter_customer);
    }

    var filter_tracking = \$('#input-tracking').val();

    if (filter_tracking) {
        url += '&filter_tracking=' + encodeURIComponent(filter_tracking);
    }

    var filter_payment_method = \$('#input-payment-method').val();

    if (filter_payment_method) {
        url += '&filter_payment_method=' + filter_payment_method;
    }

    var filter_commission = \$('#input-commission').val();

    if (filter_commission) {
        url += '&filter_commission=' + filter_commission;
    }

    var filter_date_from = \$('#input-date-from').val();

    if (filter_date_from) {
        url += '&filter_date_from=' + encodeURIComponent(filter_date_from);
    }

    var filter_date_to = \$('#input-date-to').val();

    if (filter_date_to) {
        url += '&filter_date_to=' + encodeURIComponent(filter_date_to);
    }

    var filter_status = \$('#input-status').val();

    if (filter_status !== '') {
        url += '&filter_status=' + filter_status;
    }

    var limit = \$('#input-limit').val();

    if (limit) {
        url += '&limit=' + limit;
    }

    window.history.pushState({}, null, 'index.php?route=marketing/affiliate&user_token=";
        // line 159
        yield ($context["user_token"] ?? null);
        yield "' + url);

    \$('#affiliate').load('index.php?route=marketing/affiliate.list&user_token=";
        // line 161
        yield ($context["user_token"] ?? null);
        yield "' + url);
});

\$('#input-customer').autocomplete({
    'source': function(request, response) {
        \$.ajax({
            url: 'index.php?route=customer/customer.autocomplete&user_token=";
        // line 167
        yield ($context["user_token"] ?? null);
        yield "&filter_affiliate=1&filter_name=' + encodeURIComponent(request),
            dataType: 'json',
            success: function(json) {
                response(\$.map(json, function(item) {
                    return {
                        label: item['name'],
                        value: item['customer_id']
                    }
                }));
            }
        });
    },
    'select': function(item) {
        \$('#input-customer').val(item['label']);
    }
});

\$('#button-calculate').on('click', function (e) {
    e.preventDefault();

    var element = this;

    \$.ajax({
        url: 'index.php?route=marketing/affiliate.calculate&user_token=";
        // line 190
        yield ($context["user_token"] ?? null);
        yield "',
        dataType: 'json',
        beforeSend: function () {
            \$(element).button('loading');
        },
        complete: function () {
            \$(element).button('reset');
        },
        success: function (json) {
            console.log(json);

            if (json['error']) {
                \$('#alert').prepend('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa-solid fa-circle-exclamation\"></i> ' + json['error'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');
            }

            if (json['success']) {
                \$('#alert').prepend('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa-solid fa-check-circle\"></i> ' + json['success'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');

                url = '';

                var filter_customer = \$('#input-customer').val();

                if (filter_customer) {
                    url += '&filter_customer=' + encodeURIComponent(filter_customer);
                }

                var filter_tracking = \$('#input-tracking').val();

                if (filter_tracking) {
                    url += '&filter_tracking=' + encodeURIComponent(filter_tracking);
                }

                var filter_payment_method = \$('#input-payment-method').val();

                if (filter_payment_method) {
                    url += '&filter_payment_method=' + filter_payment_method;
                }

                var filter_commission = \$('#input-commission').val();

                if (filter_commission) {
                    url += '&filter_commission=' + filter_commission;
                }

                var filter_date_from = \$('#input-date-from').val();

                if (filter_date_from) {
                    url += '&filter_date_from=' + encodeURIComponent(filter_date_from);
                }

                var filter_date_to = \$('#input-date-to').val();

                if (filter_date_to) {
                    url += '&filter_date_to=' + encodeURIComponent(filter_date_to);
                }

                var filter_status = \$('#input-status').val();

                if (filter_status !== '') {
                    url += '&filter_status=' + filter_status;
                }

                var limit = \$('#input-limit').val();

                if (limit) {
                    url += '&limit=' + limit;
                }

                \$('#affiliate').load('index.php?route=marketing/affiliate.list&user_token=";
        // line 258
        yield ($context["user_token"] ?? null);
        yield "' + url);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});
//--></script>
";
        // line 267
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
        return "admin/view/template/marketing/affiliate.twig";
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
        return array (  483 => 267,  471 => 258,  400 => 190,  374 => 167,  365 => 161,  360 => 159,  293 => 95,  289 => 94,  279 => 87,  274 => 84,  259 => 82,  255 => 81,  250 => 79,  239 => 75,  231 => 74,  225 => 71,  215 => 66,  210 => 64,  200 => 59,  195 => 57,  187 => 54,  183 => 53,  178 => 50,  163 => 48,  159 => 47,  153 => 44,  145 => 41,  141 => 40,  132 => 36,  128 => 35,  122 => 32,  113 => 25,  102 => 23,  98 => 22,  93 => 20,  83 => 17,  76 => 15,  69 => 13,  62 => 11,  57 => 9,  52 => 7,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/marketing/affiliate.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\marketing\\affiliate.twig");
    }
}
