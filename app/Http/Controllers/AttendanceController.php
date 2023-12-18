<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Api\Attendance;
use App\Traits\HttpResponseFormatter;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     use HttpResponseFormatter;


    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
public function index(Request $request)
    {
        $studentId = $request->student_id;
        $attendanceQuery = Attendance::select(['attendances.*','events.event_name'])->join('events', 'attendances.event_id', '=', 'events.id')->where('attendances.student_id', $studentId);
        $attendance = $attendanceQuery->get();
        if($attendance){
            return $this->success("Attendance Fetched", $attendance);
        }
        return $this->failure("Attendance Not Fetched");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttendanceRequest $request)
    {
        $request->validated();
        $attendance = Attendance::create($request->all());
        if($attendance){
            return $this->success("Event Joined", $attendance);
        }
        return $this->failure("Attendance Not Created");
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    public function checkIn(UpdateAttendanceRequest $request){
        $request->validated();
        $attendance = Attendance::join('events', 'attendances.event_id', '=', 'events.id')->where('student_id', $request->student_id)->where('event_id', $request->event_id)->first();
        // dd($attendance['event_date']);
        // dd($attendance->attendance_date);
        if($attendance->attendance_date){
            return $this->failure("Attendance Already Updated");
        }
        if(!$attendance){
            return $this->failure("Attendance Not Updated");
        }
        $eventDate = Carbon::parse($attendance['event_date']);
        $now = Carbon::now();
        $diff = $eventDate->diffInMinutes($now);
        if($diff > 30){
            $attendance->attendance_status = "Late";
            
        } else{
            $attendance->attendance_status = "Present";
        }
        $attendance->attendance_date = date('Y-m-d H:i:s');
        $attendance->save();
        return $this->success("Attendance Updated", $attendance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
