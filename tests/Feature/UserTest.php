<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    public function testLoginTest()
    {
        print "\e[0;32;mTest Login\e[0m\n";
        $credential = [
            'email' => 'fahd@example.com',
            'password' => '123456'
        ];
        $response = $this->post('login', $credential);
        $response->assertSessionMissing('Login Failed');
        
        print "\e[0;32;mTest Load data from local\e[0m\n";
        $response = $this->get('lists');
        $response->assertStatus(200);

        print "\e[0;32;mTest Load data from API\e[0m\n";
        $response = $this->get('checkAPI');
        $response->assertStatus(200);

        print "\e[0;32;mTest Saving data to local\e[0m\n";
        $response = $this->post('updateDB');
        $response->assertStatus(200);
    }
}
