<?php

namespace App\Http\Controllers;

use App\Models\TaskSave;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskSaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($day="today")
    {
        //
        if($day == 'today'){
            return TaskSave::where('created_at', '>=', Carbon::today())
                            ->orderByDesc('end_at')
                            ->get();
        }
        else{
            $day = new Carbon($day);
            return TaskSave::whereDate('created_at', '=', $day)
                            ->orderByDesc('end_at')
                            ->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $i=0; $data = [];
        //dd(count($request->all()));
        if(count($request->all()) != 0 ){
            dd($request->all());
            foreach ($request->all() as $task) {
                if(TaskSave::create($task)){
                    $i++;
                }
            }
            if($i == count($request->all())){
                $data = [
                    'success' => "Toutes les taches ont été sauvée"
                ];
            }else{
                $data = [
                    'error' => "certaines données n'ont pas été sauvées"
                ];
            }
        }else{
            $data = [
                'error' => "Vous n'avez pas envoyé de données"
            ];
        }
        return response()->json( $data, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getbyday($day)
    {
         // TaskSave::find
        
    }






    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TaskSave  $taskSave
     * @return \Illuminate\Http\Response
     */
    public function show(TaskSave $taskSave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskSave  $taskSave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskSave $taskSave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskSave  $taskSave
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskSave $taskSave)
    {
        //
    }
}
