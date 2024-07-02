<?php

namespace App\Core;

class Form
{
    private $config;
    private $errors = [];
    private $fields = [];

    public function __construct(String $name)
    {
        if (!file_exists('../Forms/' . $name . '.php')) {
            die('Le form ' . $name . '.php n\'existe pas dans le dossier ../Forms');
        }
        include '../Forms/' . $name . '.php';
        $name = 'App\\Forms\\' . $name;
        $this->config = $name::getConfig();
    }

    public function setField(array $fields, string $type = "text", string $name = '') {
        if($type=='group') {
            foreach ($fields as $field => $value) {
                $this->fields[$name][$name.'_'.$field] = $value;
            }
        } else if ($name){
            $this->fields[$name] = $fields;
        } 
        else  {
            foreach($fields as $field => $value){
                $this->fields[$field] = $value;
            }
        }
    }

    public function build(): string
    {
        $html = '';

        $enctype = isset($this->config['config']['enctype']) ? $this->config['config']['enctype'] : '';
        $html .= '<form action="' . $this->config['config']['action'] . '" method="' . $this->config['config']['method'] . '" enctype="' . $enctype . '">';
        
        foreach ($this->config['inputs'] as $name => $input) {
            $value = isset($this->fields[$name]) ? $this->fields[$name] : '';

            if (isset($input['part'])) {
                $partTitle = htmlentities($input['part']);
                $html .= '<h3>' . $partTitle . '</h3>';
            }

            if (isset($input['label']) && !empty($input['label'])) {
                $html .= '<label for="'.$name.'">'.$input['label'].'</label><br>';
            }

            if ($input['type'] === 'select') {
                $selectName = isset($input['name']) ? $input['name'] : $name;
                $depend = isset($input['depends-to']) ? 'dependTo="'.$input['depends-to'].'"' : '';
                $html .= '<select name="'.$selectName.'" '.(isset($input['required']) ? 'required' : '') . ' '. (isset($input['multiple']) ? 'multiple' : '') .' '.$depend.' value='.$value.'>';         
                if (isset($input['option']) && is_array($input['option'])) {
                    foreach ($input['option'] as $option) {
                        $selected = isset($option['selected']) ? 'selected' : '';
                        if ($value && is_array($value)){
                            foreach ($value as $select) {
                                if ($select == $option['id']){
                                    $selected = 'selected';
                                }
                            }
                        } else if ($value) {
                            if ($value == $option['id']){
                                $selected = 'selected';
                            }
                        }
                        $html .= '<option value="'.$option['id'].'" '.(isset($option['disabled']) ? 'disabled' : '').' '.$selected.'>'.$option['name'].'</option>';
                    }
                }
                $html .= '</select>';
            
            } else if ($input['type'] === 'radio') {
                if (isset($input['option']) && is_array($input['option'])) {
                    foreach ($input['option'] as $option) {
                        $checked = isset($option['checked']) ? 'checked' : '';
                        if ($value) {
                            if ($value == $option['id']){
                                $checked = 'checked';
                            }
                        }
                        $html .= '<input type="radio" name="'.$name.'" value="'.$option['id'].'" '.$checked.' '. (isset($input['required']) ? 'required' : '').'>
                        <label for="'.$option['id'].'">'.$option['name'].'</label><br>';
                    }
                }

            } else if ($input['type'] === 'media') {
                $html .='<button id="openMediaModal" value="'.$value.'">Choisir un média</button>
                <div id="mediaModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Media Selection</h2>
                        <div id="mediaSelection">';
                        if (isset($input['option']) && is_array($input['option'])) {
                            foreach ($input['option'] as $option) {
                                $checked = isset($option['checked']) ? 'checked' : '';
                                if ($value) {
                                    if ($value == $option['id']){
                                        $checked = 'checked';
                                    }
                                }
                                $html .= '<label for="'.$option['id'].'"><img src="'.$option['id'].'"></label>
                                <input type="radio" name="'.$name.'" '.$checked.' value="'.$option['id'].'" '. (isset($input['required']) ? 'required' : '').'><br>';
                            }
                        }
                        $html .= '</div>
                        <button id="saveMedia">Save</button>
                    </div>
                </div>';  

            } else if ($input['type'] === 'textarea') {
                $html .= '<textarea name="'.$name.'"'.(isset($input['required']) ? 'required' : '').'>'. htmlentities($value).'</textarea>';
            } else if ($input['type'] === 'submit') {
                $html .= '<input type="'.$input['type'].'" name="'.$name.'" value="'.$input['value'].'">';
            } else if ($input['type'] === 'button') {
                $link = isset($input['link-to']) ? 'data-link="'.$input['link-to'].'"' : '';
                $html .= '<button id="'.$name.'" '.$link.'>'.$input['value'].'</button>';
            } else if ($input['type'] === 'checkbox'){
                $html .= '<ul id="'.$name.'">';
                if (isset($input['option']) && is_array($input['option'])) {
                    foreach ($input['option'] as $option) {
                        $html .= '<input type="checkbox" url="'.$option['url'].'" name="'.$name.'" id="'.$option['id'].'">
                        <label for="'.$option['id'].'">'.$option['name'].'</label><br>';
                    }
                }
                $html .= '</ul>';
            } else if ($input['type'] === 'custom') {
                $html .= '<a href="#" id="add-to-menu">Ajouter au menu</a>
                <br><ul class="menu-list" sortable></ul>';
                if ($value) {
                    $menuData = json_encode($value);
                } else {
                    $menuData ='';
                }
                $html .= "<input type='hidden' id='".$name."' name='".$name."' value='".$menuData."'>";
            } else if($input['type'] === 'group') {

                if ($value){
                    foreach($value as $key => $val){
                        $newKey = $key;
                        if (substr($key, -2) === '_0') {
                            $newKey = rtrim($key, '_0');
                        }
                        $html .= '<fieldset id="'.$newKey.'">'; 
                        foreach ($input['group-element'] as $itemName => $inputGroup){
                            $html .= '<label for="'.$itemName.'">'.$inputGroup['label'].'</label>
                            <input type="'.$inputGroup['type'].'" name="'.$name.'['.$key.']['.$itemName.']" value="'.$val[$itemName].'" required>';
                        }
                        $html .= '</fieldset>';     
                    }
                } else {
                    $html .= '<fieldset id="'.$name.'">'; 
                    foreach ($input['group-element'] as $itemName => $inputGroup){
                        $html .= '<label for="'.$itemName.'">'.$inputGroup['label'].'</label>
                        <input type="'.$inputGroup['type'].'" name="'.$name.'['.$input['name'].']['.$itemName.']">';
                    }
                    $html .= '</fieldset>';  
                }  
                
            } else {
                $html .= '<input type="'.$input['type'].'" name="'.$name.'" value="'.$value.'" '. (isset($input['required']) ? 'required' : '');
                if ($input['type'] === 'file' && isset($input['accept'])) {
                    $html .= ' accept="' . $input['accept'] . '"';
                }
                $html .= '>';
                if ($input['type'] === 'file' && isset($value)){
                    $html .= '<img src="..'.$value.'">';
                }
            }
            $html .= '<br>';
        }

        $html .= '<input type="submit" value="'.htmlentities($this->config['config']['submit']).'">';
        $html .= '</form>';

        if (!empty($this->errors)) {
            foreach ($this->errors as $error) {
                $html .= '<li>'.$error.'</li>';
            }
        }
        return $html;
    }

