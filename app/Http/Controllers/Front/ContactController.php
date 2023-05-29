<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Page;
use app\Models\Admin;
use app\Models\Language;
use App\Mail\Websitemail;
use App\Helper\Helpers;
class ContactController extends Controller
{
    public function index()
    {
        Helpers::read_json();

        if(!session()->get('session_short_name')){
            $current_short_name = Language::where('is_default','Yes')->first()->short_name;
        }else 
        {
            $current_short_name = session()->get('session_short_name');
        }
        $current_language_id = Language::where('short_name',$current_short_name)->first()->id;
        $page_data = Page::where('language_id',$current_language_id)->first();
        return view('front.contact',compact('page_data'));
    }

    public function send_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ],[
            'name.required' => ERROR_NAME_REQUIRED,
            'email.required' => ERROR_EMAIL_REQUIRED,
            'email.email' => ERROR_EMAIL_VALID,
            'message.required' => ERROR_MESSAGE_REQUIRED
        ]);
        if (!$validator->passes()) {
            return response()->json(['code'=>0, 'error_message' => $validator->errors()->toArray()]);
        } else {

            // Send email
            $admin_data = Admin::where('id', 1)->first();
            $email = $admin_data->email;
            $subject = 'Contact Form Email';
            $message = 'Visitor Message Detail:<br>';
            $message .= '<b>Visitor Name: </b>' . $request->name . '<br>';
            $message .= '<b>Visitor Email: </b>' . $request->email . '<br>';
            $message .= '<b>Visitor Message: </b>' . $request->message;

            Mail::to($admin_data->email)->send(new Websitemail($subject, $message));

            return response()->json(['code' => 1, 'success_message' => SUCCESS_CONTACT]);
        }
    }
}
