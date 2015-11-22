<?php
namespace LibrosJB\Services\Validation;

use Illuminate\Validation\Validator as Validator;
use Illuminate\Contracts\Validation\Factory as ValidatorFactory;

abstract class FormValidator
{
    protected $validator;
    protected $errors = [];
    protected $rules = [];
    protected $data = [];
    protected $friendlyNames = [];
    protected $rulesToUse;

    public function __construct(ValidatorFactory $validator)
    {
        $this->validator = $validator;
        $this->setRules('create');
    }

    protected function getConditionalRules()
    {
        return [];
    }

    public function validate($data)
    {
        $this->data = $data;

        $validator = $this->validator->make($this->data, $this->getRules());

        $this->setFriendlyLabels($validator);
        $this->setConditionalRules($validator);

        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        }

        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

    public function setRules($ruleGroup)
    {
        $this->rulesToUse = $ruleGroup;

        return $this;
    }

    protected function getRules()
    {
        return $this->rules[$this->rulesToUse];
    }

    protected function getFieldValue($key)
    {
        return $this->data[$key];
    }

    protected function setFriendlyLabels(Validator $validator)
    {
        if (count($this->friendlyNames) > 0) {
            $validator->setAttributeNames($this->friendlyNames);
        }
    }

    public function setConditionalRules(Validator $validator)
    {
        $conditionalRules = $this->getConditionalRules();

        if (count($conditionalRules) == 0) {
            return;
        }

        $this->addConditionalRulesToValidator($validator, $conditionalRules);
    }

    protected function addConditionalRulesToValidator(Validator $validator, $conditionalRules)
    {
        foreach ($conditionalRules[$this->rulesToUse] as $field => $options) {
            $validator->sometimes($field, $options['rules'], $options['condition']);
        }
    }

}