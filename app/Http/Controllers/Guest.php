<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuestsImport;
use App\Models\Guest as GuestModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Guest extends Controller
{
    public function import(Request $request) {
        try {
            $excelSheet = $request->file('excelSheet');

            Excel::import(new GuestsImport, $excelSheet);

            return 
            '<p style="color: green; font-weight: bold;">
                Success: Imported Successfully.
            </p>';
        } catch (\Exception $e) {
            return
            '<p style="color: red; font-weight: bold;">
                Error: All the cells in the excel sheet should only contain values (without spaces).
            </p>';
        }
    }

    public function search () {
        return view('search');
    }

    public function searchGuests (Request $request) {
        $search = $request->query('name');

        if ($search) {
            $guests = GuestModel::select('eng_name', 'arabic_name', 'photo', 'seat_number')
            ->where('eng_name', 'like', '%' . $search . '%')
            ->orWhere('arabic_name', 'like', '%' . $search . '%')
            ->get();

            return response(['guests' => $guests], 200);
        }

        return response(['guests' => []], 200);
    }
}