    public function isSubmitted(): bool
    {
        if ($this->config['config']['method'] == 'POST' && !empty($_POST)) {
            return true;
        } else if ($this->config['config']['method'] == 'GET' && !empty($_GET)) {
            return true;
        } else {
            return false;
        }
    }

    public function isValid(): bool
    {

        $expectedFieldsCount = 0;
        foreach ($this->config['inputs'] as $name => $inputConfig) {
            if (isset($inputConfig['required']) && $inputConfig['required'] === true) {
                $expectedFieldsCount++;
            }
            if (!isset($inputConfig['required']) && isset($_POST[$name])) {
                $expectedFieldsCount++;
            }
        }
        
        $submittedDataCount = 0;
        foreach ($_POST as $key => $value) {
            if ($key !== 'submit-draft') { 
                $submittedDataCount++;
            }
        }
        foreach ($_FILES as $key => $value) {
            $submittedDataCount++;
        }

        if ($expectedFieldsCount != $submittedDataCount) {
            $this->errors[] = 'Tentative de Hack';
        }

        foreach ($_POST as $name => $dataSent) {
         
            if (!isset($this->config['inputs'][$name])) {
                $this->errors[] = "Le champ '$name' n'est pas autorisé";
            }
            
            if (isset($this->config['inputs'][$name]['required']) && empty($dataSent)) {
                $this->errors[] = 'Le champ ' . $name . ' ne doit pas être vide';
            }

            if (isset($this->config['inputs'][$name]['min']) && strlen($dataSent) < $this->config['inputs'][$name]['min']) {
                $this->errors[] = $this->config['inputs'][$name]['error'];
            }

            if (isset($this->config['inputs'][$name]['max']) && strlen($dataSent) > $this->config['inputs'][$name]['max']) {
                $this->errors[] = $this->config['inputs'][$name]['error'];
            }

            if ($name == 'comment' && preg_match('/(https?|ftp):\/\/([^\s]+)/i', $dataSent)) {
                $this->errors[] = 'Les URL ne sont pas autorisés dans le commentaire.';
            }
                         
            if (isset($this->config['inputs'][$name]['confirm']) && $dataSent != $_POST[$this->config['inputs'][$name]['confirm']]) {
                $this->errors[] = $this->config['inputs'][$name]['error'];
            }

            if ($this->config['inputs'][$name]['type'] == 'email' && !filter_var($dataSent, FILTER_VALIDATE_EMAIL)) {
                $this->errors[] = 'Le format de l\'email est incorrect';
            }

            if ($this->config['inputs'][$name]['type'] == 'password' && strlen($dataSent) >= 8 &&
                (!preg_match('#[a-z]#', $dataSent) ||
                !preg_match('#[A-Z]#', $dataSent) ||
                !preg_match('#[0-9]#', $dataSent))) {
                $this->errors[] = $this->config['inputs'][$name]['error'];
            }

            if ($this->config['inputs'][$name]['type'] == 'file' && !in_array($dataSent['type'], $this->config['inputs'][$name]['accept'])) {
                $this->errors[] = $this->config['inputs'][$name]['error'];
            }

            if ($this->config['inputs'][$name]['type'] == 'file' && $dataSent['size'] > 2097152) {
                $this->errors[] = 'L\'image ne doit pas dépasser 2 Mo.';
            }

           
            if ($this->config['inputs'][$name]['type'] == 'select' || $this->config['inputs'][$name]['type'] == 'checkbox' || $this->config['inputs'][$name]['type'] == 'radio'){
                foreach($this->config['inputs'][$name]['option'] as $option){
                    if (!$option['id'] === $dataSent) {
                        $this->errors[] = $this->config['inputs'][$name]['error'];
                    }
                }
            }

            // verifier le format de la date des input de type date
            // if ($this->config['inputs'][$name]['type'] === 'date' && isset($dataSent)) {
            //     try {
            //         $dateTime = new \DateTime($dataSent);
            //     } catch (\Exception $e) {
            //         $this->errors[] = $this->config['inputs'][$name]['error'];
            //     }
            // }
           
            if ($name === 'birthday' && !empty($dataSent)) {
                $birthDate = new \DateTime($dataSent);
                $interval = $birthDate->diff(new \DateTime());
                $age = $interval->y;
                if ($birthDate > new \DateTime()) {
                    $this->errors[] = 'La date doit être inférieure à celle d\'aujourd\'hui';
                }
            }
            
            if ($name === 'db-prefix' && isset($dataSent)) {
                $pattern = '/^[a-zA-Z_][a-zA-Z0-9_]*$/';
                if (!preg_match($pattern, $dataSent)) {
                    $this->errors[] = 'Le préfixe de la base de données doit commencer par une lettre ou un underscore et ne contenir que des lettres, chiffres et underscores.';
                }
            }

        }

        return empty($this->errors);
    }
}