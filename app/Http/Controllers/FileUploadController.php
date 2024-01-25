<?php

namespace App\Http\Controllers;

use App\Classes\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Repositories\DocumentRepositoryInterface;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    protected $documentRepository;
    public function __construct(
        DocumentRepositoryInterface $documentRepository
    ) {
        $this->documentRepository = $documentRepository;
    }

    /**
     * upload files to server
     */
    public function uploadFiles($data, $filesArray, $model, $model_id, $section = null)
    {
        // header ("Connection: close");

        $appModelSystem = "App\\Models\\" . $model;
        $record = $appModelSystem::find($model_id);
        // dd($record);
        // $files = @$data['documents'][$model];
        $files = @$data['documents'];
        $is_publications = ($model == class_basename(Document::class)) ? true : false;
        // dd($files);
        foreach ($files as $document_tag => $file) {
            $document_tag = str_replace('\'', '', $document_tag);

            /**
             * Check if file has section
             */
            if (is_array($file)) {
                $section = array_keys($file)[0];
                $file = $file[$section];
            }

            $original_name = $file->getClientOriginalName();
            $mimeType = MimeType::fromExtension($file->getClientOriginalExtension());
            // var_dump($original_name);
            // return;
            $new_name = GeneralHelper::generate_random_number_short() . '.' . $file->getClientOriginalExtension();
            $uploadDir = $is_publications ? PUBLICATIONS_DIR :  DOCUMENTS_DIR . '/' . $model;

            $destinationPath = public_path($uploadDir);

            /**
             * resize the image
             */

            $requestFileSize = $file->getSize();
            // dd($requestFileSize);
            $max_image_upload_size = GeneralHelper::mbs_to_bits(MAX_FILE_IMAGE_SIZE);
            if (
                Str::contains(strtolower($mimeType), 'image') &&
                $requestFileSize > $max_image_upload_size
            ) {
                $img = Image::make($file->getRealPath());
                $img->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($destinationPath . '/' . $new_name);
            } else {
                $file->move($destinationPath, $new_name);
            }


            // get file mimetype


            //get filesize
            $fileZize = File::size(public_path($uploadDir . '/' . $new_name));
            // $fileZize = filesize(public_path(DOCUMENTS_DIR . '/' . $model . '/' . $new_name));

            // var_dump($fileZize);

            /**
             * Check if document exists
             */
            $currentDoc = @$record->documents->where('document_tag', $document_tag)->where('section', @$section)->first();
            if ($currentDoc) {
                /**
                 * Get current document location
                 * if found remove it from the server
                 */
                $_currentLocation = DOCUMENTS_DIR . '/' . $model;

                $currentLocation = public_path($_currentLocation . '/' . $currentDoc->path);
                if (file_exists(@$currentLocation) && !is_dir(@$currentLocation)) {
                    unlink(@$currentLocation);
                }

                /**
                 * update document 
                 */
                $currentDoc->paths = @$new_name;
                $currentDoc->original_name = @$original_name;
                $currentDoc->document_tag = @$document_tag;
                $currentDoc->mime_type = $mimeType;
                $currentDoc->document_size = $fileZize;
                $currentDoc->title = substr($original_name, 0, strrpos($original_name, '.'));
                $currentDoc->save();
            } else {

                /**
                 * Create new document 
                 */
                $_file_data = array(
                    'description' => @GeneralHelper::document_tags()[@$document_tag]['description'],
                    'paths' => @$new_name,
                    'original_name' => @$original_name,
                    'section' => @$section,
                    'document_tag' => $document_tag,
                    'document_size' => $fileZize,
                    'mime_type' => $mimeType,
                    'title' => null,
                );
                if (@$record) $record->documents()->create($_file_data);
            }
        }
    }

    public function download_document($string)
    {
        $id = GeneralHelper::decrypt_data($string);
        $doucument = $this->documentRepository->getById($id);

        if (!$doucument) {
            abort(404);
        }

        try {
            if ($doucument->isPublication()) {
                $filepath = PUBLICATIONS_DIR . '/' . $doucument->path;
            } else {
                $filepath = DOCUMENTS_DIR . '/' . class_basename($doucument->documentable) . '/' . $doucument->path;
            }
            // $filepath = public_path( . '/' . $category . '/' . $name);

            return Response::download(public_path($filepath));
        } catch (\Throwable $th) {
            return redirect(route('publications'));
        }
    }
}
