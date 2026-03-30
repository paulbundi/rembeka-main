<?php

namespace App\Http\Controllers;

use App\Repository\Documents\AttachmentRepository;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:media.view')->only('index');
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
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'media-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'media-show', 'id' => $id]);
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
        if ($request->has('file') && $request->file('file')->isValid()) {
            $path = config('filesystems.attachments.media');
            app(AttachmentRepository::class)->create($request->file, $path);

            return response()->json('success');
        }  //
    }
}
