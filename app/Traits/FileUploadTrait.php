<?php

namespace App\Traits;

use File;
use Vimeo\Vimeo;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Support\Str;
use Termwind\Components\Dd;
use FFMpeg\Format\Video\X264;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    private function saveImage($destination, $attribute, $width = null, $height = null): string
    {
        if (!Storage::disk('public')->exists('uploads/' . $destination)) {
            Storage::disk('public')->makeDirectory('uploads/' . $destination);
        }

        if ($attribute->extension() == 'svg') {
            $file_name = time() . Str::random(10) . '.' . $attribute->extension();
            $path = 'uploads/' . $destination . '/' . $file_name;
            $attribute->storeAs('uploads/' . $destination, $file_name, 'public');
            return $path;
        }

        $img = Image::make($attribute);
        if ($width != null && $height != null && is_int($width) && is_int($height)) {
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->encode('png');
        }

        $returnPath = 'uploads/' . $destination . '/' . time() . '-' . Str::random(10) . '.png';
      //  $savePath = 'public/' . $returnPath;
        Storage::disk('public')->put($returnPath, $img->stream());

        return $returnPath;
    }

    private function updateImage($destination, $new_attribute, $old_attribute, $width = null, $height = null): string
    {
        if (!Storage::disk('public')->exists('uploads/' . $destination)) {
            Storage::disk('public')->makeDirectory('uploads/' . $destination);
        }

        if ($new_attribute->extension() == 'svg') {
            $file_name = time() . Str::random(10) . '.' . $new_attribute->extension();
            $path = 'uploads/' . $destination . '/' . $file_name;
            $new_attribute->storeAs('uploads/' . $destination, $file_name, 'public');
            Storage::disk('public')->delete($old_attribute);
            return $path;
        }

        $img = Image::make($new_attribute);
        if ($width != null && $height != null && is_int($width) && is_int($height)) {
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $returnPath = 'uploads/' . $destination . '/' . time() . '-' . Str::random(10) . '.' . $new_attribute->extension();
      //  $savePath = 'public/' . $returnPath;
        Storage::disk('public')->put($returnPath, $img->stream());
        Storage::disk('public')->delete($old_attribute);

        return $returnPath;
    }

    private function uploadFile($destination, $attribute)
    {
        if (!Storage::disk('public')->exists('uploads/' . $destination)) {
            Storage::disk('public')->makeDirectory('uploads/' . $destination);
        }

        $file_name = time() . Str::random(10) . '.' . $attribute->extension();
        $path = 'uploads/' . $destination . '/' . $file_name;

        try {
            Storage::disk('public')->putFileAs('uploads/' . $destination, $attribute, $file_name);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        return $path;
    }

    private function uploadFileWithDetails($destination, $attribute)
    {
        if (!Storage::disk('public')->exists('uploads/' . $destination)) {
            Storage::disk('public')->makeDirectory('uploads/' . $destination);
        }

        $data['is_uploaded'] = false;

        if ($attribute == null || $attribute == '') {
            return $data;
        }

        $data['original_filename'] = $attribute->getClientOriginalName();
        $file_name = time() . Str::random(10) . '.' . pathinfo($data['original_filename'], PATHINFO_EXTENSION);
        $data['path'] = 'uploads/' . $destination . '/' . $file_name;
        $data['file_name'] = $file_name;

        try {
            Storage::disk('public')->putFileAs('uploads/' . $destination, $attribute, $file_name);
            $data['is_uploaded'] = true;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        return $data;
    }


    private function uploadVideoWithDetails($destination, $attribute)
    {
        if (!File::isDirectory(public_path('uploads/' . $destination))) {
            File::makeDirectory(public_path('uploads/' . $destination), 0777, true, true);
        }

        $data['is_uploaded'] = false;

        if ($attribute == null || $attribute == '') {
            return $data;
        }

        $data['original_filename'] = $attribute->getClientOriginalName();
        $file_name = time() . Str::random(10) . '.' . pathinfo($data['original_filename'], PATHINFO_EXTENSION);
        $data['path'] = 'uploads/' . $destination . '/' . $file_name;

        try {
            if ($attribute->extension() == 'mp4') {
                // Convert the video to H.264 codec with MP4 container format
                $convertedFilePath = public_path($data['path'] . '_converted.mp4');
                $ffmpeg = FFMpeg::create([
                    'ffmpeg.binaries' => config('ffmpeg.binaries'),
                    'ffprobe.binaries' => config('ffprobe.binaries'),
                ]);
                $video = $ffmpeg->open($attribute->getRealPath());
                $format = new X264('aac', 'libx264');
                $video->save($format, $convertedFilePath);

                // Update the file path to point to the converted video
                $data['path'] = str_replace('.mp4', '_converted.mp4', $data['path']);
                $data['is_uploaded'] = true;
            } else {
                $attribute->move(public_path('uploads/' . $destination . '/'), $file_name);
                $data['is_uploaded'] = true;
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        return $data;
    }


    private function deleteFile($path)
    {
        if ($path == null || $path == '') {
            return null;
        }

        try {
            if (env('STORAGE_DRIVER') == 's3') {
                Storage::disk('s3')->delete($path);
            } else {
                File::delete($path);
                Storage::disk("public")->delete($path);
            }
        } catch (\Exception $e) {
            //
        }

        File::delete($path);
    }

    private function deleteVideoFile($path)
    {
        if ($path == null || $path == '') {
            return null;
        }

        try {
            if (env('STORAGE_DRIVER') == 's3') {
                Storage::disk('s3')->delete($path);
            } else {
                File::delete($path);
            }
        } catch (\Exception $e) {
            //
        }

        File::delete($path);

    }

    private function deleteVimeoVideoFile($file)
    {
        if ($file == null || $file == '') {
            return null;
        }

        try {
            $client = new Vimeo(env('VIMEO_CLIENT'), env('VIMEO_SECRET'),env('VIMEO_TOKEN_ACCESS'));
            $path = '/videos/' . $file;
            $client->request($path, [], 'DELETE');
        } catch (\Exception $e)  {
            //
        }
    }

    private function uploadVimeoVideoFile($title, $file)
    {
        $path = '';
        if ($file == null || $file == '') {
            return $path;
        }

        try {
            $client = new Vimeo(env('VIMEO_CLIENT'), env('VIMEO_SECRET'),env('VIMEO_TOKEN_ACCESS'));

            $uri = $client->upload($file, array(
                "name" => $title,
                "description" => "The description goes here."
            ));

            $response = $client->request($uri . '?fields=link');
            $response = $response['body']['link'];

            $str = $response;
            $vimeo_video_id = explode("https://vimeo.com/",$str);
            $path = null;
            if(count($vimeo_video_id))
            {
                $path = $vimeo_video_id[1];
            }
        } catch (\Exception $e) {
            //
        }

        return $path;

    }

    public function makePath($destination) {
        $path = "app/public/{$destination}";

    if (!File::exists(storage_path($path))) {
        File::makeDirectory(storage_path($path), 0777, true, true);
    }

    return storage_path($path);
    }

    public function fileDuration($path) : array | null
    {
        // Get the absolute local path of the uploaded file
        $localFilePath = storage_path('app/public/' . $path);

        // Get the file extension
        $extension = pathinfo($localFilePath, PATHINFO_EXTENSION);
        $fileSize = Storage::disk('public')->size($path);

        if (in_array($extension, ['mp3', 'mp4'])) {
            // Get the video/audio duration using FFprobe
            $ffProbe = FFProbe::create();
            $duration = $ffProbe->format($localFilePath)->get('duration');
            $duration = explode(".", $duration)[0];

            // Convert duration to minutes:seconds format
            $formattedDuration = gmdate("i:s", $duration);

            return [
                'duration' => (int) $duration,
                'formatted_duration' => $formattedDuration,
                'file_size' => number_format($fileSize / 1048576, 2) . "MB"
            ];
        } elseif (in_array($extension, ['srt', 'vtt'])) {
            // Count the number of lines (subtitles) in the SRT content
            $srtContent = Storage::disk('public')->get($path);
            $lineCount = substr_count($srtContent, "\n\n") + 1;

            // Calculate the reading time in seconds (assuming 15 characters per second)
            $readingTime = ceil($lineCount / 15);
            $formattedReadingTime = gmdate("i:s", $readingTime);

            return [
                'reading_time' =>$formattedReadingTime ,//$readingTime . " seconds",
                'file_size' => number_format($fileSize / 1048576, 2) . "MB",
                'line_count' => $lineCount
            ];
        }

        return null; // Unsupported file type
    }


    function calculateReadingTime($content) {
        // Average reading speed in words per minute
        $wordsPerMinute = 200;

        // Count the number of words in the content
        $wordCount = str_word_count(strip_tags($content));

        // Calculate the estimated reading time in minutes
        $readingTime = ceil($wordCount / $wordsPerMinute);

        return $readingTime;
    }
}
