<?php

/**
 * Created by PhpStorm.
 * User: trungphuna
 * Date: 12/4/21
 * Time: 1:01 AM
 */

return [
    [
        'name' => 'Thông tin',
        'route' => 'user.index',
        'segment' => ['user'],
        'active_routes' => ['user.index'],
    ],
    [
        'name' => 'Cập nhật mật khẩu',
        'route' => 'user.change_password',
        'segment' => ['change-password'],
        'active_routes' => ['user.change_password'],
    ],
    [
        'name' => 'Danh hiệu của bạn',
        'route' => 'user.appellation_register.index',
        'segment' => ['appellation-register'],
        'active_routes' => [
            'user.appellation_register.index',
            'user.appellation_register.update',
        ],
    ],
    [
        'name' => 'Danh sách danh hiệu',
        'route' => 'user.appellation.index',
        'segment' => ['appellation'],
        'active_routes' => [
            'user.appellation.index',              // danh sách danh hiệu
            'user.appellation_register.create',    // form đăng ký
        ],
    ],
];
