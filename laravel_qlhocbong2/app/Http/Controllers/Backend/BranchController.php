<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeScholarshipRequest;
use App\Models\Branch;
use App\Models\Department;
use App\Models\TypeScholarship;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function index()
    {
        $branchs =  Branch::with('department:id,d_name')
        ->orderByDesc('id')
            ->paginate(20);

        $viewData = [
            'branchs' => $branchs
        ];

        return view('backend.branch.index', $viewData);
    }

    public function create()
    {
        $departments = Department::all();
        return view('backend.branch.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $data['created_at'] = Carbon::now();
        Branch::create($data);
        return redirect()->route('backend.branch.index');
    }

    public function edit($id)
    {
        $departments = Department::all();
        $branch = Branch::find($id);
        return view('backend.branch.update', compact('departments','branch'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $data['updated_at'] = Carbon::now();
        Branch::find($id)->update($data);

        return redirect()->route('backend.branch.index');
    }

    public function delete($id)
    {
        $branch = Branch::find($id);
        if ($branch) $branch->delete();
        return redirect()->route('backend.branch.index');
    }
}
