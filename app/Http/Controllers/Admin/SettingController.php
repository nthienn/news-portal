<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GeneralSettingUpdateRequest;
use App\Http\Requests\Admin\SeoSettingUpdateRequest;
use App\Models\Setting;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SettingController extends Controller implements HasMiddleware
{
    use FileUploadTrait;

    public static function middleware()
    {
        return [
            new Middleware('permission:setting index,admin', only: ['index']),
            new Middleware('permission:setting edit,admin', only: ['updateGeneralSetting', 'updateSeoSetting', 'updateAppearanceSetting'])
        ];
    }

    public function index()
    {
        return view('admin.setting.index');
    }

    function updateGeneralSetting(GeneralSettingUpdateRequest $request)
    {
        $logoPath = $this->handleFileUpload($request, 'site_logo');
        $faviconPath = $this->handleFileUpload($request, 'site_favicon');

        Setting::updateOrCreate(
            ['key' => 'site_name'],
            ['value' => $request->site_name]
        );

        if (!empty($logoPath)) {
            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => $logoPath]
            );
        }

        if (!empty($faviconPath)) {
            Setting::updateOrCreate(
                ['key' => 'site_favicon'],
                ['value' => $faviconPath]
            );
        }

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->back();
    }

    function updateSeoSetting(SeoSettingUpdateRequest $request)
    {
        Setting::updateOrCreate(
            ['key' => 'site_seo_title'],
            ['value' => $request->site_seo_title]
        );

        Setting::updateOrCreate(
            ['key' => 'site_seo_description'],
            ['value' => $request->site_seo_description]
        );

        Setting::updateOrCreate(
            ['key' => 'site_seo_keywords'],
            ['value' => $request->site_seo_keywords]
        );

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->back();
    }

    function updateAppearanceSetting(Request $request)
    {
        $request->validate([
            'site_color' => ['required', 'max:200']
        ]);

        Setting::updateOrCreate(
            ['key' => 'site_color'],
            ['value' => $request->site_color]
        );

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->back();
    }

    function updateTranslateApiSetting(Request $request)
    {
        $request->validate([
            'site_api_host' => ['required'],
            'site_api_key' => ['required']
        ]);

        Setting::updateOrCreate(
            ['key' => 'site_api_host'],
            ['value' => $request->site_api_host]
        );

        Setting::updateOrCreate(
            ['key' => 'site_api_key'],
            ['value' => $request->site_api_key]
        );

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->back();
    }
}