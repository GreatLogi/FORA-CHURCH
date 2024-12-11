<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.pages.account.index');
    }
}
