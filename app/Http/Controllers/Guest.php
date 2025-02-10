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

            return back()->with('success', 'List imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: Could not import the list. Please remove all the cells that contain spaces only or create a new list without a non-empty cell.');
        }
    }

    public function search () {
        return view('search');
    }

    public function searchGuests (Request $request) {
        $search = $request->query('name');

        if ($search) {
            $guests = GuestModel::with('title')
            ->where('status', 'yet to arrive')
            ->where('eng_name', 'like', '%' . $search . '%')
            ->orWhere('arabic_name', 'like', '%' . $search . '%')
            ->get();

            return response(['guests' => $guests], 200);
        }

        return response(['guests' => []], 200);
    }

    public function confirmGuest () {
        try {
            $guest = GuestModel::find(request('guest'));
            $guest->status = 'incoming';
            $guest->save();

            return response(['success' => 'Confirmed!'], 200);
        } catch (\Exception $e) {
            return response(['error' => 'Try again!']);
        }
    }

    public function incomingGuests (Request $request) {
        $guests = GuestModel::with('title')
        ->where('status', 'incoming')
        ->orderBy('updated_at', 'desc')
        ->get();

        if ($request->ajax()) {
            return response(['guests' => $guests], 200);
        }
        
        return view('incoming');
    }

    public function onSeat () {
        try {
                $guest = GuestModel::find(request('guest'));
                $guest->status = 'on seat';
                $guest->save();

                return response(['success' => 'Confirmed!'], 200);
        } catch (\Exception $e) {
            return response(['error' => 'Try again!']);
        }
    }
}
