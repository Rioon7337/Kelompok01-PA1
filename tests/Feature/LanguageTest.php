<?php

namespace Tests\Feature;

use Tests\TestCase;

class LanguageTest extends TestCase
{
    public function test_language_switch()
    {
        $response = $this->get('/lang/en');
        $response->assertStatus(302);
        
        $this->assertEquals('en', session('locale'));
        
        $response2 = $this->get('/lang/en'); // We just need to hit a web route
        
        // Output the locale for the second request
        echo "App Locale in request 2: " . app()->getLocale() . "\n";
        echo "Session Locale in request 2: " . session('locale') . "\n";
    }
}
