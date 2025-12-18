<?php

namespace App\Controllers;

class Debug extends BaseController
{
    public function index()
    {
        echo "<h1>CSRF Debug Information</h1>";
        
        echo "<h2>Current CSRF Token:</h2>";
        echo "<pre>" . csrf_hash() . "</pre>";
        
        echo "<h2>Session Data:</h2>";
        echo "<pre>";
        print_r(session()->get());
        echo "</pre>";
        
        echo "<h2>Test Form with CSRF:</h2>";
        echo form_open('/debug/test', ['method' => 'post']);
        echo form_input(['name' => 'test', 'value' => 'test value']);
        echo form_submit('submit', 'Test Submit');
        echo form_close();
        
        echo "<h2>Test Form without CSRF:</h2>";
        echo '<form method="POST" action="/debug/test2">';
        echo '<input type="text" name="test" value="test without csrf">';
        echo '<button type="submit">Submit without CSRF</button>';
        echo '</form>';
    }
    
    public function test()
    {
        echo "<h1>✅ Form Submitted Successfully with CSRF!</h1>";
        echo "<p>CSRF token is working correctly.</p>";
        
        echo "<h2>POST Data:</h2>";
        echo "<pre>";
        print_r($this->request->getPost());
        echo "</pre>";
        
        echo "<h2>CSRF Hash from POST:</h2>";
        echo "<pre>" . ($this->request->getPost('csrf_test_name') ?? 'No CSRF token found') . "</pre>";
        
        echo '<a href="/debug">Back to Debug</a>';
    }
    
    public function test2()
    {
        echo "<h1>❌ CSRF Test without token</h1>";
        echo "<p>This should show CSRF error if protection is enabled.</p>";
        
        echo '<a href="/debug">Back to Debug</a>';
    }
}