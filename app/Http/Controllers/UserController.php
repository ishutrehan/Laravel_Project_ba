<?php



namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;

use App\Models\User;

use DB;

use Session;

use Illuminate\Support\Facades\Validator;



class UserController extends Controller

{



    public function getHome()

    {

        return view('panels.user.home');

    }



    public function getPayments()

    {

        $user = Auth::user();

        $payments = DB::table('payment_details')

            ->select('*')

            ->where('user_id', '=', $user->id)

            ->get();



        return view('panels.user.payments',['payments' => $payments]);



    }



    public function getProtected()

    {

        $results = DB::select('SELECT * FROM recent_updates');

        

        return view('panels.user.protected',[

                'results' => $results

            ]);

    }



    public function verifyAccount()

    {

        return view('panels.user.verify');

    }



    public function getMcqEmqOpt() 

    {    

        $results = DB::select('SELECT * FROM information');

        $mcq_emq = (count($results)) ? $results[0]->mcq_emq : '';

      

        return view('panels.user.mcq-options', [

                'mcq_emq' => $mcq_emq

            ]);

    }



    public function getSubscribeForm() 

    {

        return view('panels.user.subscription');

    }



    public function getPaymentPage() 

    {

        return view('panels.user.subscription');

    }



    public function stripePayment(Request $request) 

    {   



        \Stripe\Stripe::setApiKey ( 'sk_test_i3qaZ1AEm1fLnvze8Mz7SMRO' );

        try {

            $charge = \Stripe\Charge::create ( array (

                    "amount" => 60,

                    "currency" => "GBP",

                    "source" => $request->input( 'stripeToken' ), 

                    "description" => "Test payment." 

            ) );

            $id = Auth::user()->id;

        

            $customer_array = $charge->__toArray(true);

            

            $user_payment = DB::table('payment_details')->where('user_id', $id)->first();

            if(count($user_payment)) {

                $affected = DB::table('payment_details')

                    ->where('user_id', $id)

                    ->update([ 'data'=> serialize($customer_array)]);

            }else{

                DB::insert('INSERT INTO payment_details (user_id, data) VALUES (?, ?)', [ $id, serialize( $customer_array ) ] );

            }



            $in_date = date('Y-m-d', strtotime('+4 months'));

            $user = User::find($id);

            $user->expire_at = $in_date;

            $user->subscription = 1;

            $user->save();



            $user = Auth::user();

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





            $request->session()->flash('success-message', 'Payment done successfully!');



            return redirect()->route('user.home');

            

        } catch ( \Stripe\Error\Card $e ) {

            $request->session()->flash('fail-message', 'Error! Please Try again.');

            return redirect()->back();

        }

    }



    public function getMcqQues( Request $request)

    {

        $id = Auth::user()->id;       

        $que = 'all';

        $sql  = "";   

        if(($request->get('ques-type') || $request->get('subject')) && ($request->get('ques-type') != 'mcqs-emqs' || $request->get('subject'))) {

            $sql .= "WHERE";

        }

        if($request->get('ques-type')  != 'mcqs-emqs') {

            if($request->get('ques-type')) {

                $type = ($request->get('ques-type') == 'mcqs') ? 'multiple' : 'single';

                $sql .= " `type`='".$type."' ";

            }

            if($request->get('ques-type') && $request->get('subject')) {

                $sql .= "AND";

            }

        }

        if($request->get('subject')) {

            $subjects = implode("','", $request->get('subject'));

            $sql .= " `subject` IN('".$subjects."') ";

        }

        

        if($request->get('questions')) {

            $que = $request->get('questions');

        }



        $index = 0; 

        $dt = date("U");



        $results = DB::select('SELECT * FROM mcq_emq '.$sql);



        $user_id = Auth::user()->id; 

        $user_questions = DB::table('user_questions')->where(['type'=>'mcq', 'user_id'=> $user_id])->first();

        //

         

        if($request->get('ques-seen') == 'new' && count($user_questions)){

            $ids = explode(',', $user_questions->question_ids);

            foreach ($results as $key=>$value) {

                if (in_array($value->id, $ids)) {

                    unset($results[$key]);

                }

            }            

        }



        if(!count($results)){

            $request->session()->flash('alert-success', 'No questions found for these options!');

            return redirect()->route('subscription.exam-mcq-emq-opt');

        }



        if($que != 'all') {

            if(count($results) <= $que){

              $que = count($results);

            }

            $results = array_slice($results, 0, $que);

        }



        $questype = ($request->get('ques-type')) ? $request->get('ques-type') : '';

        $type = 'mcqs emqs';

        $subject = ($request->get('subject')) ? implode(',', $request->get('subject')) : '';



          

        DB::insert('INSERT INTO user_tests (uid, user_id, data, type, qtype, subject) VALUES (?, ?, ?, ?, ?, ?)', [ $dt, $id, serialize($results), $type, $questype,  $subject ] );



        $request->session()->put('total_ques', count($results));

        Session::forget('user.tests');



        $notes = DB::select('SELECT * FROM user_revision WHERE user_id='.$user_id.' AND qid='.$results[$index]->id);

        $results[$index]->notes = $notes;

        

        return view('panels.user.test-page-mcq', [

                'result' => $results[$index],

                'index' => $index,

                'dt' => $dt,

                'showans' => $request->get('show-ans'),

                'questype' => $request->get('ques-type'),

            ]);

    }



