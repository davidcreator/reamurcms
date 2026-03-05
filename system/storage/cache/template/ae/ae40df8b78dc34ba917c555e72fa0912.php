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

/* admin/view/template/customer/gdpr.twig */
class __TwigTemplate_eb227528a4e3b6a45978466251aa361d extends Template
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
        // line 6
        yield ($context["button_filter"] ?? null);
        yield "\" onclick=\"\$('#filter-gdpr').toggleClass('d-none');\" class=\"btn btn-light d-md-none d-lg-none\"><i class=\"fa-solid fa-filter\"></i></button>
        <button type=\"submit\" form=\"form-gdpr\" formaction=\"";
        // line 7
        yield ($context["approve"] ?? null);
        yield "\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["text_approve"] ?? null);
        yield "\" class=\"btn btn-success\"><i class=\"fa-solid fa-check\"></i></button>
        <button type=\"submit\" form=\"form-gdpr\" formaction=\"";
        // line 8
        yield ($context["deny"] ?? null);
        yield "\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["text_deny"] ?? null);
        yield "\" class=\"btn btn-warning\"><i class=\"fa-solid fa-circle-xmark\"></i></button>
        <button type=\"submit\" form=\"form-gdpr\" formaction=\"";
        // line 9
        yield ($context["delete"] ?? null);
        yield "\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["text_delete"] ?? null);
        yield "\" onclick=\"return confirm('";
        yield ($context["text_confirm"] ?? null);
        yield "');\" class=\"btn btn-danger\"><i class=\"fa-regular fa-trash-can\"></i></button>
      </div>
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
    <div class=\"alert alert-warning\"><i class=\"fa-solid fa-info-circle\"></i> ";
        // line 20
        yield ($context["text_info"] ?? null);
        yield "</div>
    <div class=\"row\">
      <div id=\"filter-gdpr\" class=\"col-lg-3 col-md-12 order-lg-last d-none d-lg-block mb-3\">
        <div class=\"card\">
          <div class=\"card-header\"><i class=\"fa-solid fa-filter\"></i> ";
        // line 24
        yield ($context["text_filter"] ?? null);
        yield "</div>
          <div class=\"card-body\">
            <div class=\"mb-3\">
              <label class=\"form-label\">";
        // line 27
        yield ($context["entry_email"] ?? null);
        yield "</label>
              <input type=\"text\" name=\"filter_email\" value=\"\" placeholder=\"";
        // line 28
        yield ($context["entry_email"] ?? null);
        yield "\" id=\"input-email\" data-rms-target=\"autocomplete-email\" class=\"form-control\" autocomplete=\"off\"/>
              <ul id=\"autocomplete-email\" class=\"dropdown-menu\"></ul>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-action\" class=\"col-form-label\">";
        // line 32
        yield ($context["entry_action"] ?? null);
        yield "</label>
              <select name=\"filter_action\" id=\"input-action\" class=\"form-select\">
                <option value=\"\"></option>
                <option value=\"export\">";
        // line 35
        yield ($context["text_export"] ?? null);
        yield "</option>
                <option value=\"remove\">";
        // line 36
        yield ($context["text_remove"] ?? null);
        yield "</option>
              </select>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-status\" class=\"form-label\">";
        // line 40
        yield ($context["entry_status"] ?? null);
        yield "</label>
              <select name=\"filter_status\" id=\"input-status\" class=\"form-select\">
                <option value=\"\"></option>
                <option value=\"0\">";
        // line 43
        yield ($context["text_unverified"] ?? null);
        yield "</option>
                <option value=\"1\">";
        // line 44
        yield ($context["text_pending"] ?? null);
        yield "</option>
                <option value=\"2\">";
        // line 45
        yield ($context["text_processing"] ?? null);
        yield "</option>
                <option value=\"3\">";
        // line 46
        yield ($context["text_complete"] ?? null);
        yield "</option>
                <option value=\"-1\">";
        // line 47
        yield ($context["text_denied"] ?? null);
        yield "</option>
              </select>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-date-from\" class=\"form-label\">";
        // line 51
        yield ($context["entry_date_from"] ?? null);
        yield "</label>
              <div class=\"input-group\">
                <input type=\"text\" name=\"filter_date_from\" value=\"";
        // line 53
        yield ($context["filter_date_from"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_date_from"] ?? null);
        yield "\" id=\"input-date-from\" class=\"form-control date\"/>
                <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
              </div>
            </div>
            <div class=\"mb-3\">
              <label for=\"input-date-to\" class=\"form-label\">";
        // line 58
        yield ($context["entry_date_to"] ?? null);
        yield "</label>
              <div class=\"input-group\">
                <input type=\"text\" name=\"filter_date_to\" value=\"";
        // line 60
        yield ($context["filter_date_to"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_date_to"] ?? null);
        yield "\" id=\"input-date-to\" class=\"form-control date\"/>
                <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
              </div>
            </div>
            <div class=\"text-end\">
              <button type=\"button\" id=\"button-filter\" class=\"btn btn-light\"><i class=\"fa-solid fa-filter\"></i> ";
        // line 65
        yield ($context["button_filter"] ?? null);
        yield "</button>
            </div>
          </div>
        </div>
      </div>
      <div class=\"col-lg-9 col-md-12\">
        <div class=\"card\">
          <div class=\"card-header\"><i class=\"fa-solid fa-list\"></i> ";
        // line 72
        yield ($context["text_list"] ?? null);
        yield "</div>
          <div class=\"card-body\">
            <div id=\"gdpr\">";
        // line 74
        yield ($context["list"] ?? null);
        yield "</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type=\"text/javascript\"><!--
\$('#gdpr').on('click', '.pagination a', function (e) {
    e.preventDefault();

    \$('#gdpr').load(this.href);
});

\$('#gdpr').on('click', '.btn-success, .btn-warning, .btn-danger', function (e) {
    e.preventDefault();

    var element = this;

    \$.ajax({
        url: \$(element).val(),
        dataType: 'json',
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

                \$('#gdpr').load(\$('#form-gdpr').attr('data-rms-load'));
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
        }
    });
});

\$('#button-filter').on('click', function () {
    var url = '';

    var filter_email = \$('#input-email').val();

    if (filter_email) {
        url += '&filter_email=' + encodeURIComponent(filter_email);
    }

    var filter_action = \$('#input-action').val();

    if (filter_action !== '') {
        url += '&filter_action=' + filter_action;
    }

    var filter_status = \$('#input-status').val();

    if (filter_status !== '') {
        url += '&filter_status=' + filter_status;
    }

    var filter_date_from = \$('#input-date-from').val();

    if (filter_date_from) {
        url += '&filter_date_from=' + encodeURIComponent(filter_date_from);
    }

    var filter_date_to = \$('#input-date-to').val();

    if (filter_date_to) {
        url += '&filter_date_to=' + encodeURIComponent(filter_date_to);
    }

    window.history.pushState({}, null, 'index.php?route=customer/gdpr&user_token=";
        // line 154
        yield ($context["user_token"] ?? null);
        yield "' + url);

    \$('#gdpr').load('index.php?route=customer/gdpr.list&user_token=";
        // line 156
        yield ($context["user_token"] ?? null);
        yield "' + url);
});

\$('#input-email').autocomplete({
    'source': function (request, response) {
        \$.ajax({
            url: 'index.php?route=customer/customer.autocomplete&user_token=";
        // line 162
        yield ($context["user_token"] ?? null);
        yield "&filter_email=' + encodeURIComponent(request),
            dataType: 'json',
            success: function (json) {
                response(\$.map(json, function (item) {
                    return {
                        label: item['email'],
                        value: item['customer_id']
                    }
                }));
            }
        });
    },
    'select': function (item) {
        \$('#input-email').val(item['label']);
    }
});
//--></script>
";
        // line 179
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
        return "admin/view/template/customer/gdpr.twig";
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
        return array (  334 => 179,  314 => 162,  305 => 156,  300 => 154,  217 => 74,  212 => 72,  202 => 65,  192 => 60,  187 => 58,  177 => 53,  172 => 51,  165 => 47,  161 => 46,  157 => 45,  153 => 44,  149 => 43,  143 => 40,  136 => 36,  132 => 35,  126 => 32,  119 => 28,  115 => 27,  109 => 24,  102 => 20,  96 => 16,  85 => 14,  81 => 13,  76 => 11,  67 => 9,  61 => 8,  55 => 7,  51 => 6,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/customer/gdpr.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\customer\\gdpr.twig");
    }
}
