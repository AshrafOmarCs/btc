<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
use Response;
class DocumentsController extends Controller
{
    public function index(){
        $sql = "SELECT * FROM documents WHERE type = 'tutorial'";
        $tutorials = DB::select($sql);
        $sql = "SELECT * FROM documents WHERE type = 'contract'";
        $contracts = DB::select($sql);
        return view('Documents.index', compact('tutorials', 'contracts')); 
    }
    public function upload_index(){
        return view('Documents.upload_index'); 
    }
    public function upload_store(Request $request){
        $request->validate([
            'type' => 'required',
            'name' => 'required',
            'file' => 'required',
        ]);
        $imageName = time().'.'.$request->file->extension();
        $request->file->move(storage_path('app/public/images'), $imageName);
        $sql = "INSERT into documents (type, name, file_name, created_at) VALUES ('$request->type', '$request->name', '$imageName', NOW())";
        DB::insert($sql);
        return redirect('UploadDocuments')->withSuccess('File has been saved successfully ');
    }
    
    public function show_file($file){
        $path = storage_path('app/public/images/') . $file;
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="' . $file . '"',
        ];
        
        $response = response()->download($path, $file, $headers);
        $response->headers->set('Content-Type', 'application/octet-stream');
        
        return $response;
        return Response::download($path, $file, $headers);
        // return Storage::response(storage_path('app/public/images/') . $file);


        // return response()->file(storage_path('app/public/images/') . $file);
    }
}

