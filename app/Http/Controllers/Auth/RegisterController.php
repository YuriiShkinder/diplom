<?php

namespace App\Http\Controllers\Auth;

use App\Category;
use App\Http\Controllers\SiteController;
use App\Repositories\CategoryRepository;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->loginView = 'register';
    }

    public function redirectPath()
    {
        return Session::get('backUrl') ? Session::get('backUrl') : $this->redirectTo;
    }

    public function showRegistrationForm()
    {
        $view = property_exists($this, 'loginView')
            ? $this->loginView : '';

        if (view()->exists($view)) {
            if(URL::current()!==URL::previous()){
                Session::put('backUrl', URL::previous());
            }

            $obj=new SiteController(new CategoryRepository(new Category()));
            $obj->title='Регистрация';
            $obj->template=$view;

            return  response( $obj->renderOutput());
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'last' => 'required|string|max:255',
            'login' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'address' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([

            'last' => $data['last'],
            'login' => $data['login'],
            'phone' => $data['phone'],
            'img' => asset('assets/images/user.png'),
            'address' => $data['address'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
