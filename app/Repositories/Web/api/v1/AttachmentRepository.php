<?php

namespace App\Repositories\Web\api\v1;

use App\Models\Attachment;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;

class AttachmentRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Attachment::class;
    }

    public function create_attachment($data, $file)
    {
        $file_name = null;
        $path  = class_basename($data->getModel());
        if ($file) {
            // if (gettype($file) == 'string') {
            //     $file_name = $transaction->transaction_no . '_image_' . time() . '.' . 'png';
            //     Storage::disk('dospace')->put($path . '/' . $file_name, base64_decode($file));
            // } else {
                $file_name = $data->id . '_image_' . time() . '_' . $file->getClientOriginalName();
                $content = file_get_contents($file);
                Storage::disk('dospace')->put($path . '/' . $file_name, $content);
            // }
            Storage::setVisibility($path . '/' . $file_name, "public");

            // return Attachment::create([
            //     'resource_type' => class_basename($data->getModel()),
            //     'image' => $file_name,
            //     'resource_id' => $data->id,
            //     'latitude' => null,
            //     'longitude' => null,
            //     'created_by_type'   => class_basename(auth()->user()->getModel()),
            //     'created_by_id'   => auth()->user()->id
            // ]);
        }
    }

    public function uploadToSpace($data, $path)
    {
        $file_name = null;
        $file = $data['file'];
        if ($file) {
            $file_name = 'image_' . time() . '_' . $file->getClientOriginalName();
            $content = file_get_contents($file);
            Storage::disk('dospace')->put($path . '/' . $file_name, $content);
            Storage::setVisibility($path . '/' . $file_name, "public");

          return $path.'/'.$file_name;
        }
        return '';
    }
}