    public function McqQuesPage(Request $request)

    {

        $uid = $request->get('dt');

        $index = $request->get('index');

        $user_id = Auth::user()->id;  

        $tests = DB::table('user_tests')

            ->select('*')

            ->where('uid', '=', $uid)

            ->first();



        if( !$request->get('skip') && $request->get('showans') == 'ans_end') {

            $arr = $this->checkQue($request);            

            Session::push('user.tests', $arr);

            Session::save();

        } 



        $index = $index + 1;

        $un_date = unserialize($tests->data);

        if(!isset($un_date[$index])) {

            $test_result = Session::get('user.tests');

            return view('panels.user.final-mcq', [

                'results' => $test_result,   

                'tests' => $un_date,   

            ]);

        }

        $results2 = $un_date[$index];



        $notes = DB::select('SELECT * FROM user_revision WHERE user_id='.$user_id.' AND qid='.$results2->id);

        $results2->notes = $notes;

        return view('panels.user.test-page-mcq', [

                'result' => $results2,

                'index' => $index,

                'dt' => $uid,

                'showans' => $request->get('showans'),

                'questype' => $request->get('questype'),

            ]);

    }



    public function saveNote(Request $request)

    {

        $form_data = $request->all(); 

        $user_id = Auth::user()->id;

        $dt = date("U");

        $my_file =  $dt.'.txt';

        $handle = fopen('uploads/notes/'.$my_file, 'w') or die('Cannot open file:  '.$my_file);

        $data = $form_data['text'];

        fwrite($handle, $data);

        fclose($handle);


        $id = 0;
        if(!empty($form_data['text'])) {
            $id = DB::insert('INSERT INTO user_revision (user_id, uid, revision, qid) VALUES (?, ?, ?, ?)', [ $user_id, $dt, $form_data['text'], $form_data['qid'] ] );
            $id = DB::select('SELECT id FROM user_revision WHERE uid='.$dt);
            $id = (count($id)) ? $id[0]->id : 0; 
        }

        $ky = '/uploads/notes/'.$my_file;
        return json_encode(array('key'=> $ky , 'id'=> $id ));

    }



    public function checkQuestion(Request $request)

    {   



        $arr = $this->checkQue($request);

        $user_id = Auth::user()->id;  

        $form_data = $request->all();

        if (count($arr)) {   

            if($request->get('questype') == 'mcqs') { 

                $arr2 = array(); 

                foreach ($arr as $key => $va) {

                    if ($va['key'] == $va['uans']) {

                        $right = ($va['value'] == 'yes') ? 'yes' : 'no';

                        array_push($arr2, array('key'=> $va['key'], 'value'=> $va['value'], 'qid' => $va['qid']));

                    }

                }

                Session::push('user.tests', $arr2);

                Session::save();

            }else{
                
                Session::push('user.tests', $arr);

                Session::save();
            }

        }



        $user_questions = DB::table('user_questions')->where(['user_id' => $user_id, 'type'=> 'mcq'])->first();

        

        if(count($user_questions)) {

            $q = $user_questions->question_ids.",".$request->get('qid');

            $affected = DB::table('user_questions')

                ->where(['user_id' => $user_id, 'type'=> 'mcq'])

                ->update([ 'question_ids'=> $q]);

        }else{

            DB::insert('INSERT INTO user_questions (user_id, question_ids, type) VALUES (?, ?, ?)', [ $user_id, $request->get('qid') , 'mcq'] );

        }

        return response()->json($arr);

       

    }



