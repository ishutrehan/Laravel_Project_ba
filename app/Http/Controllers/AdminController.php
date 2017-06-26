<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;

class AdminController extends Controller {

    public function getHome()
    {
        return view('panels.admin.home');
    }

    public function getMembers()
    {

    	$users = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftjoin('payment_details', 'payment_details.user_id', '=', 'users.id')
            ->select('users.*', 'role_user.user_id', 'role_user.role_id', 'payment_details.data')
            ->where('role_user.role_id', '=', 1)
            ->paginate(10);

        return view('panels.admin.members', ['users'=> $users]);
    }

    public function editMember() 
    {
    	
    	$user_id = Route::input('user_id');
    	$user = User::find($user_id);
        return view('panels.admin.edit-member', ['user'=> $user]);
    }

    public function updateMember(Request $request)
    {	
    	$user = User::find(Input::get('user_id'));
        $user->first_name = Input::get('name');
    	$user->last_name = Input::get('lname');
    	$user->current_hospital = Input::get('current_hospital');
    	$user->haematology = Input::get('haematology');
        $user->country_residence = Input::get('country_residence');
        $user->phone = Input::get('phone');
        $user->gender = Input::get('gender');		
        $user->save();
		
        $request->session()->flash('alert-success', 'User updated successfully!');
		return redirect()->route('admin.members');
    }

    public function addMember()
    {
        return view('panels.admin.add-member');
    }

    public function saveMember(Request $request)
    {
    	$requestData = $request->all();

    	$rules = array(
            'name'             => 'required|string',            
            'email'            => 'required|email|unique:users',
        );
        $data = array(
            'name' => $requestData['name'],
            'email' => $requestData['email']
        );

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {          
           return redirect('admin/add-user')
                        ->withErrors($validator);
        } else { 
	        
	    	$str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $password =  substr(str_shuffle(str_repeat($str, 5)), 0, 10);   
    		$unstr =  substr(str_shuffle(str_repeat($str, 5)), 0, 5);	

            $first_email = explode("@", $requestData['email']);
            $un_email = $first_email[0]."_".$unstr;
            
			$user =  User::create([
                'first_name' => $requestData['name'],
			    'last_name' => $requestData['lname'],
			    'current_hospital' => $requestData['current_hospital'],
                'country_residence' => $requestData['country_residence'],
                'phone' => $requestData['phone'],
			    'gender' => $requestData['gender'],
			    'haematology' => $requestData['haematology'],
			    'email' => $requestData['email'],
			    'password' => bcrypt($password),
                'username'=> $requestData['email'],
			    'token' => str_random(64),
			    'activated' => !config('settings.activation')
			]);


            \Mail::send('emails.newuser',
                array(
                    'name' => $user->first_name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'password' => $password,
                ), function($message) use ($user)
                {               
                    $message->from('admin@blood-academy.com');
                    $message->to($user->email, $user->first_name)->subject('New Register');
                });

			$role = Role::whereName('user')->first();
			$user->assignRole($role);
			$request->session()->flash('alert-success', 'User added successfully!');
			return redirect()->route('admin.members');

        }

    }

    public function deleteMember(Request $request)
    {
        $user_id = Route::input('user_id');
        $user = User::find($user_id);
        $user->delete();
        DB::table('role_user')->where('user_id', '=', $user_id)->delete();
        $request->session()->flash('alert-success', 'User deleted successfully!');
        return redirect()->route('admin.members');
    }

    public function deleteUpdates(Request $request)
    {
    	$rid = Route::input('rid');
		DB::table('recent_updates')->where('id', '=', $rid)->delete();
		$request->session()->flash('alert-success', 'Update deleted successfully!');
		return redirect()->route('admin.add-test');
    }

    public function cancelSubscription(Request $request)
    {
        $user_id = Route::input('id');
        $user = User::find($user_id);
        $user->expire_at = '';
        $user->subscription = 0;
        $user->save();
        $request->session()->flash('alert-success', 'Cancel membership successfully!');
        return redirect()->route('admin.members');
    }

    public function updateSubscription(Request $request) 
    {
        $data = $request->all();
        $user = User::find($data['user_id']);
        $user->expire_at = $data['date'];
        $user->subscription = 1;
        $user->save();
        $request->session()->flash('alert-success', 'Subscription updated successfully!');
        return redirect()->route('admin.members');
    }

