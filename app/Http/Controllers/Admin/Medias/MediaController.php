<?php

namespace App\Http\Controllers\Admin\Medias;

use App\Http\Controllers\Controller;
use App\Models\Medias\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\ContentRangeUploadHandler;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class MediaController extends Controller
{
    /**
     * Delete media
     *
     * @param string $uuid
     *
     * @return JsonResponse
     */
    public function destroy(string $uuid): JsonResponse
    {
        $media = Media::where('uuid', $uuid)->first();
        if (!$media) {
            return response()->json([
                'message' => 'Votre média est introuvable',
            ], 404);
        }
        $model = $media->model;
        if ($model->cacheFor) {
            $model::flushQueryCache();
        }
        if ($media->model_type == "App\Models\Medias\Asset") {
            $model->delete();
        }
        $media->delete();
        return response()->json([
            'message' => 'Le média a bien été supprimé',
        ]);
    }

    /**
     * Handles the file upload
     *
     * @param FileReceiver $receiver
     * @param string $field
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function uploadFile(FileReceiver $receiver, string $field, Request $request): JsonResponse
    {
        if (false === $receiver->isUploaded()) {
            throw new UploadMissingFileException();
        }
        $save = $receiver->receive();
        if ($save->isFinished()) {
            return $this->saveFile($save->getFile(), $field);
        }

        /** @var ContentRangeUploadHandler $handler */
        $handler = $save->handler();
        return response()->json([
            'name' => $save->getClientOriginalName(),
            'done' => $handler->getPercentageDone(),
        ]);
    }

    /**
     * Create unique filename for uploaded file
     *
     * @param UploadedFile $file
     *
     * @return string
     */
    protected function createFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug(str_replace('.' . $extension, '', $file->getClientOriginalName())); // Filename without extension

        $filename .= '_' . time() . '.' . $extension;

        return $filename;
    }

    /**
     * Saves the file
     *
     * @param UploadedFile $file
     * @param string $field
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function saveFile(UploadedFile $file, string $field): \Illuminate\Http\JsonResponse
    {
        $name = $file->getClientOriginalName();
        $fileName = $this->createFilename($file);
        $filePath = 'chunk-upload/';
        $finalPath = storage_path('app/public/' . $filePath);

        $mime_original = $file->getMimeType();
        $mime = str_replace('/', '-', $mime_original);

        $file->move($finalPath, $fileName);

        return response()->json([
            'field' => $field,
            'file_name' => $name,
            'media' => $filePath . $fileName,
            'mime_type' => $mime
        ]);
    }
}
