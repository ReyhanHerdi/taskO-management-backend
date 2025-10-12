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
            $data_status = (count($data) > 0) ? 'Data found' : 'Data not found' ;
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

    public function showById($id) {
        try {
            $data = Team::where('id_team', $id)->first();
            return response()->json([
                'status' => true,
                'message' => 'Data has found',
                'data' => $data
            ]);
        } catch(\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Get data fail',
                'error' => $th->getMessage()
            ]);
        }
    }


    public function showByUserId($id) {
        try {
            $data = Member::with('team')->where('user_id', $id)->get();
            $data_status = (count($data) > 0) ? 'Data found' : 'Data not found' ;
            return response()->json([
                'status' => true,
                'message' => $data_status,
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

    public function showByTeamId($id) {
        try {
            $data = Member::with('user')->where('team_id', $id)->get();
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

            return $this->adminStore($request->user_id, $team->id);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => 'Insert data fail',
                'error' =>$th->getMessage()
            ]);
        }
    }

    public function showProject($id) {
        try {
            $data = Team::with('project')->where('id_team', $id)->get();
            $data_status = (count($data) > 0) ? 'Data found' : 'Data not foung' ;

            return response()->json([
                'status' => true,
                'message' => $data_status,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => 'Data not found',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function adminStore($userId, $teamId) {
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

    public function memberStore($id, Request $request) {
        try {
            $user = User::where('email', $request->email)->first();
            Member::create([
                'team_id' => $id,
                'user_id' => $user->id_user
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'Insert member success',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Insert member fail',
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