    public function addTest()
    {
        $results = DB::table('recent_updates')
            ->select('recent_updates.*')
            ->paginate(15);

        return view('panels.admin.tests', [
                'results' => $results
            ]);
    }

    public function viewMcqEmq()
    {
        $results = DB::table('mcq_emq')->paginate(10);
        return view('panels.admin.mcq-emq', [
            'results' => $results
            ]);
    }

    public function addMcqEmq(Request $request)
    {
        $data = $request->all();
       
        if ($request->get('ans_type') == 'single') {
            $data['multiple_opts'] = $data['multiple_opts2'];
        }

        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/mcq';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }

        DB::insert('insert into mcq_emq (question, subject, type, data, images, discussion, reference) values (?, ?, ?, ?, ?, ?, ?)', [ base64_encode($data['question']), $data['subject'], $data['ans_type'], base64_encode(serialize($data['multiple_opts'])), implode(',', $file_names), base64_encode($data['discussion']), base64_encode($data['reference']) ] );
        $request->session()->flash('alert-success', 'Question added successfully!');
        return redirect()->route('admin.mcq-emq');
    }

    
    public function deleteQuestionmcq(Request $request)
    {
        $r_id = Route::input('r_id');
        DB::table('mcq_emq')->where('id', '=', $r_id)->delete();         
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.mcq-emq');
    }

    public function editQuestionMcq()
    {
        $r_id = Route::input('r_id');
        $mcq = DB::table('mcq_emq')->where('id',  $r_id)->first();
        return view('panels.admin.edit-mcq-emq', [
            'mcq' => $mcq
            ]);
    }
    
    public function updateMcqEmq(Request $request)
    {

        $data = $request->all();

        if ($request->get('ans_type') == 'single') {
            $data['multiple_opts'] = $data['multiple_opts2'];
        }

        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/mcq';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }
       
        $affected = DB::table('mcq_emq')
            ->where('id', $data['id'])
            ->update(['question' => base64_encode($data['question']), 'subject'=> $data['subject'], 'type'=> $data['ans_type'], 'data'=> base64_encode(serialize($data['multiple_opts'])), 'images'=>implode(',', $file_names), 'discussion'=> base64_encode($data['discussion']), 'reference' => base64_encode($data['reference']) ]);

        $request->session()->flash('alert-success', 'Question updated successfully!');
        return redirect()->route('admin.mcq-emq');


    }    

    public function viewEssayQuestions() {

        $results = DB::table('essay')->paginate(10);
        return view('panels.admin.essay-questions', [
            'results' => $results
            ]);
    }

    public function addEssayques(Request $request)
    {
        $data = $request->all();
      
        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/essay';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        // base64_decode(data)
        DB::insert('insert into essay (question, answer, images, discussion, subject, topic, reference) values (?, ?, ?, ?, ?, ?, ?)', [ base64_encode($data['question']), base64_encode($data['answer']), implode(',', $file_names), base64_encode($data['discussion']), $data['subject'], base64_encode($data['topic']), base64_encode($data['reference'])] );
        $request->session()->flash('alert-success', 'Question added successfully!');
        return redirect()->route('admin.essay-questions');
    }
    
    public function deleteQuestionEssay(Request $request)
    {
        $r_id = Route::input('r_id');
        DB::table('essay')->where('id', '=', $r_id)->delete();       
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.essay-questions');
    }

    public function editQuestionEssay(Request $request)
    {
        $r_id = Route::input('r_id');
        $essay = DB::table('essay')->where('id',  $r_id)->first();
        return view('panels.admin.essay-edit', [
            'essay' => $essay
            ]);
    }

    public function UpdateEssayques(Request $request)
    {
        $data = $request->all();
        $files = $request->file('file');

        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/essay';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }

        $affected = DB::table('essay')
            ->where('id', $data['id'])
            ->update(['question' => base64_encode($data['question']), 'answer'=> base64_encode($data['answer']), 'discussion'=>base64_encode($data['discussion']),'subject'=> $data['subject'], 'images'=>implode(',', $file_names), 'topic'=> base64_encode($data['topic']), 'reference'=> base64_encode($data['reference']) ]);

        $request->session()->flash('alert-success', 'Question Updated successfully!');
        return redirect()->route('admin.essay-questions');
    } 

