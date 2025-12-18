<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class TestController extends BaseController
{
    public function index()
    {
        return "TEST BERHASIL! Controller bekerja.";
    }
}