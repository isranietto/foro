 verga<?php


use Tests\TestHelper;
use Tests\CreatesApplication;
use Laravel\BrowserKitTesting\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class FeatureTestCase extends TestCase
{
    use DatabaseTransactions, CreatesApplication, TestHelper;

    public function seeErrors(array $fields)
    {
        foreach ($fields as $name => $errors){
            foreach ((array) $errors as $message){
                $this->seeInElement(
                    "#field_{$name}.has-error .help-block", $message
                );
            }
        }
    }
}