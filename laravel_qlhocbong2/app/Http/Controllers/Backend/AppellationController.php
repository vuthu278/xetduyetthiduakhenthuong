<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appellation;
use App\Models\Department;
use App\Models\Semester;
use App\Models\User;
use App\Models\Branch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppellationController extends Controller
{
    public function index(Request $request)
    {
        $appellations =  Appellation::whereRaw(1);
        // $appellations = Appellation::with('semesters:id,s_name');

        // if ($request->semesters_id)
        //     $appellations->where('semesters_id', $request->semesters_id);


        if ($request->type)
            $appellations->where('type', $request->type);
        if ($request->keyword) {
            $appellations->where('name', 'like', '%' . $request->keyword . '%');
        }



        if ($request->time_start && $request->time_stop) {
            // Lọc đúng cả ngày bắt đầu và ngày kết thúc
            $appellations->whereDate('time_start', $request->time_start)
                ->whereDate('time_stop', $request->time_stop);
        } elseif ($request->time_start) {
            // Chỉ lọc theo ngày bắt đầu
            $appellations->whereDate('time_start', $request->time_start);
        } elseif ($request->time_stop) {
            // Chỉ lọc theo ngày kết thúc
            $appellations->whereDate('time_stop', $request->time_stop);
        }






        $appellations  = $appellations->orderByDesc('id')->paginate(20);
        // $semesters = Semester::all();

        $viewData = [
            'appellations' => $appellations,
            // 'semesters' => $semesters
        ];

        return view('backend.appellation.index', $viewData);
    }

    public function create()
    {
        return view('backend.appellation.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token', 'avatar', 'rule');
        $data['created_at'] = Carbon::now();

        if ($request->avatar) {
            $image = upload_image('avatar');
            if (isset($image['code'])) {
                $data['avatar'] = $image['name'];
            }
        }

        if ($request->rule) {
            $image = upload_image('rule', '', ['pdf', 'docx']);
            if (isset($image['code'])) {
                $data['rule'] = $image['name'];
            }
        }

        $appellation = Appellation::create($data);
        session()->flash('success', 'Thêm danh hiệu thành công!');
        return redirect()->route('backend.appellation.index');
    }

    public function edit($id)
    {
        $appellation = Appellation::find($id);

        $viewData = [
            'appellation' => $appellation,
        ];

        return view('backend.appellation.update', $viewData);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token', 'avatar', 'rule');
        if ($request->avatar) {
            $image = upload_image('avatar');
            if (isset($image['code'])) {
                $data['avatar'] = $image['name'];
            }
        }

        if ($request->rule) {
            $image = upload_image('rule', '', ['pdf', 'docx']);
            if (isset($image['code'])) {
                $data['rule'] = $image['name'];
            }
        }

        $data['updated_at'] = Carbon::now();
        Appellation::find($id)->update($data);

        session()->flash('success', 'Cập nhật danh hiệu thành công!');
        return redirect()->route('backend.appellation.index');
    }

    public function delete($id)
    {
        $user = Appellation::find($id);
        if ($user) $user->delete();
        session()->flash('success', 'Xóa danh hiệu thành công!');
        return redirect()->route('backend.appellation.index');
    }
}