    public function checkQue($request)

    {

        $arr = array();

        $uid = $request->get('dt');  

          

        $test = DB::table('user_tests')

            ->select('*')

            ->where('uid', '=', $uid)

            ->first();



        $data = unserialize($test->data);



       

        foreach ($data as $key => $que) {

            if($que->id == $request->get('qid') ) {

                $ques_ans = unserialize(base64_decode($que->data));

                $user_ans = $request->get('que_ans');

                if (count($user_ans)) {

                    if($request->get('questype') == 'emqs') {                      

                        foreach ($user_ans as $key=>$val) {                           

                            $right = (isset($ques_ans[$key][$val][2])) ? 'yes' : 'no';

                            array_push($arr, array('key'=> $key, 'value'=> $right, 'qid' => $request->get('qid')));

                        }                        

                    }else{

                        foreach ($ques_ans as $key => $val) {                          

                            $right = (isset($ques_ans[$key][1])) ? 'yes' : 'no';

                            array_push($arr, array('key'=> $key, 'value'=> $right, 'uans'=> $user_ans[0], 'qid' => $request->get('qid')));

                        }

                        // foreach ($user_ans as $val) {

                        //     $right = (isset($ques_ans[$val][1])) ? 'yes' : 'no';

                        //     array_push($arr, array('key'=> $val, 'value'=> $right, 'qid' => $request->get('qid')));

                        // }

                    }

                }

            }

        }

        return $arr;        

    }



    // Essay type ques

    public function getEssayOpt(Request $request)

    {

        $results = DB::select('SELECT * FROM information');

        $essay = (count($results)) ? $results[0]->essay : '';



        $general = DB::table('essay')

            ->select('*')

            ->where('subject', '=', 'general-haematology')

            ->get();

        $transfusion = DB::table('essay')

            ->select('*')

            ->where('subject', '=', 'transfusion')

            ->get();

        $haemato = DB::table('essay')

            ->select('*')

            ->where('subject', '=', 'haemato-oncology')

            ->get(); 

        $haemastasis = DB::table('essay')

            ->select('*')

            ->where('subject', '=', 'haemastasis-thrombosis')

            ->get();  



        return view('panels.user.essay-options', [

                'general'     => $general,

                'transfusion' => $transfusion,

                'haemato'     => $haemato,

                'haemastasis' => $haemastasis,

                'essay' => $essay

            ]);

    }



    public function getEssayQues(Request $request)

    {



        $main = array();

        $user_id = Auth::user()->id;  

        $index = 0; 

        $dt = date("U");



        $arr = array();

        if($request->get('general-haematology')){

            array_push($arr, $request->get('general-haematology'));

        }

        if($request->get('transfusion')){

            array_push($arr, $request->get('transfusion'));

        }

        if($request->get('haemato-oncology')){

            array_push($arr, $request->get('haemato-oncology'));

        }

        if($request->get('haemastasis-thrombosis')){

            array_push($arr, $request->get('haemastasis-thrombosis'));

        }



        $ids = implode(',', $arr);

        $main = DB::select('SELECT * FROM `essay` WHERE `id` IN("'.$ids.'")');      



        if(!count($main)){

            $request->session()->flash('alert-success', 'No questions found for these options!');

            return redirect()->route('subscription.exam-essay-questions');

        }



        $type = 'essay';

        $keys = array_keys($request->all());

        $subject = (isset($keys[1])) ? $keys[1] : '';



        DB::insert('INSERT INTO user_tests (uid, user_id, data, type, subject) VALUES (?, ?, ?, ?, ?)', [ $dt, $user_id, serialize($main), $type, $subject ] );

        

        $request->session()->put('total_ques', count($main));

        Session::forget('user.tests');

        

        return view('panels.user.test-page-essay', [

                'result' => $main[$index],

                'index' => $index,

                'dt' => $dt

            ]);

        

    }



