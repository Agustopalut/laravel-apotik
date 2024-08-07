<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLogin() {
        $this->post('/login',[
            'email' => 'fanny@owner.com',
            'password' => 'password'
        ])
        ->assertRedirect('/dashboard');
    }
}
