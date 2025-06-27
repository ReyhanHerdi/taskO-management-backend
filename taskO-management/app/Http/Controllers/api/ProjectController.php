<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;

class ProjectController extends Controller
{
    public function index() {
        $data = Project::get();
        try {
            if (!isNull($data)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data found',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Data is empty',
                    'data' => $data
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function showByProjectId($id) {
        try {
            $data = Project::where('id_project', $id)->first();
            return response()->json([
                'status' => true,
                'message' => 'Data found',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => "get data fail",
                'error' => $th->getMessage()
            ]);
        }
    }
    public function showByUserId($id) {
        try {
            $data = Project::where('user_id', $id)->get();
            $data_status = (count($data) > 0) ? 'Data found' : 'Data not found' ;
            return response()->json([
                'status' => true,
                'message' => $data_status,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => true,
                'message' => "get data fail",
                'error' => $th->getMessage()
            ]);
        }
    }

    public function showByTeamId($id) {
        try {
            $data = Project::with('task')->where('team_id', $id)->get();
            $data_status = (count($data) > 0) ? 'Data found' : 'Data not found' ;
            return response()->json([
                'status' => true,
                'message' => $data_status,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Get data error',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'team_id' => 'required',
                'user_id' => 'required',
                'name_project' => 'required',
            ]);

            Project::create([
                'team_id' => $request->team_id,
                'user_id' => $request->user_id,
                'name_project' => $request->name_project,
                'description' => $request->description,
                'due' => $request->due
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Insert data success'
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
                'name_project' => 'required',
                'description' => 'required',
                'due' => 'required',
                'status' => 'required'
            ]);
            Project::where('id_project', $id)->update([
                'name_project' => $request->name_project,
                'description' => $request->description,
                'due' => $request->due,
                'status' => $request->status   
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Update data success'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Update data fail',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function destroy($id) {
        try {
            Project::where('id_project', $id)->delete();

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