    public function EssayQuesPage(Request $request)

    {      

        $uid = $request->get('dt');

        $qid = $request->get('qid');



        $tests = DB::table('user_tests')

            ->select('*')

            ->where('uid', '=', $uid)

            ->first();



        $result = array();

        $test_ques = unserialize($tests->data);

        foreach ($test_ques as $key => $value) {

            if ($value->id == $qid) {

               $result = $value;

            }

        }



        return view('panels.user.test-page-essay-ans', [

            'result' => $result,

            'answer' => $request->get('answer'),

            'index' => $request->get('index'),

            'dt' => $uid

        ]);



    }



    public function getMorphologyOpt() 

    {

        $results = DB::select('SELECT * FROM information');

        $morphology = (count($results)) ? $results[0]->morphology : '';



        return view('panels.user.morphology-options', [

                'morphology' => $morphology

            ]);

    }



    public function getMorphologyQues(Request $request)

    {



        $id = Auth::user()->id;       

        $que = 'all';

        $sql  = "";   

        $index = 0; 

        $dt = date("U");



        if($request->get('q_type') == 'short-cases' || $request->get('q_type') == 'long-cases') {

            $type = $request->get('q_type');

            $sql .= " WHERE `type`='".$type."' ";

        }

        if($request->get('q_type') == 'short-long') {

            $type = $request->get('q_type');

            $sql .= " WHERE `type` IN ('short-cases','long-cases','short-long') ";

        }



        if($request->get('no_ques')) {

            $que = $request->get('no_ques');

        }

        

        $results = DB::select('SELECT * FROM `morphology` '.$sql);

        

        if(!count($results)){

            $request->session()->flash('alert-success', 'No questions found for these options!');

            return redirect()->route('subscription.exam-morphology');

        }        



        $user_id = Auth::user()->id; 

        $user_questions = DB::table('user_questions')->where(['type'=>'morphology', 'user_id'=> $user_id])->first();

        // 

      

        if($request->get('q_seen') == 'not_seen' && count($user_questions)){

            $ids = explode(',', $user_questions->question_ids);

            foreach ($results as $key=>$value) {

                if (in_array($value->id, $ids)) {

                    unset($results[$key]);

                }

            }            

        }



        if($que != 'all') {

            if(count($results) <= $que) {

                $que = count($results);

            }                

            $results = array_slice($results, 0, $que);

        }





        if(!count($results)){

            $request->session()->flash('alert-success', 'No questions found for these options!');

            return redirect()->route('subscription.exam-morphology');

        }

        

      

        $questype = ($request->get('q_type')) ? $request->get('q_type') : '';

        $type = 'morphology';      



        DB::insert('INSERT INTO user_tests (uid, user_id, data, type, qtype) VALUES (?, ?, ?, ?, ?)', [ $dt, $id, serialize($results), $type, $questype ] );

        

        $request->session()->put('total_ques', count($results));

        Session::forget('user.tests');



        $user_questions = DB::table('user_questions')->where(['user_id' => $id, 'type'=> 'morphology'])->first();

        

        if(count($user_questions)) {

            $q = $user_questions->question_ids.",".$results[$index]->id;

            $affected = DB::table('user_questions')

                ->where(['user_id' => $user_id, 'type'=> 'morphology'])

                ->update([ 'question_ids'=> $q]);

        }else{

            DB::insert('INSERT INTO user_questions (user_id, question_ids, type) VALUES (?, ?, ?)', [ $id, $results[$index]->id, 'morphology'] );

        }





        return view('panels.user.test-page-morphology', [

                'result' => $results[$index],

                'index' => $index,

                'dt' => $dt,

                'ans_after' => $request->get('ans_after'),

                'q_type' => $request->get('q_type'),

            ]);



    }



    public function MorphologyQuesPage(Request $request)

