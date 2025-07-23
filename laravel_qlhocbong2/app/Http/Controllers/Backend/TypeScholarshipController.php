<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeScholarshipRequest;
use App\Models\TypeScholarship;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TypeScholarshipController extends Controller
{
    public function index()
    {
        $typeScholarship =  TypeScholarship::orderByDesc('id')
            ->paginate(20);

        $viewData = [
            'typeScholarship' => $typeScholarship
        ];

        return view('backend.type_scholarship.index', $viewData);
    }

    public function create()
    {
        return view('backend.type_scholarship.create');
    }

    public function store(TypeScholarshipRequest $request)
    {
        $data = $request->except('_token');
        $data['created_at'] = Carbon::now();
        $typeScholarship = TypeScholarship::create($data);
        return redirect()->route('backend.type_scholarship.index');
    }

    public function edit($id)
    {
        $typeScholarship = TypeScholarship::find($id);
        return view('backend.type_scholarship.update', compact('typeScholarship'));
    }

    public function update(TypeScholarshipRequest $request, $id)
    {
        $data = $request->except('_token');
        $data['updated_at'] = Carbon::now();
        TypeScholarship::find($id)->update($data);

        return redirect()->route('backend.type_scholarship.index');
    }

    public function delete($id)
    {
        $typeScholarship = TypeScholarship::find($id);
        if ($typeScholarship) $typeScholarship->delete();
        return redirect()->route('backend.type_scholarship.index');
    }
}
