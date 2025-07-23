<?php

return [
     [
        'name' => 'Quản lý quản trị viên',
        'route' => 'backend.account.index',
        'segment' => ['account']
    ],
    [
        'name' => 'Quản lý ứng viên',
        'route' => 'backend.user.index',
        'segment' => ['user']
    ],
    // [
    //     'name' => 'QL đợt thi đua',
    //     'route' => 'backend.semester.index',
    //     'segment' => ['semester']
    // ],
//    [
//        'name' => 'QL lớp',
//        'route' => 'backend.class.index',
//        'segment' => ['class']
//    ],
//    [
//        'name' => 'QL ngành',
//        'route' => 'backend.branch.index',
//        'segment' => ['branch']
//    ],
    [
        'name' => 'Quản lý đơn vị',
        'route' => 'backend.department.index',
        'segment' => ['department']
    ],
//    [
//        'name' => 'QL nhà tài trợ',
//        'route' => '',
//        'segment' => ['']
//    ],
//    [
//        'name' => 'QL ĐK học bổng',
//        'route' => '',
//        'segment' => ['']
//    ],
//    [
//        'name' => 'QL loại học bổng',
//        'route' => 'backend.type_scholarship.index',
//        'segment' => ['type-scholarship']
//    ],
    [
        'name' => 'Danh sách danh hiệu',
        'route' => 'backend.appellation.index',
        'segment' => ['appellation']
    ],
    [
        'name' => 'Xét duyệt khen thưởng',
        'route' => 'backend.appellation_register.index',
        'segment' => ['appellation-register']
    ],
   
    [
        'name' => 'Thống kê',
        'route' => 'backend.dashboard',
        'segment' => ['dashboard']
    ],

];
