<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;

class UploadController extends Controller
{
    public function uploadImage(Request $request){
        $fileName =time().'-'.$_FILES['file']['name'];
        $request->file('file')->storeAs('mangacovers', $fileName, 'public');;
        $url = '/storage/mangacovers/'.$fileName;
        return response() -> json([
            'success' => true,
            'path' => $url
        ]);
    }
    public function uploadAvatar(Request $request){
        $fileName =time().'-'.$_FILES['file']['name'];
        $request->file('file')->storeAs('avatars', $fileName, 'public');;
        $url = '/storage/avatars/'.$fileName;
        $user = Auth::user();
        $user->avatar = $url;
        $user->save();
        return response() -> json([
            'success' => true,
            'path' => $url
        ]);
    }
    public function uploadImages(Request $request){
        $files = $request -> file('files');
       for ($i=0; $i < count($files) ; $i++) { 
        $fileName =time().'-'.$files[$i]->getClientOriginalName();
        $files[$i] -> storeAs('images', $fileName, 'public');
        $url[] = '/storage/images/'.$fileName;
        
       }
       return response() -> json([
        'success' => true,
        'paths' => $url
    ]);
    }
}
