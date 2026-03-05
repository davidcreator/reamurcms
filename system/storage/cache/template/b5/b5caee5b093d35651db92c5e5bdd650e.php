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

/* install/view/template/install/step_4.twig */
class __TwigTemplate_775fc469a60f3449db5018d875244df4 extends Template
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
\t\t\t<h1>";
        // line 5
        yield ($context["heading_title"] ?? null);
        yield "</h1>
\t\t</div>
\t</div>
\t<div class=\"container\">
\t\t";
        // line 9
        if ((($tmp = ($context["error_warning"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 10
            yield "\t\t<div class=\"alert alert-danger\" role=\"alert\"><i class=\"fa-solid fa-circle-exclamation\" aria-hidden=\"true\"></i> ";
            yield ($context["error_warning"] ?? null);
            yield "</div>
\t\t";
        }
        // line 12
        yield "\t\t";
        if ((($tmp = ($context["success_message"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 13
            yield "\t\t<div class=\"alert alert-success\" role=\"alert\"><i class=\"fa-solid fa-circle-check\" aria-hidden=\"true\"></i> ";
            yield ($context["success_message"] ?? null);
            yield "</div>
\t\t";
        }
        // line 15
        yield "\t\t<div class=\"card\">
\t\t\t<div class=\"card-header\"><i class=\"fa-solid fa-pencil\" aria-hidden=\"true\"></i> ";
        // line 16
        yield ($context["text_step_4"] ?? null);
        yield "</div>
\t\t\t<div class=\"card-body p-4\">
\t\t\t\t<div class=\"row mb-4\">
\t\t\t\t\t<div class=\"col-md-6 col-sm-12 text-center mb-3 mb-md-0\">
\t\t\t\t\t\t<a href=\"../\" aria-label=\"";
        // line 20
        yield ($context["text_catalog"] ?? null);
        yield "\">
\t\t\t\t\t\t\t<img src=\"view/image/catalog.jpg\" alt=\"ReamurCMS Catalog\" title=\"ReamurCMS Catalog\" class=\"img-thumbnail\"/>
\t\t\t\t\t\t</a>
\t\t\t\t\t\t<br/>
\t\t\t\t\t\t<a href=\"../\" class=\"btn btn-outline-secondary mt-3\" role=\"button\">";
        // line 24
        yield ($context["text_catalog"] ?? null);
        yield "</a>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6 col-sm-12 text-center\">
\t\t\t\t\t\t<a href=\"../admin/\" aria-label=\"";
        // line 27
        yield ($context["text_admin"] ?? null);
        yield "\">
\t\t\t\t\t\t\t<img src=\"view/image/admin.jpg\" alt=\"ReamurCMS Admin\" title=\"ReamurCMS Admin\" class=\"img-thumbnail\"/>
\t\t\t\t\t\t</a>
\t\t\t\t\t\t<br/>
\t\t\t\t\t\t<a href=\"../admin/\" class=\"btn btn-outline-secondary mt-3\" role=\"button\">";
        // line 31
        yield ($context["text_admin"] ?? null);
        yield "</a>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"mb-4\">
\t\t\t\t\t<h4 class=\"mb-2\"><i class=\"fa-solid fa-plug\" aria-hidden=\"true\"></i> ";
        // line 35
        yield ($context["text_install_extensions"] ?? null);
        yield "</h4>
\t\t\t\t\t<p class=\"text-muted\">";
        // line 36
        yield ($context["text_install_extensions_desc"] ?? null);
        yield "</p>
\t\t\t\t\t<div class=\"row g-3\">
\t\t\t\t\t\t<div class=\"col-lg-4 col-md-6\">
\t\t\t\t\t\t\t<div class=\"border rounded p-3 h-100\">
\t\t\t\t\t\t\t\t<form method=\"post\" class=\"h-100 d-flex flex-column\">
\t\t\t\t\t\t\t\t\t<div class=\"d-flex justify-content-between align-items-start gap-3 flex-grow-1\">
\t\t\t\t\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t\t\t\t\t<h5 class=\"mb-1\">";
        // line 43
        yield ($context["text_blog_title"] ?? null);
        yield "</h5>
\t\t\t\t\t\t\t\t\t\t\t<p class=\"small text-muted mb-2\">";
        // line 44
        yield ($context["text_blog_desc"] ?? null);
        yield "</p>
\t\t\t\t\t\t\t\t\t\t\t";
        // line 45
        $context["status_class_blog"] = "text-muted";
        // line 46
        yield "\t\t\t\t\t\t\t\t\t\t\t";
        if ((($tmp = ($context["status_blog"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 47
            yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            if ((CoreExtension::inFilter("Erro", ($context["status_blog"] ?? null)) || CoreExtension::inFilter("Error", ($context["status_blog"] ?? null)))) {
                // line 48
                yield "\t\t\t\t\t\t\t\t\t\t\t\t\t";
                $context["status_class_blog"] = "text-danger";
                // line 49
                yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            } else {
                // line 50
                yield "\t\t\t\t\t\t\t\t\t\t\t\t\t";
                $context["status_class_blog"] = "text-success";
                // line 51
                yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            }
            // line 52
            yield "\t\t\t\t\t\t\t\t\t\t\t";
        }
        // line 53
        yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"small ";
        yield ($context["status_class_blog"] ?? null);
        yield "\">";
        yield ($context["status_blog"] ?? null);
        yield "</span>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<input type=\"hidden\" name=\"install_extension\" value=\"blog\"/>
\t\t\t\t\t\t\t\t\t\t<button type=\"submit\" class=\"btn btn-primary btn-sm\">
\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-play\" aria-hidden=\"true\"></i> ";
        // line 57
        yield ($context["button_install_now"] ?? null);
        yield "
\t\t\t\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</form>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-lg-4 col-md-6\">
\t\t\t\t\t\t\t<div class=\"border rounded p-3 h-100\">
\t\t\t\t\t\t\t\t<form method=\"post\" class=\"h-100 d-flex flex-column\">
\t\t\t\t\t\t\t\t\t<div class=\"d-flex justify-content-between align-items-start gap-3 flex-grow-1\">
\t\t\t\t\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t\t\t\t\t<h5 class=\"mb-1\">";
        // line 68
        yield ($context["text_landpage_title"] ?? null);
        yield "</h5>
\t\t\t\t\t\t\t\t\t\t\t<p class=\"small text-muted mb-2\">";
        // line 69
        yield ($context["text_landpage_desc"] ?? null);
        yield "</p>
\t\t\t\t\t\t\t\t\t\t\t";
        // line 70
        $context["status_class_landpage"] = "text-muted";
        // line 71
        yield "\t\t\t\t\t\t\t\t\t\t\t";
        if ((($tmp = ($context["status_landpage"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 72
            yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            if ((CoreExtension::inFilter("Erro", ($context["status_landpage"] ?? null)) || CoreExtension::inFilter("Error", ($context["status_landpage"] ?? null)))) {
                // line 73
                yield "\t\t\t\t\t\t\t\t\t\t\t\t\t";
                $context["status_class_landpage"] = "text-danger";
                // line 74
                yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            } else {
                // line 75
                yield "\t\t\t\t\t\t\t\t\t\t\t\t\t";
                $context["status_class_landpage"] = "text-success";
                // line 76
                yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            }
            // line 77
            yield "\t\t\t\t\t\t\t\t\t\t\t";
        }
        // line 78
        yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"small ";
        yield ($context["status_class_landpage"] ?? null);
        yield "\">";
        yield ($context["status_landpage"] ?? null);
        yield "</span>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<input type=\"hidden\" name=\"install_extension\" value=\"landpage\"/>
\t\t\t\t\t\t\t\t\t\t<button type=\"submit\" class=\"btn btn-primary btn-sm\">
\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-play\" aria-hidden=\"true\"></i> ";
        // line 82
        yield ($context["button_install_now"] ?? null);
        yield "
\t\t\t\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</form>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"col-lg-4 col-md-6\">
\t\t\t\t\t\t\t<div class=\"border rounded p-3 h-100\">
\t\t\t\t\t\t\t\t<form method=\"post\" class=\"h-100 d-flex flex-column\">
\t\t\t\t\t\t\t\t\t<div class=\"d-flex justify-content-between align-items-start gap-3 flex-grow-1\">
\t\t\t\t\t\t\t\t\t\t<div>
\t\t\t\t\t\t\t\t\t\t\t<h5 class=\"mb-1\">";
        // line 93
        yield ($context["text_mooc_title"] ?? null);
        yield "</h5>
\t\t\t\t\t\t\t\t\t\t\t<p class=\"small text-muted mb-2\">";
        // line 94
        yield ($context["text_mooc_desc"] ?? null);
        yield "</p>
\t\t\t\t\t\t\t\t\t\t\t";
        // line 95
        $context["status_class_mooc"] = "text-muted";
        // line 96
        yield "\t\t\t\t\t\t\t\t\t\t\t";
        if ((($tmp = ($context["status_mooc"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 97
            yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            if ((CoreExtension::inFilter("Erro", ($context["status_mooc"] ?? null)) || CoreExtension::inFilter("Error", ($context["status_mooc"] ?? null)))) {
                // line 98
                yield "\t\t\t\t\t\t\t\t\t\t\t\t\t";
                $context["status_class_mooc"] = "text-danger";
                // line 99
                yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            } else {
                // line 100
                yield "\t\t\t\t\t\t\t\t\t\t\t\t\t";
                $context["status_class_mooc"] = "text-success";
                // line 101
                yield "\t\t\t\t\t\t\t\t\t\t\t\t";
            }
            // line 102
            yield "\t\t\t\t\t\t\t\t\t\t\t";
        }
        // line 103
        yield "\t\t\t\t\t\t\t\t\t\t\t<span class=\"small ";
        yield ($context["status_class_mooc"] ?? null);
        yield "\">";
        yield ($context["status_mooc"] ?? null);
        yield "</span>
\t\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t\t\t<input type=\"hidden\" name=\"install_extension\" value=\"mooc\"/>
\t\t\t\t\t\t\t\t\t\t<button type=\"submit\" class=\"btn btn-primary btn-sm\">
\t\t\t\t\t\t\t\t\t\t\t<i class=\"fa-solid fa-play\" aria-hidden=\"true\"></i> ";
        // line 107
        yield ($context["button_install_now"] ?? null);
        yield "
\t\t\t\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t</form>
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t\t<div class=\"mb-4\">";
        // line 115
        yield ($context["promotion"] ?? null);
        yield "</div>
\t\t\t\t<div class=\"m-4 text-center\">
\t\t\t\t\t<a href=\"https://reamurcms.com/index.php?route=marketplace/extension&utm_source=reamurcms_install&utm_medium=store_link&utm_campaign=reamurcms_install\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"btn btn-outline-secondary\" role=\"button\">";
        // line 117
        yield ($context["text_extension"] ?? null);
        yield "</a>
\t\t\t\t</div>
\t\t\t\t<fieldset class=\"mb-5\">
\t\t\t\t\t<legend><i class=\"fa-solid fa-envelope\" aria-hidden=\"true\"></i> ";
        // line 120
        yield ($context["text_mail"] ?? null);
        yield "</legend>
\t\t\t\t\t<div class=\"text-center\">
\t\t\t\t\t\t<p class=\"pb-2\">";
        // line 122
        yield ($context["text_mail_description"] ?? null);
        yield "</p>
\t\t\t\t\t\t<a href=\"http://newsletter.reamurcms.com/h/r/B660EBBE4980C85C\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"btn btn-primary\" role=\"button\"><i class=\"fa-solid fa-envelope\" aria-hidden=\"true\"></i> ";
        // line 123
        yield ($context["button_mail"] ?? null);
        yield "</a>
\t\t\t\t\t</div>
\t\t\t\t</fieldset>
\t\t\t\t<div class=\"row mb-4\">
\t\t\t\t\t<div class=\"col-lg-4 col-md-12 text-center mb-3 mb-lg-0\">
\t\t\t\t\t\t<h3><a href=\"https://www.facebook.com/reamurcms\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"icon transition\"><i class=\"fab fa-facebook\" aria-hidden=\"true\"></i></a> ";
        // line 128
        yield ($context["text_facebook"] ?? null);
        yield "</h3>
\t\t\t\t\t\t<p>";
        // line 129
        yield ($context["text_facebook_description"] ?? null);
        yield "</p>
\t\t\t\t\t\t<a href=\"https://www.facebook.com/reamurcms\" target=\"_blank\" rel=\"noopener noreferrer\">";
        // line 130
        yield ($context["text_facebook_visit"] ?? null);
        yield "</a>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-lg-4 col-md-12 text-center mb-3 mb-lg-0\">
\t\t\t\t\t\t<h3><a href=\"https://forum.reamurcms.com/?utm_source=reamurcms_install&utm_medium=forum_link&utm_campaign=reamurcms_install\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"icon transition\"><i class=\"fa-solid fa-comments\" aria-hidden=\"true\"></i></a> ";
        // line 133
        yield ($context["text_forum"] ?? null);
        yield "</h3>
\t\t\t\t\t\t<p>";
        // line 134
        yield ($context["text_forum_description"] ?? null);
        yield "</p>
\t\t\t\t\t\t<a href=\"https://forum.reamurcms.com/?utm_source=reamurcms_install&utm_medium=forum_link&utm_campaign=reamurcms_install\" target=\"_blank\" rel=\"noopener noreferrer\">";
        // line 135
        yield ($context["text_forum_visit"] ?? null);
        yield "</a>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-lg-4 col-md-12 text-center\">
\t\t\t\t\t\t<h3><a href=\"https://reamurcms.com/index.php?route=support/partner&utm_source=reamurcms_install&utm_medium=partner_link&utm_campaign=reamurcms_install\" target=\"_blank\" rel=\"noopener noreferrer\" class=\"icon transition\"><i class=\"fa-solid fa-user\" aria-hidden=\"true\"></i></a> ";
        // line 138
        yield ($context["text_commercial"] ?? null);
        yield "</h3>
\t\t\t\t\t\t<p>";
        // line 139
        yield ($context["text_commercial_description"] ?? null);
        yield "</p>
\t\t\t\t\t\t<a href=\"https://reamurcms.com/index.php?route=support/partner&utm_source=reamurcms_install&utm_medium=partner_link&utm_campaign=reamurcms_install\" target=\"_blank\" rel=\"noopener noreferrer\">";
        // line 140
        yield ($context["text_commercial_visit"] ?? null);
        yield "</a>
\t\t\t\t\t</div>
\t\t\t\t</div>
\t\t\t</div>
\t\t</div>
\t</div>
</main>
";
        // line 147
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
        return "install/view/template/install/step_4.twig";
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
        return array (  360 => 147,  350 => 140,  346 => 139,  342 => 138,  336 => 135,  332 => 134,  328 => 133,  322 => 130,  318 => 129,  314 => 128,  306 => 123,  302 => 122,  297 => 120,  291 => 117,  286 => 115,  275 => 107,  265 => 103,  262 => 102,  259 => 101,  256 => 100,  253 => 99,  250 => 98,  247 => 97,  244 => 96,  242 => 95,  238 => 94,  234 => 93,  220 => 82,  210 => 78,  207 => 77,  204 => 76,  201 => 75,  198 => 74,  195 => 73,  192 => 72,  189 => 71,  187 => 70,  183 => 69,  179 => 68,  165 => 57,  155 => 53,  152 => 52,  149 => 51,  146 => 50,  143 => 49,  140 => 48,  137 => 47,  134 => 46,  132 => 45,  128 => 44,  124 => 43,  114 => 36,  110 => 35,  103 => 31,  96 => 27,  90 => 24,  83 => 20,  76 => 16,  73 => 15,  67 => 13,  64 => 12,  58 => 10,  56 => 9,  49 => 5,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "install/view/template/install/step_4.twig", "E:\\wamp64\\www\\reamur\\install\\view\\template\\install\\step_4.twig");
    }
}
