<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdvertiseController extends Controller implements HasMiddleware
{
    use FileUploadTrait;

    public static function middleware()
    {
        return [
            new Middleware('permission:advertise index,admin', only: ['index']),
            new Middleware('permission:advertise edit,admin', only: ['update'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ad = Advertise::first();

        return view('admin.advertise.index', ['ad' => $ad]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $top_bar_ad = $this->handleFileUpload($request, 'top_bar_ad');
        $middle_ad = $this->handleFileUpload($request, 'middle_ad');
        $bottom_bar_ad = $this->handleFileUpload($request, 'bottom_bar_ad');
        $sidebar_ad = $this->handleFileUpload($request, 'sidebar_ad');
        $ad = Advertise::first();

        Advertise::updateOrCreate(
            ['id' => $id],
            [
                'top_bar_ad' => !empty($top_bar_ad) ? $top_bar_ad : $ad->top_bar_ad,
                'top_bar_ad_url' => $request->top_bar_ad_url,
                'top_bar_ad_status' => $request->top_bar_ad_status == 1 ? 1 : 0,
                'middle_ad' => !empty($middle_ad) ? $middle_ad : $ad->middle_ad,
                'middle_ad_url' => $request->middle_ad_url,
                'middle_ad_status' => $request->middle_ad_status == 1 ? 1 : 0,
                'bottom_bar_ad' => !empty($bottom_bar_ad) ? $bottom_bar_ad : $ad->bottom_bar_ad,
                'bottom_bar_ad_url' => $request->bottom_bar_ad_url,
                'bottom_bar_ad_status' => $request->bottom_bar_ad_status == 1 ? 1 : 0,
                'sidebar_ad' => !empty($sidebar_ad) ? $sidebar_ad : $ad->sidebar_ad,
                'sidebar_ad_url' => $request->sidebar_ad_url,
                'sidebar_ad_status' => $request->sidebar_ad_status == 1 ? 1 : 0,
            ]
        );

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->back();
    }
}