<?php



namespace App\Http\Controllers;



use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

use DB;



class PagesController extends Controller

{



    public function getHome()

    {

        $results = DB::select('SELECT * FROM pages');



        $home = (count($results)) ? $results[0]->home_page : '';

        $home2 = (count($results)) ? $results[0]->home_page_about : '';



        return view('pages.home', [

                'home' => $home,

                'home2' => $home2

            ]);

       

    }

    

    public function getAboutus()

    {

        $results = DB::select('SELECT * FROM pages');

        $about = (count($results)) ? $results[0]->about_us : '';

        return view('pages.aboutus', [

                'about' => $about

            ]);

    }



    public function getTermsuse()

    {

        $results = DB::select('SELECT * FROM pages');

        $terms_use = (count($results)) ? $results[0]->terms_use : '';

        return view('pages.terms-use', [

                'terms_use' => $terms_use

            ]);

        

    }



    public function contact(Request $request)

    {

     

        \Mail::send('emails.contact',

        array(

            'name' => $request->get('name'),

            'email' => $request->get('email'),

            'user_message' => $request->get('message')

        ), function($message) use ($request)

        {               

            $message->from($request->get('email'));

            $message->to('admin@blood-academy.com', 'Admin')->subject('Test');

        });

         return \Redirect::route('public.home')

        ->with('message', 'Thanks for contacting us!');



    }



    public function contactPage(Request $request)

    {

     

        \Mail::send('emails.contact',

        array(

            'name' => $request->get('name'),

            'email' => $request->get('email'),

            'user_message' => $request->get('message')

        ), function($message) use ($request)

        {               

            $message->from($request->get('email'));

            $message->to('admin@blood-academy.com', 'Admin')->subject('Test');

        });

         return \Redirect::route('public.contact-us')

        ->with('message', 'Thanks for contacting us!');



    }



    public function ExplorePage()

    {

        return view('pages.explore-page');

    }



    public function getUsername()

    {

        return view('pages.username');

    }



    public function getContactus() 

    {

        return view('pages.contactus');

    }



    public function resetUsername(Request $request)

    {

        $email = $request->get('email');

        $user = DB::table('users')->where('email',  $email)->first();

        if ($user) {



            \Mail::send('emails.username',

            array(

                'name' => $user->first_name,

                'username' => $user->username,

            ), function($message) use ($user)

            {               

                $message->from('admin@blood-academy.com',  'Blood Academy');

                $message->to($user->email, $user->first_name)->subject('Username');

            });

            return \Redirect::route('public.getusername')

            ->with('alert-success', 'please check your email to reset your password');



        }else{

            $request->session()->flash('alert-warning', 'User not found!');

            return redirect()->route('public.getusername');

        }

        



    }



    public function pricingPage()

    {

        return view('pages.pricing');

    }

}