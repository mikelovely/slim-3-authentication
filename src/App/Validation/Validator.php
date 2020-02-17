<?php

namespace App\Validation;

use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator as JsonSchemaValidator;

class Validator
{
    private $validator;

    private $errors;

    public function __construct($validator = null)
    {
        $this->validator = $validator;
    }

    public function validate($request, $schema)
    {
        $validator = $this->getValidator();

        $body = (object) $request->getParams();

        $validator->validate(
            $body,
            ['$ref' => 'file://' . APP_SOURCE_PATH . '/src/App/JsonSchemas/' . $schema . '.json'],
            Constraint::CHECK_MODE_APPLY_DEFAULTS
        );

        if (!$validator->isValid()) {
            foreach ($validator->getErrors() as $error) {
                $this->errors[$error['property']] = [$error['message']];
            }

            $_SESSION['errors'] = $this->errors;
        }

        return $body;
    }

    public function failed()
    {
        return !empty($this->errors);
    }

    private function getValidator()
    {
        if (!$this->validator) {
            $this->validator = new JsonSchemaValidator();
        }

        return $this->validator;
    }
}
