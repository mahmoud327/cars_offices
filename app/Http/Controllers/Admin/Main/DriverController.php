<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Office;

use App\DataTables\DriverDataTable;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DriverDataTable $type)
   {

        return $type->render('admin.drivers.index');

        // return view('layouts.main');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.drivers.create');
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
            'name' => 'required|unique:drivers,name',
            'phone' => 'required|unique:drivers,phone',
            'car_name' => 'required',
            'plate' => 'required|unique:drivers,plate',
            'office_id'=>'required',
            'type_id'=>'required'

          ];

          $messages = [
            'name.required' => 'اسم السائق مطلوب',
            'name.unique' => 'اسم السائق موجود بالفعل ',
            'phone.required' => 'رقم السائق مطلوب',
            'phone.unique' => 'رقم التلفون موجود بالفعل ',
            'car_name.required' => 'اسم السياره مطلوب',
            'plate.required' => 'رفم اللوحه مطلوب',
            'plate.unique' => 'رقم اللوحه موجود بالفعل ',
            'office_id.required' => 'اسم المكتب مطلوب',
            'type_id.required' => ' الفئه مطلوب',

          ];

          $this->validate($request, $rules, $messages);

          $record = Driver::create($request->all());

          flash()->success("تم إضافة سائق بنجاح");

          return redirect(route('driver.index'));
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
        $model = Driver::findOrFail($id);
        $office=Office::pluck('name','id');
        $selectedid=$model->office_id;
        return view('admin.drivers.edit', compact('model','office','selectedid'));
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
            'name' => 'required|unique:drivers,name,'.$id,
            'phone' => 'required|unique:drivers,phone,'.$id,
            'plate' => 'required|unique:drivers,plate,'.$id,
            'car_name' => 'required|unique:drivers,car_name,'.$id,
            'office_id'=>'required',
            'type_id'=>'required'
        ];
        $messages = [
            'name.required' => 'اسم السائق مطلوب',
            'name.unique' => 'اسم السائق موجود بالفعل ',
            'phone.required' => 'رقم السائق مطلوب',
            'phone.unique' => 'رقم التلفون موجود بالفعل ',
            'car_name.required' => 'اسم السياره مطلوب',
            'plate.required' => 'رفم اللوحه مطلوب',
            'plate.unique' => 'رقم اللوحه موجود بالفعل ',
            'office_id.required' => 'اسم المكتب مطلوب',
            'type_id.required' => ' الفئه مطلوب',

          ];
        $this->validate($request, $rules, $messages);

        $record = Driver::findOrFail($id);
        $record->update($request->all());
        flash()->success("تم التعديل بنجاح");
        return redirect(route('driver.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $record = Driver::findOrFail($request->drive_id);
        $record->delete();
        flash()->success("تم الحذف بنجاح");
        return back();
    }
    public function multi_delete() {
		if (is_array(request('item'))) {
			Driver::destroy(request('item'));
		} else {
			Driver::find(request('item'))->delete();
		}
		session()->flash('success','تم الحذف بنجاح');
		return redirect()->back();
	}
    
    public function activate($id)
    {
        $user = Driver::findOrFail($id);
        $user->activate = 1;
        $user->save();

        flash()->success('تم التفعيل');
        return back();
    }
    public function deactivate($id)
    {
        $user = Driver::findOrFail($id);
        $user->activate = 0;
        $user->save();

        flash()->success('تم إلغاء التفعيل');
        return back();
    }
}