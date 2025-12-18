<?php namespace App\Controllers;

class SimpleTest extends BaseController
{
    public function index()
    {
        echo "<h1>Simple Test</h1>";
        echo "<p><a href='/simple-test/login'>Test Login</a></p>";
    }
    
    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            echo "<h3>Login Submitted</h3>";
            echo "<p>Redirecting to /admin...</p>";
            
            // Set simple session
            session()->set('logged_in', true);
            session()->set('username', 'testuser');
            
            // Immediate redirect
            header('Location: /admin');
            exit;
        }
        
        echo '
        <form method="post">
            <input type="text" name="username" value="admin">
            <input type="password" name="password" value="admin123">
            <button type="submit">Test Login</button>
        </form>
        ';
    }
}