<?php
declare(strict_types = 1);
namespace App\HTML;

class Form {

  private $data;

  public function __construct(array $form_data = []) {
    $this->data = $form_data;
  }

  public function input(string $name, string $label = null, array $options = []) :string {
    $label = $label ?? ucfirst($name);
    $label .= in_array('required', $options) ? null : ' <span class="label__optional">(optionnel)</span>';
    $input_type = isset($options['type']) ? null : $input_type = 'type="text"';
    $html = <<<HTML
      <label class="label" for="$name">$label</label>
      <input
        class="input" id="$name" name="$name" $input_type
        value="{$this->getValue($name)}" {$this->parseOptions($options)}
        onblur="validateField(this)"
      >
HTML;
    return $html;
  }

  public function checkbox(string $name, string $label = null, array $options = []) :string {
    $checked = $this->getValue($name) ? 'checked' : null;
    $html = <<<HTML
      <label class="label" for="$name">$label</label>
      <input
        class="input-checkbox" id="$name" name="$name" type="checkbox"
        $checked {$this->parseOptions($options)}
        onblur="validateField(this)"
      >
HTML;
    return $html;
  }

  private function parseOptions(array $options) {
    $options = array_map(function ($key, $value) {
      return is_int($key) ? $value : "$key=\"$value\"";
    }, array_keys($options), $options);
    $options = implode(' ', $options);
    return $options;
  }

  private function getValue(string $field) :?string {
    return $this->data[$field] ?? null;
  }

}
