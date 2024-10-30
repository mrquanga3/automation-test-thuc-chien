<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* administrator/view/template/customer/customer_form.twig */
class __TwigTemplate_ede822b580fda9716a6d778761b4a9cf extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo ($context["header"] ?? null);
        echo ($context["column_left"] ?? null);
        echo "
<div id=\"content\">
  <div class=\"page-header\">
    <div class=\"container-fluid\">
      <div class=\"float-end\">
        ";
        // line 6
        if (($context["orders"] ?? null)) {
            // line 7
            echo "          <a href=\"";
            echo ($context["orders"] ?? null);
            echo "\" data-bs-toggle=\"tooltip\" title=\"";
            echo ($context["button_order"] ?? null);
            echo "\" class=\"btn btn-warning\"><i class=\"fa-solid fa-receipt\"></i></a>
        ";
        }
        // line 9
        echo "        <button type=\"submit\" form=\"form-customer\" data-bs-toggle=\"tooltip\" title=\"";
        echo ($context["button_save"] ?? null);
        echo "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-floppy-disk\"></i></button>
        <a href=\"";
        // line 10
        echo ($context["back"] ?? null);
        echo "\" data-bs-toggle=\"tooltip\" title=\"";
        echo ($context["button_back"] ?? null);
        echo "\" class=\"btn btn-light\"><i class=\"fa-solid fa-reply\"></i></a></div>
      <h1>";
        // line 11
        echo ($context["heading_title"] ?? null);
        echo "</h1>
      <ol class=\"breadcrumb\">
        ";
        // line 13
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["breadcrumbs"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb"]) {
            // line 14
            echo "          <li class=\"breadcrumb-item\"><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "href", [], "any", false, false, false, 14);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["breadcrumb"], "text", [], "any", false, false, false, 14);
            echo "</a></li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo "      </ol>
    </div>
  </div>
  <div class=\"container-fluid\">
    <div class=\"card\">
      <div class=\"card-header\"><i class=\"fa-solid fa-pencil\"></i> ";
        // line 21
        echo ($context["text_form"] ?? null);
        echo "</div>
      <div class=\"card-body\">
        <form id=\"form-customer\" action=\"";
        // line 23
        echo ($context["save"] ?? null);
        echo "\" method=\"post\" data-oc-toggle=\"ajax\">
          <ul class=\"nav nav-tabs\">
            <li class=\"nav-item\"><a href=\"#tab-general\" data-bs-toggle=\"tab\" class=\"nav-link active\">";
        // line 25
        echo ($context["tab_general"] ?? null);
        echo "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-address\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 26
        echo ($context["tab_address"] ?? null);
        echo "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-payment\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 27
        echo ($context["tab_payment_method"] ?? null);
        echo "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-history\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 28
        echo ($context["tab_history"] ?? null);
        echo "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-transaction\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 29
        echo ($context["tab_transaction"] ?? null);
        echo "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-reward\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 30
        echo ($context["tab_reward"] ?? null);
        echo "</a></li>
            <li class=\"nav-item\"><a href=\"#tab-ip\" data-bs-toggle=\"tab\" class=\"nav-link\">";
        // line 31
        echo ($context["tab_ip"] ?? null);
        echo "</a></li>
          </ul>
          <div class=\"tab-content\">
            <div id=\"tab-general\" class=\"tab-pane active\">
              <fieldset>
                <legend>";
        // line 36
        echo ($context["text_customer"] ?? null);
        echo "</legend>
                <div class=\"row mb-3\">
                  <label for=\"input-store\" class=\"col-sm-2 col-form-label\">";
        // line 38
        echo ($context["entry_store"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <select name=\"store_id\" id=\"input-store\" class=\"form-select\">
                      ";
        // line 41
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["stores"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["store"]) {
            // line 42
            echo "                        <option value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 42);
            echo "\"";
            if ((twig_get_attribute($this->env, $this->source, $context["store"], "store_id", [], "any", false, false, false, 42) == ($context["store_id"] ?? null))) {
                echo " selected";
            }
            echo ">";
            echo twig_get_attribute($this->env, $this->source, $context["store"], "name", [], "any", false, false, false, 42);
            echo "</option>
                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['store'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "                    </select>
                  </div>
                </div>
                <div class=\"row mb-3\">
                  <label for=\"input-customer-group\" class=\"col-sm-2 col-form-label\">";
        // line 48
        echo ($context["entry_customer_group"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <select name=\"customer_group_id\" id=\"input-customer-group\" class=\"form-select\">
                      ";
        // line 51
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["customer_groups"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["customer_group"]) {
            // line 52
            echo "                        <option value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["customer_group"], "customer_group_id", [], "any", false, false, false, 52);
            echo "\"";
            if ((twig_get_attribute($this->env, $this->source, $context["customer_group"], "customer_group_id", [], "any", false, false, false, 52) == ($context["customer_group_id"] ?? null))) {
                echo " selected";
            }
            echo ">";
            echo twig_get_attribute($this->env, $this->source, $context["customer_group"], "name", [], "any", false, false, false, 52);
            echo "</option>
                      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['customer_group'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        echo "                    </select>
                  </div>
                </div>
                <div class=\"row mb-3 required\">
                  <label for=\"input-firstname\" class=\"col-sm-2 col-form-label\">";
        // line 58
        echo ($context["entry_firstname"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"firstname\" value=\"";
        // line 60
        echo ($context["firstname"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_firstname"] ?? null);
        echo "\" id=\"input-firstname\" class=\"form-control\"/>
                    <div id=\"error-firstname\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
                <div class=\"row mb-3 required\">
                  <label for=\"input-lastname\" class=\"col-sm-2 col-form-label\">";
        // line 65
        echo ($context["entry_lastname"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"lastname\" value=\"";
        // line 67
        echo ($context["lastname"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_lastname"] ?? null);
        echo "\" id=\"input-lastname\" class=\"form-control\"/>
                    <div id=\"error-lastname\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
                <div class=\"row mb-3 required\">
                  <label for=\"input-email\" class=\"col-sm-2 col-form-label\">";
        // line 72
        echo ($context["entry_email"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"email\" value=\"";
        // line 74
        echo ($context["email"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_email"] ?? null);
        echo "\" id=\"input-email\" class=\"form-control\"/>
                    <div id=\"error-email\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
                <div class=\"row mb-3";
        // line 78
        if (($context["config_telephone_required"] ?? null)) {
            echo " required";
        }
        echo "\">
                  <label for=\"input-telephone\" class=\"col-sm-2 col-form-label\">";
        // line 79
        echo ($context["entry_telephone"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"telephone\" value=\"";
        // line 81
        echo ($context["telephone"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_telephone"] ?? null);
        echo "\" id=\"input-telephone\" class=\"form-control\"/>
                    <div id=\"error-telephone\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
                ";
        // line 85
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["custom_fields"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["custom_field"]) {
            // line 86
            echo "
                  ";
            // line 87
            if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "location", [], "any", false, false, false, 87) == "account")) {
                // line 88
                echo "
                    ";
                // line 89
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 89) == "select")) {
                    // line 90
                    echo "                      <div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 90);
                    echo "\">
                        <label for=\"input-custom-field-";
                    // line 91
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 91);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 91);
                    echo "</label>
                        <div class=\"col-sm-10\">
                          <select name=\"custom_field[";
                    // line 93
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 93);
                    echo "]\" id=\"input-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 93);
                    echo "\" class=\"form-select\">
                            <option value=\"\">";
                    // line 94
                    echo ($context["text_select"] ?? null);
                    echo "</option>
                            ";
                    // line 95
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 95));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 96
                        echo "                              <option value=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 96);
                        echo "\"";
                        if (((($__internal_compile_0 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_0) || $__internal_compile_0 instanceof ArrayAccess ? ($__internal_compile_0[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 96)] ?? null) : null) && (twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 96) == (($__internal_compile_1 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_1) || $__internal_compile_1 instanceof ArrayAccess ? ($__internal_compile_1[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 96)] ?? null) : null)))) {
                            echo " selected";
                        }
                        echo ">";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 96);
                        echo "</option>
                            ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field_value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 98
                    echo "                          </select>
                          <div id=\"error-custom-field-";
                    // line 99
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 99);
                    echo "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 103
                echo "
                    ";
                // line 104
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 104) == "radio")) {
                    // line 105
                    echo "                      <div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 105);
                    echo "\">
                        <label class=\"col-sm-2 col-form-label\">";
                    // line 106
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 106);
                    echo "</label>
                        <div class=\"col-sm-10\">
                          <div id=\"input-custom-field-";
                    // line 108
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 108);
                    echo "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">
                            ";
                    // line 109
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 109));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 110
                        echo "                              <div class=\"form-check\">
                                <input type=\"radio\" name=\"custom_field[";
                        // line 111
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 111);
                        echo "]\" value=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 111);
                        echo "\" id=\"input-custom-value-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 111);
                        echo "\" class=\"form-check-input\"";
                        if (((($__internal_compile_2 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_2) || $__internal_compile_2 instanceof ArrayAccess ? ($__internal_compile_2[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 111)] ?? null) : null) && (twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 111) == (($__internal_compile_3 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_3) || $__internal_compile_3 instanceof ArrayAccess ? ($__internal_compile_3[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 111)] ?? null) : null)))) {
                            echo " checked";
                        }
                        echo "/> <label for=\"input-custom-value-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 111);
                        echo "\" class=\"form-check-label\">";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 111);
                        echo "</label>
                              </div>
                            ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field_value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 114
                    echo "                          </div>
                          <div id=\"error-custom-field-";
                    // line 115
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 115);
                    echo "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 119
                echo "
                    ";
                // line 120
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 120) == "checkbox")) {
                    // line 121
                    echo "                      <div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 121);
                    echo "\">
                        <label class=\"col-sm-2 col-form-label\">";
                    // line 122
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 122);
                    echo "</label>
                        <div class=\"col-sm-10\">
                          <div id=\"input-custom-field-";
                    // line 124
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 124);
                    echo "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">
                            ";
                    // line 125
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 125));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 126
                        echo "                              <div class=\"form-check\">
                                <input type=\"checkbox\" name=\"custom_field[";
                        // line 127
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 127);
                        echo "][]\" value=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 127);
                        echo "\" id=\"input-custom-value-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 127);
                        echo "\" class=\"form-check-input\"";
                        if (((($__internal_compile_4 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_4) || $__internal_compile_4 instanceof ArrayAccess ? ($__internal_compile_4[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 127)] ?? null) : null) && twig_in_filter(twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 127), (($__internal_compile_5 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_5) || $__internal_compile_5 instanceof ArrayAccess ? ($__internal_compile_5[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 127)] ?? null) : null)))) {
                            echo " checked";
                        }
                        echo "/> <label for=\"input-custom-value-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 127);
                        echo "\" class=\"form-check-label\">";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 127);
                        echo "</label>
                              </div>
                            ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field_value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 130
                    echo "                          </div>
                          <div id=\"error-custom-field-";
                    // line 131
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 131);
                    echo "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 135
                echo "
                    ";
                // line 136
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 136) == "text")) {
                    // line 137
                    echo "                      <div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 137);
                    echo "\">
                        <label for=\"input-custom-field-";
                    // line 138
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 138);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 138);
                    echo "</label>
                        <div class=\"col-sm-10\">
                          <input type=\"text\" name=\"custom_field[";
                    // line 140
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 140);
                    echo "]\" value=\"";
                    echo (((($__internal_compile_6 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_6) || $__internal_compile_6 instanceof ArrayAccess ? ($__internal_compile_6[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 140)] ?? null) : null)) ? ((($__internal_compile_7 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_7) || $__internal_compile_7 instanceof ArrayAccess ? ($__internal_compile_7[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 140)] ?? null) : null)) : (twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 140)));
                    echo "\" placeholder=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 140);
                    echo "\" id=\"input-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 140);
                    echo "\" class=\"form-control\"/>
                          <div id=\"error-custom-field-";
                    // line 141
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 141);
                    echo "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 145
                echo "
                    ";
                // line 146
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 146) == "textarea")) {
                    // line 147
                    echo "                      <div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 147);
                    echo "\">
                        <label for=\"input-custom-field-";
                    // line 148
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 148);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 148);
                    echo "</label>
                        <div class=\"col-sm-10\">
                          <textarea name=\"custom_field[";
                    // line 150
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 150);
                    echo "]\" rows=\"5\" placeholder=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 150);
                    echo "\" id=\"input-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 150);
                    echo "\" class=\"form-control\">";
                    echo (((($__internal_compile_8 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_8) || $__internal_compile_8 instanceof ArrayAccess ? ($__internal_compile_8[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 150)] ?? null) : null)) ? ((($__internal_compile_9 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_9) || $__internal_compile_9 instanceof ArrayAccess ? ($__internal_compile_9[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 150)] ?? null) : null)) : (twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 150)));
                    echo "</textarea>
                          <div id=\"error-custom-field-";
                    // line 151
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 151);
                    echo "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 155
                echo "
                    ";
                // line 156
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 156) == "file")) {
                    // line 157
                    echo "                      <div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 157);
                    echo "\">
                        <label class=\"col-sm-2 col-form-label\">";
                    // line 158
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 158);
                    echo "</label>
                        <div class=\"col-sm-10\">

                          <div class=\"input-group\">
                            <button type=\"button\" data-oc-toggle=\"upload\" data-oc-url=\"";
                    // line 162
                    echo ($context["upload"] ?? null);
                    echo "\" data-oc-target=\"#input-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 162);
                    echo "\" data-oc-size-max=\"";
                    echo ($context["config_file_max_size"] ?? null);
                    echo "\" data-oc-size-error=\"";
                    echo ($context["error_upload_size"] ?? null);
                    echo "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-upload\"></i> ";
                    echo ($context["button_upload"] ?? null);
                    echo "</button>
                            <input type=\"text\" name=\"custom_field[";
                    // line 163
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 163);
                    echo "]\" value=\"";
                    echo (((($__internal_compile_10 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_10) || $__internal_compile_10 instanceof ArrayAccess ? ($__internal_compile_10[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 163)] ?? null) : null)) ? ((($__internal_compile_11 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_11) || $__internal_compile_11 instanceof ArrayAccess ? ($__internal_compile_11[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 163)] ?? null) : null)) : (""));
                    echo "\" id=\"input-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 163);
                    echo "\" class=\"form-control\" readonly/>
                            <button type=\"button\" data-oc-toggle=\"download\" data-oc-target=\"#input-custom-field-";
                    // line 164
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 164);
                    echo "\"";
                    if ( !(($__internal_compile_12 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_12) || $__internal_compile_12 instanceof ArrayAccess ? ($__internal_compile_12[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 164)] ?? null) : null)) {
                        echo " disabled";
                    }
                    echo " class=\"btn btn-outline-secondary\"><i class=\"fa-solid fa-download\"></i> ";
                    echo ($context["button_download"] ?? null);
                    echo "</button>
                            <button type=\"button\" data-oc-toggle=\"clear\" data-bs-toggle=\"tooltip\" title=\"";
                    // line 165
                    echo ($context["button_clear"] ?? null);
                    echo "\" data-oc-target=\"#input-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 165);
                    echo "\"";
                    if ( !(($__internal_compile_13 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_13) || $__internal_compile_13 instanceof ArrayAccess ? ($__internal_compile_13[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 165)] ?? null) : null)) {
                        echo " disabled";
                    }
                    echo " class=\"btn btn-outline-danger\"><i class=\"fa-solid fa-eraser\"></i></button>
                          </div>

                          <div id=\"error-custom-field-";
                    // line 168
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 168);
                    echo "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 172
                echo "
                    ";
                // line 173
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 173) == "date")) {
                    // line 174
                    echo "                      <div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 174);
                    echo "\">
                        <label for=\"input-custom-field-";
                    // line 175
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 175);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 175);
                    echo "</label>
                        <div class=\"col-sm-10\">
                          <div class=\"input-group\">
                            <input type=\"text\" name=\"custom_field[";
                    // line 178
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 178);
                    echo "]\" value=\"";
                    echo (((($__internal_compile_14 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_14) || $__internal_compile_14 instanceof ArrayAccess ? ($__internal_compile_14[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 178)] ?? null) : null)) ? ((($__internal_compile_15 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_15) || $__internal_compile_15 instanceof ArrayAccess ? ($__internal_compile_15[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 178)] ?? null) : null)) : (twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 178)));
                    echo "\" placeholder=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 178);
                    echo "\" id=\"input-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 178);
                    echo "\" class=\"form-control date\"/>
                            <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                          </div>
                          <div id=\"error-custom-field-";
                    // line 181
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 181);
                    echo "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 185
                echo "
                    ";
                // line 186
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 186) == "time")) {
                    // line 187
                    echo "                      <div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 187);
                    echo "\">
                        <label for=\"input-custom-field-";
                    // line 188
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 188);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 188);
                    echo "</label>
                        <div class=\"col-sm-10\">
                          <div class=\"input-group\">
                            <input type=\"text\" name=\"custom_field[";
                    // line 191
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 191);
                    echo "]\" value=\"";
                    echo (((($__internal_compile_16 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_16) || $__internal_compile_16 instanceof ArrayAccess ? ($__internal_compile_16[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 191)] ?? null) : null)) ? ((($__internal_compile_17 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_17) || $__internal_compile_17 instanceof ArrayAccess ? ($__internal_compile_17[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 191)] ?? null) : null)) : (twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 191)));
                    echo "\" placeholder=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 191);
                    echo "\" id=\"input-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 191);
                    echo "\" class=\"form-control time\"/>
                            <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                          </div>
                          <div id=\"error-custom-field-";
                    // line 194
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 194);
                    echo "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 198
                echo "
                    ";
                // line 199
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 199) == "datetime")) {
                    // line 200
                    echo "                      <div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 200);
                    echo "\">
                        <label for=\"input-custom-field-";
                    // line 201
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 201);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 201);
                    echo "</label>
                        <div class=\"col-sm-10\">
                          <div class=\"input-group\">
                            <input type=\"text\" name=\"custom_field[";
                    // line 204
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 204);
                    echo "]\" value=\"";
                    echo (((($__internal_compile_18 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_18) || $__internal_compile_18 instanceof ArrayAccess ? ($__internal_compile_18[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 204)] ?? null) : null)) ? ((($__internal_compile_19 = ($context["account_custom_field"] ?? null)) && is_array($__internal_compile_19) || $__internal_compile_19 instanceof ArrayAccess ? ($__internal_compile_19[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 204)] ?? null) : null)) : (twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 204)));
                    echo "\" placeholder=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 204);
                    echo "\" id=\"input-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 204);
                    echo "\" class=\"form-control datetime\"/>
                            <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                          </div>
                          <div id=\"error-custom-field-";
                    // line 207
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 207);
                    echo "\" class=\"invalid-feedback\"></div>
                        </div>
                      </div>
                    ";
                }
                // line 211
                echo "
                  ";
            }
            // line 213
            echo "                ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 214
        echo "              </fieldset>
              <fieldset>
                <legend>";
        // line 216
        echo ($context["text_password"] ?? null);
        echo "</legend>
                <div class=\"row mb-3 required\">
                  <label for=\"input-password\" class=\"col-sm-2 col-form-label\">";
        // line 218
        echo ($context["entry_password"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"password\" name=\"password\" value=\"";
        // line 220
        echo ($context["password"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_password"] ?? null);
        echo "\" id=\"input-password\" class=\"form-control\" autocomplete=\"new-password\"/>
                    <div id=\"error-password\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
                <div class=\"row mb-3 required\">
                  <label for=\"input-confirm\" class=\"col-sm-2 col-form-label\">";
        // line 225
        echo ($context["entry_confirm"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"password\" name=\"confirm\" value=\"";
        // line 227
        echo ($context["confirm"] ?? null);
        echo "\" placeholder=\"";
        echo ($context["entry_confirm"] ?? null);
        echo "\" id=\"input-confirm\" class=\"form-control\"/>
                    <div id=\"error-confirm\" class=\"invalid-feedback\"></div>
                  </div>
                </div>
              </fieldset>
              <fieldset>
                <legend>";
        // line 233
        echo ($context["text_other"] ?? null);
        echo "</legend>
                <div class=\"row mb-3\">
                  <label class=\"col-sm-2 col-form-label\">";
        // line 235
        echo ($context["entry_newsletter"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <div class=\"form-check form-switch form-switch-lg\">
                      <input type=\"hidden\" name=\"newsletter\" value=\"0\"/> <input type=\"checkbox\" name=\"newsletter\" value=\"1\" id=\"input-newsletter\" class=\"form-check-input\"";
        // line 238
        if (($context["newsletter"] ?? null)) {
            echo " checked";
        }
        echo "/>
                    </div>
                  </div>
                </div>
                <div class=\"row mb-3\">
                  <label class=\"col-sm-2 col-form-label\">";
        // line 243
        echo ($context["entry_status"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <div class=\"form-check form-switch form-switch-lg\">
                      <input type=\"hidden\" name=\"status\" value=\"0\"/> <input type=\"checkbox\" name=\"status\" value=\"1\" id=\"input-status\" class=\"form-check-input\"";
        // line 246
        if (($context["status"] ?? null)) {
            echo " checked";
        }
        echo "/>
                    </div>
                  </div>
                </div>
                <div class=\"row mb-3\">
                  <label class=\"col-sm-2 col-form-label\">";
        // line 251
        echo ($context["entry_safe"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <div class=\"form-check form-switch form-switch-lg\">
                      <input type=\"hidden\" name=\"safe\" value=\"0\"/> <input type=\"checkbox\" name=\"safe\" value=\"1\" id=\"input-safe\" class=\"form-check-input\"";
        // line 254
        if (($context["safe"] ?? null)) {
            echo " checked";
        }
        echo "/>
                    </div>
                    <div class=\"form-text\">";
        // line 256
        echo ($context["help_safe"] ?? null);
        echo "</div>
                  </div>
                </div>
              </fieldset>
            </div>
            <div id=\"tab-address\" class=\"tab-pane\">
              ";
        // line 262
        $context["address_row"] = 0;
        // line 263
        echo "              ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["addresses"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["address"]) {
            // line 264
            echo "                <fieldset id=\"address-row-";
            echo ($context["address_row"] ?? null);
            echo "\">
                  <legend>";
            // line 265
            echo ($context["text_address"] ?? null);
            echo " ";
            echo (($context["address_row"] ?? null) + 1);
            echo " <button type=\"button\" onclick=\"\$('#address-row-";
            echo ($context["address_row"] ?? null);
            echo "').remove();\" data-bs-toggle=\"tooltip\" title=\"";
            echo ($context["button_remove"] ?? null);
            echo "\" class=\"btn btn-danger btn-sm float-end\"><i class=\"fa-solid fa-minus-circle\"></i></button></legend>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 267
            echo ($context["address_row"] ?? null);
            echo "-firstname\" class=\"col-sm-2 col-form-label\">";
            echo ($context["entry_firstname"] ?? null);
            echo "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 269
            echo ($context["address_row"] ?? null);
            echo "][firstname]\" value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["address"], "firstname", [], "any", false, false, false, 269);
            echo "\" placeholder=\"";
            echo ($context["entry_firstname"] ?? null);
            echo "\" id=\"input-address-";
            echo ($context["address_row"] ?? null);
            echo "-firstname\" class=\"form-control\"/>
                      <div id=\"error-address-";
            // line 270
            echo ($context["address_row"] ?? null);
            echo "-firstname\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 274
            echo ($context["address_row"] ?? null);
            echo "-lastname\" class=\"col-sm-2 col-form-label\">";
            echo ($context["entry_lastname"] ?? null);
            echo "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 276
            echo ($context["address_row"] ?? null);
            echo "][lastname]\" value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["address"], "lastname", [], "any", false, false, false, 276);
            echo "\" placeholder=\"";
            echo ($context["entry_lastname"] ?? null);
            echo "\" id=\"input-address-";
            echo ($context["address_row"] ?? null);
            echo "-lastname\" class=\"form-control\"/>
                      <div id=\"error-address-";
            // line 277
            echo ($context["address_row"] ?? null);
            echo "-lastname\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3\">
                    <label for=\"input-address-";
            // line 281
            echo ($context["address_row"] ?? null);
            echo "-company\" class=\"col-sm-2 col-form-label\">";
            echo ($context["entry_company"] ?? null);
            echo "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 283
            echo ($context["address_row"] ?? null);
            echo "][company]\" value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["address"], "company", [], "any", false, false, false, 283);
            echo "\" placeholder=\"";
            echo ($context["entry_company"] ?? null);
            echo "\" id=\"input-address-";
            echo ($context["address_row"] ?? null);
            echo "-company\" class=\"form-control\"/>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 287
            echo ($context["address_row"] ?? null);
            echo "-address-1\" class=\"col-sm-2 col-form-label\">";
            echo ($context["entry_address_1"] ?? null);
            echo "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 289
            echo ($context["address_row"] ?? null);
            echo "][address_1]\" value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["address"], "address_1", [], "any", false, false, false, 289);
            echo "\" placeholder=\"";
            echo ($context["entry_address_1"] ?? null);
            echo "\" id=\"input-address-";
            echo ($context["address_row"] ?? null);
            echo "-address-1\" class=\"form-control\"/>
                      <div id=\"error-address-";
            // line 290
            echo ($context["address_row"] ?? null);
            echo "-address-1\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3\">
                    <label for=\"input-address-";
            // line 294
            echo ($context["address_row"] ?? null);
            echo "-address-2\" class=\"col-sm-2 col-form-label\">";
            echo ($context["entry_address_2"] ?? null);
            echo "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 296
            echo ($context["address_row"] ?? null);
            echo "][address_2]\" value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["address"], "address_2", [], "any", false, false, false, 296);
            echo "\" placeholder=\"";
            echo ($context["entry_address_2"] ?? null);
            echo "\" id=\"input-address-";
            echo ($context["address_row"] ?? null);
            echo "-address-2\" class=\"form-control\"/>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 300
            echo ($context["address_row"] ?? null);
            echo "-city\" class=\"col-sm-2 col-form-label\">";
            echo ($context["entry_city"] ?? null);
            echo "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 302
            echo ($context["address_row"] ?? null);
            echo "][city]\" value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["address"], "city", [], "any", false, false, false, 302);
            echo "\" placeholder=\"";
            echo ($context["entry_city"] ?? null);
            echo "\" id=\"input-address-";
            echo ($context["address_row"] ?? null);
            echo "-city\" class=\"form-control\"/>
                      <div id=\"error-address-";
            // line 303
            echo ($context["address_row"] ?? null);
            echo "-city\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 307
            echo ($context["address_row"] ?? null);
            echo "-postcode\" class=\"col-sm-2 col-form-label\">";
            echo ($context["entry_postcode"] ?? null);
            echo "</label>
                    <div class=\"col-sm-10\">
                      <input type=\"text\" name=\"address[";
            // line 309
            echo ($context["address_row"] ?? null);
            echo "][postcode]\" value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["address"], "postcode", [], "any", false, false, false, 309);
            echo "\" placeholder=\"";
            echo ($context["entry_postcode"] ?? null);
            echo "\" id=\"input-address-";
            echo ($context["address_row"] ?? null);
            echo "-postcode\" class=\"form-control\"/>
                      <div id=\"error-address-";
            // line 310
            echo ($context["address_row"] ?? null);
            echo "-postcode\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 314
            echo ($context["address_row"] ?? null);
            echo "-country\" class=\"col-sm-2 col-form-label\">";
            echo ($context["entry_country"] ?? null);
            echo "</label>
                    <div class=\"col-sm-10\">
                      <select name=\"address[";
            // line 316
            echo ($context["address_row"] ?? null);
            echo "][country_id]\" id=\"input-address-";
            echo ($context["address_row"] ?? null);
            echo "-country\" class=\"form-select\" data-address-row=\"";
            echo ($context["address_row"] ?? null);
            echo "\" data-zone-id=\"";
            echo twig_get_attribute($this->env, $this->source, $context["address"], "zone_id", [], "any", false, false, false, 316);
            echo "\" disabled>
                        <option value=\"0\">";
            // line 317
            echo ($context["text_select"] ?? null);
            echo "</option>
                        ";
            // line 318
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["countries"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
                // line 319
                echo "                          <option value=\"";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 319);
                echo "\"";
                if ((twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 319) == twig_get_attribute($this->env, $this->source, $context["address"], "country_id", [], "any", false, false, false, 319))) {
                    echo " selected";
                }
                echo ">";
                echo twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 319);
                echo "</option>
                        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['country'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 321
            echo "                      </select>
                      <div id=\"error-address-";
            // line 322
            echo ($context["address_row"] ?? null);
            echo "-country\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>
                  <div class=\"row mb-3 required\">
                    <label for=\"input-address-";
            // line 326
            echo ($context["address_row"] ?? null);
            echo "-zone\" class=\"col-sm-2 col-form-label\">";
            echo ($context["entry_zone"] ?? null);
            echo "</label>
                    <div class=\"col-sm-10\">
                      <select name=\"address[";
            // line 328
            echo ($context["address_row"] ?? null);
            echo "][zone_id]\" id=\"input-address-";
            echo ($context["address_row"] ?? null);
            echo "-zone\" class=\"form-select\" disabled></select>
                      <div id=\"error-address-";
            // line 329
            echo ($context["address_row"] ?? null);
            echo "-zone\" class=\"invalid-feedback\"></div>
                    </div>
                  </div>

                  ";
            // line 333
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["custom_fields"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["custom_field"]) {
                // line 334
                echo "                    ";
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "location", [], "any", false, false, false, 334) == "address")) {
                    // line 335
                    echo "
                      ";
                    // line 336
                    if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 336) == "select")) {
                        // line 337
                        echo "                        <div class=\"row mb-3 custom-field custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 337);
                        echo "\">
                          <label for=\"input-address-";
                        // line 338
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 338);
                        echo "\" class=\"col-sm-2 col-form-label\">";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 338);
                        echo "</label>
                          <div class=\"col-sm-10\">
                            <select name=\"address[";
                        // line 340
                        echo ($context["address_row"] ?? null);
                        echo "][custom_field][";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 340);
                        echo "]\" id=\"input-address-";
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 340);
                        echo "\" class=\"form-select\">
                              <option value=\"\">";
                        // line 341
                        echo ($context["text_select"] ?? null);
                        echo "</option>
                              ";
                        // line 342
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 342));
                        foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                            // line 343
                            echo "                                <option value=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 343);
                            echo "\"";
                            if (((($__internal_compile_20 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 343)) && is_array($__internal_compile_20) || $__internal_compile_20 instanceof ArrayAccess ? ($__internal_compile_20[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 343)] ?? null) : null) && (twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 343) == (($__internal_compile_21 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 343)) && is_array($__internal_compile_21) || $__internal_compile_21 instanceof ArrayAccess ? ($__internal_compile_21[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 343)] ?? null) : null)))) {
                                echo " selected";
                            }
                            echo ">";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 343);
                            echo "</option>
                              ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field_value'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 345
                        echo "                            </select>
                            <div id=\"error-address-";
                        // line 346
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 346);
                        echo "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 350
                    echo "
                      ";
                    // line 351
                    if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 351) == "radio")) {
                        // line 352
                        echo "                        <div class=\"row mb-3 custom-field custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 352);
                        echo "\">
                          <label class=\"col-sm-2 col-form-label\">";
                        // line 353
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 353);
                        echo "</label>
                          <div class=\"col-sm-10\">
                            <div id=\"input-address-";
                        // line 355
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 355);
                        echo "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">
                              ";
                        // line 356
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 356));
                        foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                            // line 357
                            echo "                                <div class=\"form-check\">
                                  <input type=\"radio\" name=\"address[";
                            // line 358
                            echo ($context["address_row"] ?? null);
                            echo "][custom_field][";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 358);
                            echo "]\" value=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 358);
                            echo "\" id=\"input-custom-value-";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 358);
                            echo "\" class=\"form-check-input\"";
                            if (((($__internal_compile_22 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 358)) && is_array($__internal_compile_22) || $__internal_compile_22 instanceof ArrayAccess ? ($__internal_compile_22[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 358)] ?? null) : null) && (twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 358) == (($__internal_compile_23 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 358)) && is_array($__internal_compile_23) || $__internal_compile_23 instanceof ArrayAccess ? ($__internal_compile_23[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 358)] ?? null) : null)))) {
                                echo " checked";
                            }
                            echo "/> <label for=\"input-custom-value-";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 358);
                            echo "\" class=\"form-check-label\">";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 358);
                            echo "</label>
                                </div>
                              ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field_value'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 361
                        echo "                            </div>
                            <div id=\"error-address-";
                        // line 362
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 362);
                        echo "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 366
                    echo "
                      ";
                    // line 367
                    if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 367) == "checkbox")) {
                        // line 368
                        echo "                        <div class=\"row mb-3 custom-field custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 368);
                        echo "\">
                          <label class=\"col-sm-2 col-form-label\">";
                        // line 369
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 369);
                        echo "</label>
                          <div class=\"col-sm-10\">
                            <div id=\"input-address-";
                        // line 371
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 371);
                        echo "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">
                              ";
                        // line 372
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 372));
                        foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                            // line 373
                            echo "                                <div class=\"form-check\">
                                  <input type=\"checkbox\" name=\"address[";
                            // line 374
                            echo ($context["address_row"] ?? null);
                            echo "][custom_field][";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 374);
                            echo "][]\" value=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 374);
                            echo "\" id=\"input-custom-value-";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 374);
                            echo "\" class=\"form-check-input\"";
                            if (((($__internal_compile_24 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 374)) && is_array($__internal_compile_24) || $__internal_compile_24 instanceof ArrayAccess ? ($__internal_compile_24[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 374)] ?? null) : null) && twig_in_filter(twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 374), (($__internal_compile_25 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 374)) && is_array($__internal_compile_25) || $__internal_compile_25 instanceof ArrayAccess ? ($__internal_compile_25[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 374)] ?? null) : null)))) {
                                echo " checked";
                            }
                            echo "/> <label for=\"input-custom-value-";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 374);
                            echo "\" class=\"form-check-label\">";
                            echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 374);
                            echo "</label>
                                </div>
                              ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field_value'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 377
                        echo "                            </div>
                            <div id=\"error-address-";
                        // line 378
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 378);
                        echo "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 382
                    echo "
                      ";
                    // line 383
                    if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 383) == "text")) {
                        // line 384
                        echo "                        <div class=\"row mb-3 custom-field custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 384);
                        echo "\">
                          <label for=\"input-address-";
                        // line 385
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 385);
                        echo "\" class=\"col-sm-2 col-form-label\">";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 385);
                        echo "</label>
                          <div class=\"col-sm-10\">
                            <input type=\"text\" name=\"address[";
                        // line 387
                        echo ($context["address_row"] ?? null);
                        echo "][custom_field][";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 387);
                        echo "]\" value=\"";
                        echo (((($__internal_compile_26 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 387)) && is_array($__internal_compile_26) || $__internal_compile_26 instanceof ArrayAccess ? ($__internal_compile_26[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 387)] ?? null) : null)) ? ((($__internal_compile_27 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 387)) && is_array($__internal_compile_27) || $__internal_compile_27 instanceof ArrayAccess ? ($__internal_compile_27[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 387)] ?? null) : null)) : (twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 387)));
                        echo "\" placeholder=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 387);
                        echo "\" id=\"input-address-";
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 387);
                        echo "\" class=\"form-control\"/>
                            <div id=\"error-address-";
                        // line 388
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 388);
                        echo "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 392
                    echo "
                      ";
                    // line 393
                    if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 393) == "textarea")) {
                        // line 394
                        echo "                        <div class=\"row mb-3 custom-field custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 394);
                        echo "\">
                          <label for=\"input-address-";
                        // line 395
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 395);
                        echo "\" class=\"col-sm-2 col-form-label\">";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 395);
                        echo "</label>
                          <div class=\"col-sm-10\">
                            <textarea name=\"address[";
                        // line 397
                        echo ($context["address_row"] ?? null);
                        echo "][custom_field][";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 397);
                        echo "]\" rows=\"5\" placeholder=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 397);
                        echo "\" id=\"input-address-";
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 397);
                        echo "\" class=\"form-control\">";
                        echo (((($__internal_compile_28 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 397)) && is_array($__internal_compile_28) || $__internal_compile_28 instanceof ArrayAccess ? ($__internal_compile_28[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 397)] ?? null) : null)) ? ((($__internal_compile_29 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 397)) && is_array($__internal_compile_29) || $__internal_compile_29 instanceof ArrayAccess ? ($__internal_compile_29[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 397)] ?? null) : null)) : (twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 397)));
                        echo "</textarea>
                            <div id=\"error-address-";
                        // line 398
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 398);
                        echo "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 402
                    echo "
                      ";
                    // line 403
                    if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 403) == "file")) {
                        // line 404
                        echo "                        <div class=\"row mb-3 custom-field custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 404);
                        echo "\">
                          <label class=\"col-sm-2 col-form-label\">";
                        // line 405
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 405);
                        echo "</label>
                          <div class=\"col-sm-10\">
                            <div class=\"input-group\">
                              <button type=\"button\" data-oc-toggle=\"upload\" data-oc-url=\"";
                        // line 408
                        echo ($context["upload"] ?? null);
                        echo "\" data-oc-target=\"#input-address-";
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 408);
                        echo "\" data-oc-size-max=\"";
                        echo ($context["config_file_max_size"] ?? null);
                        echo "\" data-oc-size-error=\"";
                        echo ($context["error_upload_size"] ?? null);
                        echo "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-upload\"></i> ";
                        echo ($context["button_upload"] ?? null);
                        echo "</button>
                              <input type=\"text\" name=\"address[";
                        // line 409
                        echo ($context["address_row"] ?? null);
                        echo "][custom_field][";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 409);
                        echo "]\" value=\"";
                        echo (((($__internal_compile_30 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 409)) && is_array($__internal_compile_30) || $__internal_compile_30 instanceof ArrayAccess ? ($__internal_compile_30[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 409)] ?? null) : null)) ? ((($__internal_compile_31 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 409)) && is_array($__internal_compile_31) || $__internal_compile_31 instanceof ArrayAccess ? ($__internal_compile_31[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 409)] ?? null) : null)) : (""));
                        echo "\" id=\"input-address-";
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 409);
                        echo "\" class=\"form-control\" readonly/>
                              <button type=\"button\" data-oc-toggle=\"download\" data-oc-target=\"#input-address-";
                        // line 410
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 410);
                        echo "\" class=\"btn btn-outline-secondary\"";
                        if ( !(($__internal_compile_32 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 410)) && is_array($__internal_compile_32) || $__internal_compile_32 instanceof ArrayAccess ? ($__internal_compile_32[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 410)] ?? null) : null)) {
                            echo " disabled";
                        }
                        echo "><i class=\"fa-solid fa-download\"></i> ";
                        echo ($context["button_download"] ?? null);
                        echo "</button>
                              <button type=\"button\" data-oc-toggle=\"clear\" data-oc-target=\"#input-address-";
                        // line 411
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 411);
                        echo "\" data-bs-toggle=\"tooltip\" title=\"";
                        echo ($context["button_clear"] ?? null);
                        echo "\" class=\"btn btn-outline-danger\"";
                        if ( !(($__internal_compile_33 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 411)) && is_array($__internal_compile_33) || $__internal_compile_33 instanceof ArrayAccess ? ($__internal_compile_33[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 411)] ?? null) : null)) {
                            echo " disabled";
                        }
                        echo "><i class=\"fa-solid fa-eraser\"></i></button>
                            </div>
                            <div id=\"error-address-";
                        // line 413
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 413);
                        echo "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 417
                    echo "
                      ";
                    // line 418
                    if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 418) == "date")) {
                        // line 419
                        echo "                        <div class=\"row mb-3 custom-field custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 419);
                        echo "\">
                          <label for=\"input-address-";
                        // line 420
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 420);
                        echo "\" class=\"col-sm-2 col-form-label\">";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 420);
                        echo "</label>
                          <div class=\"col-sm-10\">
                            <div class=\"input-group\">
                              <input type=\"text\" name=\"address[";
                        // line 423
                        echo ($context["address_row"] ?? null);
                        echo "][custom_field][";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 423);
                        echo "]\" value=\"";
                        echo (((($__internal_compile_34 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 423)) && is_array($__internal_compile_34) || $__internal_compile_34 instanceof ArrayAccess ? ($__internal_compile_34[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 423)] ?? null) : null)) ? ((($__internal_compile_35 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 423)) && is_array($__internal_compile_35) || $__internal_compile_35 instanceof ArrayAccess ? ($__internal_compile_35[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 423)] ?? null) : null)) : (twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 423)));
                        echo "\" placeholder=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 423);
                        echo "\" id=\"input-address-";
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 423);
                        echo "\" class=\"form-control date\"/>
                              <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                            </div>
                            <div id=\"error-address-";
                        // line 426
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 426);
                        echo "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 430
                    echo "
                      ";
                    // line 431
                    if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 431) == "time")) {
                        // line 432
                        echo "                        <div class=\"row mb-3 custom-field custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 432);
                        echo "\">
                          <label for=\"input-address-";
                        // line 433
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 433);
                        echo "\" class=\"col-sm-2 col-form-label\">";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 433);
                        echo "</label>
                          <div class=\"col-sm-10\">
                            <div class=\"input-group\">
                              <input type=\"text\" name=\"address[";
                        // line 436
                        echo ($context["address_row"] ?? null);
                        echo "][custom_field][";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 436);
                        echo "]\" value=\"";
                        echo (((($__internal_compile_36 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 436)) && is_array($__internal_compile_36) || $__internal_compile_36 instanceof ArrayAccess ? ($__internal_compile_36[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 436)] ?? null) : null)) ? ((($__internal_compile_37 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 436)) && is_array($__internal_compile_37) || $__internal_compile_37 instanceof ArrayAccess ? ($__internal_compile_37[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 436)] ?? null) : null)) : (twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 436)));
                        echo "\" placeholder=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 436);
                        echo "\" id=\"input-address-";
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 436);
                        echo "\" class=\"form-control time\"/>
                              <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                            </div>
                            <div id=\"error-address-";
                        // line 439
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 439);
                        echo "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 443
                    echo "
                      ";
                    // line 444
                    if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 444) == "datetime")) {
                        // line 445
                        echo "                        <div class=\"row mb-3 custom-field custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 445);
                        echo "\">
                          <label for=\"input-address-";
                        // line 446
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 446);
                        echo "\" class=\"col-sm-2 col-form-label\">";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 446);
                        echo "</label>
                          <div class=\"col-sm-10\">
                            <div class=\"input-group\">
                              <input type=\"text\" name=\"address[";
                        // line 449
                        echo ($context["address_row"] ?? null);
                        echo "][custom_field][";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 449);
                        echo "]\" value=\"";
                        echo (((($__internal_compile_38 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 449)) && is_array($__internal_compile_38) || $__internal_compile_38 instanceof ArrayAccess ? ($__internal_compile_38[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 449)] ?? null) : null)) ? ((($__internal_compile_39 = twig_get_attribute($this->env, $this->source, $context["address"], "custom_field", [], "any", false, false, false, 449)) && is_array($__internal_compile_39) || $__internal_compile_39 instanceof ArrayAccess ? ($__internal_compile_39[twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 449)] ?? null) : null)) : (twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 449)));
                        echo "\" placeholder=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 449);
                        echo "\" id=\"input-address-";
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 449);
                        echo "\" class=\"form-control datetime\"/>
                              <div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>
                            </div>
                            <div id=\"error-address-";
                        // line 452
                        echo ($context["address_row"] ?? null);
                        echo "-custom-field-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 452);
                        echo "\" class=\"invalid-feedback\"></div>
                          </div>
                        </div>
                      ";
                    }
                    // line 456
                    echo "
                    ";
                }
                // line 458
                echo "
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 460
            echo "
                  <div class=\"row mb-3\">
                    <label for=\"input-address-";
            // line 462
            echo ($context["address_row"] ?? null);
            echo "-default\" class=\"col-sm-2 col-form-label\">";
            echo ($context["entry_default"] ?? null);
            echo "</label>
                    <div class=\"col-sm-10\">
                      <div class=\"form-check\">
                        <input type=\"radio\" name=\"address[";
            // line 465
            echo ($context["address_row"] ?? null);
            echo "][default]\" value=\"1\" id=\"input-address-";
            echo ($context["address_row"] ?? null);
            echo "-default\" class=\"form-check-input\"";
            if (twig_get_attribute($this->env, $this->source, $context["address"], "default", [], "any", false, false, false, 465)) {
                echo " checked";
            }
            echo "/>
                      </div>
                    </div>
                  </div>
                  <input type=\"hidden\" name=\"address[";
            // line 469
            echo ($context["address_row"] ?? null);
            echo "][address_id]\" value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["address"], "address_id", [], "any", false, false, false, 469);
            echo "\"/>
                </fieldset>
                ";
            // line 471
            $context["address_row"] = (($context["address_row"] ?? null) + 1);
            // line 472
            echo "              ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['address'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 473
        echo "              <div class=\"text-end\">
                <button type=\"button\" id=\"button-address\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus-circle\"></i> ";
        // line 474
        echo ($context["button_address_add"] ?? null);
        echo "</button>
              </div>
              <input type=\"hidden\" name=\"customer_id\" value=\"";
        // line 476
        echo ($context["customer_id"] ?? null);
        echo "\" id=\"input-customer-id\"/>
            </div>

            <div id=\"tab-payment\" class=\"tab-pane\">
              <fieldset>
                <legend>";
        // line 481
        echo ($context["text_payment_method"] ?? null);
        echo "</legend>
                <div id=\"payment-method\">";
        // line 482
        echo ($context["payment_method"] ?? null);
        echo "</div>
              </fieldset>
            </div>
            <div id=\"tab-history\" class=\"tab-pane\">
              <fieldset>
                <legend>";
        // line 487
        echo ($context["text_history"] ?? null);
        echo "</legend>
                <div id=\"history\">";
        // line 488
        echo ($context["history"] ?? null);
        echo "</div>
              </fieldset>
              <fieldset>
                <legend>";
        // line 491
        echo ($context["text_history_add"] ?? null);
        echo "</legend>
                <div class=\"row mb-3\">
                  <label for=\"input-history\" class=\"col-sm-2 col-form-label\">";
        // line 493
        echo ($context["entry_comment"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <textarea name=\"comment\" rows=\"8\" placeholder=\"";
        // line 495
        echo ($context["entry_comment"] ?? null);
        echo "\" id=\"input-history\" class=\"form-control\"></textarea>
                  </div>
                </div>
                <div class=\"text-end\">
                  <button type=\"button\" id=\"button-history\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus-circle\"></i> ";
        // line 499
        echo ($context["button_history_add"] ?? null);
        echo "</button>
                </div>
              </fieldset>
            </div>

            <div id=\"tab-transaction\" class=\"tab-pane\">
              <fieldset>
                <legend>";
        // line 506
        echo ($context["text_transaction"] ?? null);
        echo "</legend>
                <div id=\"transaction\">";
        // line 507
        echo ($context["transaction"] ?? null);
        echo "</div>
              </fieldset>
              <fieldset>
                <legend>";
        // line 510
        echo ($context["text_transaction_add"] ?? null);
        echo "</legend>
                <div class=\"row mb-3\">
                  <label for=\"input-transaction\" class=\"col-sm-2 col-form-label\">";
        // line 512
        echo ($context["entry_description"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"description\" value=\"\" placeholder=\"";
        // line 514
        echo ($context["entry_description"] ?? null);
        echo "\" id=\"input-transaction\" class=\"form-control\"/>
                  </div>
                </div>
                <div class=\"row mb-3\">
                  <label for=\"input-amount\" class=\"col-sm-2 col-form-label\">";
        // line 518
        echo ($context["entry_amount"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"amount\" value=\"\" placeholder=\"";
        // line 520
        echo ($context["entry_amount"] ?? null);
        echo "\" id=\"input-amount\" class=\"form-control\"/>
                  </div>
                </div>
                <div class=\"text-end\">
                  <button type=\"button\" id=\"button-transaction\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus-circle\"></i> ";
        // line 524
        echo ($context["button_transaction_add"] ?? null);
        echo "</button>
                </div>
              </fieldset>
            </div>
            <div id=\"tab-reward\" class=\"tab-pane\">
              <fieldset>
                <legend>";
        // line 530
        echo ($context["text_reward"] ?? null);
        echo "</legend>
                <div id=\"reward\">";
        // line 531
        echo ($context["reward"] ?? null);
        echo "</div>
              </fieldset>
              <fieldset>
                <legend>";
        // line 534
        echo ($context["text_reward_add"] ?? null);
        echo "</legend>
                <div class=\"row mb-3\">
                  <label for=\"input-reward\" class=\"col-sm-2 col-form-label\">";
        // line 536
        echo ($context["entry_description"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"description\" value=\"\" placeholder=\"";
        // line 538
        echo ($context["entry_description"] ?? null);
        echo "\" id=\"input-reward\" class=\"form-control\"/>
                  </div>
                </div>
                <div class=\"row mb-3\">
                  <label for=\"input-points\" class=\"col-sm-2 col-form-label\">";
        // line 542
        echo ($context["entry_points"] ?? null);
        echo "</label>
                  <div class=\"col-sm-10\">
                    <input type=\"text\" name=\"points\" value=\"\" placeholder=\"";
        // line 544
        echo ($context["entry_points"] ?? null);
        echo "\" id=\"input-points\" class=\"form-control\"/>
                    <div class=\"form-text\">";
        // line 545
        echo ($context["help_points"] ?? null);
        echo "</div>
                  </div>
                </div>
                <div class=\"text-end\">
                  <button type=\"button\" id=\"button-reward\" class=\"btn btn-primary\"><i class=\"fa-solid fa-plus-circle\"></i> ";
        // line 549
        echo ($context["button_reward_add"] ?? null);
        echo "</button>
                </div>
              </fieldset>
            </div>
            <div id=\"tab-ip\" class=\"tab-pane\">
              <fieldset>
                <legend>";
        // line 555
        echo ($context["text_ip"] ?? null);
        echo "</legend>
                <div id=\"ip\">";
        // line 556
        echo ($context["ip"] ?? null);
        echo "</div>
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
        echo ($context["user_token"] ?? null);
        echo "&customer_group_id=' + this.value,
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
        echo ($context["address_row"] ?? null);
        echo ";

\$('#button-address').on('click', function (e) {
    e.preventDefault();

    html = '<fieldset id=\"address-row-' + address_row + '\">';
    html += '  <legend>";
        // line 598
        echo ($context["text_address"] ?? null);
        echo " ' + (address_row + 1) + ' <button type=\"button\" onclick=\"\$(\\'#address-row-' + address_row + '\\').remove();\" data-bs-toggle=\"tooltip\" title=\"";
        echo twig_escape_filter($this->env, ($context["button_remove"] ?? null), "js");
        echo "\" class=\"btn btn-danger btn-sm float-end\"><i class=\"fa-solid fa-minus-circle\"></i></button></legend>';
    html += '  <input type=\"hidden\" name=\"address[' + address_row + '][address_id]\" value=\"\" />';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-firstname\" class=\"col-sm-2 col-form-label\">";
        // line 602
        echo twig_escape_filter($this->env, ($context["entry_firstname"] ?? null), "js");
        echo "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][firstname]\" value=\"\" placeholder=\"";
        // line 604
        echo twig_escape_filter($this->env, ($context["entry_firstname"] ?? null), "js");
        echo "\" id=\"input-address-' + address_row + '-firstname\" class=\"form-control\"/>';
    html += '      <div id=\"error-address-' + address_row + '-firstname\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-lastname\" class=\"col-sm-2 col-form-label\">";
        // line 610
        echo twig_escape_filter($this->env, ($context["entry_lastname"] ?? null), "js");
        echo "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][lastname]\" value=\"\" placeholder=\"";
        // line 612
        echo twig_escape_filter($this->env, ($context["entry_lastname"] ?? null), "js");
        echo "\" id=\"input-address-' + address_row + '-lastname\" class=\"form-control\"/>';
    html += '      <div id=\"error-address-' + address_row + '-lastname\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3\">';
    html += '    <label for=\"input-address-' + address_row + '-company\" class=\"col-sm-2 col-form-label\">";
        // line 618
        echo twig_escape_filter($this->env, ($context["entry_company"] ?? null), "js");
        echo "</label>';
    html += '    <div class=\"col-sm-10\"><input type=\"text\" name=\"address[' + address_row + '][company]\" value=\"\" placeholder=\"";
        // line 619
        echo twig_escape_filter($this->env, ($context["entry_company"] ?? null), "js");
        echo "\" id=\"input-address-' + address_row + '-company\" class=\"form-control\"/></div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-address-1\" class=\"col-sm-2 col-form-label\">";
        // line 623
        echo twig_escape_filter($this->env, ($context["entry_address_1"] ?? null), "js");
        echo "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][address_1]\" value=\"\" placeholder=\"";
        // line 625
        echo twig_escape_filter($this->env, ($context["entry_address_1"] ?? null), "js");
        echo "\" id=\"input-address-' + address_row + '-address-1\" class=\"form-control\"/>';
    html += '      <div id=\"error-address-' + address_row + '-address-1\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3\">';
    html += '    <label for=\"input-address-' + address_row + '-address-2\" class=\"col-sm-2 col-form-label\">";
        // line 631
        echo twig_escape_filter($this->env, ($context["entry_address_2"] ?? null), "js");
        echo "</label>';
    html += '    <div class=\"col-sm-10\"><input type=\"text\" name=\"address[' + address_row + '][address_2]\" value=\"\" placeholder=\"";
        // line 632
        echo twig_escape_filter($this->env, ($context["entry_address_2"] ?? null), "js");
        echo "\" id=\"input-address-' + address_row + '-address-2\" class=\"form-control\"/></div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-city\" class=\"col-sm-2 col-form-label\">";
        // line 636
        echo twig_escape_filter($this->env, ($context["entry_city"] ?? null), "js");
        echo "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][city]\" value=\"\" placeholder=\"";
        // line 638
        echo twig_escape_filter($this->env, ($context["entry_city"] ?? null), "js");
        echo "\" id=\"input-address-' + address_row + '-city\" class=\"form-control\"/>';
    html += '      <div id=\"error-address-' + address_row + '-city\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-postcode\" class=\"col-sm-2 col-form-label\">";
        // line 644
        echo twig_escape_filter($this->env, ($context["entry_postcode"] ?? null), "js");
        echo "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][postcode]\" value=\"\" placeholder=\"";
        // line 646
        echo twig_escape_filter($this->env, ($context["entry_postcode"] ?? null), "js");
        echo "\" id=\"input-address-' + address_row + '-postcode\" class=\"form-control\"/>';
    html += '      <div id=\"error-address-' + address_row + '-postcode\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-country\" class=\"col-sm-2 col-form-label\">";
        // line 652
        echo twig_escape_filter($this->env, ($context["entry_country"] ?? null), "js");
        echo "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '       <select name=\"address[' + address_row + '][country_id]\" id=\"input-address-' + address_row + '-country\" data-address-row=\"' + address_row + '\" data-zone-id=\"0\" class=\"form-select\" disabled>';
    html += '         <option value=\"0\">";
        // line 655
        echo twig_escape_filter($this->env, ($context["text_select"] ?? null), "js");
        echo "</option>';
  ";
        // line 656
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["countries"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["country"]) {
            // line 657
            echo "    html += '         <option value=\"";
            echo twig_get_attribute($this->env, $this->source, $context["country"], "country_id", [], "any", false, false, false, 657);
            echo "\">";
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["country"], "name", [], "any", false, false, false, 657), "js");
            echo "</option>';
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['country'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 659
        echo "    html += '      </select>';
    html += '      <div id=\"error-address-' + address_row + '-country\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    html += '  <div class=\"row mb-3 required\">';
    html += '    <label for=\"input-address-' + address_row + '-zone\" class=\"col-sm-2 col-form-label\">";
        // line 665
        echo twig_escape_filter($this->env, ($context["entry_zone"] ?? null), "js");
        echo "</label>';
    html += '    <div class=\"col-sm-10\">';
    html += '      <select name=\"address[' + address_row + '][zone_id]\" id=\"input-address-' + address_row + '-zone\" class=\"form-select\" disabled><option value=\"\">";
        // line 667
        echo twig_escape_filter($this->env, ($context["text_none"] ?? null), "js");
        echo "</option></select>';
    html += '      <div id=\"error-address-' + address_row + '-zone\" class=\"invalid-feedback\"></div>';
    html += '    </div>';
    html += '  </div>';

    // Custom Fields
  ";
        // line 673
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["custom_fields"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["custom_field"]) {
            // line 674
            echo "  ";
            if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "location", [], "any", false, false, false, 674) == "address")) {
                // line 675
                echo "  ";
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 675) == "select")) {
                    // line 676
                    echo "
    html += '<div class=\"row mb-3 custom-field custom-field-";
                    // line 677
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 677);
                    echo "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 678
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 678);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 678), "js");
                    echo "</label>';
    html += '\t <div class=\"col-sm-10\">';
    html += '    <select name=\"address[' + address_row + '][custom_field][";
                    // line 680
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 680);
                    echo "]\" id=\"input-address-' + address_row + '-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 680);
                    echo "\" class=\"form-select\">';
    html += '      <option value=\"\">";
                    // line 681
                    echo twig_escape_filter($this->env, ($context["text_select"] ?? null), "js");
                    echo "</option>';

  ";
                    // line 683
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 683));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 684
                        echo "    html += '\t\t   <option value=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 684);
                        echo "\">";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 684), "js");
                        echo "</option>';
  ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field_value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 686
                    echo "
    html += '\t   </select>';
    html += '    <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 688
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 688);
                    echo "\" class=\"invalid-feedback\"></div>';
    html += '\t </div>';
    html += '</div>';
  ";
                }
                // line 692
                echo "
  ";
                // line 693
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 693) == "radio")) {
                    // line 694
                    echo "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 694);
                    echo "\">';
    html += '  <label class=\"col-sm-2 col-form-label\">";
                    // line 695
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 695), "js");
                    echo "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div id=\"input-address-' + address_row + '-custom-field-";
                    // line 697
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 697);
                    echo "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">';

  ";
                    // line 699
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 699));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 700
                        echo "    html += '  \t\t     <div class=\"form-check\">';
    html += '  \t\t       <input type=\"radio\" name=\"address[' + address_row + '][custom_field][";
                        // line 701
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 701);
                        echo "]\" value=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 701);
                        echo "\" id=\"input-custom-value-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 701);
                        echo "\" class=\"form-check-input\"/>';
    html += '  \t\t       <label for=\"input-custom-value-";
                        // line 702
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 702);
                        echo "\" class=\"form-check-label\">";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 702), "js");
                        echo "</label>';
    html += '\t\t       </div>';
  ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field_value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 705
                    echo "
    html += '\t\t </div>';
    html += '    <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 707
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 707);
                    echo "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 711
                echo "
  ";
                // line 712
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 712) == "checkbox")) {
                    // line 713
                    echo "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 713);
                    echo "\">';
    html += '  <label class=\"col-sm-2 col-form-label\">";
                    // line 714
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 714), "js");
                    echo "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div id=\"input-address-' + address_row + '-custom-field-";
                    // line 716
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 716);
                    echo "\" class=\"form-control\" style=\"height: 150px; overflow: auto;\">';

  ";
                    // line 718
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_value", [], "any", false, false, false, 718));
                    foreach ($context['_seq'] as $context["_key"] => $context["custom_field_value"]) {
                        // line 719
                        echo "    html += '      <div class=\"form-check\">';
    html += '        <input type=\"checkbox\" name=\"address[";
                        // line 720
                        echo ($context["address_row"] ?? null);
                        echo "][custom_field][";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 720);
                        echo "][]\" value=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 720);
                        echo "\" id=\"input-custom-value-";
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 720);
                        echo "\" class=\"form-check-input\"/>';
    html += '        <label for=\"input-custom-value-";
                        // line 721
                        echo twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "custom_field_value_id", [], "any", false, false, false, 721);
                        echo "\" class=\"form-check-label\">";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field_value"], "name", [], "any", false, false, false, 721), "js");
                        echo "</label>';
    html += '\t\t   </div>';
  ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field_value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 724
                    echo "
    html += '\t\t </div>';
    html += '    <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 726
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 726);
                    echo "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 730
                echo "
  ";
                // line 731
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 731) == "text")) {
                    // line 732
                    echo "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 732);
                    echo "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 733
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 733);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 733), "js");
                    echo "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <input type=\"text\" name=\"address[' + address_row + '][custom_field][";
                    // line 735
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 735);
                    echo "]\" value=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 735), "js");
                    echo "\" placeholder=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 735), "js");
                    echo "\" id=\"input-address-' + address_row + '-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 735);
                    echo "\" class=\"form-control\"/>';
    html += '  </div>';
    html += '  <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 737
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 737);
                    echo "\" class=\"invalid-feedback\"></div>';
    html += '</div>';
  ";
                }
                // line 740
                echo "
  ";
                // line 741
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 741) == "textarea")) {
                    // line 742
                    echo "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 742);
                    echo "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 743
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 743);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 743), "js");
                    echo "</label>';
    html += '\t <div class=\"col-sm-10\">';
    html += '\t   <textarea name=\"address[' + address_row + '][custom_field][";
                    // line 745
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 745);
                    echo "]\" rows=\"5\" placeholder=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 745), "js");
                    echo "\" id=\"input-address-' + address_row + '-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 745);
                    echo "\" class=\"form-control\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 745), "js");
                    echo "</textarea>';
    html += '\t   <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 746
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 746);
                    echo "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 750
                echo "
  ";
                // line 751
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 751) == "file")) {
                    // line 752
                    echo "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 752);
                    echo "\">';
    html += '  <label class=\"col-sm-2 col-form-label\">";
                    // line 753
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 753), "js");
                    echo "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div class=\"input-group\">';
    html += '      <button type=\"button\" data-oc-toggle=\"upload\" data-oc-url=\"";
                    // line 756
                    echo ($context["upload"] ?? null);
                    echo "\" data-oc-target=\"#input-address-' + address_row + '-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 756);
                    echo "\" data-oc-size-max=\"";
                    echo ($context["config_file_max_size"] ?? null);
                    echo "\" data-oc-size-error=\"";
                    echo twig_escape_filter($this->env, ($context["error_upload_size"] ?? null), "js");
                    echo "\" class=\"btn btn-primary\"><i class=\"fa-solid fa-upload\"></i> ";
                    echo twig_escape_filter($this->env, ($context["button_upload"] ?? null), "js");
                    echo "</button>';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][custom_field][";
                    // line 757
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 757);
                    echo "]\" value=\"\" id=\"input-address-' + address_row + '-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 757);
                    echo "\" class=\"form-control\" readonly/>';
    html += '      <button type=\"button\" data-oc-toggle=\"download\" data-oc-target=\"#input-address-' + address_row + '-custom-field-";
                    // line 758
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 758);
                    echo "\" class=\"btn btn-outline-secondary\" disabled><i class=\"fa-solid fa-download\"></i> ";
                    echo twig_escape_filter($this->env, ($context["button_download"] ?? null), "js");
                    echo "</button>';
    html += '      <button type=\"button\" data-oc-toggle=\"clear\" data-bs-toggle=\"tooltip\" title=\"";
                    // line 759
                    echo twig_escape_filter($this->env, ($context["button_clear"] ?? null), "js");
                    echo "\" data-oc-target=\"#input-address-' + address_row + '-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 759);
                    echo "\" class=\"btn btn-outline-danger\" disabled><i class=\"fa-solid fa-eraser\"></i></button>';
    html += '    </div>';
    html += '\t   <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 761
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 761);
                    echo "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 765
                echo "
  ";
                // line 766
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 766) == "date")) {
                    // line 767
                    echo "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 767);
                    echo "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 768
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 768);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 768), "js");
                    echo "</label>';
    html += '\t <div class=\"col-sm-10\">';
    html += '\t\t <div class=\"input-group\">';
    html += '\t\t   <input type=\"text\" name=\"address[' + address_row + '][custom_field][";
                    // line 771
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 771);
                    echo "]\" value=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 771), "js");
                    echo "\" placeholder=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 771), "js");
                    echo "\" id=\"input-address-' + address_row + '-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 771);
                    echo "\" class=\"form-control date\"/><div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>';
    html += '\t\t </div>';
    html += '\t   <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 773
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 773);
                    echo "\" class=\"invalid-feedback\"></div>';
    html += '\t </div>';
    html += '</div>';
  ";
                }
                // line 777
                echo "
  ";
                // line 778
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 778) == "time")) {
                    // line 779
                    echo "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 779);
                    echo "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 780
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 780);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 780), "js");
                    echo "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div class=\"input-group\">';
    html += '\t\t   <input type=\"text\" name=\"address[' + address_row + '][custom_field][";
                    // line 783
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 783);
                    echo "]\" value=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 783), "js");
                    echo "\" placeholder=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 783), "js");
                    echo "\" id=\"input-address-' + address_row + '-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 783);
                    echo "\" class=\"form-control time\"/><div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>';
    html += '    </div>';
    html += '\t   <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 785
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 785);
                    echo "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 789
                echo "
  ";
                // line 790
                if ((twig_get_attribute($this->env, $this->source, $context["custom_field"], "type", [], "any", false, false, false, 790) == "datetime")) {
                    // line 791
                    echo "    html += '<div class=\"row mb-3 custom-field custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 791);
                    echo "\">';
    html += '  <label for=\"input-address-' + address_row + '-custom-field-";
                    // line 792
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 792);
                    echo "\" class=\"col-sm-2 col-form-label\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 792), "js");
                    echo "</label>';
    html += '  <div class=\"col-sm-10\">';
    html += '    <div class=\"input-group\">';
    html += '      <input type=\"text\" name=\"address[' + address_row + '][custom_field][";
                    // line 795
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 795);
                    echo "]\" value=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "value", [], "any", false, false, false, 795), "js");
                    echo "\" placeholder=\"";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["custom_field"], "name", [], "any", false, false, false, 795), "js");
                    echo "\" id=\"input-address-' + address_row + '-custom-field-";
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 795);
                    echo "\" class=\"form-control datetime\"/><div class=\"input-group-text\"><i class=\"fa-regular fa-calendar\"></i></div>';
    html += '    </div>';
    html += '\t   <div id=\"error-address-' + address_row + '-custom-field-";
                    // line 797
                    echo twig_get_attribute($this->env, $this->source, $context["custom_field"], "custom_field_id", [], "any", false, false, false, 797);
                    echo "\" class=\"invalid-feedback\"></div>';
    html += '  </div>';
    html += '</div>';
  ";
                }
                // line 801
                echo "
  ";
            }
            // line 803
            echo "  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['custom_field'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 804
        echo "
    html += '<div class=\"row mb-3\">';
    html += '  <label for=\"input-address-' + address_row + '-default\" class=\"col-sm-2 col-form-label\">";
        // line 806
        echo twig_escape_filter($this->env, ($context["entry_default"] ?? null), "js");
        echo "</label>';
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
        echo ($context["user_token"] ?? null);
        echo "&country_id=' + \$(element).val(),
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
        echo twig_escape_filter($this->env, ($context["text_select"] ?? null), "js");
        echo "</option>';

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
        echo twig_escape_filter($this->env, ($context["text_none"] ?? null), "js");
        echo "</option>';
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
        echo twig_escape_filter($this->env, ($context["text_select"] ?? null), "js");
        echo "</option>';

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
        echo twig_escape_filter($this->env, ($context["text_none"] ?? null), "js");
        echo "</option>';
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
        echo ($context["user_token"] ?? null);
        echo "&customer_id=' + \$('#input-customer-id').val());
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
        echo ($context["user_token"] ?? null);
        echo "&customer_id=' + \$('#input-customer-id').val(),
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
        echo ($context["user_token"] ?? null);
        echo "&customer_id=' + \$('#input-customer-id').val());
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
        echo ($context["user_token"] ?? null);
        echo "&customer_id=' + \$('#input-customer-id').val(),
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
        echo ($context["user_token"] ?? null);
        echo "&customer_id=' + \$('#input-customer-id').val());

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
        echo ($context["user_token"] ?? null);
        echo "&customer_id=' + \$('#input-customer-id').val(),
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
        echo ($context["user_token"] ?? null);
        echo "&customer_id=' + \$('#input-customer-id').val());

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
        echo ($context["user_token"] ?? null);
        echo "&customer_id=' + \$('#input-customer-id').val(),
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
        echo ($context["user_token"] ?? null);
        echo "&customer_id=' + \$('#input-customer-id').val());

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
        echo ($context["footer"] ?? null);
        echo "
