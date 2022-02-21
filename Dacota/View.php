<?php

namespace Dacota\View;

use Exception;
use Pug\Pug;

include_once 'vendor/autoload.php';

class View
{
    static function render(array $context = [], string $templatePath)
    {
        $pug = new Pug();
        try {
            echo $pug->render($templatePath, $context);
        } catch (Exception $e) {
            $messages[] = ['error' => $e];
        }
        die();
    }

}

class Validator
{
    public $errs = [];


    public function username($value)
    {
        if (!preg_match('/^(?=[a-zA-Z0-9._]{8,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/', $value)) {
            $this->errs[] = ['danger' => 'invalid username'];
            return false;
        }
        return true;
    }


    public function password($value)
    {
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $value)) {
            $this->errs[] = ['danger' => 'invalid password'];
            return false;
        }
        return true;
    }
}