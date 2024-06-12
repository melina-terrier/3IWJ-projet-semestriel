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

        $enctype = isset($this->config["config"]["enctype"]) ? $this->config["config"]["enctype"] : '';
        $html .= "<form action='" . $this->config["config"]["action"] . "' method='" . $this->config["config"]["method"] . "' enctype='" . $enctype . "'>";
        
        foreach ($this->config["inputs"] as $name => $input) {
            $value = isset($this->fields[$name]) ? $this->fields[$name] : '';

            if (isset($input["part"])) {
                $partTitle = htmlentities($input["part"]);
                $html .= "<h3>" . $partTitle . "</h3>";
              }

            if ($input["type"] === "select") {
                if (isset($input["label"]) && !empty($input["label"])) {
                    $html .= "
                      <label for='" . $name . "'>" . $input["label"] . "</label><br>
                    ";
                  }
                $html .= "<select name='$name' " . (isset($input["required"]) ? "required" : "") . " aria-label='Sélectionnez une catégorie'>";
                $html .= "<option value='' disabled " . ($value == '' ? 'selected' : '') . " aria-label='Sélectionnez une catégorie'>Sélectionnez</option>";
              
                if (isset($input["option"]) && is_array($input["option"])) {
                    foreach ($input["option"] as $option) {
                        $selected = $value == $option['id'] ? 'selected' : '';
                        $html .= "<option value='{$option['id']}' " . (isset($option["disabled"]) ? "disabled" : "") . " $selected>{$option['name']}</option>";
                    }
                }
              
                $html .= "</select>";
            }else if ($input["type"] === "checkbox") {
                if (isset($input["label"]) && !empty($input["label"])) {
                    $html .= "
                      <label for='" . $name . "'>" . $input["label"] . "</label><br>
                    ";
                  }
              
                if (isset($input["option"]) && is_array($input["option"])) {
                  foreach ($input["option"] as $option) {
                    $html .= "
                      <label for='{$option['id']}'>{$option['name']}</label>
                      <input type='checkbox' name='$name' value='{$option['id']}'><br>";
                  }
                }
            } else if ($input["type"] === "textarea") {
                if (isset($input["label"]) && !empty($input["label"])) {
                    $html .= "
                      <label for='" . $name . "'>" . $input["label"] . "</label><br>
                    ";
                  }
                $html .= "
                <textarea
                    name='" . $name . "'
                    " . (isset($input["id"]) && !empty($input["id"]) ? "id='" . $input["id"] . "'" : "") . "
                    " . (isset($input["required"]) ? "required" : "") . "
                >" . htmlentities($value) . "</textarea>";
            } else if ($input["type"] === "submit") {
                if (isset($input["label"]) && !empty($input["label"])) {
                    $html .= "
                      <label for='" . $name . "'>" . $input["label"] . "</label><br>
                    ";
                  }

                $html .= "
                <input 
                    type='" . $input["type"] . "' 
                    name='" . $name . "' 
                    value='" . $input["value"] . "'
                >";
            } else {
                if (isset($input["label"]) && !empty($input["label"])) {
                    $html .= "
                      <label for='" . $name . "'>" . $input["label"] . "</label><br>
                    ";
                }

                $html .= "
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

        if (!empty($this->errors)) {
            foreach ($this->errors as $error) {
                $html .= "<li>" . $error . "</li>";
            }
        }
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

        $expectedFieldsCount = 0;
        foreach ($this->config["inputs"] as $name => $inputConfig) {
            if (isset($inputConfig["required"]) && $inputConfig["required"] === true) {
                $expectedFieldsCount++;
            }
            if (isset($inputConfig["type"]) && $inputConfig["type"] === "submit") {
                continue;
            }
            if (!isset($inputConfig["required"]) && isset($_POST[$name])) {
                $expectedFieldsCount++;
            }
        }

        $submittedDataCount = 0;
        foreach ($_POST as $key => $value) {
            if ($key !== "submit-draft") { 
                $submittedDataCount++;
            }
        }
        foreach ($_FILES as $key => $value) {
            $submittedDataCount++;
        }

        if ($expectedFieldsCount != $submittedDataCount) {
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


            if (isset($this->config['inputs'][$name]['label'])){
                if ($this->config['inputs'][$name]['label']=="Laisser un commentaire" && preg_match('/(https?|ftp):\/\/([^\s]+)/i', $dataSent)) {
                    $this->errors[] = "Les URL ne sont pas autorisés dans le commentaire.";
                }
            }
                         
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