    {

        $uid = $request->get('dt');

        $index = $request->get('index');

        $user_id = Auth::user()->id;  

        $tests = DB::table('user_tests')

            ->select('*')

            ->where('uid', '=', $uid)

            ->first();



        $index = $index;

        $un_date = unserialize($tests->data);

        

        if(!isset($un_date[$index])) {

            $test_result = Session::get('user.tests');

            return view('panels.user.final-morphology', [

                'results' => $test_result   

            ]);

        }

        $results2 = $un_date[$index];

        

        if ( $request->get('skip') || $request->get('ans_after') == 'end' ) {

            $index = $index + 1;

            if(!isset($un_date[$index])) {

                $test_result = Session::get('user.tests');

                return view('panels.user.final-morphology', [

                    'results' => $test_result   

                ]);

            }

            $results2 = $un_date[$index]; 

            return view('panels.user.test-page-morphology', [

                'result' => $results2,

                'index' => $index,

                'dt' => $uid,

                'ans_after' => $request->get('ans_after'),

                'q_type' => $request->get('q_type'),

                'ans' => $request->get('ans'),

            ]);

        }



        return view('panels.user.test-page-morphology-ans', [

                'result' => $results2,

                'index' => $index,

                'dt' => $uid,

                'ans_after' => $request->get('ans_after'),

                'q_type' => $request->get('q_type'),

                'ans' => $request->get('ans'),

            ]);



    }



    public function MorphologyQuesNextPage(Request $request)

    {



        $uid = $request->get('dt');

        $index = $request->get('index');

        $user_id = Auth::user()->id;  

        $tests = DB::table('user_tests')

            ->select('*')

            ->where('uid', '=', $uid)

            ->first();



        $index = $index;

        $un_date = unserialize($tests->data);

        if(!isset($un_date[$index])) {

            $test_result = Session::get('user.tests');

            return view('panels.user.final-morphology', [

                'results' => $test_result   

            ]);

        }

        $results2 = $un_date[$index];





        $user_questions = DB::table('user_questions')->where(['user_id' => $user_id, 'type'=> 'morphology'])->first();

        

        if(count($user_questions)) {

            $q = $user_questions->question_ids.",".$results2->id;

            $affected = DB::table('user_questions')

                ->where(['user_id' => $user_id, 'type'=> 'morphology'])

                ->update([ 'question_ids'=> $q]);

        }else{

            DB::insert('INSERT INTO user_questions (user_id, question_ids, type) VALUES (?, ?, ?)', [ $user_id, $results2->id, 'morphology'] );

        }



        return view('panels.user.test-page-morphology', [

                'result' => $results2,

                'index' => $index,

                'dt' => $uid,

                'ans_after' => $request->get('ans_after'),

                'q_type' => $request->get('q_type')

            ]);



    }



    public function getQualityAssuranceOpt(Request $request)

    {

        $general = DB::table('quality_assurance')

            ->select('*')

            ->where('subject', '=', 'general-haematology')

            ->get();



        $transfusion = DB::table('quality_assurance')

            ->select('*')

            ->where('subject', '=', 'transfusion')

            ->get();



        $haemastasis = DB::table('quality_assurance')

            ->select('*')

            ->where('subject', '=', 'haemastasis-thrombosis')

            ->get();



        $results = DB::select('SELECT * FROM information');

        $quality_assurance = (count($results)) ? $results[0]->quality_assurance : '';

 



        return view('panels.user.quality-assurance-options', [

                'general'     => $general,

                'transfusion' => $transfusion,

                'haemastasis' => $haemastasis,

                'quality_assurance' => $quality_assurance 

            ]);

       

    }





    public function getQualityAssuranceQues(Request $request)

