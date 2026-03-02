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

/* admin/view/template/common/filemanager_list.twig */
class __TwigTemplate_81103ad7d7d63f7ac713b69062c27b8b extends Template
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
        yield "<div class=\"row mb-3\">
  <div class=\"col-sm-5\">
    <a href=\"";
        // line 3
        yield ($context["parent"] ?? null);
        yield "\" id=\"button-parent\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["button_parent"] ?? null);
        yield "\" class=\"btn btn-light\"><i class=\"fa-solid fa-level-up-alt\"></i></a>
    <a href=\"";
        // line 4
        yield ($context["refresh"] ?? null);
        yield "\" id=\"button-refresh\" data-bs-toggle=\"tooltip\" title=\"";
        yield ($context["button_refresh"] ?? null);
        yield "\" class=\"btn btn-light\"><i class=\"fa-solid fa-rotate\"></i></a>
    <button type=\"button\" data-bs-toggle=\"tooltip\" title=\"";
        // line 5
        yield ($context["button_upload"] ?? null);
        yield "\" id=\"button-upload\" class=\"btn btn-primary\"><i class=\"fa-solid fa-upload\"></i></button>
    <button type=\"button\" data-bs-toggle=\"tooltip\" title=\"";
        // line 6
        yield ($context["button_folder"] ?? null);
        yield "\" id=\"button-folder\" class=\"btn btn-light\"><i class=\"fa-solid fa-folder\"></i></button>
    <button type=\"button\" data-bs-toggle=\"tooltip\" title=\"";
        // line 7
        yield ($context["button_delete"] ?? null);
        yield "\" id=\"button-delete\" class=\"btn btn-danger\"><i class=\"fa-regular fa-trash-can\"></i></button>
    <input type=\"hidden\" name=\"directory\" value=\"";
        // line 8
        yield ($context["directory"] ?? null);
        yield "\" id=\"input-directory\"/>
  </div>
  <div class=\"col-sm-7\">
    <div class=\"input-group\">
      <input type=\"text\" name=\"search\" value=\"";
        // line 12
        yield ($context["filter_name"] ?? null);
        yield "\" placeholder=\"";
        yield ($context["entry_search"] ?? null);
        yield "\" id=\"input-search\" class=\"form-control\">
      <button type=\"button\" id=\"button-search\" data-bs-toggle=\"tooltip\" title=\"";
        // line 13
        yield ($context["button_search"] ?? null);
        yield "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-search\"></i></button>
    </div>
  </div>
</div>
<div id=\"modal-folder\" class=\"row mb-3\" style=\"display: none;\">
  <div class=\"col-sm-12\">
    <div class=\"input-group\">
      <div class=\"input-group\">
        <input type=\"text\" name=\"folder\" value=\"\" placeholder=\"";
        // line 21
        yield ($context["entry_folder"] ?? null);
        yield "\" id=\"input-folder\" class=\"form-control\">
        <button type=\"button\" title=\"";
        // line 22
        yield ($context["button_folder"] ?? null);
        yield "\" id=\"button-create\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus-circle\"></i></button>
      </div>
    </div>
  </div>
</div>
<hr/>
<div class=\"row row-cols-sm-3 row-cols-lg-4\">
  ";
        // line 29
        $context["path_row"] = 0;
        // line 30
        yield "  ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["directories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["directory"]) {
            // line 31
            yield "    <div class=\"mb-3\">
      <div class=\"mb-1\" style=\"min-height: 140px;\">
        <a href=\"";
            // line 33
            yield CoreExtension::getAttribute($this->env, $this->source, $context["directory"], "href", [], "any", false, false, false, 33);
            yield "\" class=\"directory mb-1\"><i class=\"fa-solid fa-folder fa-5x\"></i></a>
      </div>
      <div class=\"form-check\">
        <label for=\"input-path-";
            // line 36
            yield ($context["path_row"] ?? null);
            yield "\" class=\"form-check-label\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["directory"], "name", [], "any", false, false, false, 36);
            yield "</label>
        <input type=\"checkbox\" name=\"path[]\" value=\"";
            // line 37
            yield CoreExtension::getAttribute($this->env, $this->source, $context["directory"], "path", [], "any", false, false, false, 37);
            yield "\" id=\"input-path-";
            yield ($context["path_row"] ?? null);
            yield "\" class=\"form-check-input\"/>
      </div>
    </div>
    ";
            // line 40
            $context["path_row"] = (($context["path_row"] ?? null) + 1);
            // line 41
            yield "  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['directory'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 42
        yield "  ";
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["images"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["image"]) {
            // line 43
            yield "    <div class=\"mb-3\">
      <div class=\"mb-1\" style=\"min-height: 140px;\">
        <a href=\"";
            // line 45
            yield CoreExtension::getAttribute($this->env, $this->source, $context["image"], "href", [], "any", false, false, false, 45);
            yield "\" class=\"thumbnail mb-1\"><img src=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["image"], "thumb", [], "any", false, false, false, 45);
            yield "\" alt=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["image"], "name", [], "any", false, false, false, 45);
            yield "\" title=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["image"], "name", [], "any", false, false, false, 45);
            yield "\" class=\"img-thumbnail\"/></a>
      </div>
      <div class=\"form-check\">
        <label for=\"input-path-";
            // line 48
            yield ($context["path_row"] ?? null);
            yield "\" class=\"form-check-label\">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["image"], "name", [], "any", false, false, false, 48);
            yield "</label>
        <input type=\"checkbox\" name=\"path[]\" value=\"";
            // line 49
            yield CoreExtension::getAttribute($this->env, $this->source, $context["image"], "path", [], "any", false, false, false, 49);
            yield "\" id=\"input-path-";
            yield ($context["path_row"] ?? null);
            yield "\" class=\"form-check-input\"/>
      </div>
    </div>
    ";
            // line 52
            $context["path_row"] = (($context["path_row"] ?? null) + 1);
            // line 53
            yield "  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['image'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        yield "</div>
";
        // line 55
        if ((($tmp = ($context["pagination"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 56
            yield "  <div class=\"modal-footer\">";
            yield ($context["pagination"] ?? null);
            yield "</div>
";
        }
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "admin/view/template/common/filemanager_list.twig";
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
        return array (  195 => 56,  193 => 55,  190 => 54,  184 => 53,  182 => 52,  174 => 49,  168 => 48,  156 => 45,  152 => 43,  147 => 42,  141 => 41,  139 => 40,  131 => 37,  125 => 36,  119 => 33,  115 => 31,  110 => 30,  108 => 29,  98 => 22,  94 => 21,  83 => 13,  77 => 12,  70 => 8,  66 => 7,  62 => 6,  58 => 5,  52 => 4,  46 => 3,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "admin/view/template/common/filemanager_list.twig", "E:\\wamp64\\www\\reamur\\admin\\view\\template\\common\\filemanager_list.twig");
    }
}
