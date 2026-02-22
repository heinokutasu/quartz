<?php

namespace App\Imports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Carbon\Carbon;

class AttendanceImport implements ToModel, WithHeadingRow, WithUpserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row['name'])) {
            return null;
        }
        try {
            // Tell Carbon exactly to look for Day (d), Month (m), then Year (Y)
            $formattedDate = Carbon::createFromFormat('d/m/Y', $row['date'])->format('Y-m-d');
        } catch (\Exception $e) {
            // If the date is already in Y-m-d or another format, try a fallback parse
            $formattedDate = Carbon::parse($row['date'])->format('Y-m-d');
        }

        return new Attendance([
            'employee_name'   => $row['name'],
            'attendance_date' => $formattedDate,
            'clock_in'        => $row['clock_in'],
            'clock_out'       => $row['clock_out'],
            'note'            => $row['note'] ?? null, // Optional note column
        ]);
    }

    /**
     * This tells Laravel which columns to check for duplicates.
     * If these match, it will UPDATE instead of INSERT.
     */
    public function uniqueBy()
    {
        return ['employee_name', 'attendance_date'];
    }
}
