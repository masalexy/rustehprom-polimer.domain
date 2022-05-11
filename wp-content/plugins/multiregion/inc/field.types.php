<?php
function get_field_content($name, $type, $value = ''){
    $required = ( in_array($name, ['name']) ) ? 'required' : '';
    switch($type){
        case 'text':
            return "<input type='text' name='region[{$name}]' value='{$value}' {$required} />";
        break;

        case 'tel':
            return "<input type='tel' name='region[{$name}]' value='{$value}' {$required} />";
        break;

        case 'email':
            return "<input type='email' name='region[{$name}]' value='{$value}' {$required} />";
        break;

        case 'textarea':
            return "<textarea name='region[{$name}]'  {$required}>{$value}</textarea>";
        break;

        case 'select':
            $selected_0 = ($value == 0) ? 'selected' : '';
            $selected_1 = ($value == 1) ? 'selected' : '';
            return
            "
                <select name='region[{$name}]'>
                    <option value='0' {$selected_0}>Подкаталог</option>
                    <option value='1' {$selected_1}>Субдомен</option>
                </select>
            ";
        break;
    }
}
