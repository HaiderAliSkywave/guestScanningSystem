<?php

namespace App\Imports;

use App\Models\Guest;
use App\Models\Title;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuestsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $title = Title::firstOrCreate(['name' => $row['title']]);

        return new Guest([
            'eng_name' => trim($row['eng_name']),
            'arabic_name' => trim($row['arabic_name']),
            'photo' => trim($row['photo']),
            'seat_number' => trim($row['seat_number']),
            'title_id' => trim($title->id),
            'status' => trim($row['status']),
        ]);
    }
}