    public function viewMorphology(Request $request)
    {
        $results = DB::table('morphology')->paginate(10);
        return view('panels.admin.morphology', [
            'results' => $results
            ]);
    }

    public function addMorphology(Request $request)
    {
        $file = $request->file('slide');
        $data = $request->all();

        $file_name = "";
        if($file) {
            $file_name = $file->getClientOriginalName();
            $file_ext = $file->getClientOriginalExtension();
            $file_name = date("U").'.'.$file_ext;
            $destinationPath = 'uploads';
            $file->move($destinationPath, $file_name);
        }

        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/morphology';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        $qdata = base64_encode(serialize($data['question']));

        DB::insert('insert into morphology (short_longcase, information, data, slide, images, discussion, type, pdf, reference) values (?, ?, ?, ?, ?, ?, ?, ?, ?)', [ base64_encode($data['short_longcase']), base64_encode($data['information']), $qdata, $file_name, implode(',', $file_names), base64_encode($data['discussion']), $data['subject'], $data['pdf'], base64_encode($data['reference'])  ] );
        $request->session()->flash('alert-success', 'Question added successfully!');
        return redirect()->route('admin.morphology');
    }

    public function deleteQuestionMorphology(Request $request)
    {
        $r_id = Route::input('r_id');
        DB::table('morphology')->where('id', '=', $r_id)->delete();       
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.morphology');
    }
       
    public function editQuestionMorphology(Request $request)
    {
        $r_id = Route::input('r_id');
        $morphology = DB::table('morphology')->where('id',  $r_id)->first();

        return view('panels.admin.morphology-edit', [
            'morphology' => $morphology
            ]);
    }

    
    public function updateMorphology(Request $request)
    {
        $file = $request->file('slide');
        $data = $request->all();
        $file_name = "";
        if($file) {
            $file_name = $file->getClientOriginalName();
            $file_ext = $file->getClientOriginalExtension();
            $file_name = date("U").'.'.$file_ext;
            $destinationPath = 'uploads/morphology';
            $file->move($destinationPath, $file_name);
        }

        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/morphology';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }

        $affected = DB::table('morphology')
            ->where('id', $data['id'])
            ->update(['short_longcase'=>base64_encode($data['short_longcase']), 'information'=>base64_encode($data['information']), 'data'=> base64_encode(serialize($data['question'])), 'slide'=> $file_name, 'images'=>implode(',', $file_names), 'discussion'=> base64_encode($data['discussion']), 'type'=> $data['subject'], 'pdf'=> $data['pdf'], 'reference'=> base64_encode($data['reference'])]);



        $request->session()->flash('alert-success', 'Question updated successfully!');
        return redirect()->route('admin.morphology');
    }


    public function viewQualityAssurance(Request $request)
    {
        $results = DB::table('quality_assurance')->paginate(10);
        return view('panels.admin.quality-assurance', [
                'results' => $results
            ]);
    }

    public function addQualityAssurance(Request $request)
    {
        $data = $request->all();

        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/quality-assurance';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }

        $qdata = base64_encode(serialize($data['question']));

        DB::insert('insert into quality_assurance(topic, data, discussion, images, subject, reference) values(?, ?, ?, ?, ?, ?)', [ base64_encode($data['topic']), $qdata, base64_encode($data['discussion']), implode(',', $file_names), $data['subject'], base64_encode($data['reference']) ] );
        $request->session()->flash('alert-success', 'Question added successfully!');
        return redirect()->route('admin.quality-assurance');
    }
    
    public function deleteQuestionQualityAssurance(Request $request)
    {
        $r_id = Route::input('r_id');
        DB::table('quality_assurance')->where('id', '=', $r_id)->delete();       
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.quality-assurance');
    }

    public function editQualityAssurance(Request $request)
    {
        $r_id = Route::input('r_id');
        $qualityassurance = DB::table('quality_assurance')->where('id',  $r_id)->first();
        return view('panels.admin.edit-quality-assurance', [
            'qualityassurance' => $qualityassurance
            ]);
    }

