<?php

namespace Modules\Account\tests;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function login_should_fail_on_missing_credentials()
    {
        $response = $this->post('/account/login', [
            'phone' => '',
            'password' => '',
        ]);

        $response->assertJson([
            'success' => false
        ]);
    }

    public function login_should_fail_on_invalid_credentials()
    {
        $response = $this->post('/account/login', [
            'phone' => '',
            'password' => '',
        ]);

        $response->assertJson([
            'success' => false
        ]);
    }
}
