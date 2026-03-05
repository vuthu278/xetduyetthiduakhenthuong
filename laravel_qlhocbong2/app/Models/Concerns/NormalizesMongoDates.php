<?php

namespace App\Models\Concerns;

use Carbon\CarbonInterface;
use DateTimeInterface;
use Illuminate\Support\Carbon;

/**
 * Chuẩn hóa giá trị date/datetime từ MongoDB (array/BSON) trước khi Laravel cast.
 * Tránh lỗi preg_match() khi HasAttributes::isStandardDateFormat() nhận non-string.
 */
trait NormalizesMongoDates
{
    /**
     * @param  mixed  $value
     * @return \Illuminate\Support\Carbon
     */
    protected function asDateTime($value)
    {
        $value = $this->normalizeMongoDateValue($value);
        return parent::asDateTime($value);
    }

    /**
     * Chuẩn hóa giá trị date từ MongoDB về string hoặc DateTime để parent::asDateTime() xử lý được.
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function normalizeMongoDateValue($value)
    {
        if ($value === null || $value === '') {
            return $value;
        }
        if ($value instanceof CarbonInterface || $value instanceof DateTimeInterface || is_numeric($value)) {
            return $value;
        }
        // MongoDB JSON: ['$date' => '2024-01-01T00:00:00.000Z'] hoặc ['$date' => ...]
        if (is_array($value)) {
            $date = $value['$date'] ?? null;
            if ($date !== null) {
                if (is_string($date)) {
                    return $date;
                }
                if (is_numeric($date)) {
                    // Một số payload dùng milliseconds timestamp
                    return (int) ($date / 1000);
                }
                if (is_array($date)) {
                    // Mongo extended json: {"$date":{"$numberLong":"1741177800000"}}
                    $numberLong = $date['$numberLong'] ?? null;
                    if ($numberLong !== null && is_numeric($numberLong)) {
                        return (int) ($numberLong / 1000);
                    }
                }
                // Nếu là UTCDateTime embedded trong array thì để Jenssegers xử lý tiếp.
                if (is_object($date) && $date instanceof \MongoDB\BSON\UTCDateTime) {
                    return $date;
                }
            }
            // Không để rơi vào Date::parse('') (sẽ thành "now"), dùng epoch để tránh trôi thời gian.
            return 0;
        }
        // MongoDB BSON UTCDateTime -> để nguyên cho Jenssegers\Model xử lý timezone đúng.
        if (is_object($value) && $value instanceof \MongoDB\BSON\UTCDateTime) {
            return $value;
        }
        // Đảm bảo string trước khi vào isStandardDateFormat (tránh preg_match nhận array/object)
        if (! is_string($value)) {
            if (is_object($value) && method_exists($value, '__toString')) {
                return (string) $value;
            }
            return 0;
        }
        return $value;
    }
}
