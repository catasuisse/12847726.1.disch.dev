<?php

/**
 * @var rex_yform_value_textarea $this
 * @psalm-scope-this rex_yform_value_textarea
 */

$notice = [];

if('' != $this->getElement('notice')) {
    $notice[] = rex_i18n::translate($this->getElement('notice'), false);
}

if(isset($this->params['warning_messages'][$this->getId()]) && !$this->params['hide_field_warning_messages']) {
    $notice[] = '<span class="text-warning">' . rex_i18n::translate($this->params['warning_messages'][$this->getId()], false) . '</span>';
}

if(count($notice) > 0) {
    $notice = implode('<br />', $notice);
} else {
    $notice = '–';
}

$class = $this->getElement('required') ? 'form-is-required ' : '';
$class_group = trim('dd-form-group form-group ' . $this->getWarningClass());
$class_label = ['control-label'];

$rows = $this->getElement('rows');

if(!$rows) {
    $rows = 4;
}

$attributes = [
    'class' => 'form-control',
    'name' => $this->getFieldName(),
    'id' => $this->getFieldId(),
    'rows' => $rows,
];

$attributes = $this->getAttributeElements($attributes, ['placeholder', 'pattern', 'required', 'disabled', 'readonly']);

echo '
    
    <div id="' . $this->getHTMLId() . '" class="' . $class_group . '">
        <label for="' . $this->getFieldId() . '" class="' . implode(' ', $class_label) . '">' . $this->getLabel() . '</label>
        <textarea ' . implode(' ', $attributes) . '>' . htmlspecialchars($this->getValue()) . '</textarea>
        <div class="dd-alert help-block small">' . $notice . '</div>
    </div>

';
