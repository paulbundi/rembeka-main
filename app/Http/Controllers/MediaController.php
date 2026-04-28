<?php

namespace App\Http\Controllers;

use App\Repository\Documents\AttachmentRepository;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:media.view')->only(['index', 'show']);
        $this->middleware('can-access:media.create')->only('create');
        $this->middleware('can-access:media.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.media.index', ['page' => 'media-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'media-create']);
    }

    /**
     * @param \App\Models\Media $media
     *
     * @return void
     */
    public function edit(\App\Models\Media $media)
    {
        return view('dashboard.page', ['page' => 'media-create', 'id' => $media->id]);
    }

    /**
     * @param \App\Models\Media $media
     *
     * @return void
     */
    public function show(\App\Models\Media $media)
    {
        return view('dashboard.page', ['page' => 'media-show', 'id' => $media->id]);
    }

    /**
     * Upload files.
     *
     * @param Request $request
     *
     * @return void
     */
    public function uploadMedia(Request $request)
    {
        try {
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $path = config('filesystems.attachments.media');
                $media = app(AttachmentRepository::class)->create($request->file('file'), $path);

                return response()->json([
                    'success' => true,
                    'message' => 'File uploaded successfully',
                    'media' => $media
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'No valid file provided'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
