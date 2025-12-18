<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url', 'session']);
    }
    
    public function index()
    {
        return redirect()->to('auth/login');
    }
    
    public function login()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->get('logged_in')) {
            return $this->redirectBasedOnRole();
        }
        
        return view('auth/login', [
            'title' => 'Login - Sistem Karcis TPI'
        ]);
    }
    
    public function processLogin()
    {
        // Validasi input
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        // Validasi manual
        if (empty($username) || empty($password)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username dan password harus diisi');
        }
        
        try {
            // Cari user di tabel USERS
            $user = $this->userModel->where('username', $username)->first();
            
            if (!$user) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Username tidak ditemukan');
            }
            
            // Debug: lihat data user
            // echo "<pre>"; print_r($user); echo "</pre>"; die();
            
            // Verifikasi password
            if (!password_verify($password, $user['password'])) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Password salah');
            }
            
            // Set session data
            $sessionData = [
                'user_id'       => $user['id'],
                'username'      => $user['username'],
                'nama_lengkap'  => $user['nama_lengkap'] ?? $user['username'],
                'role'          => $user['role'] ?? 'petugas',
                'tpi_id'        => $user['tpi_id'] ?? 1,
                'logged_in'     => true,
            ];
            
            session()->set($sessionData);
            
            // Redirect berdasarkan role
            return $this->redirectBasedOnRole()
                ->with('success', 'Login berhasil! Selamat datang ' . ($user['nama_lengkap'] ?? $user['username']));
            
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Login gagal: ' . $e->getMessage());
        }
    }
    
    private function redirectBasedOnRole()
    {
        $role = session()->get('role') ?? 'petugas';
        
        if ($role === 'admin' || $role === 'superadmin') {
            return redirect()->to('/admin');
        } else {
            return redirect()->to('/petugas');
        }
    }
    
    public function logout()
    {
        // Clear session
        session()->destroy();
        
        // Redirect ke login
        return redirect()->to('/auth/login')
            ->with('success', 'Anda telah logout');
    }
    
    // Method untuk debug database
    public function debug()
    {
        echo "<h3>Debug Database Users</h3>";
        
        try {
            $db = \Config\Database::connect();
            echo "<p style='color:green;'>✓ Database connected</p>";
            
            // Cek tabel users
            $tables = $db->listTables();
            echo "<p>Tables: " . implode(', ', $tables) . "</p>";
            
            if (in_array('users', $tables)) {
                echo "<p style='color:green;'>✓ Table 'users' exists</p>";
                
                // Cek struktur tabel
                $fields = $db->getFieldData('users');
                echo "<h4>Table Structure:</h4>";
                echo "<table border='1' cellpadding='5'>";
                echo "<tr><th>Field</th><th>Type</th><th>Max Length</th></tr>";
                foreach ($fields as $field) {
                    echo "<tr>";
                    echo "<td>" . $field->name . "</td>";
                    echo "<td>" . $field->type . "</td>";
                    echo "<td>" . ($field->max_length ?? '-') . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                
                // Cek data users
                $users = $db->table('users')->get()->getResult();
                echo "<h4>User Data (" . count($users) . " users):</h4>";
                
                if (count($users) > 0) {
                    echo "<table border='1' cellpadding='5'>";
                    echo "<tr><th>ID</th><th>Username</th><th>Password Hash</th><th>Role</th><th>Nama Lengkap</th></tr>";
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . ($user->id ?? '-') . "</td>";
                        echo "<td>" . ($user->username ?? '-') . "</td>";
                        echo "<td>" . substr($user->password ?? '-', 0, 30) . "...</td>";
                        echo "<td>" . ($user->role ?? '-') . "</td>";
                        echo "<td>" . ($user->nama_lengkap ?? '-') . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p style='color:orange;'>No users found in table</p>";
                }
            } else {
                echo "<p style='color:red;'>✗ Table 'users' NOT found</p>";
                echo "<p>But found these tables: " . implode(', ', $tables) . "</p>";
            }
            
        } catch (\Exception $e) {
            echo "<p style='color:red;'>✗ Database error: " . $e->getMessage() . "</p>";
        }
        
        echo "<hr>";
        
        // Test login
        echo '<h4>Test Login:</h4>';
        echo '<form method="POST" action="' . base_url('auth/testLoginManual') . '">';
        echo 'Username: <input type="text" name="username" value="petugas"><br>';
        echo 'Password: <input type="password" name="password" value="Petugas12345"><br>';
        echo '<button type="submit">Test Login</button>';
        echo '</form>';
    }
    
    // Method untuk test login manual
    public function testLoginManual()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $user = $this->userModel->where('username', $username)->first();
        
        if (!$user) {
            echo "User '$username' not found!";
            return;
        }
        
        echo "<h3>Login Test for: $username</h3>";
        echo "<pre>";
        print_r($user);
        echo "</pre>";
        
        echo "<p>Password hash: " . $user['password'] . "</p>";
        echo "<p>Password verify: " . (password_verify($password, $user['password']) ? 'SUCCESS' : 'FAILED') . "</p>";
        
        if (password_verify($password, $user['password'])) {
            echo '<p style="color:green;">Login successful!</p>';
            echo '<a href="' . base_url('auth/login') . '">Go to Login Page</a>';
        }
    }
    
    // Method untuk route test-login
    public function testLogin($username = null)
    {
        if ($username) {
            // Simulate login for testing
            $user = $this->userModel->where('username', $username)->first();
            
            if ($user) {
                $sessionData = [
                    'user_id'       => $user['id'],
                    'username'      => $user['username'],
                    'nama_lengkap'  => $user['nama_lengkap'] ?? $user['username'],
                    'role'          => $user['role'] ?? 'petugas',
                    'tpi_id'        => $user['tpi_id'] ?? 1,
                    'logged_in'     => true,
                ];
                
                session()->set($sessionData);
                
                return "Test login successful for: " . $user['username'] . 
                       " <br><a href='/petugas'>Go to Dashboard</a>";
            }
        }
        
        return "Please specify username: /auth/test-login/username";
    }
    
    // Method untuk test login page
    public function testLoginPage()
    {
        return view('auth/test_login');
    }
}