<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index(){
        
        return inertia::render('EventManagement/Index',[
            'events'=> Event::get() //gets and array of events and passes them to the index.vue as a prop
        ]);
    }
    public function store(Request $request){
        $params = $request->all();//get the form submited data
        $data = [
            'name' => $params['name'],
            'from_datetime'=> $params['startDate'],
            'to_datetime'=> $params['endDate'],
            'location'=> $params['location'],
        ];
        Event::create($data);//creates the event record in the table
        return redirect()->route('event.index');//routes to the index page after creating the record
    }
    public function create(){
        return Inertia::render('EventManagement/Create');
    }
    public function show(Event $event){ 
        return Inertia::render('EventManagement/View',[
            'event'=> $event //renders the view.vue and sends the event data which will map to event prop
        ]);
    }
    public function edit(Event $event){
        return Inertia::render('EventManagement/Edit',[
            'event'=> $event
        ]);
    }
    public function update(Request $request, Event $event){
        $params = $request->all();//get the form data 
        $data = [
            'name'=> $params['name'],
            'from_datetime'=> $params['startDate'],
            'to_datetime'=> $params['endDate'],
            'location'=> $params['location'],
        ];
        $event->update($data);//update the current event with the id coming from edit.vue
        return redirect()->route('event.index');//go to the event.index page
    }
}
