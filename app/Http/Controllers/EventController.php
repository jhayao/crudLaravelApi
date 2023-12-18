<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Api\Event;
use App\Traits\HttpResponseFormatter;
use Illuminate\Http\Request;

class EventController extends Controller
{

    use HttpResponseFormatter;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $eventList = Event::all();
        if ($eventList->isEmpty()) {
            return $this->failure("No Event Found");
        }
        return $this->success("Event List", $eventList);
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
    public function store(StoreEventRequest $request)
    {
        $request->validated();
        $event = Event::create($request->all());
        if($event){
            return $this->success("Event Created Successfully", $event);
        }else{
            return $this->failure("Event Creation Failed");
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // dd($request->id);
        $event = Event::find($request->id);
        if($event){
            return $this->success("Event Found", $event);
        }else{
            return $this->failure("Event Not Found");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request)
    {
        $request->validated();
        $event = Event::find($request->id);
        if($event){
            $event->update($request->all());
            return $this->success("Event Updated Successfully", $event);
        }else{
            return $this->failure("Event Not Found");
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $event = Event::find($request->id);
        if($event){
            $event->delete();
            return $this->success("Event Deleted Successfully", $event);
        }else{
            return $this->failure("Event Not Found");
        }
    }
}