    public function updateQualityAssurance(Request $request)
    {
        $data = $request->all();
        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/quality-assurance';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }
        
        $affected = DB::table('quality_assurance')
            ->where('id', $data['id'])
            ->update(['topic'=> base64_encode($data['topic']), 'data'=> base64_encode(serialize($data['question'])), 'discussion' => base64_encode($data['discussion']), 'images'=>implode(',', $file_names), 'subject' => $data['subject'], 'reference' => base64_encode($data['reference']) ]);

        $request->session()->flash('alert-success', 'Question Updated successfully!');
        return redirect()->route('admin.quality-assurance');
    } 

    public function viewTransfusion(Request $request)
    {
        $results = DB::table('transfusion')->paginate(10);
        return view('panels.admin.transfusion', [
                'results' => $results
            ]);
    }

     
    public function addTransfusion(Request $request)
    {
        $data = $request->all();

        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/transfusion';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }

        $qdata = base64_encode(serialize($data['question']));

        DB::insert('insert into transfusion (qcase, information, data, discussion,  images, reference) values (?, ?, ?, ?, ?, ?)', [ base64_encode($data['qcase']), base64_encode($data['information']), $qdata, base64_encode($data['discussion']), implode(',', $file_names), base64_encode($data['reference']) ] );
            $request->session()->flash('alert-success', 'Question added successfully!');
            return redirect()->route('admin.transfusion');

    }

    public function deleteQuestionTransfusion(Request $request)
    {
        $r_id = Route::input('r_id');
        DB::table('transfusion')->where('id', '=', $r_id)->delete();       
        $request->session()->flash('alert-success', 'Deleted successfully!');
        return redirect()->route('admin.transfusion');
    }

    public function editTransfusion(Request $request)
    {
        $r_id = Route::input('r_id');
        $transfusion = DB::table('transfusion')->where('id',  $r_id)->first();
        return view('panels.admin.edit-transfusion', [
            'transfusion' => $transfusion
            ]);
    }

    public function updateTransfusion(Request $request)
    {
        $data = $request->all();
        
        $files = $request->file('file');
        $file_names = array();
        if(count($files)) {
            foreach ($files as $key => $file) {
                if($file) {
                    $file_name = $file->getClientOriginalName();
                    $file_ext = $file->getClientOriginalExtension();
                    $file_name = date("U").rand(10,99).'.'.$file_ext;
                    $destinationPath = 'uploads/transfusion';
                    $file->move($destinationPath, $file_name);
                    array_push($file_names, $file_name);
                }
            }
        }
        if(!empty($data['old_images'])) {
            $old = explode(',', $data['old_images']);
            $file_names = array_merge($old, $file_names);
        }


        $affected = DB::table('transfusion')
            ->where('id', $data['id'])
            ->update(['qcase'=> base64_encode($data['qcase']), 'information'=> base64_encode($data['information']), 'data'=> base64_encode(serialize($data['question'])), 'discussion' => base64_encode($data['discussion']), 'images'=>implode(',', $file_names),'reference'=> base64_encode($data['reference']) ]);

        $request->session()->flash('alert-success', 'Question Updated successfully!');
        return redirect()->route('admin.transfusion');
    } 

    public function previewQuestionMcq()
    {
        $r_id = Route::input('r_id');
        $mcq = DB::table('mcq_emq')->where('id',  $r_id)->first();
        return view('panels.admin.preview-mcq', [
                    'result' => $mcq
                ]);
    }

    public function previewQuestionEssay()
    {
        $r_id = Route::input('r_id');        
        $essay = DB::table('essay')->where('id',  $r_id)->first();
        return view('panels.admin.preview-essay', [
                    'result' => $essay
                ]);
    }

    public function previewQuestionMorphology()
    {
        $r_id = Route::input('r_id');        
        $morphology = DB::table('morphology')->where('id',  $r_id)->first();
      
        return view('panels.admin.preview-morphology', [
                    'result' => $morphology
                ]);
    }

    public function previewQuestionQuality()
    {
        $r_id = Route::input('r_id');        
        $quality = DB::table('quality_assurance')->where('id',  $r_id)->first();
        
        return view('panels.admin.preview-quality', [
                    'result' => $quality
                ]);
    }

    public function previewQuestionTransfusion()
    {
        $r_id = Route::input('r_id');        
        $transfusion = DB::table('transfusion')->where('id',  $r_id)->first();

        return view('panels.admin.preview-transfusion', [
                    'result' => $transfusion
                ]);
    }

