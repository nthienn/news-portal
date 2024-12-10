<?php

namespace App\Traits;

use File;
use Illuminate\Http\Request;

trait FileUploadTrait
{
    public function handleFileUpload(Request $request, string $fieldName, ?string $oldPath = null, string $dir = 'uploads')
    {
        // Check if the uploaded file
        if (!$request->hasFile($fieldName)) {
            return null;
        }

        // Delete the existing image if it exists
        if ($oldPath && File::exists(public_path($oldPath))) {
            File::delete(public_path($oldPath));
        }

        $file = $request->file($fieldName);
        $extension = $file->getClientOriginalExtension();
        $updatedFileName = \Str::random(30) . '.' . $extension;

        $file->move(public_path($dir), $updatedFileName);

        $filePath = $dir . '/' . $updatedFileName;

        return $filePath;
    }

    // Handle file delete
    public function deleteFile(string $path)
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}