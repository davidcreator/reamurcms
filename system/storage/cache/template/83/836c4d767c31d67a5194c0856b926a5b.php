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

/* install/view/template/install/step_3.twig */
class __TwigTemplate_5d8613f382455ae4145d9d0456860d45 extends Template
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
  <div class=\"page-header\">
    <div class=\"container\">
      <div class=\"float-end\" aria-label=\"Language selection\">";
        // line 5
        yield ($context["language"] ?? null);
        yield "</div>
      <h1>";
        // line 6
        yield ($context["heading_title"] ?? null);
        yield "</h1>
    </div>
  </div>
  <div class=\"container\">
    ";
        // line 10
        if ((($tmp = ($context["error_warning"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 11
            yield "      <div class=\"alert alert-danger\" role=\"alert\"><i class=\"fa-solid fa-circle-exclamation\" aria-hidden=\"true\"></i> ";
            yield ($context["error_warning"] ?? null);
            yield "</div>
    ";
        }
        // line 13
        yield "    
    <!-- Progress Bar Section (Hidden by default) -->
    <div id=\"progress-container\" class=\"card mb-4\" style=\"display: none;\" role=\"region\" aria-labelledby=\"progress-heading\">
      <div class=\"card-header\">
        <i class=\"fa-solid fa-spinner fa-spin\" aria-hidden=\"true\"></i> 
        <span id=\"progress-heading\">Installing ReamurCMS...</span>
      </div>
      <div class=\"card-body\">
        <div class=\"progress mb-3\" role=\"progressbar\" aria-valuenow=\"0\" aria-valuemin=\"0\" aria-valuemax=\"100\">
          <div id=\"progress-bar\" class=\"progress-bar progress-bar-striped progress-bar-animated\" style=\"width: 0%\"></div>
        </div>
        <div id=\"progress-text\" class=\"text-center\">Initializing installation...</div>
        <div id=\"progress-steps\" class=\"mt-3\">
          <ul class=\"list-unstyled\">
            <li id=\"step-validate\" class=\"mb-2\"><i class=\"fa-solid fa-clock text-muted\" aria-hidden=\"true\"></i> Validating configuration...</li>
            <li id=\"step-database\" class=\"mb-2\"><i class=\"fa-solid fa-clock text-muted\" aria-hidden=\"true\"></i> Creating database tables...</li>
            <li id=\"step-data\" class=\"mb-2\"><i class=\"fa-solid fa-clock text-muted\" aria-hidden=\"true\"></i> Inserting initial data...</li>
            <li id=\"step-admin\" class=\"mb-2\"><i class=\"fa-solid fa-clock text-muted\" aria-hidden=\"true\"></i> Setting up administrator account...</li>
            <li id=\"step-config\" class=\"mb-2\"><i class=\"fa-solid fa-clock text-muted\" aria-hidden=\"true\"></i> Creating configuration files...</li>
            <li id=\"step-complete\" class=\"mb-2\"><i class=\"fa-solid fa-clock text-muted\" aria-hidden=\"true\"></i> Finalizing installation...</li>
          </ul>
        </div>
        <div id=\"completion-message\" class=\"alert alert-success mt-3\" style=\"display: none;\" role=\"alert\">
          <i class=\"fa-solid fa-check-circle\" aria-hidden=\"true\"></i> 
          <strong>Installation Completed Successfully!</strong>
          <p class=\"mb-0 mt-2\">ReamurCMS has been installed successfully. You will be redirected to the final step shortly.</p>
        </div>
      </div>
    </div>
    
    <div class=\"card-info\">
        <div class=\"alert alert-info\" role=\"region\" aria-labelledby=\"help-heading\">
            <p id=\"help-heading\">";
        // line 45
        yield ($context["text_help"] ?? null);
        yield "</p>
            <ul class=\"text-info\">
            <li><strong><a href=\"https://docs.cpanel.net/cpanel/databases/mysql-databases/\" target=\"_blank\" rel=\"noopener noreferrer\">";
        // line 47
        yield ($context["text_cpanel"] ?? null);
        yield "</a></strong></li>
            <li><strong><a href=\"https://support.plesk.com/hc/en-us/articles/115004263014-How-to-create-a-database-in-Plesk\" target=\"_blank\" rel=\"noopener noreferrer\">";
        // line 48
        yield ($context["text_plesk"] ?? null);
        yield "</a></strong></li>
            </ul>
        </div>
    </div>
    <div class=\"card\" id=\"installation-form\">    
      <div class=\"card-header\"><i class=\"fa-solid fa-cogs\" aria-hidden=\"true\"></i> ";
        // line 53
        yield ($context["text_step_3"] ?? null);
        yield "</div>
      <div class=\"card-body\">
        <form action=\"";
        // line 55
        yield ($context["action"] ?? null);
        yield "\" method=\"post\" enctype=\"multipart/form-data\" novalidate id=\"install-form\">
          <fieldset>
            <legend>";
        // line 57
        yield ($context["text_db_connection"] ?? null);
        yield "</legend>

            <div class=\"row\">
              <div class=\"col-md-12 order-md-1\">
                <div class=\"row mb-3\">
                  <div class=\"col\">
                    <label for=\"input-db-driver\" class=\"form-label\">";
        // line 63
        yield ($context["entry_db_driver"] ?? null);
        yield "</label>
                    <select name=\"db_driver\" id=\"input-db-driver\" class=\"form-select\">
                      ";
        // line 65
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["drivers"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["driver"]) {
            // line 66
            yield "                        <option value=\"";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["driver"], "value", [], "any", false, false, false, 66);
            yield "\"";
            if ((($context["db_driver"] ?? null) == CoreExtension::getAttribute($this->env, $this->source, $context["driver"], "value", [], "any", false, false, false, 66))) {
                yield " selected";
            }
            yield ">";
            yield CoreExtension::getAttribute($this->env, $this->source, $context["driver"], "text", [], "any", false, false, false, 66);
            yield "</option>
                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['driver'], $context['_parent']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 68
        yield "                    </select>
                    ";
        // line 69
        if ((($tmp = ($context["error_db_driver"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 70
            yield "                      <div class=\"text-danger\" id=\"error-db-driver\">";
            yield ($context["error_db_driver"] ?? null);
            yield "</div>
                    ";
        }
        // line 72
        yield "                  </div>
                  <div class=\"col required\">
                    <label for=\"input-db-hostname\" class=\"form-label\">";
        // line 74
        yield ($context["entry_db_hostname"] ?? null);
        yield "</label>
                    <input type=\"text\" name=\"db_hostname\" value=\"";
        // line 75
        yield ($context["db_hostname"] ?? null);
        yield "\" id=\"input-db-hostname\" class=\"form-control\" aria-required=\"true\"/>
                    ";
        // line 76
        if ((($tmp = ($context["error_db_hostname"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 77
            yield "                      <div class=\"text-danger\" id=\"error-db-hostname\">";
            yield ($context["error_db_hostname"] ?? null);
            yield "</div>
                    ";
        }
        // line 79
        yield "                  </div>
                </div>

                <div class=\"row mb-3\">
                  <div class=\"col required\">
                    <label for=\"input-db-username\" class=\"form-label\">";
        // line 84
        yield ($context["entry_db_username"] ?? null);
        yield "</label>
                    <input type=\"text\" name=\"db_username\" value=\"";
        // line 85
        yield ($context["db_username"] ?? null);
        yield "\" id=\"input-db-username\" class=\"form-control\" aria-required=\"true\"/>
                    ";
        // line 86
        if ((($tmp = ($context["error_db_username"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 87
            yield "                      <div class=\"text-danger\" id=\"error-db-username\">";
            yield ($context["error_db_username"] ?? null);
            yield "</div>
                    ";
        }
        // line 89
        yield "                  </div>
                  <div class=\"col\">
                    <label for=\"input-db-password\" class=\"form-label\">";
        // line 91
        yield ($context["entry_db_password"] ?? null);
        yield "</label>
                    <input type=\"password\" name=\"db_password\" value=\"";
        // line 92
        yield ($context["db_password"] ?? null);
        yield "\" id=\"input-db-password\" class=\"form-control\" autocomplete=\"new-password\"/>
                  </div>
                </div>

                <div class=\"row mb-3\">

                  <div class=\"col-6 required\">
                    <label for=\"input-db-database\" class=\"form-label\">";
        // line 99
        yield ($context["entry_db_database"] ?? null);
        yield "</label>
                    <input type=\"text\" name=\"db_database\" value=\"";
        // line 100
        yield ($context["db_database"] ?? null);
        yield "\" id=\"input-db-database\" class=\"form-control\" aria-required=\"true\"/>
                    ";
        // line 101
        if ((($tmp = ($context["error_db_database"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 102
            yield "                      <div class=\"text-danger\" id=\"error-db-database\">";
            yield ($context["error_db_database"] ?? null);
            yield "</div>
                    ";
        }
        // line 104
        yield "                  </div>

                  <div class=\"col-3\">
                    <label for=\"input-db-prefix\" class=\"form-label\">";
        // line 107
        yield ($context["entry_db_prefix"] ?? null);
        yield "</label>
                    <input type=\"text\" name=\"db_prefix\" value=\"";
        // line 108
        yield ($context["db_prefix"] ?? null);
        yield "\" id=\"input-db-prefix\" class=\"form-control\" pattern=\"[a-z0-9_]+\"/>
                    ";
        // line 109
        if ((($tmp = ($context["error_db_prefix"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 110
            yield "                      <div class=\"text-danger\" id=\"error-db-prefix\">";
            yield ($context["error_db_prefix"] ?? null);
            yield "</div>
                    ";
        }
        // line 112
        yield "                  </div>

                  <div class=\"col-3 required\">
                    <label for=\"input-db-port\" class=\"form-label\">";
        // line 115
        yield ($context["entry_db_port"] ?? null);
        yield "</label>
                    <input type=\"number\" name=\"db_port\" value=\"";
        // line 116
        yield ($context["db_port"] ?? null);
        yield "\" id=\"input-db-port\" class=\"form-control\" aria-required=\"true\"/>
                    ";
        // line 117
        if ((($tmp = ($context["error_db_port"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 118
            yield "                      <div class=\"text-danger\" id=\"error-db-port\">";
            yield ($context["error_db_port"] ?? null);
            yield "</div>
                    ";
        }
        // line 120
        yield "                  </div>

                </div>
              </div>
            </div>
          </fieldset>
          <fieldset>
            <legend>";
        // line 127
        yield ($context["text_db_administration"] ?? null);
        yield "</legend>
            <div class=\"row mb-3\">
              <div class=\"col required\">
                <label for=\"input-username\" class=\"form-label\">";
        // line 130
        yield ($context["entry_username"] ?? null);
        yield "</label>
                <input type=\"text\" name=\"username\" value=\"";
        // line 131
        yield ($context["username"] ?? null);
        yield "\" id=\"input-username\" class=\"form-control\" aria-required=\"true\"/>
                ";
        // line 132
        if ((($tmp = ($context["error_username"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 133
            yield "                  <div class=\"text-danger\" id=\"error-username\">";
            yield ($context["error_username"] ?? null);
            yield "</div>
                ";
        }
        // line 135
        yield "              </div>
              <div class=\"col required\">
                <label for=\"input-password\" class=\"form-label\">";
        // line 137
        yield ($context["entry_password"] ?? null);
        yield "</label>
                <input type=\"password\" name=\"password\" value=\"";
        // line 138
        yield ($context["password"] ?? null);
        yield "\" id=\"input-password\" class=\"form-control\" autocomplete=\"new-password\" aria-required=\"true\"/>
                ";
        // line 139
        if ((($tmp = ($context["error_password"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 140
            yield "                  <div class=\"text-danger\" id=\"error-password\">";
            yield ($context["error_password"] ?? null);
            yield "</div>
                ";
        }
        // line 142
        yield "              </div>
            </div>
            <div class=\"required\">
              <label for=\"input-email\" class=\"form-label\">";
        // line 145
        yield ($context["entry_email"] ?? null);
        yield "</label> 
              <input type=\"email\" name=\"email\" value=\"";
        // line 146
        yield ($context["email"] ?? null);
        yield "\" id=\"input-email\" class=\"form-control\" aria-required=\"true\"/>
              ";
        // line 147
        if ((($tmp = ($context["error_email"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 148
            yield "                <div class=\"text-danger\" id=\"error-email\">";
            yield ($context["error_email"] ?? null);
            yield "</div>
              ";
        }
        // line 150
        yield "            </div>
          </fieldset>
          <div class=\"row mt-3\">
            <div class=\"col\"><a href=\"";
        // line 153
        yield ($context["back"] ?? null);
        yield "\" class=\"btn btn-light\" role=\"button\">";
        yield ($context["button_back"] ?? null);
        yield "</a></div>
            <div class=\"col text-end\"><input type=\"submit\" value=\"";
        // line 154
        yield ($context["button_continue"] ?? null);
        yield "\" class=\"btn btn-primary\" id=\"install-button\"/></div>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('install-form');
    const progressContainer = document.getElementById('progress-container');
    const installationForm = document.getElementById('installation-form');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const completionMessage = document.getElementById('completion-message');
    const installButton = document.getElementById('install-button');
    
    // Installation steps with their corresponding progress percentages
    const installationSteps = [
        { id: 'step-validate', text: 'Validating configuration...', progress: 10 },
        { id: 'step-database', text: 'Creating database tables...', progress: 30 },
        { id: 'step-data', text: 'Inserting initial data...', progress: 50 },
        { id: 'step-admin', text: 'Setting up administrator account...', progress: 70 },
        { id: 'step-config', text: 'Creating configuration files...', progress: 90 },
        { id: 'step-complete', text: 'Finalizing installation...', progress: 100 }
    ];
    
    function updateStepStatus(stepId, status) {
        const stepElement = document.getElementById(stepId);
        const icon = stepElement.querySelector('i');
        
        // Remove existing classes
        icon.classList.remove('fa-clock', 'fa-spinner', 'fa-check', 'fa-spin', 'text-muted', 'text-primary', 'text-success');
        
        switch(status) {
            case 'current':
                icon.classList.add('fa-spinner', 'fa-spin', 'text-primary');
                break;
            case 'completed':
                icon.classList.add('fa-check', 'text-success');
                break;
            default:
                icon.classList.add('fa-clock', 'text-muted');
        }
    }
    
    function updateProgress(step, percentage, text) {
        // Update progress bar
        progressBar.style.width = percentage + '%';
        progressBar.setAttribute('aria-valuenow', percentage);
        
        // Update progress text
        progressText.textContent = text + ' (' + percentage + '%)';
        
        // Update step status
        installationSteps.forEach((installStep, index) => {
            if (index < step) {
                updateStepStatus(installStep.id, 'completed');
            } else if (index === step) {
                updateStepStatus(installStep.id, 'current');
            }
        });
    }
    
    function simulateInstallation() {
        let currentStep = 0;
        
        function nextStep() {
            if (currentStep < installationSteps.length) {
                const step = installationSteps[currentStep];
                updateProgress(currentStep, step.progress, step.text);
                currentStep++;
                
                if (currentStep < installationSteps.length) {
                    // Continue to next step after a delay
                    setTimeout(nextStep, Math.random() * 2000 + 1500); // 1.5-3.5 seconds
                } else {
                    // Installation complete
                    setTimeout(showCompletion, 1000);
                }
            }
        }
        
        nextStep();
    }
    
    function showCompletion() {
        // Mark all steps as completed
        installationSteps.forEach(step => {
            updateStepStatus(step.id, 'completed');
        });
        
        // Show completion message
        completionMessage.style.display = 'block';
        
        // Update progress text
        progressText.innerHTML = '<strong>Installation completed successfully!</strong>';
        
        // Remove animation from progress bar
        progressBar.classList.remove('progress-bar-animated');
        progressBar.classList.add('bg-success');
        
        // Submit the form after showing completion
        setTimeout(() => {
            form.submit();
        }, 3000); // Wait 3 seconds before submitting
    }
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Disable the install button
        installButton.disabled = true;
        installButton.value = 'Installing...';
        
        // Hide the installation form and show progress
        installationForm.style.display = 'none';
        progressContainer.style.display = 'block';
        
        // Scroll to progress bar
        progressContainer.scrollIntoView({ behavior: 'smooth' });
        
        // Start the installation simulation
        setTimeout(simulateInstallation, 500);
    });
});
</script>

";
        // line 284
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
        return "install/view/template/install/step_3.twig";
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
        return array (  508 => 284,  375 => 154,  369 => 153,  364 => 150,  358 => 148,  356 => 147,  352 => 146,  348 => 145,  343 => 142,  337 => 140,  335 => 139,  331 => 138,  327 => 137,  323 => 135,  317 => 133,  315 => 132,  311 => 131,  307 => 130,  301 => 127,  292 => 120,  286 => 118,  284 => 117,  280 => 116,  276 => 115,  271 => 112,  265 => 110,  263 => 109,  259 => 108,  255 => 107,  250 => 104,  244 => 102,  242 => 101,  238 => 100,  234 => 99,  224 => 92,  220 => 91,  216 => 89,  210 => 87,  208 => 86,  204 => 85,  200 => 84,  193 => 79,  187 => 77,  185 => 76,  181 => 75,  177 => 74,  173 => 72,  167 => 70,  165 => 69,  162 => 68,  147 => 66,  143 => 65,  138 => 63,  129 => 57,  124 => 55,  119 => 53,  111 => 48,  107 => 47,  102 => 45,  68 => 13,  62 => 11,  60 => 10,  53 => 6,  49 => 5,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "install/view/template/install/step_3.twig", "E:\\wamp64\\www\\reamur\\install\\view\\template\\install\\step_3.twig");
    }
}
