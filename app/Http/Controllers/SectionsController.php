<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=Sections::all();
        return view('sections.sections',compact('sections'));
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
    public function store(SectionRequest $request)
    {
        $validated = $request->validated();
            sections::create([
                'section_name' => $request->section_name,
                'description' => $request->description,
                'created_by' => (Auth::user()->name)

            ]);
            session()->flash('Add', 'Done');
            return redirect('/sections');
        }


    /**
     * Display the specified resource.
     */
    public function show(Sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sections $sections)
    {
        $id=$request->id;
        $this->validate($request,[
            'section_name' => 'required|unique:sections|max:255'. $id,
            'description' => 'required',

        ],[
            'section_name.requried'=>'Please Enter {section_name}',
            'section_name.unique'=>'Please Change {section_name}',
            'description.requried'=>'Please Enter {description}',

        ]);

        $sections=Sections::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description
        ]);
        session()->flash('edit','Updated');
        return redirect('/sections'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
         Sections::find($id)->delete();
         session()->flash('delete','Deleted');
         return redirect('/sections'); 
    }
    }