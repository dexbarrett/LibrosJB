<?php
namespace LibrosJB\Services\Validation;

use Illuminate\Validation\Validator as Validator;
use Illuminate\Contracts\Validation\Factory as ValidatorFactory;

abstract class FormValidator
{
  protected $validator;
  protected $errors = [];
  protected $rules = [];
  protected $friendlyNames = [];
  protected $rulesToUse;

  public function __construct(ValidatorFactory $validator)
  {
      $this->validator = $validator;
      $this->setRules('create');
  }

  public function validate($data)
  {
      $validator = $this->validator->make($data, $this->getRules());

      $this->setFriendlyLabels($validator);

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

  protected function setFriendlyLabels(Validator $validator)
  {
      if (count($this->friendlyNames) > 0) {
          $validator->setAttributeNames($this->friendlyNames);
      }
  }

}