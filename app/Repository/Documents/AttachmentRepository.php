<?php

namespace App\Repository\Documents;

use App\Models\Attachment;
use App\Models\Media;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AttachmentRepository
{
    /**
     * create all files.
     *
     * @param UploadedFile $file
     * @param string       $path
     * @param int          $modelId
     * @param string       $name
     *
     * @return Attachment
     */
    public function create(UploadedFile $file, string $path): Media
    {
        $filename = Storage::putFile($path, $file, 'public');

        return Media::create([
            'path' => $filename,
            'disk' => config('filesystems.default'),
            'name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'user_id' => auth()->id(),
        ]);
    }

    public function stream(Type $var = null)
    {
        // code...
    }

    /**
     * Download file.
     *
     * @param Attachment $attachment
     * @param bool|null  $inline
     *
     * @return void
     */
    public function download(Attachment $attachment, ?bool $inline = false)
    {
        set_time_limit(600);
        $path = str_replace('original', $attachment->size, $attachment->path . '/' . $attachment->name);
        $file = Storage::get($path);
        $contentDisposition = ($inline ? 'inline' : 'attachment') . '; filename=' . $attachment->original_name;

        return (new Response($file, 200))
            ->header('Content-Type', $attachment->mime_type)
            ->header('Content-Disposition', $contentDisposition);
    }

    /**
     * Delete stored attachment, (Modify when dealing with disks).
     *
     * @param int $attachmentId
     *
     * @return void
     */
    public function delete(int $attachmentId)
    {
        $attachment = Attachment::find($attachmentId);
        $path = str_replace('original', $attachment->size, $attachment->path . '/' . $attachment->name);
        Storage::delete($path);
    }
}
