<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\ClassModel;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters =  Semester::orderByDesc('id')
            ->paginate(20);

        $viewData = [
            'semesters' => $semesters
        ];

        return view('backend.semester.index', $viewData);
    }

    public function create()
    {
        return view('backend.semester.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['created_at'] = Carbon::now();
        Semester::create($data);
        return redirect()->route('backend.semester.index');
    }

    public function edit($id)
    {
        $semester = Semester::find($id);
        return view('backend.semester.update', compact('semester'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $data['updated_at'] = Carbon::now();
        Semester::find($id)->update($data);

        return redirect()->route('backend.semester.index');
    }

    public function delete($id)
    {
        $class = Semester::find($id);
        if ($class) $class->delete();
        return redirect()->route('backend.semester.index');
    }
}
