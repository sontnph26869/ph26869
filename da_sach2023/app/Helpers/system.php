<?php
use Illuminate\Support\Facades\Storage;
if(!function_exists('upload_file')){
    function upload_file($folder,$file){
        return 'storage/'.Storage::put($folder,$file);
    }
}
function uploadFile($nameFolder, $file)
{
    $fileName = time() . '_' . $file->getClientOriginalName();
    return $file->storeAs($nameFolder, $fileName, 'public');
}


if (!function_exists('upload_files')) {
    function upload_files($folder, $files) {
        $imageURLs = [];
        
        foreach ($files as $file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'storage/' . Storage::putFileAs($folder, $file, $filename);
            $imageURLs[] = $path;
        }
        
        return json_encode($imageURLs);
    }
}
if(!function_exists('delete_file')){
    function delete_file($pathFile){
        $pathFile=str_replace('storage/','',$pathFile); 
        if (Storage::exists($pathFile))
        return   Storage::delete($pathFile);
    }
    return false;   

}
function countCommentsAndReplies($comments) {
    $count = 0;

    foreach ($comments as $comment) {
        $count++; // Increment for the current comment

        if ($comment->replies->isNotEmpty()) {
            $count += countCommentsAndReplies($comment->replies); // Recursively count replies
        }
    }

    return $count;
}
