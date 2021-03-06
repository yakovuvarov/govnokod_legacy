<?php

fileLoader::load('forms/validators/validator');

class formValidator extends validator
{
    protected $submit = 'submit';

    protected $csrf = true;

    public function __construct($data = null)
    {
        parent::__construct($data);

        if (is_null($data)) {
            $request = systemToolkit::getInstance()->getRequest();
            $this->data = $request->exportPost() + $request->exportGet();
        }
    }

    public function submit($submit)
    {
        foreach ($this->rules as $key => $rule) {
            if ($rule['name'] == $this->submit) {
                unset($this->rules[$key]);
                break;
            }
        }

        $this->submit = $submit;
    }

    public function validate()
    {
        if (!$this->getValue($this->submit, $submit)) {
            return;
        }

        if (!$this->filtered) {
            $this->runFilters();
        }

        foreach ($this->rules() as $rule) {
            if ($this->isFieldError($rule['name'])) {
                continue;
            }

            $this->getValue($rule['name'], $value);

            if (!$value) {
                $rule['validator']->notExists();
            }

            if (!$rule['validator']->validate($value, $rule['name'])) {
                $this->setError($rule['name'], $rule['validator']->getErrorMsg());
            }
        }

        return $this->isValid();
    }

    private function rules()
    {
        if (!$this->csrf) {
            return $this->rules;
        }

        $required = $this->loadValidator('required');
        $required->setData($this->data);
        $csrf = $this->loadValidator('csrf');
        $csrf->setData($this->data);

		$csrf_rules = array(
            array(
                'name' => '_csrf_token',
                'validator' => $required),
            array(
                'name' => '_csrf_token',
                'validator' => $csrf));

        return array_merge($this->rules, $csrf_rules);

		/*
        return $this->rules + array(
            array(
                'name' => '_csrf_token',
                'validator' => $required),
            array(
                'name' => '_csrf_token',
                'validator' => $csrf));
		*/
    }

    private function getValue($name, & $value)
    {
        $indexName = $this->hasBrackets($name);

        if (!isset($this->data[$name])) {
            $value = null;
            return false;
        }

        $value = $this->data[$name];

        if ($indexName) {
            $value = arrayDataspace::extractFromArray($indexName, $value);
        }

        return true;
    }

    private function hasBrackets(&$name)
    {
        if ($bracket = strpos($name, '[')) {
            $indexName = substr($name, $bracket);
            $name = substr($name, 0, $bracket);

            return $indexName;
        }
    }

    protected function getFromRequest($name, $type = 'string')
    {
        $funcName = 'get' . ucfirst(strtolower($type));
        $request = systemToolkit::getInstance()->getRequest();
        return $request->$funcName($name, SC_REQUEST);
    }
}

?>