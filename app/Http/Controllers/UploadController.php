<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TemporaryFile;

class UploadController extends Controller
{
    public function store(Request $request){

        $documentFields = ['file_1', 'file_2', 'file_3', 'file_4', 'file_5', 'file_6'];
        $uploadedFolder = '';

        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $originalFilename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = $originalFilename . uniqid() . '.' . $extension;
                $folder = uniqid() . '-' . now()->timestamp;
                $file->storeAs('public/uploads/tmp/' . $folder, $filename);

                TemporaryFile::create([
                    'folder' => $folder,
                    'filename' => $filename,
                ]);

                $uploadedFolder = $folder;
                break;
            }
        }
        return $uploadedFolder;
    }
}
