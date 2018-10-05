<?php

/* security/login.html.twig */
class __TwigTemplate_d6476d53326cdb2f5266fc8e3d2d7a9554b2b6afaefb2843be106a052a518a59 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("base.html.twig", "security/login.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "security/login.html.twig"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "security/login.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->enter($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02 = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->enter($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 4
        echo "    ";
        if ((isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new Twig_Error_Runtime('Variable "error" does not exist.', 4, $this->source); })())) {
            // line 5
            echo "        <div class=\"alert alert-danger\">
            ";
            // line 6
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["error"]) || array_key_exists("error", $context) ? $context["error"] : (function () { throw new Twig_Error_Runtime('Variable "error" does not exist.', 6, $this->source); })()), "messageKey", array()), "html", null, true);
            echo "
        </div>
    ";
        }
        // line 9
        echo "
    <div class=\"container\">
        <div class=\"row justify-content-md-center\">
            <form action=\"";
        // line 12
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("security_login");
        echo "\" method=\"post\">
                <fieldset>
                    <legend><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> Connexion</legend>
                    <div class=\"form-group fb\">
                        <a href=\"";
        // line 16
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("connect_facebook");
        echo "\" class=\"btn btn-social btn-facebook btn-block btn-lg\"><i class=\"fab fa-facebook-f\"></i>Se connecter avec facebook</a>
                    </div>
                    <div class=\"form-group fb\">
                        <a href=\"";
        // line 19
        echo $this->extensions['Symfony\Bridge\Twig\Extension\RoutingExtension']->getPath("connect_google");
        echo "\" class=\"btn btn-social btn-google-plus btn-block btn-lg\"><i class=\"fab fa-google-plus-g\"></i>Se connecter avec Google</a>
                    </div>
                    <div class=\"ou\"><span>ou</span>
                        <hr>
                    </div>
                    <div class=\"form-group\">
                        <label for=\"username\">Username</label>
                        <input type=\"text\" id=\"username\" name=\"_username\" value=\"";
        // line 26
        echo twig_escape_filter($this->env, (isset($context["last_username"]) || array_key_exists("last_username", $context) ? $context["last_username"] : (function () { throw new Twig_Error_Runtime('Variable "last_username" does not exist.', 26, $this->source); })()), "html", null, true);
        echo "\" class=\"form-control\" />
                    </div>
                    <div class=\"form-group\">
                        <label for=\"password\">Mot de passe</label>
                        <input type=\"password\" id=\"password\" name=\"_password\" class=\"form-control\" />
                    </div>

                    ";
        // line 34
        echo "                        ";
        // line 35
        echo "                        ";
        // line 36
        echo "                    ";
        // line 37
        echo "
                    <input type=\"hidden\" name=\"_csrf_token\" value=\"";
        // line 38
        echo twig_escape_filter($this->env, $this->env->getRuntime('Symfony\Component\Form\FormRenderer')->renderCsrfToken("authenticate"), "html", null, true);
        echo "\" />
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fa fa-sign-in\" aria-hidden=\"true\"></i> Se connecter
                    </button>
                </fieldset>
            </form>
        </div>
    </div>


";
        
        $__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02->leave($__internal_319393461309892924ff6e74d6d6e64287df64b63545b994e100d4ab223aed02_prof);

        
        $__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e->leave($__internal_085b0142806202599c7fe3b329164a92397d8978207a37e79d70b8c52599e33e_prof);

    }

    public function getTemplateName()
    {
        return "security/login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  112 => 38,  109 => 37,  107 => 36,  105 => 35,  103 => 34,  93 => 26,  83 => 19,  77 => 16,  70 => 12,  65 => 9,  59 => 6,  56 => 5,  53 => 4,  44 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends 'base.html.twig' %}

{% block body %}
    {% if error %}
        <div class=\"alert alert-danger\">
            {{ error.messageKey }}
        </div>
    {% endif %}

    <div class=\"container\">
        <div class=\"row justify-content-md-center\">
            <form action=\"{{ path('security_login') }}\" method=\"post\">
                <fieldset>
                    <legend><i class=\"fa fa-lock\" aria-hidden=\"true\"></i> Connexion</legend>
                    <div class=\"form-group fb\">
                        <a href=\"{{ path('connect_facebook') }}\" class=\"btn btn-social btn-facebook btn-block btn-lg\"><i class=\"fab fa-facebook-f\"></i>Se connecter avec facebook</a>
                    </div>
                    <div class=\"form-group fb\">
                        <a href=\"{{ path('connect_google') }}\" class=\"btn btn-social btn-google-plus btn-block btn-lg\"><i class=\"fab fa-google-plus-g\"></i>Se connecter avec Google</a>
                    </div>
                    <div class=\"ou\"><span>ou</span>
                        <hr>
                    </div>
                    <div class=\"form-group\">
                        <label for=\"username\">Username</label>
                        <input type=\"text\" id=\"username\" name=\"_username\" value=\"{{ last_username }}\" class=\"form-control\" />
                    </div>
                    <div class=\"form-group\">
                        <label for=\"password\">Mot de passe</label>
                        <input type=\"password\" id=\"password\" name=\"_password\" class=\"form-control\" />
                    </div>

                    {#<div class=\"form-group\">#}
                        {#<input type=\"checkbox\" id=\"remember_me\" name=\"_remember_me\" class=\"form-control\" checked />#}
                        {#<label for=\"remember_me\">Keep me logged in</label>#}
                    {#</div>#}

                    <input type=\"hidden\" name=\"_csrf_token\" value=\"{{ csrf_token('authenticate') }}\" />
                    <button type=\"submit\" class=\"btn btn-primary\">
                        <i class=\"fa fa-sign-in\" aria-hidden=\"true\"></i> Se connecter
                    </button>
                </fieldset>
            </form>
        </div>
    </div>


{% endblock %}", "security/login.html.twig", "/var/www/fromton/templates/security/login.html.twig");
    }
}
