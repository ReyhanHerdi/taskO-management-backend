<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;

class TeamController extends Controller
{
    public function index() {
        $data = Team::get();
        try {
            $data_status = (!isNull($data)) ? 'Data found' : 'Data not found' ;
            return response()->json([
                'status' => true,
                'message' => $data_status,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => 'Get data failed',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function showByUserId($id) {
        try {
            $data = User::with('member.team')->where('id_user', $id)->get();
            return response()->json([
                'status' => true,
                'message' => 'Data found',
                'data' => $data
        ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Get data fail',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'name_team' => 'required',
                'user_id' => 'required',
            ]);

            $team = Team::create([
                'name_team' => $request->name_team,
                'description' => $request->description
            ]);

            return $this->memberStore($request->user_id, $team->id);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => 'Insert data fail',
                'error' =>$th->getMessage()
            ]);
        }
    }

    public function memberStore($userId, $teamId) {
        try {
            Member::create([
                'user_id' => $userId,
                'team_id' => $teamId,
                'role' => 'leader'
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Insert data success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Insert data fail',
                'error' => $th->getMessage()
            ]);
        }     
    }

    public function update($id, Request $request) {
        try {
            $request->validate([
                'name_team' => 'required',
                'description' => 'required'
            ]);

            Team::where('id_team', $id)->update([
                'name_team' => $request->name_team,
                'description' => $request->description,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Update data success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Update data fail',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function delete($id) {
        try {
            Team::where('id_team', $id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Delete data success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Delete data fail',
                'error' => $th->getMessage()
            ]);
        }
    }
}
