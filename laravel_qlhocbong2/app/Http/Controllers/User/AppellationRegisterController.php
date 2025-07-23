<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Appellation;
use App\Models\AppellationRegister;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppellationRegisterController extends Controller
{
    public function index(Request $request)
    {
        $appellationsRegister = AppellationRegister::with('appellation:id,name,note')->whereRaw(1);

        $appellationsRegister->where('user_id', get_data_user('web'));

        if ($request->filled('name')) {
            $appellationsRegister->whereHas('appellation', function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->name . '%');
            });
        }

        if (!is_null($request->status) && $request->status !== "") {
            $appellationsRegister->where('status', $request->status);
        }


        if ($request->filled('register_date')) {
            $appellationsRegister->whereDate('created_at', '=', $request->register_date);
        }

        $appellationsRegister = $appellationsRegister->orderByDesc('id')->paginate(20);

        return view('user.appellation_register.index', [
            'appellationsRegister' => $appellationsRegister,
            'query' => $request->query()
        ]);
    }


    public function create(Request $request)
    {
        $user = User::find(get_data_user('web'));
        $type = get_data_user('web', 'type');
        $appellations = Appellation::where('type', $type)->get();

        $appellation = null;
        if ($request->has('appellation')) {
            $appellation = Appellation::find($request->get('appellation'));
        }

        return view('user.appellation_register.create', compact('user', 'appellations', 'appellation'));
    }

    public function store(Request $request)
    {
        $data               = $request->except('_token', 'file', 'proof');
        $data['created_at'] = Carbon::now();
        $data['user_id']    = get_data_user('web');
        if ($request->file) {
            $image = upload_image('file', '', ['docx', 'pdf', 'jpg', 'png']);
            if (isset($image['code'])) {
                $data['file'] = $image['name'];
            }
        }
        if ($request->proof) {
            $image = upload_image('proof', '', ['docx', 'doc', 'pdf', 'jpg', 'jpeg', 'png', 'zip']);
            if (isset($image['code']) && $image['code'] == 1) {
                $data['proof'] = $image['name'];
            }
        }


        $appellation = AppellationRegister::create($data);
        session()->flash('success', 'Đăng ký xét duyệt danh hiệu thành công!');
        return redirect()->route('user.appellation_register.index');
    }

    public function edit($id)
    {
        $appellationRegister = AppellationRegister::find($id);

        $user         = User::find(get_data_user('web'));
        $type = get_data_user('web', 'type');
        $appellations =  Appellation::where('type', $type)->get();

        $viewData = [
            'appellations'        => $appellations,
            'user'                => $user,
            'appellationRegister' => $appellationRegister
        ];

        return view('user.appellation_register.update', $viewData);
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token', 'file', 'proof');
        if ($request->file) {
            $image = upload_image('file', '', ['docx', 'pdf', 'jpg', 'png']);
            if (isset($image['code'])) {
                $data['file'] = $image['name'];
            }
        }
        if ($request->proof) {
            $image = upload_image('proof', '', ['docx', 'doc', 'pdf', 'jpg', 'jpeg', 'png', 'zip']);
            if (isset($image['code']) && $image['code'] == 1) {
                $data['proof'] = $image['name'];
            }
        }

        $data['updated_at'] = Carbon::now();

        AppellationRegister::find($id)->update($data);
        session()->flash('success', 'Cập nhật danh hiệu xét duyệt thành công!');
        return redirect()->route('user.appellation_register.index');
    }

    public function delete($id)
    {
        $user = AppellationRegister::find($id);
        if ($user && $user->status === 1) $user->delete();
        return redirect()->route('user.appellation_register.index');
    }
}