";
    }

    public function getTemplateName()
    {
        return "administrator/view/template/customer/customer_form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  2740 => 1116,  2719 => 1098,  2695 => 1077,  2670 => 1055,  2646 => 1034,  2622 => 1013,  2598 => 992,  2576 => 973,  2554 => 954,  2536 => 939,  2487 => 893,  2471 => 880,  2452 => 864,  2436 => 851,  2416 => 834,  2385 => 806,  2381 => 804,  2375 => 803,  2371 => 801,  2364 => 797,  2353 => 795,  2345 => 792,  2340 => 791,  2338 => 790,  2335 => 789,  2328 => 785,  2317 => 783,  2309 => 780,  2304 => 779,  2302 => 778,  2299 => 777,  2292 => 773,  2281 => 771,  2273 => 768,  2268 => 767,  2266 => 766,  2263 => 765,  2256 => 761,  2249 => 759,  2243 => 758,  2237 => 757,  2225 => 756,  2219 => 753,  2214 => 752,  2212 => 751,  2209 => 750,  2202 => 746,  2192 => 745,  2185 => 743,  2180 => 742,  2178 => 741,  2175 => 740,  2169 => 737,  2158 => 735,  2151 => 733,  2146 => 732,  2144 => 731,  2141 => 730,  2134 => 726,  2130 => 724,  2119 => 721,  2109 => 720,  2106 => 719,  2102 => 718,  2097 => 716,  2092 => 714,  2087 => 713,  2085 => 712,  2082 => 711,  2075 => 707,  2071 => 705,  2060 => 702,  2052 => 701,  2049 => 700,  2045 => 699,  2040 => 697,  2035 => 695,  2030 => 694,  2028 => 693,  2025 => 692,  2018 => 688,  2014 => 686,  2003 => 684,  1999 => 683,  1994 => 681,  1988 => 680,  1981 => 678,  1977 => 677,  1974 => 676,  1971 => 675,  1968 => 674,  1964 => 673,  1955 => 667,  1950 => 665,  1942 => 659,  1931 => 657,  1927 => 656,  1923 => 655,  1917 => 652,  1908 => 646,  1903 => 644,  1894 => 638,  1889 => 636,  1882 => 632,  1878 => 631,  1869 => 625,  1864 => 623,  1857 => 619,  1853 => 618,  1844 => 612,  1839 => 610,  1830 => 604,  1825 => 602,  1816 => 598,  1807 => 592,  1780 => 568,  1765 => 556,  1761 => 555,  1752 => 549,  1745 => 545,  1741 => 544,  1736 => 542,  1729 => 538,  1724 => 536,  1719 => 534,  1713 => 531,  1709 => 530,  1700 => 524,  1693 => 520,  1688 => 518,  1681 => 514,  1676 => 512,  1671 => 510,  1665 => 507,  1661 => 506,  1651 => 499,  1644 => 495,  1639 => 493,  1634 => 491,  1628 => 488,  1624 => 487,  1616 => 482,  1612 => 481,  1604 => 476,  1599 => 474,  1596 => 473,  1590 => 472,  1588 => 471,  1581 => 469,  1568 => 465,  1560 => 462,  1556 => 460,  1549 => 458,  1545 => 456,  1536 => 452,  1520 => 449,  1510 => 446,  1505 => 445,  1503 => 444,  1500 => 443,  1491 => 439,  1475 => 436,  1465 => 433,  1460 => 432,  1458 => 431,  1455 => 430,  1446 => 426,  1430 => 423,  1420 => 420,  1415 => 419,  1413 => 418,  1410 => 417,  1401 => 413,  1388 => 411,  1376 => 410,  1364 => 409,  1350 => 408,  1344 => 405,  1339 => 404,  1337 => 403,  1334 => 402,  1325 => 398,  1311 => 397,  1302 => 395,  1297 => 394,  1295 => 393,  1292 => 392,  1283 => 388,  1269 => 387,  1260 => 385,  1255 => 384,  1253 => 383,  1250 => 382,  1241 => 378,  1238 => 377,  1215 => 374,  1212 => 373,  1208 => 372,  1202 => 371,  1197 => 369,  1192 => 368,  1190 => 367,  1187 => 366,  1178 => 362,  1175 => 361,  1152 => 358,  1149 => 357,  1145 => 356,  1139 => 355,  1134 => 353,  1129 => 352,  1127 => 351,  1124 => 350,  1115 => 346,  1112 => 345,  1097 => 343,  1093 => 342,  1089 => 341,  1079 => 340,  1070 => 338,  1065 => 337,  1063 => 336,  1060 => 335,  1057 => 334,  1053 => 333,  1046 => 329,  1040 => 328,  1033 => 326,  1026 => 322,  1023 => 321,  1008 => 319,  1004 => 318,  1000 => 317,  990 => 316,  983 => 314,  976 => 310,  966 => 309,  959 => 307,  952 => 303,  942 => 302,  935 => 300,  922 => 296,  915 => 294,  908 => 290,  898 => 289,  891 => 287,  878 => 283,  871 => 281,  864 => 277,  854 => 276,  847 => 274,  840 => 270,  830 => 269,  823 => 267,  812 => 265,  807 => 264,  802 => 263,  800 => 262,  791 => 256,  784 => 254,  778 => 251,  768 => 246,  762 => 243,  752 => 238,  746 => 235,  741 => 233,  730 => 227,  725 => 225,  715 => 220,  710 => 218,  705 => 216,  701 => 214,  695 => 213,  691 => 211,  684 => 207,  672 => 204,  664 => 201,  659 => 200,  657 => 199,  654 => 198,  647 => 194,  635 => 191,  627 => 188,  622 => 187,  620 => 186,  617 => 185,  610 => 181,  598 => 178,  590 => 175,  585 => 174,  583 => 173,  580 => 172,  573 => 168,  561 => 165,  551 => 164,  543 => 163,  531 => 162,  524 => 158,  519 => 157,  517 => 156,  514 => 155,  507 => 151,  497 => 150,  490 => 148,  485 => 147,  483 => 146,  480 => 145,  473 => 141,  463 => 140,  456 => 138,  451 => 137,  449 => 136,  446 => 135,  439 => 131,  436 => 130,  415 => 127,  412 => 126,  408 => 125,  404 => 124,  399 => 122,  394 => 121,  392 => 120,  389 => 119,  382 => 115,  379 => 114,  358 => 111,  355 => 110,  351 => 109,  347 => 108,  342 => 106,  337 => 105,  335 => 104,  332 => 103,  325 => 99,  322 => 98,  307 => 96,  303 => 95,  299 => 94,  293 => 93,  286 => 91,  281 => 90,  279 => 89,  276 => 88,  274 => 87,  271 => 86,  267 => 85,  258 => 81,  253 => 79,  247 => 78,  238 => 74,  233 => 72,  223 => 67,  218 => 65,  208 => 60,  203 => 58,  197 => 54,  182 => 52,  178 => 51,  172 => 48,  166 => 44,  151 => 42,  147 => 41,  141 => 38,  136 => 36,  128 => 31,  124 => 30,  120 => 29,  116 => 28,  112 => 27,  108 => 26,  104 => 25,  99 => 23,  94 => 21,  87 => 16,  76 => 14,  72 => 13,  67 => 11,  61 => 10,  56 => 9,  48 => 7,  46 => 6,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "administrator/view/template/customer/customer_form.twig", "D:\\xampp\\htdocs\\opencart\\administrator\\view\\template\\customer\\customer_form.twig");
    }
}
