<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Helper\Helpers;

class AdminSettingController extends Controller
{
    public function index()
    {
        Helpers::read_json();
        $setting_data = Setting::where('id',1)->first();
        return view('admin.setting', compact('setting_data'));
    }

    public function update(Request $request)
    {
        // dd($request->news_ticker_total);

        $request->validate([
            'news_ticker_total' => 'required'
        ]);

        $setting = Setting::where('id',1)->first();
        $setting->news_ticker_total =$request->news_ticker_total;
        $setting->news_ticker_status =$request->news_ticker_status;
        $setting->video_total =$request->video_total;
        $setting->video_status =$request->video_status;
        $setting->update();

        return redirect()->route('admin_setting')->with('success', 'Data is updated successfully.');
    }
}
