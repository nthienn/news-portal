<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class LocalizationController extends Controller
{
    function indexAdmin()
    {
        $languages = Language::all();

        return view('admin.localization.index-admin', ['languages' => $languages]);
    }

    function indexFrontend()
    {
        $languages = Language::all();

        return view('admin.localization.index-frontend', ['languages' => $languages]);
    }

    function generateString(Request $request)
    {
        $directories = explode(', ', $request->directory);
        $language = $request->language;
        $fileName = $request->file_name;

        $localizationStrings = [];

        foreach ($directories as $directory) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

            // Iterate over each file in the directory 
            foreach ($files as $file) {
                if ($file->isDir()) {
                    continue;
                }

                $contents = file_get_contents($file->getPathName());

                preg_match_all('/__\([\'"](.+?)[\'"]\)/', $contents, $matches);

                if (!empty($matches[1])) {
                    foreach ($matches[1] as $match) {
                        $match = preg_replace('/^(frontend|admin)\./', '', $match);
                        $localizationStrings[$match] = $match;
                    }
                }
            }
        }

        $phpArray = "<?php\n\nreturn " . var_export($localizationStrings, true) . ";\n";

        // Create language sub folder if it is not exit
        if (!File::isDirectory(lang_path($language))) {
            File::makeDirectory(lang_path($language), 0755, true);
        }

        file_put_contents(lang_path($language . '/' . $fileName . '.php'), $phpArray);

        toast(__('admin.Generate successfully!'), 'success');

        return redirect()->back();
    }

    function updateString(Request $request)
    {
        $languageStrings = trans($request->file_name, [], $request->language);

        $languageStrings[$request->key] = $request->value;

        $phpArray = "<?php\n\nreturn " . var_export($languageStrings, true) . ";\n";

        file_put_contents(lang_path($request->language . '/' . $request->file_name . '.php'), $phpArray);

        toast(__('admin.Update successfully!'), 'success');

        return redirect()->back();
    }

    function translateString(Request $request)
    {
        try {
            $language = $request->language;

            $languageStrings = trans($request->file_name, [], $language);

            $keyStrings = array_keys($languageStrings);

            $text = implode(' | ', $keyStrings);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-rapidapi-host' => getSetting('site_api_host'),
                'x-rapidapi-key' => getSetting('site_api_key'),
            ])->post('https://google-translate113.p.rapidapi.com/api/v1/translator/text', [
                        "from" => "auto",
                        "to" => $language,
                        "text" => $text
                    ]);

            $translatedText = json_decode($response->body())->trans;

            $translatedValues = explode(' | ', $translatedText);

            $updatedArray = array_combine($keyStrings, $translatedValues);

            $phpArray = "<?php\n\nreturn " . var_export($updatedArray, true) . ";\n";

            file_put_contents(lang_path($language . '/' . $request->file_name . '.php'), $phpArray);

            return response(['status' => 'success', 'message' => __('admin.Translation is completed!')]);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}