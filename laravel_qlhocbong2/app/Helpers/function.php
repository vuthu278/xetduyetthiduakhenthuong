<?php


if (!function_exists('get_client_ip')) {
    function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}

function routeRuleAdm()
{
    return [
        'backend.dashboard',
        'backend.index',
        'backend.user.index',
        'backend.user.create',
        'backend.user.update',
        'backend.user.delete',
        'backend.appellation_register.index',
        'backend.appellation_register.create',
        'backend.appellation_register.update',
        'backend.appellation_register.delete',
        'backend.appellation.index',
        'backend.activity.index',
        'backend.activity.create',
        'backend.activity.update',
        'backend.activity.delete',
        'backend.activity.qr_codes',
        'backend.activity.generate_qr',
        'backend.activity.show_qr',
        'backend.activity_attendance.index',
        'backend.drl_snapshot.index',
        'backend.drl_snapshot.create',
        'backend.drl_snapshot.show',
    ];
}

if (!function_exists('mongodb_id_string')) {
    /** Chuẩn hóa MongoDB _id (array/object/scalar) thành string cho route/URL. Luôn trả về string. */
    function mongodb_id_string($id)
    {
        if ($id === null || $id === '') {
            return '';
        }
        if (is_array($id)) {
            $v = $id['$oid'] ?? $id['_id'] ?? '';
            return is_array($v) ? '' : (string) $v;
        }
        if (is_object($id)) {
            if (method_exists($id, '__toString')) {
                return (string) $id->__toString();
            }
            $v = $id->{'$oid'} ?? $id->oid ?? $id->id ?? '';
            return is_array($v) ? '' : (string) $v;
        }
        return (string) $id;
    }
}

if( !function_exists('get_data_user'))
{
    function get_data_user($guest, $column = 'id')
    {
        return Auth::guard($guest)->user() ? Auth::guard($guest)->user()->$column : null;
    }
}


if (!function_exists('pare_url_file')) {
    function pare_url_file($file, $folder = '')
    {
        if (!$file) {
            return '/images/no-image.svg';
        }

        // Nếu là đường dẫn HTTP hoặc HTTPS thì trả thẳng về
        if (strpos($file, 'http') !== false) {
            return $file;
        }

        // Nếu không, xử lý file trong uploads (format: 2025-02-28__filename.ext)
        $explode = explode('__', $file);
        if (isset($explode[0])) {
            $time = $explode[0];
            $path = '/uploads' . ($folder ? '/' . $folder : '') . '/' . date('Y/m/d', strtotime($time)) . '/' . $file;
            return $path;
        }

        // File không đúng format upload (thử path trực tiếp)
        if (strpos($file, 'uploads/') === 0 || strpos($file, '/uploads/') === 0) {
            return $file[0] === '/' ? $file : '/' . $file;
        }
        return '/images/no-image.svg';
    }
}


if (!function_exists('upload_image')) {
    /**
     * @param $file [tên file trùng tên input]
     * @param array $extend [ định dạng file có thể upload được]
     * @return array|int [ tham số trả về là 1 mảng - nếu lỗi trả về int ]
     */
    function upload_image($file, $folder = '', array $extend = array())
    {
        $code = 1;
        // lay duong dan anh
        $baseFilename = public_path() . '/uploads/' . $_FILES[$file]['name'];

        // thong tin file
        $info = new SplFileInfo($baseFilename);

        // duoi file
        $ext = strtolower($info->getExtension());

        // kiem tra dinh dang file
        if (!$extend)
            $extend = ['png', 'jpg', 'jpeg', 'webp'];

        if (!in_array($ext, $extend))
            return $data['code'] = 0;

        // Tên file mới
        $nameFile = trim(str_replace('.' . $ext, '', strtolower($info->getFilename())));
        $filename = date('Y-m-d__') . \Illuminate\Support\Str::slug($nameFile) . '.' . $ext;;

        // thu muc goc de upload
        $path = public_path() . '/uploads/' . date('Y/m/d/');
        if ($folder)
            $path = public_path() . '/uploads/' . $folder . '/' . date('Y/m/d/');

        if (!\File::exists($path))
            mkdir($path, 0777, true);

        // di chuyen file vao thu muc uploads
        move_uploaded_file($_FILES[$file]['tmp_name'], $path . $filename);

        $data = [
            'name'     => $filename,
            'code'     => $code,
            'path'     => $path,
            'path_img' => 'uploads/' . $filename
        ];

        return $data;
    }
}
