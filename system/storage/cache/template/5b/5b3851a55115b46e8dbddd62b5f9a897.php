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

/* install/view/template/install/step_2.twig */
class __TwigTemplate_580dffc0484d8847f2e0ef19700acc19 extends Template
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
<main id=\"content\" role=\"main\">
\t<div class=\"page-header\">
\t\t<div class=\"container\">
\t\t\t<div class=\"float-end\">";
        // line 5
        yield ($context["language"] ?? null);
        yield "</div>
\t\t\t<h1>";
        // line 6
        yield ($context["heading_title"] ?? null);
        yield "</h1>
\t\t</div>
\t</div>
\t<div class=\"container\">
\t\t";
        // line 10
        if ((($tmp = ($context["error_warning"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 11
            yield "\t\t\t<div class=\"alert alert-danger\" role=\"alert\">
\t\t\t\t<i class=\"fa-solid fa-circle-exclamation\" aria-hidden=\"true\"></i>
\t\t\t\t<span class=\"ms-2\">";
            // line 13
            yield ($context["error_warning"] ?? null);
            yield "</span>
\t\t\t</div>
\t\t";
        }
        // line 16
        yield "\t\t<form action=\"";
        yield ($context["action"] ?? null);
        yield "\" method=\"post\" enctype=\"multipart/form-data\">
\t\t\t<div class=\"card\">
\t\t\t\t<div class=\"card-header\">
\t\t\t\t\t<i class=\"fa-solid fa-pencil\" aria-hidden=\"true\"></i>
\t\t\t\t\t<span class=\"ms-2\">";
        // line 20
        yield ($context["text_step_2"] ?? null);
        yield "</span>
\t\t\t\t</div>
\t\t\t\t<div class=\"card-body\">
\t\t\t\t\t<fieldset>
\t\t\t\t\t\t<legend>";
        // line 24
        yield ($context["text_install_php"] ?? null);
        yield "</legend>
\t\t\t\t\t\t<div class=\"table-responsive\">
\t\t\t\t\t\t\t<table class=\"table table-bordered\">
\t\t\t\t\t\t\t\t<caption class=\"visually-hidden\">";
        // line 27
        yield ($context["text_install_php"] ?? null);
        yield "</caption>
\t\t\t\t\t\t\t\t<thead>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<th scope=\"col\" style=\"width: 35%\">";
        // line 30
        yield ($context["text_setting"] ?? null);
        yield "</th>
\t\t\t\t\t\t\t\t\t\t<th scope=\"col\" style=\"width: 25%\">";
        // line 31
        yield ($context["text_current"] ?? null);
        yield "</th>
\t\t\t\t\t\t\t\t\t\t<th scope=\"col\" style=\"width: 25%\">";
        // line 32
        yield ($context["text_required"] ?? null);
        yield "</th>
\t\t\t\t\t\t\t\t\t\t<th scope=\"col\" style=\"width: 15%\" class=\"text-center\">";
        // line 33
        yield ($context["text_status"] ?? null);
        yield "</th>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t</thead>
\t\t\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 38
        yield ($context["text_version"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 39
        yield ($context["php_version"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>8.0+</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"text-center\">
\t\t\t\t\t\t\t\t\t\t\t";
        // line 42
        if ((($tmp = ($context["version"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 43
            yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\" aria-label=\"";
            yield ($context["text_on"] ?? null);
            yield "\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-check\" aria-hidden=\"true\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 47
            yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\" aria-label=\"";
            yield ($context["text_off"] ?? null);
            yield "\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-circle-xmark\" aria-hidden=\"true\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t";
        }
        // line 51
        yield "\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr";
        // line 53
        if ((($tmp = ($context["register_globals"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 54
        yield ($context["text_global"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 55
        if ((($tmp = ($context["register_globals"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield ($context["text_on"] ?? null);
        } else {
            yield ($context["text_off"] ?? null);
        }
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 56
        yield ($context["text_off"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"text-center\">
\t\t\t\t\t\t\t\t\t\t\t";
        // line 58
        if ((($tmp =  !($context["register_globals"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 59
            yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\" aria-label=\"";
            yield ($context["text_on"] ?? null);
            yield "\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-check\" aria-hidden=\"true\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 63
            yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\" aria-label=\"";
            yield ($context["text_off"] ?? null);
            yield "\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-circle-xmark\" aria-hidden=\"true\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t";
        }
        // line 67
        yield "\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr";
        // line 69
        if ((($tmp = ($context["magic_quotes_gpc"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 70
        yield ($context["text_magic"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 71
        if ((($tmp = ($context["magic_quotes_gpc"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield ($context["text_on"] ?? null);
        } else {
            yield ($context["text_off"] ?? null);
        }
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 72
        yield ($context["text_off"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"text-center\">
\t\t\t\t\t\t\t\t\t\t\t";
        // line 74
        if ((($tmp =  !($context["error_magic_quotes_gpc"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 75
            yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\" aria-label=\"";
            yield ($context["text_on"] ?? null);
            yield "\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-check\" aria-hidden=\"true\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 79
            yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\" aria-label=\"";
            yield ($context["text_off"] ?? null);
            yield "\">
\t\t\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-circle-xmark\" aria-hidden=\"true\"></i>
\t\t\t\t\t\t\t\t\t\t\t\t</span>
\t\t\t\t\t\t\t\t\t\t\t";
        }
        // line 83
        yield "\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr";
        // line 85
        if ((($tmp =  !($context["file_uploads"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 86
        yield ($context["text_file_upload"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 87
        if ((($tmp = ($context["file_uploads"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 88
            yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_on"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 90
            yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_off"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t\t";
        }
        // line 91
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 92
        yield ($context["text_on"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"text-center\">";
        // line 93
        if ((($tmp = ($context["file_uploads"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 94
            yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\"><i class=\"fa-solid fa-check\"></i></span>
\t\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 96
            yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\"><i class=\"fa-solid fa-circle-xmark\"></i></span>
\t\t\t\t\t\t\t\t\t\t\t";
        }
        // line 98
        yield "\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t<tr";
        // line 100
        if ((($tmp = ($context["session_auto_start"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 101
        yield ($context["text_session"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 102
        if ((($tmp = ($context["session_auto_start"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 103
            yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_on"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 105
            yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_off"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t\t";
        }
        // line 106
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
        // line 107
        yield ($context["text_off"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"text-center\">";
        // line 108
        if ((($tmp =  !($context["session_auto_start"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 109
            yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\"><i class=\"fa-solid fa-check\"></i></span>
\t\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 111
            yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\"><i class=\"fa-solid fa-circle-xmark\"></i></span>
\t\t\t\t\t\t\t\t\t\t\t";
        }
        // line 113
        yield "\t\t\t\t\t\t\t\t\t\t</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t</tbody>
\t\t\t\t\t\t</table>
\t\t\t\t\t</fieldset>
\t\t\t\t\t<fieldset>
\t\t\t\t\t\t<legend>";
        // line 119
        yield ($context["text_install_extension"] ?? null);
        yield "</legend>
\t\t\t\t\t\t<table class=\"table table-bordered\">
\t\t\t\t\t\t\t<thead>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td width=\"35%\"><b>";
        // line 123
        yield ($context["text_extension"] ?? null);
        yield "</b></td>
\t\t\t\t\t\t\t\t\t<td width=\"25%\"><b>";
        // line 124
        yield ($context["text_current"] ?? null);
        yield "</b></td>
\t\t\t\t\t\t\t\t\t<td width=\"25%\"><b>";
        // line 125
        yield ($context["text_required"] ?? null);
        yield "</b></td>
\t\t\t\t\t\t\t\t\t<td width=\"15%\" class=\"text-center\"><b>";
        // line 126
        yield ($context["text_status"] ?? null);
        yield "</b></td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t</thead>
\t\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t\t<tr";
        // line 130
        if ((($tmp =  !($context["db"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t<td>";
        // line 131
        yield ($context["text_db"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 132
        if ((($tmp = ($context["db"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 133
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_on"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 135
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_off"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 136
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 137
        yield ($context["text_on"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td class=\"text-center\">";
        // line 138
        if ((($tmp = ($context["db"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 139
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\"><i class=\"fa-solid fa-check\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 141
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\"><i class=\"fa-solid fa-circle-xmark\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 142
        yield "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr";
        // line 144
        if ((($tmp =  !($context["gd"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t<td>";
        // line 145
        yield ($context["text_gd"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 146
        if ((($tmp = ($context["gd"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 147
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_on"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 149
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_off"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 150
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 151
        yield ($context["text_on"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td class=\"text-center\">";
        // line 152
        if ((($tmp = ($context["gd"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 153
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\"><i class=\"fa-solid fa-check\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 155
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\"><i class=\"fa-solid fa-circle-xmark\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 156
        yield "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr";
        // line 158
        if ((($tmp =  !($context["curl"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t<td>";
        // line 159
        yield ($context["text_curl"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 160
        if ((($tmp = ($context["curl"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 161
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_on"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 163
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_off"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 164
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 165
        yield ($context["text_on"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td class=\"text-center\">";
        // line 166
        if ((($tmp = ($context["curl"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 167
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\"><i class=\"fa-solid fa-check\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 169
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\"><i class=\"fa-solid fa-circle-xmark\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 170
        yield "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr";
        // line 172
        if ((($tmp =  !($context["openssl"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t<td>";
        // line 173
        yield ($context["text_openssl"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 174
        if ((($tmp = ($context["openssl"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 175
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_on"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 177
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_off"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 178
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 179
        yield ($context["text_on"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td class=\"text-center\">";
        // line 180
        if ((($tmp = ($context["openssl"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 181
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\"><i class=\"fa-solid fa-check\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 183
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\"><i class=\"fa-solid fa-circle-xmark\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 184
        yield "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr";
        // line 186
        if ((($tmp =  !($context["zlib"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t<td>";
        // line 187
        yield ($context["text_zlib"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 188
        if ((($tmp = ($context["zlib"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 189
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_on"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 191
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_off"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 192
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 193
        yield ($context["text_on"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td class=\"text-center\">";
        // line 194
        if ((($tmp = ($context["zlib"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 195
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\"><i class=\"fa-solid fa-check\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 197
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\"><i class=\"fa-solid fa-circle-xmark\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 198
        yield "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr";
        // line 200
        if ((($tmp =  !($context["zip"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t<td>";
        // line 201
        yield ($context["text_zip"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 202
        if ((($tmp = ($context["zip"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 203
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_on"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 205
            yield "\t\t\t\t\t\t\t\t\t\t\t";
            yield ($context["text_off"] ?? null);
            yield "
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 206
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 207
        yield ($context["text_on"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td class=\"text-center\">";
        // line 208
        if ((($tmp = ($context["zip"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 209
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\"><i class=\"fa-solid fa-check\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 211
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\"><i class=\"fa-solid fa-circle-xmark\"></i></span>
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 212
        yield "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t";
        // line 214
        if ((($tmp =  !($context["iconv"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 215
            yield "\t\t\t\t\t\t\t\t\t<tr";
            if ((($tmp =  !($context["mbstring"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield " class=\"table-danger\"";
            }
            yield ">
\t\t\t\t\t\t\t\t\t\t<td>";
            // line 216
            yield ($context["text_mbstring"] ?? null);
            yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
            // line 217
            if ((($tmp = ($context["mbstring"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 218
                yield "\t\t\t\t\t\t\t\t\t\t\t\t";
                yield ($context["text_on"] ?? null);
                yield "
\t\t\t\t\t\t\t\t\t\t\t";
            } else {
                // line 220
                yield "\t\t\t\t\t\t\t\t\t\t\t\t";
                yield ($context["text_off"] ?? null);
                yield "
\t\t\t\t\t\t\t\t\t\t\t";
            }
            // line 221
            yield "</td>
\t\t\t\t\t\t\t\t\t\t<td>";
            // line 222
            yield ($context["text_on"] ?? null);
            yield "</td>
\t\t\t\t\t\t\t\t\t\t<td class=\"text-center\">";
            // line 223
            if ((($tmp = ($context["mbstring"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 224
                yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\"><i class=\"fa-solid fa-check\"></i></span>
\t\t\t\t\t\t\t\t\t\t\t";
            } else {
                // line 226
                yield "\t\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\"><i class=\"fa-solid fa-circle-xmark\"></i></span>
\t\t\t\t\t\t\t\t\t\t\t";
            }
            // line 227
            yield "</td>
\t\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t";
        }
        // line 230
        yield "\t\t\t\t\t\t\t</tbody>
\t\t\t\t\t\t</table>
\t\t\t\t\t</fieldset>
\t\t\t\t\t<fieldset>
\t\t\t\t\t\t<legend>";
        // line 234
        yield ($context["text_install_file"] ?? null);
        yield "</legend>
\t\t\t\t\t\t<table class=\"table table-bordered\">
\t\t\t\t\t\t\t<thead>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t\t\t\t<td><b>";
        // line 238
        yield ($context["text_file"] ?? null);
        yield "</b></td>
\t\t\t\t\t\t\t\t\t<td><b>";
        // line 239
        yield ($context["text_status"] ?? null);
        yield "</b></td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t</thead>
\t\t\t\t\t\t\t<tbody>
\t\t\t\t\t\t\t\t<tr";
        // line 243
        if ((($tmp = ($context["error_catalog_config"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t<td>";
        // line 244
        yield ($context["catalog_config"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 245
        if ((($tmp =  !($context["error_catalog_config"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 246
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\">";
            yield ($context["text_writable"] ?? null);
            yield "</span>
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 248
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\">";
            yield ($context["error_catalog_config"] ?? null);
            yield "</span>
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 249
        yield "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t<tr";
        // line 251
        if ((($tmp = ($context["error_admin_config"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield " class=\"table-danger\"";
        }
        yield ">
\t\t\t\t\t\t\t\t\t<td>";
        // line 252
        yield ($context["admin_config"] ?? null);
        yield "</td>
\t\t\t\t\t\t\t\t\t<td>";
        // line 253
        if ((($tmp =  !($context["error_admin_config"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 254
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-success\">";
            yield ($context["text_writable"] ?? null);
            yield "</span>
\t\t\t\t\t\t\t\t\t\t";
        } else {
            // line 256
            yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"text-danger\">";
            yield ($context["error_admin_config"] ?? null);
            yield "</span>
\t\t\t\t\t\t\t\t\t\t";
        }
        // line 257
        yield "</td>
\t\t\t\t\t\t\t\t</tr>
\t\t\t\t\t\t\t</tbody>
\t\t\t\t\t\t</table>
\t\t\t\t\t</fieldset>
\t\t\t\t\t<div class=\"row mt-3\">
\t\t\t\t\t\t<div class=\"col\">
\t\t\t\t\t\t\t<a href=\"";
        // line 264
        yield ($context["back"] ?? null);
        yield "\" class=\"btn btn-light\" role=\"button\">";
        yield ($context["button_back"] ?? null);
        yield "</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col text-end\">
\t\t\t\t\t\t\t<button type=\"submit\" class=\"btn btn-primary\">";
        // line 267
        yield ($context["button_continue"] ?? null);
        yield "</button>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</form>
\t</div>
</main>
";
        // line 275
        yield ($context["footer"] ?? null);
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "install/view/template/install/step_2.twig";
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
        return array (  784 => 275,  773 => 267,  765 => 264,  756 => 257,  750 => 256,  744 => 254,  742 => 253,  738 => 252,  732 => 251,  728 => 249,  722 => 248,  716 => 246,  714 => 245,  710 => 244,  704 => 243,  697 => 239,  693 => 238,  686 => 234,  680 => 230,  675 => 227,  671 => 226,  667 => 224,  665 => 223,  661 => 222,  658 => 221,  652 => 220,  646 => 218,  644 => 217,  640 => 216,  633 => 215,  631 => 214,  627 => 212,  623 => 211,  619 => 209,  617 => 208,  613 => 207,  610 => 206,  604 => 205,  598 => 203,  596 => 202,  592 => 201,  586 => 200,  582 => 198,  578 => 197,  574 => 195,  572 => 194,  568 => 193,  565 => 192,  559 => 191,  553 => 189,  551 => 188,  547 => 187,  541 => 186,  537 => 184,  533 => 183,  529 => 181,  527 => 180,  523 => 179,  520 => 178,  514 => 177,  508 => 175,  506 => 174,  502 => 173,  496 => 172,  492 => 170,  488 => 169,  484 => 167,  482 => 166,  478 => 165,  475 => 164,  469 => 163,  463 => 161,  461 => 160,  457 => 159,  451 => 158,  447 => 156,  443 => 155,  439 => 153,  437 => 152,  433 => 151,  430 => 150,  424 => 149,  418 => 147,  416 => 146,  412 => 145,  406 => 144,  402 => 142,  398 => 141,  394 => 139,  392 => 138,  388 => 137,  385 => 136,  379 => 135,  373 => 133,  371 => 132,  367 => 131,  361 => 130,  354 => 126,  350 => 125,  346 => 124,  342 => 123,  335 => 119,  327 => 113,  323 => 111,  319 => 109,  317 => 108,  313 => 107,  310 => 106,  304 => 105,  298 => 103,  296 => 102,  292 => 101,  286 => 100,  282 => 98,  278 => 96,  274 => 94,  272 => 93,  268 => 92,  265 => 91,  259 => 90,  253 => 88,  251 => 87,  247 => 86,  241 => 85,  237 => 83,  229 => 79,  221 => 75,  219 => 74,  214 => 72,  206 => 71,  202 => 70,  196 => 69,  192 => 67,  184 => 63,  176 => 59,  174 => 58,  169 => 56,  161 => 55,  157 => 54,  151 => 53,  147 => 51,  139 => 47,  131 => 43,  129 => 42,  123 => 39,  119 => 38,  111 => 33,  107 => 32,  103 => 31,  99 => 30,  93 => 27,  87 => 24,  80 => 20,  72 => 16,  66 => 13,  62 => 11,  60 => 10,  53 => 6,  49 => 5,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "install/view/template/install/step_2.twig", "E:\\wamp64\\www\\reamur\\install\\view\\template\\install\\step_2.twig");
    }
}
