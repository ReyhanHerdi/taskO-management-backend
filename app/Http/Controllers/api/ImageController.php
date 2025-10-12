<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function imageUpload($id, Request $req) {
        $user = User::where('id_user', $id)->first();
        try {
            $req->validate([
                'image' => ['required','mimes:jpeg,png']
            ]);


            if($req->hasFile('image')) {
                $getUserId = $user->id_user;
                $getfileExtension = $req->file('image')->getClientOriginalExtension(); // get the file extension
                $createnewFileName = time().'_'.str_replace(' ','_', $getUserId).'.'.$getfileExtension; // create new random file name
                $img_path = $req->file('image')->storeAs('public/userImage', $createnewFileName, 'public'); // get the image path
                User::where('id_user', $id)->update([
                    'photoUrl' => $createnewFileName
                ]);
                $post = $user->save();

                if($post && $img_path) { // save file in databse
                    return response()->json([
                        'status' => true,
                        'message' => 'Upload foto berhasil',
                    ]);
                }
                else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Upload foto gagal'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Upload foto kosong'
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $user,
                'error' => $th->getMessage()
            ]);
        }
    }
}
