<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\ClassModel;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $class =  ClassModel::with('branch:id,b_name')
            ->orderByDesc('id')
            ->paginate(20);

        $viewData = [
            'class' => $class
        ];

        return view('backend.class.index', $viewData);
    }

    public function create()
    {
        $branchs = Branch::all();
        return view('backend.class.create', compact('branchs'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['created_at'] = Carbon::now();
        ClassModel::create($data);
        return redirect()->route('backend.class.index');
    }

    public function edit($id)
    {
        $branchs = Branch::all();
        $class = ClassModel::find($id);
        return view('backend.class.update', compact('branchs','class'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $data['updated_at'] = Carbon::now();
        ClassModel::find($id)->update($data);

        return redirect()->route('backend.class.index');
    }

    public function delete($id)
    {
        $class = ClassModel::find($id);
        if ($class) $class->delete();
        return redirect()->route('backend.class.index');
    }
}
