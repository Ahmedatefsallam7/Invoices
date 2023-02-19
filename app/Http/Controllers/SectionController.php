<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    public function index()
    {
        $sections = Section::get();
        return view('sections.section', compact('sections'));
    }


    public function create()
    {
    }


    public function store(Request $request)
    {

        $request->validate([

            'section_name' => 'required|unique:sections',
            // 'description' => 'required',
        ], [

            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'هذا القسم موجود مسبقا',
            // 'description.required' => 'يرجي ادخال الوصف',
        ]);


        Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => auth()->user()->name
        ]);
        session()->flash('Add', 'تم ادخال القسم بنجاج');
        return redirect()->back();
    }


    public function show()
    {
    }


    public function edit($id)
    {
        return 'edit' . $id;
    }


    public function update(Request $request)
    {

        $id = $request->id;

        $this->validate($request, [

            'section_name' => 'required|max:255|unique:sections,section_name,' . $id,
            // 'description' => 'required',
        ], [

            'section_name.required' => 'يرجي ادخال اسم القسم',
            'section_name.unique' => 'اسم القسم مسجل مسبقا',
            'description.required' => 'يرجي ادخال البيان',

        ]);

        $sections = Section::find($id);
        $sections->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);
        // return redirect('/sections');
        session()->flash('edit', 'تم تعديل القسم بنجاج');
        return redirect()->back();
    }


    public function destroy(Request $request)
    {
        $id = $request->id;
        Section::destroy($id);
        session()->flash('delete', 'تم حذف القسم بنجاج');
        return redirect()->back();
    }
}