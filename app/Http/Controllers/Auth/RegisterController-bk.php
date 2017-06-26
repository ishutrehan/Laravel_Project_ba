<?php

namespace App\Http\Controllers\Auth;

use App\Traits\CaptchaTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Traits\ActivationTrait;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth; 
use DB;

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

    use RegistersUsers, ActivationTrait, CaptchaTrait;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('guest');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        $data['captcha'] = $this->captchaCheck();

        $validator = Validator::make($data,
            [
                'first_name'            => 'required',
                'email'                 => 'required|email|unique:users',
                'password'              => 'required|min:6|max:20',
                'password_confirmation' => 'required|same:password',
                'g-recaptcha-response'  => 'required',
                'captcha'               => 'required|min:1',
                'username'              => 'required|unique:users',
                'city'                  => 'required',
            ],
            [
                'first_name.required'   => 'First Name is required',
                'email.required'        => 'Email is required',
                'email.email'           => 'Email is invalid',
                'password.required'     => 'Password is required',
                'password.min'          => 'Password needs to have at least 6 characters',
                'password.max'          => 'Password maximum length is 20 characters',
                'g-recaptcha-response.required' => 'Captcha is required',
                'captcha.min'           => 'Wrong captcha, please try again.',
                'username.required'     => 'Username is required',
                'city.required'         => 'City is required',
            ]
        );

        return $validator;

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        // Payment        
        \Stripe\Stripe::setApiKey ( 'sk_test_i3qaZ1AEm1fLnvze8Mz7SMRO' );
        try {
            $charge = \Stripe\Charge::create ( array (
                    "amount" => 300,
                    "currency" => "usd",
                    "source" => $data['stripeToken'], 
                    "description" => "Test payment." 
            ) );

            $user =  User::create([
                'first_name' => $data['first_name'],
                'current_hospital' => $data['current_hospital'],
                'country_residence' => $data['country_residence'],
                'haematology' => $data['haematology'],
                'username' => $data['username'],
                'city' => $data['city'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'token' => str_random(64),
                'activated' => !config('settings.activation')
            ]);

            $role = Role::whereName('user')->first();
            $user->assignRole($role);

            $this->initiateEmailActivation($user);

            $id = $user->id;
            $customer_array = $charge->__toArray(true);            
            $user_payment = DB::table('payment_details')->where('user_id', $id)->first();
            if(count($user_payment)) {
                $affected = DB::table('payment_details')
                    ->where('user_id', $id)
                    ->update([ 'data'=> serialize($customer_array)]);
            }else{
                DB::insert('insert into payment_details (user_id, data) values (?, ?)', [ $id, serialize( $customer_array ) ] );
            }

            $in_date = date('Y-m-d', strtotime('+4 months'));
            $new_user = User::find($id);
            $new_user->expire_at = $in_date;
            $new_user->subscription = 1;
            $new_user->save();

            $date =  date("Y-m-d");
            \Mail::send('emails.subscription',
                array(
                    'name' => $user->first_name,
                    'username' => $user->username,
                    'date' => $in_date,
                ), function($message) use ($user)
                {               
                    $message->from('admin@blood-academy.com');
                    $message->to($user->email, $user->first_name)->subject('Subscription');
                });
            
            return $user;
            
        } catch ( \Stripe\Error\Card $e ) {
            return redirect()->back();
        }
    }
}