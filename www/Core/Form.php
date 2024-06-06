<?php

namespace App\Core;

class Form
{
    private $config;
    private $errors = [];
    private $fields = [];

    public function __construct(String $name)
    {
        if (!file_exists("../Forms/" . $name . ".php")) {
            die("Le form " . $name . ".php n'existe pas dans le dossier ../Forms");
        }
        include "../Forms/" . $name . ".php";
        $name = "App\\Forms\\" . $name;
        $this->config = $name::getConfig();
    }

    public function setField($fieldName, $value) {
        $this->fields[$fieldName] = $value;
    }

    public function build(): string
    {
        $html = "";
        if (!empty($this->errors)) {
            foreach ($this->errors as $error) {
                $html .= "<li>" . $error . "</li>";
            }
        }
        $enctype = isset($this->config["config"]["enctype"]) ? $this->config["config"]["enctype"] : '';
        $html .= "<form action='" . $this->config["config"]["action"] . "' method='" . $this->config["config"]["method"] . "' enctype='" . $enctype . "'>";
        
        foreach ($this->config["inputs"] as $name => $input) {
            $value = isset($this->fields[$name]) ? $this->fields[$name] : '';

            if ($input["type"] === "select") {
                $html .= "<label for='$name'>" . $input["label"] . "</label>";
                $html .= "<select name='$name' " . (isset($input["required"]) ? "required" : "") . " aria-label='Sélectionnez une catégorie'>";
                $html .= "<option value='' disabled " . ($value == '' ? 'selected' : '') . " aria-label='Sélectionnez une catégorie'>Sélectionnez</option>";
              
                if (isset($input["option"]) && is_array($input["option"])) {
                    foreach ($input["option"] as $option) {
                        $selected = $value == $option['id'] ? 'selected' : '';
                        $html .= "<option value='{$option['id']}' " . (isset($option["disabled"]) ? "disabled" : "") . " $selected>{$option['name']}</option>";
                    }
                }
              
                $html .= "</select>";
            } else if ($input["type"] === "textarea") {
                $html .= "
                <label for='" . $name . "'>" . $input["label"] . "</label>
                <textarea
                    name='" . $name . "'
                    " . (isset($input["id"]) && !empty($input["id"]) ? "id='" . $input["id"] . "'" : "") . "
                    " . (isset($input["required"]) ? "required" : "") . "
                >" . htmlentities($value) . "</textarea>";
            } else {
                $html .= "
                <label for='" . $name . "'>" . $input["label"] . "</label>
                <input 
                    type='" . $input["type"] . "' 
                    name='" . $name . "' 
                    " . (isset($input["id"]) && !empty($input["id"]) ? "id='" . $input["id"] . "'" : "") . "
                    " . (isset($input["required"]) ? "required" : "") . "
                    value='" . htmlentities($value) . "'
                >";
            }
            $html .= "<br>";
        }

        $html .= "<input type='submit' value='" . htmlentities($this->config["config"]["submit"]) . "'>";
        $html .= "</form>";
        return $html;
    }

    public function isSubmitted(): bool
    {
        if ($this->config["config"]["method"] == "POST" && !empty($_POST)) {
            return true;
        } else if ($this->config["config"]["method"] == "GET" && !empty($_GET)) {
            return true;
        } else {
            return false;
        }
    }

    public function isValid(): bool
    {
        if (count($this->config["inputs"]) != count($_POST) + count($_FILES)) {
            $this->errors[] = "Tentative de Hack";
        }

        foreach ($_POST as $name => $dataSent) {
            if (!isset($this->config["inputs"][$name])) {
                $this->errors[] = "Le champ " . $name . " n'est pas autorisé";
            }

            if (isset($this->config["inputs"][$name]["required"]) && empty($dataSent)) {
                $this->errors[] = "Le champ " . $name . " ne doit pas être vide";
            }

            if (isset($this->config["inputs"][$name]["min"]) && strlen($dataSent) < $this->config["inputs"][$name]["min"]) {
                $this->errors[] = $this->config["inputs"][$name]["error"];
            }

            if (isset($this->config["inputs"][$name]["max"]) && strlen($dataSent) > $this->config["inputs"][$name]["max"]) {
                $this->errors[] = $this->config["inputs"][$name]["error"];
            }

            if ($this->config['inputs'][$name]['label']=="Laisser un commentaire" && preg_match('/(https?|ftp):\/\/([^\s]+)/i', $dataSent)) {
                $this->errors[] = "Les URL ne sont pas autorisés dans le commentaire.";
            }

            // if ($this->config['inputs'][$name]['label'] == "Slug"){
                
            //         $this->errors[] = "Le slug existe déjà pour une autre catégorie";
                
            // }
                         
            if (isset($this->config["inputs"][$name]["confirm"]) && $dataSent != $_POST[$this->config["inputs"][$name]["confirm"]]) {
                $this->errors[] = $this->config["inputs"][$name]["error"];
            } else {
                if ($this->config["inputs"][$name]["type"] == "email" && !filter_var($dataSent, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[] = "Le format de l'email est incorrect";
                }

                if ($this->config["inputs"][$name]["type"] == "password" && strlen($dataSent) >= 8 &&
                    (!preg_match("#[a-z]#", $dataSent) ||
                    !preg_match("#[A-Z]#", $dataSent) ||
                    !preg_match("#[0-9]#", $dataSent))) {
                    $this->errors[] = $this->config["inputs"][$name]["error"];
                }
            }
        }

        return empty($this->errors);
    }
}
