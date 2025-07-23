<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Appellation;
use App\Models\AppellationRegister;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function Symfony\Component\String\u;
use DB;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AppellationRegisterController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');

        $appellationsRegister = AppellationRegister::with(
            'appellation:id,name,avatar',
            'user:id,name,department_id'
        )->whereRaw(1);

        // Lọc theo trạng thái
        if (!is_null($status) && $status !== '') {
            $appellationsRegister = $appellationsRegister->where(function ($query) use ($status) {
                if ($status == 0 || $status === '0') {
                    $query->where('status', 0);
                } else {
                    $query->where('status', $status);
                }
            });
        }

        // Lọc theo loại danh hiệu
        if ($request->type) {
            $appellationsRegister = $appellationsRegister->whereHas('appellation', function ($query) use ($request) {
                $query->where('type', $request->type);
            });
        }

        // Lọc theo tên
        if ($request->name) {
            $appellationsRegister = $appellationsRegister->where('name', 'like', '%' . $request->name . '%');
        }

        // Lọc theo mã
        if ($request->code) {
            $appellationsRegister = $appellationsRegister->where('code', 'like', '%' . $request->code . '%');
        }

        // Lọc theo phòng ban nếu không phải admin cấp cao
        $level = get_data_user('admins', 'level');
        if ($level != 0) {
            $appellationsRegister = $appellationsRegister->whereHas('user', function ($query) use ($level) {
                $query->where('department_id', $level);
            });
        }

        // Lấy dữ liệu cuối cùng
        $appellationsRegister = $appellationsRegister->orderByDesc('id')->paginate(20);
        $appellations = Appellation::all();

        $viewData = [
            'appellationsRegister' => $appellationsRegister,
            'appellations'         => $appellations
        ];

        return view('backend.appellation_register.index', $viewData);
    }


    public function create()
    {
        $user         = User::find(get_data_user('web'));
        $appellations = Appellation::all();
        return view('backend.appellation_register.create', compact('user', 'appellations'));
    }

    public function store(Request $request)
    {
        $data               = $request->except('_token', 'file', 'certification');
        $data['created_at'] = Carbon::now();
        $data['user_id']    = get_data_user('web');

        if ($request->is_suggest) {
            $data['is_suggest'] = 1;
        } else {
            $data['is_suggest'] = 0;
        }

        if ($request->file) {
            $image = upload_image('file', '', ['zip']);
            if (isset($image['code'])) {
                $data['file'] = $image['name'];
            }
        }
        if ($request->certification) {
            $image = upload_image('certification');
            if (isset($image['code'])) {
                $data['certification'] = $image['name'];
            }
        }

        $appellation = AppellationRegister::create($data);
        return redirect()->route('backend.appellation_register.index');
    }

    public function edit($id)
    {
        $appellationRegister = AppellationRegister::find($id);

        $user         = User::find($appellationRegister->user_id);
        $appellations = Appellation::all();

        $viewData = [
            'appellations'        => $appellations,
            'user'                => $user,
            'appellationRegister' => $appellationRegister
        ];

        return view('backend.appellation_register.update', $viewData);
    }

    public function update(Request $request, $id)
    {

        $appellationsRegister = AppellationRegister::with('appellation:id,name,avatar,semesters_name ', 'user:id,name,department_id')->whereRaw(1);
        $data = $request->except('_token', 'file', 'certification');

        if ($request->file) {
            $image = upload_image('file', '', ['zip']);
            if (isset($image['code'])) {
                $data['file'] = $image['name'];
            }
        }
        if ($request->is_suggest) {
            $data['is_suggest'] = 1;
        } else {
            $data['is_suggest'] = 0;
        }
        $data['updated_at'] = Carbon::now();
        $appel = AppellationRegister::find($id);
        if ($request->status == AppellationRegister::STATUS_DAT) {
            $nameUser = mb_strtoupper($request->name);
            $appellationModel = Appellation::find($request->appellation_id);
            $appellation = mb_strtoupper($appellationModel->name ?? '');  // lấy tên danh hiệu

            //$note = mb_strtoupper($request->note);
            // $qrcode = QrCode::format('png')->generate('ANh dinh');

            $image_certifi = Image::make('certificate/certifi.jpg');

            $image_certifi->text($nameUser, 760, 850, function ($font) {
                $font->file(public_path('Roboto-Black.ttf'));
                $font->size(104);
                $font->color('#fd0000');
                $font->align('center');
                $font->valign('bottom');
                $font->angle(0);
            });
            $image_certifi->text($appellation, 760, 1170, function ($font) {
                $font->file(public_path('Roboto-Bold.ttf'));
                $font->size(60);
                $font->color('#fd0000');
                $font->align('center');
                $font->valign('bottom');
                $font->angle(0);
            });
            //$image_certifi->text($note, 760, 1250, function ($font) {
            //    $font->file(public_path('Roboto-Light.ttf'));
            //   $font->size(60);
            //   $font->color('#fd0000');
            //   $font->align('center');
            //   $font->valign('bottom');
            //  $font->angle(0);
            // });

            $appellations = Appellation::all();

            $name_file_certify = 'certifyCertify-' . time() . '.jpg';
            $path_render = 'certificate/' . $name_file_certify;
            $link_image = url($path_render);

            // Tạo mã qr code cho chứng nhận
            $path_qrcode = 'certificate/-' . time() . '.png';
            QrCode::format('png')->size(200)->generate($link_image, public_path($path_qrcode));

            $img_qrcode = public_path($path_qrcode);

            $image_certifi->insert(Image::make($img_qrcode), 'top-left', 150, 1600);


            $image_certifi->save($path_render);
            $_REQUEST['certification'] = $image_certifi;

            $appel->certification = $name_file_certify;
        }
        $appel->time_process = new Carbon();
        $appel->status = $request->status;
        $appel->note = $request->note;
        $appel->save();
        session()->flash('success', 'Cập nhật danh hiệu xét duyệt thành công!');
        return redirect()->route('backend.appellation_register.index');
    }


    public function delete($id)
    {
        $user = AppellationRegister::find($id);
        if ($user) $user->delete();
        session()->flash('success', 'Xóa danh hiệu xét duyệt thành công!');
        return redirect()->route('backend.appellation_register.index');
    }
}
