<?php

namespace App\Http\Controllers;

use App\Http\Requests\MediaRequest;
use Illuminate\Http\Request;
use App\Models\Media;

class LibraryController extends Controller
{
    /**
     * Display a listing of the files.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $files = Media::orderBy('created_at', 'desc')->paginate(20);

        return response()->json($files);
    }

    /**
     * Upload a new file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'max:15000',
        ]);

        $path = date('Y') .'/'. date('m');
        $uri = $request->file->storePublicly("uploads/{$path}");

        $filename = $request->file->getClientOriginalName();
        $mime = $request->file->getClientMimeType();
        $size = $request->file->getSize();

        $media = Media::create([
            'filename' => $filename,
            'uri' => $uri,
            'size' => $size,
            'mime_type' => $mime,
        ]);

        if (preg_match('/^image/', $mime)) {
            $media->generateThumbnails();
        }

        return response()->json($media);
    }

    /**
     * Update the specified media in storage.
     *
     * @param  \App\Http\Requests\MediaRequest  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(MediaRequest $request, Media $media)
    {
        $media->update([
            'alt' => $request->alt,
            'caption' => $request->caption,
        ]);

        return response()->json("The file has been updated.");
    }
}
