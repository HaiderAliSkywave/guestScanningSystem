<?php

namespace App\Http\Controllers;

use App\Models\Guest as GuestModel;
use App\Models\Title;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;

class Guest extends Controller
{
    public function import(Request $request)
    {
        try {
            $filePath = $request->file('excelSheet')->getRealPath();
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();

            foreach ($sheet->getRowIterator(2) as $row) {
                $rowIndex = $row->getRowIndex();
                $data = [];

                foreach ($row->getCellIterator() as $cell) {
                    $data[] = $cell->getValue();
                }

                // Process Image from Cell
                $drawingCollection = $sheet->getDrawingCollection();
                $imagePath = null;

                foreach ($drawingCollection as $drawing) {
                    if ($drawing->getCoordinates() == "C{$rowIndex}") { // Image in column 'C'
                        $imageExtension = pathinfo($drawing->getPath(), PATHINFO_EXTENSION);
                        $imageName = uniqid() . '.' . $imageExtension;
                        $imagePath = "uploads/{$imageName}";

                        // Store the image in the public directory
                        Storage::put($imagePath, file_get_contents($drawing->getPath()));

                        $imageUrl = Storage::disk('s3')->url($imagePath);
                    }
                }

                $title = Title::firstOrCreate(['name' => $data[4]]);

                // Save Data in Database
                GuestModel::create([
                    'eng_name' => $data[0],
                    'arabic_name' => $data[1],
                    'photo' => $imageUrl,
                    'seat_number' => $data[3],
                    'title_id' => $title->id,
                    'status' => $data[5],
                ]);
            }

            return back()->with('success', 'List imported successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: Could not import the list. Please remove all the cells that contain spaces only or create a new list without a non-empty cell.');
        }
    }

    public function search () {
        $guests = GuestModel::with('title')
            ->where('status', 'yet to arrive')
            ->get();
        
        return view('search', compact('guests'));
    }

    // public function searchGuests (Request $request) {
    //     $search = $request->query('name');

    //     if ($search) {
    //         $guests = GuestModel::with('title')
    //         ->where('status', 'yet to arrive')
    //         ->where('eng_name', 'like', '%' . $search . '%')
    //         ->orWhere('arabic_name', 'like', '%' . $search . '%')
    //         ->get();

    //         return response(['guests' => $guests], 200);
    //     }

    //     return response(['guests' => []], 200);
    // }

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

    public function editGuest (GuestModel $guest) {
        $titles = Title::all();

        return view('edit', compact('guest', 'titles'));
    }

    public function editGuestDetails (Request $request, GuestModel $guest) {
        try {
                $imagePath = null;
                $imageUrl = null;
                if ($request->photo) {
                    Storage::delete($guest->photo);
                    $imageName = uniqid() . '.' . pathinfo($request->photo->getClientOriginalName(), PATHINFO_EXTENSION);
                    $imagePath = "uploads/{$imageName}";
                    Storage::put($imagePath, file_get_contents(request('photo')));
                    $imageUrl = Storage::disk('s3')->url($imagePath);
                } else {
                    $imagePath = $guest->photo;
                }

                $title = Title::find(request('title'));

                $guest->update([
                    'eng_name' => request('eng_name'),
                    'arabic_name' => request('arabic_name'),
                    'seat_number' => request('seat_number'),
                    'photo' => $imageUrl,
                    'title_id' => $title->id,
                ]);

                return redirect('/search')->with('success', 'Guest details updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: Could not update the guest details. Please try again.');
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

    public function onSeatGuests () {
        $guests = GuestModel::with('title')
        ->where('status', 'on seat')
        ->orderBy('updated_at', 'desc')
        ->get();

        return view('on-seat', compact('guests'));
    }

    public function revertGuestStatus () {
        try {
                $guest = GuestModel::find(request('guest'));
                $guest->status = 'incoming';
                $guest->save();

                return response(['success' => 'Confirmed!'], 200);
        } catch (\Exception $e) {
            return response(['error' => 'Try again!']);
        }
    }
}
