<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RequiredActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function index(){
        $user_id = AUTH::user()->id;
        $actions = DB::select("SELECT tbl_actions.*, users.name, users_role.role_name FROM tbl_actions join users on tbl_actions.created_by = users.id join users_role on users.role_id = users_role.id WHERE created_by = '$user_id' OR assign_ids LIKE '%$user_id".','."%' order by tbl_actions.id DESC");
        $employees = DB::select("SELECT id, name from users order by name");
        return view('new_porttal.Actions.index')->with('employees', $employees)->with('actions', $actions);
    }
    function store(Request $request) {
        $user_id = AUTH::user()->id;
        $ticket_id = $request->ticket_id;
        $subject = $request->subject;
        $description = $request->description;
        $status = $request->status;
        // dd($status);
        $priority = $request->priority;
        $assign_ids = '';
        if ($request->assign_ids != '') {
            $assign_ids = implode(',', $request->assign_ids);
        }
        $assign_ids .= ",";
        if ($ticket_id > 0) {
            DB::insert("UPDATE tbl_actions SET module = '$subject', description = '$description', status = '$status', priority = '$priority', assign_ids = '$assign_ids', updated_by = '$user_id', updated_at = NOW() WHERE id = '$ticket_id'");
            return back()->with('success', 'Ticket Updated successfully');
        } else {
            DB::insert("INSERT into tbl_actions (module, description, status, priority, assign_ids, created_by, created_at)
                    VALUES ('$subject', '$description', '$status', '$priority', '$assign_ids', '$user_id', NOW())");
            return back()->with('success', 'Ticket Added successfully');
        }
    }
    function edit(Request $request) {
        $id = $request->id;
        $action = DB::select("SELECT * FROM tbl_actions WHERE id = '$id'");
        echo $action[0]->module . ':::';
        echo $action[0]->description . ':::';
        echo $action[0]->status . ':::';
        echo $action[0]->priority . ':::';
        echo $action[0]->assign_ids . ':::';
    }
    function destroy($id) {
        DB::delete('DELETE from tbl_actions where id = ' . $id);
        return back()->with('success', "Ticket Deleted Successfully");
    }
    function comments($id) {
        $action = DB::select("SELECT tbl_actions.* FROM tbl_actions Where id = '$id'");
        $comments = DB::select("SELECT tbl_actions_comments.*, users.name FROM tbl_actions_comments join users on tbl_actions_comments.created_by = users.id WHERE tbl_actions_comments.action_id = '$id' ORDER BY id ASC");
        return view('new_porttal.Actions.comments')->with('action', $action)->with('comments', $comments);
    }

    function saveComment(Request $request) {
        $user_id = AUTH::user()->id;
        $action_id = $request->action_id;
        $comment = $request->comment;
        try {
            DB::insert("INSERT INTO tbl_actions_comments (action_id, comment, created_by, created_at) VALUES ('$action_id', '$comment', '$user_id', NOW())");
            echo "Good";
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    function closeTicket(Request $request) {
        $user_id = AUTH::user()->id;
        $id = $request->id;
        try {
            DB::insert("UPDATE tbl_actions SET status = 'Closed', updated_by = '$user_id', updated_at = NOW() WHERE id = '$id'");
            echo "Good";
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
