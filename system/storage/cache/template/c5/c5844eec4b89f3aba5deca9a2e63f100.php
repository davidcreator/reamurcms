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

/* admin/view/template/common/filemanager.twig */
class __TwigTemplate_887a1d73f60064f5dc874d7cbb8c6225 extends Template
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
        yield "<div id=\"modal-image\" class=\"modal\">
  <div id=\"filemanager\" class=\"modal-dialog modal-lg\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h5 class=\"modal-title\">";
        // line 5
        yield ($context["heading_title"] ?? null);
        yield "</h5>
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>
      </div>
      <div class=\"modal-body\"></div>
    </div>
  </div>
  <script type=\"text/javascript\">
    // Configurações do FileManager
    window.fileManagerConfig = {
      userToken: '";
        // line 14
        yield ($context["user_token"] ?? null);
        yield "',
      maxFileSize: ";
        // line 15
        yield ($context["config_file_max_size"] ?? null);
        yield ",
      translations: {
        error_upload_size: '";
        // line 17
        yield ($context["error_upload_size"] ?? null);
        yield "',
        text_confirm: '";
        // line 18
        yield ($context["text_confirm"] ?? null);
        yield "',
        heading_title: '";
        // line 19
        yield ($context["heading_title"] ?? null);
        yield "'
      },
      thumb: ";
        // line 21
        if ((($tmp = ($context["thumb"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "'";
            yield ($context["thumb"] ?? null);
            yield "'";
        } else {
            yield "null";
        }
        yield ",
      target: ";
        // line 22
        if ((($tmp = ($context["target"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "'";
            yield ($context["target"] ?? null);
            yield "'";
        } else {
            yield "null";
        }
        yield ",
      ckeditor: ";
        // line 23
        if ((($tmp = ($context["ckeditor"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            yield "'";
            yield ($context["ckeditor"] ?? null);
            yield "'";
        } else {
            yield "null";
        }
        // line 24
        yield "    };

    // Inicializa o FileManager quando o documento estiver pronto
    \$(document).ready(function() {
      if (typeof FileManager !== 'undefined') {
        FileManager.init();
      } else {
        console.error('";
        // line 31
        yield ($context["error_log"] ?? null);
        yield "');
      }
    });
  </script>
</div>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/view/template/common/filemanager.twig";
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
        return array (  119 => 31,  110 => 24,  102 => 23,  92 => 22,  82 => 21,  77 => 19,  73 => 18,  69 => 17,  64 => 15,  60 => 14,  48 => 5,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/common/filemanager.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\common\\filemanager.twig");
    }
}
