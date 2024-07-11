<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index(Request $request){
        /*$events = Event::paginate(10);
        return Inertia::render('EventManagement/Index', [
            'events' => $events->items(), // Get the actual event data using items()
            'pagination' => [
                'current_page' => $events->currentPage(),
                'total_pages' => $events->total(),
                'last_page'=> $events->lastPage(),
                'per_page' => $events->perPage(), // Add per_page count for clarity
            ],
        ]);
        
        return Inertia::render('EventManagement/Index',[
            'events'=> Event::paginate(10)//gets and array of events and passes them to the index.vue as a prop
            
        ]);*/#
        //with serarch
        $query = Event::query();    
        if($request->has("search")){
            $search = $request->input("search");
            $query->where('name','like','%'.$search.'%')
                  ->orWhere('location','like','%'.$search.'%');
        }
        $events= $query->paginate(10);
        return Inertia::render('EventManagement/Index', [
            'events'=> $events,
            'filters'=>$request->only(['search']),
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
