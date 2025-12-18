<?php namespace App\Controllers;

class SessionDebug extends BaseController
{
    public function index()
    {
        echo "<h1>🔍 DEBUG SESSION DATA</h1>";
        
        echo "<h3>Session yang aktif:</h3>";
        echo "<pre>";
        print_r($_SESSION);
        echo "</pre>";
        
        echo "<h3>Session via CI4:</h3>";
        echo "<pre>";
        print_r(session()->get());
        echo "</pre>";
        
        echo "<h3>Role khusus:</h3>";
        echo "<p>Role: <strong>" . session()->get('role') . "</strong></p>";
        echo "<p>User ID: " . session()->get('user_id') . "</p>";
        echo "<p>Username: " . session()->get('username') . "</p>";
        echo "<p>Nama Lengkap: " . session()->get('nama_lengkap') . "</p>";
        echo "<p>Logged In: " . (session()->get('logged_in') ? 'TRUE' : 'FALSE') . "</p>";
        
        echo "<hr>";
        echo "<p><a href='/petugas'>Ke Dashboard Petugas</a></p>";
        echo "<p><a href='/admin'>Ke Dashboard Admin</a></p>";
        echo "<p><a href='/auth/logout'>Logout</a></p>";
    }
}