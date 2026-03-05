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

/* catalog/view/template/checkout/shipping_method.twig */
class __TwigTemplate_acfc20f91c34049a7489d2c101088f65 extends Template
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
        yield "<fieldset>
  <legend>";
        // line 2
        yield ($context["heading_title"] ?? null);
        yield "</legend>
  <div class=\"input-group\">
    <span class=\"input-group-text\"><i class=\"fa fa-truck\"></i></span><input type=\"text\" name=\"shipping_method\" value=\"";
        // line 4
        yield ($context["shipping_method"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_shipping_method"] ?? null);
        yield "\" id=\"input-shipping-method\" class=\"form-control\" readonly/>
    <button type=\"button\" id=\"button-shipping-methods\" class=\"btn btn-primary\">";
        // line 5
        yield ($context["button_choose"] ?? null);
        yield "</button>
  </div>
  <input type=\"hidden\" name=\"code\" value=\"";
        // line 7
        yield ($context["code"] ?? null);
        yield "\" id=\"input-shipping-code\"/>
  <div id=\"error-shipping-method\" class=\"invalid-feedback\"></div>
</fieldset>
<script type=\"text/javascript\"><!--
\$('#button-shipping-methods').on('click', function() {
    var element = this;

    chain.attach(function() {
        return \$.ajax({
            url: 'index.php?route=checkout/shipping_method.quote&language=";
        // line 16
        yield ($context["language"] ?? null);
        yield "',
            dataType: 'json',
            beforeSend: function() {
                \$(element).button('loading');
            },
            complete: function() {
                \$(element).button('reset');
            },
            success: function(json) {
                console.log(json);

                \$('#input-shipping-method').removeClass('is-invalid');
                \$('#error-shipping-method').removeClass('d-block');

                if (json['error']) {
                    \$('#input-shipping-method').addClass('is-invalid');
                    \$('#error-shipping-method').html(json['error']).addClass('d-block');
                }

                if (json['shipping_methods']) {
                    \$('#modal-shipping').remove();

                    html = '<div id=\"modal-shipping\" class=\"modal\">';
                    html += '  <div class=\"modal-dialog modal-dialog-centered\">';
                    html += '    <div class=\"modal-content\">';
                    html += '      <div class=\"modal-header\">';
                    html += '        <h5 class=\"modal-title\"><i class=\"fa fa-truck\"></i> ";
        // line 42
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text_shipping_method"] ?? null), "js");
        yield "</h5>';
                    html += '        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>';
                    html += '      </div>';
                    html += '      <div class=\"modal-body\">';
                    html += '        <form id=\"form-shipping-method\">';
                    html += '          <p>";
        // line 47
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["text_shipping"] ?? null), "js");
        yield "</p>';

                    for (i in json['shipping_methods']) {
                        html += '<p><strong>' + json['shipping_methods'][i]['name'] + '</strong></p>';

                        if (!json['shipping_methods'][i]['error']) {
                            for (j in json['shipping_methods'][i]['quote']) {
                                html += '<div class=\"form-check\">';

                                var code = i + '-' + j.replaceAll('_', '-');

                                html += '<input type=\"radio\" name=\"shipping_method\" value=\"' + json['shipping_methods'][i]['quote'][j]['code'] + '\" id=\"input-shipping-method-' + code + '\"';

                                if (json['shipping_methods'][i]['quote'][j]['code'] == \$('#input-shipping-code').val()) {
                                    html += ' checked';
                                }

                                html += '/>';
                                html += '  <label for=\"input-shipping-method-' + code + '\">' + json['shipping_methods'][i]['quote'][j]['name'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</label>';
                                html += '</div>';
                            }
                        } else {
                            html += '<div class=\"alert alert-danger\">' + json['shipping_methods'][i]['error'] + '</div>';
                        }
                    }

                    html += '          <div class=\"text-end\">';
                    html += '            <button type=\"submit\" id=\"button-shipping-method\" class=\"btn btn-primary\">";
        // line 74
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["button_continue"] ?? null), "js");
        yield "</button>';
                    html += '          </div>';
                    html += '        </form>';
                    html += '      </div>';
                    html += '    </div>';
                    html += '  </div>';
                    html += '</div>';

                    \$('body').append(html);

                    \$('#modal-shipping').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
            }
        });
    });
});

\$(document).on('submit', '#form-shipping-method', function(e) {
    e.preventDefault();

    var element = this;

    chain.attach(function() {
        return \$.ajax({
            url: 'index.php?route=checkout/shipping_method.save&language=";
        // line 101
        yield ($context["language"] ?? null);
        yield "',
            type: 'post',
            data: \$('#form-shipping-method').serialize(),
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            beforeSend: function() {
                \$('#button-shipping-method').button('loading');
            },
            complete: function() {
                \$('#button-shipping-method').button('reset');
            },
            success: function(json) {
                console.log(json);

                if (json['redirect']) {
                    location = json['redirect'];
                }

                if (json['error']) {
                    \$('#alert').prepend('<div class=\"alert alert-danger alert-dismissible\"><i class=\"fa-solid fa-circle-exclamation\"></i> ' + json['error'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');
                }

                if (json['success']) {
                    \$('#alert').prepend('<div class=\"alert alert-success alert-dismissible\"><i class=\"fa-solid fa-circle-check\"></i> ' + json['success'] + ' <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\"></button></div>');

                    \$('#modal-shipping').modal('hide');

                    \$('#input-shipping-method').val(\$('input[name=\\'shipping_method\\']:checked').parent().find('label').text());
                    \$('#input-shipping-code').val(\$('input[name=\\'shipping_method\\']:checked').val());

                    \$('#input-payment-method').val('');

                    \$('#checkout-confirm').load('index.php?route=checkout/confirm.confirm&language=";
        // line 133
        yield ($context["language"] ?? null);
        yield "');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(thrownError + \"\\r\\n\" + xhr.statusText + \"\\r\\n\" + xhr.responseText);
            }
        });
    });
});
//--></script>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "catalog/view/template/checkout/shipping_method.twig";
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
        return array (  205 => 133,  170 => 101,  140 => 74,  110 => 47,  102 => 42,  73 => 16,  61 => 7,  56 => 5,  50 => 4,  45 => 2,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "catalog/view/template/checkout/shipping_method.twig", "E:\\wamp64\\www\\reamur\\catalog\\view\\template\\checkout\\shipping_method.twig");
    }
}
