<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskExecutor;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        try {
            $data = Task::get();
            $data_status = (count($data) > 0) ? 'data found' : 'data not found' ;

            return response()->json([
                'status' => true,
                'message' => $data_status,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Get data has failed',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'project_id' => 'required',
                'name_task' => 'required',
            ]);

            Task::create([
                'project_id' => $request->project_id,
                'name_task' => $request->name_task,
                'description' => $request->description,
                'due' => $request->due,
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

    public function taskByProjectId($id) {
        try {
            $data = Task::where('project_id', $id)->get();
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

    public function taskDoneByProjectId($id) {
        try {
            $data = Project::with('task')->where('id_project', $id)->get();
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

    public function taskByExecutor($id) {
        try {
            $data = TaskExecutor::with('task')->where('user_id', $id)->get();
            return response()->json([
                'status' => true,
                'message' => 'Get data success',
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Get data has failed',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function taskExecutorStore(Request $request) {
        try {
            $request->validate([
                'task_id' => 'required',
                'user_id' => 'required'
            ]);

            TaskExecutor::create([
                'task_id' => $request->task_id,
                'user_id' => $request->user_id
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Insert data succes'
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
                'name_task' => 'required',
                'description' => 'required',
                'due' => 'required',
                'status' => 'required'
            ]);

            Task::where('id_task', $id)->update([
                'name_task' => $request->name_task,
                'description' => $request->description,
                'due' => $request->due,
                'status' => $request->status
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Data has been updated'
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
            Task::where('id_task', $id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data has been deleted'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Delete data fail',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function taskExecutorDestroy($id) {
        try {
            TaskExecutor::where('user_id', $id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data has been deleted',
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
