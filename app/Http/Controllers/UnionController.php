<?php

namespace App\Http\Controllers;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use DateTime;

class UnionController extends Controller
{
    function index() {
        $unions = DB::select('SELECT * FROM tbl_union');
        return view('new_porttal.Union.index')->with('unions', $unions);
    }
    function create() {
        return view('new_porttal.Union.create');
    }
    function store(Request $request) {
        $user_id = Auth::user()->id;
        $id = $request->id;
        $name = htmlspecialchars($request->name, ENT_QUOTES, 'UTF-8');
        $description = htmlspecialchars($request->description, ENT_QUOTES, 'UTF-8');
        $link = htmlspecialchars($request->link, ENT_QUOTES, 'UTF-8');

        if($id > 0)
            DB::update("UPDATE tbl_union set name = '$name', description = '$description', link = '$link', updated_by = '$user_id', updated_on = now() WHERE id = '$id'");
        else
            DB::insert("INSERT into tbl_union (name, description, link, created_by, created_on) Values('$name', '$description', '$link', '$user_id', now())");
        return redirect()->back()->with('success', 'Data Added successfully.');
    }
    function get($id) {
        $union = DB::select("SELECT * FROM tbl_union where id = '$id'");
        return view('new_porttal.Union.create')->with('union', $union);
    }
    function delete(Request $request) {
        $id = $request->id;
        DB::select("DELETE FROM tbl_union where id = '$id'");
        // return redirect('union')->with('success', 'Data Deleted successfully.');
    }

}
