<?php

use Foro\User;
use Tests\TestHelper;
use Tests\CreatesApplication;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use CreatesApplication, TestHelper;

}
