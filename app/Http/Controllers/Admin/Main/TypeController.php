<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\DataTables\TypeDataTable;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TypeDataTable $type)
   {

        return $type->render('admin.types.index');

        // return view('layouts.main');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:types,name',
  

          ];

          $messages = [
            'name.required' => 'اسم العمل مطلوب',
            'name.unique' => 'اسم العمل موجود بالفعل ',
          ];

          $this->validate($request, $rules, $messages);

          $record = Type::create($request->all());

          flash()->success("تم إضافة عمل بنجاح");

          return redirect(route('types.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Type::findOrFail($id);
        return view('admin.types.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|unique:types,name,'.$id
        ];

        $messages = [
            'name.required' => 'اسم العمل مطلوب',
            'name.unique' => 'اسم العمل موجود بالفعل '
        ];
        $this->validate($request, $rules, $messages);

        $record = Type::findOrFail($id);
        $record->update($request->all());
        flash()->success("تم التعديل بنجاح");
        return redirect(route('types.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $record = Type::findOrFail($request->type_id);
        $record->delete();
        flash()->success("تم الحذف بنجاح");
        return back();
    }
    public function multi_delete() {
		if (is_array(request('item'))) {
			Type::destroy(request('item'));
		} else {
			Type::find(request('item'))->delete();
		}
		session()->flash('success','تم الحذف بنجاح');
		return redirect()->back();
	}
}