    public function mcqPreview(Request $request)
    {
        
        $index = ( Route::input('index') ) ? Route::input('index') : 0;

        $results = DB::select('SELECT * FROM mcq_emq');

        if(isset($results[$index])) {
            return view('panels.admin.preview-mcq', [
                    'result' => $results[$index],
                    'index'=> $index
                ]);
        }else{
            $request->session()->flash('alert-success', 'No question found!');
            return redirect()->route('admin.mcq-emq');
        }
    }

    public function recentUpdates(Request $request)
    {
        $data = $request->all();
        DB::insert('insert into recent_updates (updates) values (?)', [ base64_encode($data['update']) ] );
        $request->session()->flash('alert-success', 'Updates added successfully!');
        return redirect()->route('admin.add-test');
        
    }

    public function pages()
    {
        $results = DB::select('SELECT * FROM pages');
        return view('panels.admin.pages', [
                'results' => $results
            ]);
    }
    
    public function updatePages(Request $request)
    {
        $data = $request->all();

        $results = DB::select('SELECT * FROM pages');
        if (count($results)) {
            $affected = DB::table('pages')
                ->where('id', 1)
                ->update([ 'about_us'=> base64_encode($data['about-us']), 'terms_use'=> base64_encode($data['terms-use']), 'home_page'=> base64_encode($data['home1']), 'home_page_about'=> base64_encode($data['home2']) ]);
            
        }else{
            DB::insert('insert into pages (about_us, terms_use, home_page, home_page_about) values (?,?,?,?)', [ base64_encode($data['about-us']), base64_encode($data['terms-use']), base64_encode($data['home1']), base64_encode($data['home2']) ] );            
        }

        $request->session()->flash('alert-success', 'Pages content updated successfully!');
        return redirect()->route('admin.pages');
    }

    public function addInfo(Request $request)
    {
        $results = DB::select('SELECT * FROM information');
        return view('panels.admin.info', [
                'results' => $results
            ]);
    }

    public function updateInfo(Request $request)
    {
        $data = $request->all();
   
        $results = DB::select('SELECT * FROM information');
        if (count($results)) {
            $affected = DB::table('information')
                ->where('id', 1)
                ->update([ 'mcq_emq'=> base64_encode($data['mcq_emq']), 'essay'=> base64_encode($data['essay']), 'morphology'=> base64_encode($data['morphology']), 'quality_assurance'=> base64_encode($data['quality_assurance']), 'transfusion'=> base64_encode($data['transfusion']) ]);
            
        }else{
            DB::insert('insert into information (mcq_emq, essay, morphology, quality_assurance, transfusion) values (?,?,?,?,?)', [ base64_encode($data['mcq_emq']), base64_encode($data['essay']), base64_encode($data['morphology']), base64_encode($data['quality_assurance']), base64_encode($data['transfusion']) ] );            
        }

        $request->session()->flash('alert-success', 'Information updated successfully!');
        return redirect()->route('admin.info');

    }

    public function getTests(Request $request)
    {
        $user_id = Route::input('uid');
        $results = DB::table('user_tests')
            ->select('user_tests.*')
            ->where('user_id', '=', $user_id)
            ->paginate(10);
        
        return view('panels.admin.user-tests', [
                'results' => $results
            ]);
    }

    public function payHistory()
    {

        $results = DB::table('users')
            ->select('users.id','users.first_name','users.last_name','users.email','payment_details.user_id','payment_details.data','payment_details.created_at')
            ->join('payment_details','payment_details.user_id','=','users.id')
            ->paginate(15);

        return view('panels.admin.pay-history', [
                'results' => $results
            ]);
    }

    public function filterPayment(Request $request)
    {

        $dt_from = date('Y-m-d', strtotime($request->get('dt-from')));
        $dt_to = date('Y-m-d', strtotime($request->get('dt-to')));
        
        $results = DB::table('users')
            ->select('users.id','users.first_name','users.last_name','users.email','payment_details.user_id','payment_details.data','payment_details.created_at')
            ->join('payment_details','payment_details.user_id','=','users.id')
            ->whereBetween('payment_details.created_at', [ $dt_from, $dt_to])
            ->paginate(15);
        
        return view('panels.admin.pay-history', [
                'results' => $results
            ]);

    }

}