    {

  

        $main = array();

        $user_id = Auth::user()->id;  

        $index = 0; 

        $dt = date("U");



        $arr = array();

        if($request->get('general-haematology')){

            array_push($arr, $request->get('general-haematology'));

        }

        if($request->get('transfusion')){

            array_push($arr, $request->get('transfusion'));

        }     

        if($request->get('haemastasis-thrombosis')){

            array_push($arr, $request->get('haemastasis-thrombosis'));

        }



        $ids = implode(',', $arr);

        $main = DB::select('SELECT * FROM `quality_assurance` WHERE `id` IN("'.$ids.'")');      





        if(!count($main)){

            $request->session()->flash('alert-success', 'No questions found for these options!');

            return redirect()->route('subscription.exam-quality-assurance');

        }



        $type = 'quality assurance';

        $keys = array_keys($request->all());

        $subject = (isset($keys[1])) ? $keys[1] : '';



        DB::insert('INSERT INTO user_tests (uid, user_id, data, type, subject) VALUES (?, ?, ?, ?, ?)', [ $dt, $user_id, serialize($main) , $type, $subject ] );

        

        $request->session()->put('total_ques', count($main));

        Session::forget('user.tests');



        return view('panels.user.test-page-quality-assurance', [

                'result' => $main[$index],

                'index' => $index,

                'dt' => $dt

            ]);



    }



    public function QualityAssuranceQuesPage(Request $request)

    {



        $uid = $request->get('dt');

        $index = $request->get('index');

        $qid = $request->get('qid');

        $user_id = Auth::user()->id;  

        $tests = DB::table('user_tests')

            ->select('*')

            ->where('uid', '=', $uid)

            ->first();



        $index = $index;

        $un_date = unserialize($tests->data);



        $results2 = $un_date[$index];

        

        return view('panels.user.test-page-quality-assurance-ans', [

                'result' => $results2,

                'index' => $index,

                'dt' => $uid,

                'ans' => $request->get('ans'),

            ]);



    }





    // 

    public function getTransfusionOpt(Request $request)

    {

        $results = DB::select('SELECT * FROM information');

        $transfusion = (count($results)) ? $results[0]->transfusion : '';

 

        return view('panels.user.transfusion-options', [

            'transfusion' => $transfusion 

        ]);

    }



    

    public function TransfusionQuesPage(Request $request)

    {



        $id = Auth::user()->id;       

        $que = 'all';

        $sql  = "";   

        $index = 0; 

        $dt = date("U");

        $results = DB::select('SELECT * FROM `transfusion` ');

        if(!count($results)){

            $request->session()->flash('alert-success', 'No questions found for these options!');

            return redirect()->route('subscription.exam-transfusion');

        }



        $user_id = Auth::user()->id; 

        $user_questions = DB::table('user_questions')->where(['type'=>'transfusion', 'user_id'=> $user_id])->first();

        // 

      

        if($request->get('q_seen') == 'not_seen' && count($user_questions)){

            $ids = explode(',', $user_questions->question_ids);

            foreach ($results as $key=>$value) {

                if (in_array($value->id, $ids)) {

                    unset($results[$key]);

                }

            }            

        }



        if($request->get('questions')) {

            $que = $request->get('questions');

        }



        if ($que != 'all') { 

            if(count($results) <= $que) {

                $que = count($results);

            }                    

            $results = array_slice($results, 0, $que);

        }





        if(!count($results)){

            $request->session()->flash('alert-success', 'No questions found for these options!');

            return redirect()->route('subscription.exam-transfusion');

        }

        

   

        $type = 'transfusion';

      

        DB::insert('INSERT INTO user_tests (uid, user_id, data, type) VALUES (?, ?, ?, ?)', [ $dt, $id, serialize($results), $type ] );

        

        $request->session()->put('total_ques', count($results));

        Session::forget('user.tests');

        

        if(count($user_questions)) {

            $q = $user_questions->question_ids.",".$results[$index]->id;

            $affected = DB::table('user_questions')

                ->where(['user_id' => $user_id, 'type'=> 'transfusion'])

                ->update([ 'question_ids'=> $q]);

        }else{

            DB::insert('INSERT INTO user_questions (user_id, question_ids, type) VALUES (?, ?, ?)', [ $id, $results[$index]->id, 'transfusion'] );

        }





        return view('panels.user.test-page-transfusion', [

                'result' => $results[$index],

                'index' => $index,

                'dt' => $dt,

                'ans_after' => $request->get('ans_after')

            ]);



    }



    public function TransfusionQues(Request $request)

