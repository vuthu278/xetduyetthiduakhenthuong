<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateMysqlToMongo extends Command
{
    protected $signature = 'migrate:mysql-to-mongo
                            {--fresh : Xóa dữ liệu Mongo trước khi migrate}';

    protected $description = 'Migrate dữ liệu từ MySQL sang MongoDB (theo thứ tự phụ thuộc)';

    /**
     * Thứ tự migrate: parent trước, child sau (theo FK)
     */
    protected array $tables = [
        'departments'      => 'departments',
        'branchs'          => 'branchs',
        'class'            => 'class',
        'semesters'        => 'semesters',
        'type_scholarship' => 'type_scholarship',
        'appellations'     => 'appellations',
        'users'            => 'users',
        'admins'           => 'admins',
        'appellations_register' => 'appellations_register',
        'chat_histories'   => 'chat_histories',
    ];

    public function handle(): int
    {
        if (! extension_loaded('pdo_mysql')) {
            $this->error('Cần cài extension pdo_mysql để đọc MySQL.');
            return 1;
        }

        try {
            DB::connection('mysql_source')->getPdo();
        } catch (\Throwable $e) {
            $this->error('Không kết nối được MySQL. Kiểm tra MYSQL_* trong .env');
            $this->error($e->getMessage());
            return 1;
        }

        try {
            DB::connection('mongodb')->getMongoDB()->listCollections();
        } catch (\Throwable $e) {
            $this->error('Không kết nối được MongoDB. Kiểm tra DB_* trong .env');
            $this->error($e->getMessage());
            return 1;
        }

        if ($this->option('fresh')) {
            $this->warn('Đang xóa collections Mongo...');
            foreach ($this->tables as $mysqlTable => $mongoCollection) {
                try {
                    DB::connection('mongodb')->getCollection($mongoCollection)->drop();
                    $this->line("  - Đã xóa: {$mongoCollection}");
                } catch (\Throwable) {
                    // Collection chưa tồn tại
                }
            }
        }

        $this->info('Bắt đầu migrate MySQL → MongoDB...');

        foreach ($this->tables as $mysqlTable => $mongoCollection) {
            if (! Schema::connection('mysql_source')->hasTable($mysqlTable)) {
                $this->warn("  Bỏ qua {$mysqlTable} (bảng không tồn tại)");
                continue;
            }

            $rows = DB::connection('mysql_source')->table($mysqlTable)->get();
            $count = $rows->count();

            if ($count === 0) {
                $this->line("  {$mysqlTable} → {$mongoCollection}: 0 bản ghi");
                continue;
            }

            $docs = $rows->map(fn ($row) => $this->rowToDoc($row))->toArray();

            try {
                $collection = DB::connection('mongodb')->getCollection($mongoCollection);
                $collection->insertMany($docs);
                $this->info("  {$mysqlTable} → {$mongoCollection}: {$count} bản ghi");
            } catch (\Throwable $e) {
                $this->error("  Lỗi {$mysqlTable}: " . $e->getMessage());
            }
        }

        $this->info('Hoàn thành migrate.');
        return 0;
    }

    protected function rowToDoc(object $row): array
    {
        $arr = (array) $row;
        $doc = [];

        foreach ($arr as $key => $value) {
            if ($key === 'id') {
                $doc['_id'] = $value;
                continue;
            }
            $doc[$key] = $value;
        }

        if (! isset($doc['_id'])) {
            $doc['_id'] = $arr['id'] ?? null;
        }

        return $doc;
    }
}
