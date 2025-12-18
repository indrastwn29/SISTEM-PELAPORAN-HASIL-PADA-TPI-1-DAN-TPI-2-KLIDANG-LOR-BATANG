<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface  // <-- PERUBAHAN: Auth (bukan AuthFilter)
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Silahkan login terlebih dahulu!');
            return redirect()->to(base_url('auth/login'));
        }

        // Check role if specified
        if (!empty($arguments)) {
            $role = session()->get('role');
            
            if (!in_array($role, $arguments)) {
                if ($role === 'admin') {
                    return redirect()->to(base_url('admin'));
                } elseif ($role === 'petugas') {
                    return redirect()->to(base_url('petugas'));
                } else {
                    return redirect()->to(base_url('auth/login'));
                }
            }
        }

        return $request;
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response;
    }
}