    {

        $uid = $request->get('dt');

        $index = $request->get('index');

        $qid = $request->get('qid');

        $user_id = Auth::user()->id;  

        $tests = DB::table('user_tests')

            ->select('*')

            ->where('uid', '=', $uid)

            ->first();



        $index = $index;

        $un_date = unserialize($tests->data);



        $results2 = $un_date[$index];

      

        if ($request->get('skip') || $request->get('ans_after') == 'end' ) {

            $index = $index + 1;

            if(!isset($un_date[$index])) {

                $test_result = Session::get('user.tests');

                return view('panels.user.final-transfusion', [

                    'results' => $test_result   

                ]);

            }

            $results2 = $un_date[$index]; 

            return view('panels.user.test-page-transfusion', [

                'result' => $results2,

                'index' => $index,

                'dt' => $uid,

                'ans_after' => $request->get('ans_after'),

                'ans' => $request->get('ans'),

            ]);

        }

        

        return view('panels.user.test-page-transfusion-ans', [

                'result' => $results2,

                'index' => $index,

                'dt' => $uid,

                'ans' => $request->get('ans'),

                'ans_after' => $request->get('ans_after'),

            ]);

    }



    public function TransfusionQuesNextPage(Request $request)

    {

        $uid = $request->get('dt');

        $index = $request->get('index');

        $user_id = Auth::user()->id;  

        $tests = DB::table('user_tests')

            ->select('*')

            ->where('uid', '=', $uid)

            ->first();



        $index = $index;

        $un_date = unserialize($tests->data);

        if(!isset($un_date[$index])) {

            $test_result = Session::get('user.tests');

            return view('panels.user.final-transfusion', [

                'results' => $test_result   

            ]);

        }

        $results2 = $un_date[$index];





        // $user_questions = DB::table('user_questions')->where(['user_id' => $user_id, 'type'=> 'morphology'])->first();

        

        // if(count($user_questions)) {

        //     $q = $user_questions->question_ids.",".$results2->id;

        //     $affected = DB::table('user_questions')

        //         ->where(['user_id' => $user_id, 'type'=> 'morphology'])

        //         ->update([ 'question_ids'=> $q]);

        // }else{

        //     DB::insert('INSERT INTO user_questions (user_id, question_ids, type) VALUES (?, ?, ?)', [ $user_id, $results2->id, 'morphology'] );

        // }

           return view('panels.user.test-page-transfusion', [

                'result' => $results2,

                'index' => $index,

                'dt' => $uid,

                'ans_after' => $request->get('ans_after')

            ]); 



    }



    public function editProfilePage() {



        $user_id = Auth::user()->id;  

        $user = User::find($user_id);

        return view('panels.user.edit-profile', ['user'=> $user]);



    }



    public function updateUser(Request $request)

    {

        $requestData = $request->all();

        if($requestData['email']) {

            $rules = array(

                'email'            => 'required|email|unique:users',

            );

            $data = array(

                'email' => $requestData['email']

            );

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {          

                return redirect('user/edit-profile')

                        ->withErrors($validator);

            } else { 

                $user_id = Auth::user()->id;  

                $user = User::find($user_id);

                $user->email = $requestData['email'];

                $user->username = $requestData['email'];

                $user->save();

                $request->session()->flash('alert-success', 'User updated successfully!');

                return redirect()->route('user.edit-profile');



            }

        }

    }



    public function updateUserPass(Request $request)

    {

       

        $requestData = $request->all();

        $rules = array(

            'password'              => 'required|min:6|max:20',

            'password_confirmation' => 'required|same:password',

        );

        $data = array(

            'password' => $requestData['password'],

            'password_confirmation' => $requestData['password_confirmation']

        );

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {          

            return redirect('user/edit-profile')

                        ->withErrors($validator);

        }else{

            $user_id = Auth::user()->id;  

            $user = User::find($user_id);

            $user->password = bcrypt($requestData['password']);

            $user->save();

            $request->session()->flash('alert-success', 'User updated successfully!');

            return redirect()->route('user.edit-profile');

        }

    }



    public function invoicePage()

    {

        $id = Route::input('pid');

        $user = Auth::user();



        $payment = DB::table('payment_details')

            ->select('*')

            ->where('user_id', '=', $user->id)

            ->where('id', '=', $id)

            ->get();



        return view('panels.user.invoice', [

            'payment' => $payment,

            'user' => $user

        ]);

    }



}