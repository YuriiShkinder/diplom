<?php

namespace App\Http\Controllers\Auth;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SiteController;
use App\Repositories\CategoryRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    protected $username='login';
    protected $loginView;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->loginView = 'login';
    }

    public function redirectPath()
    {
        return Session::get('backUrl') ? Session::get('backUrl') : $this->redirectTo;
    }

    public function username()
    {
        return $this->username;
    }

    public function showLoginForm()
    {
        $view = property_exists($this, 'loginView')
            ? $this->loginView : '';

        if (view()->exists($view)) {
            if(URL::current()!==URL::previous()){
                Session::put('backUrl', URL::previous());
            }

            $obj=new SiteController(new CategoryRepository(new Category()));
            $obj->title='Вход на сайт';
            $obj->template=$view;

            return  response( $obj->renderOutput());
        }

        abort(404);
    }


}
