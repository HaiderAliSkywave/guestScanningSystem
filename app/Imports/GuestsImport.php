<?php

namespace App\Imports;

use App\Models\Guest;
use App\Models\Title;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Illuminate\Support\Facades\Storage;

class GuestsImport implements ToModel, WithHeadingRow, WithEvents
{
    private $images = [];

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Find or create the title
        $title = Title::firstOrCreate(['name' => trim($row['title'])]);

        // Get the image path for the current row
        $imagePath = $this->images[$row['eng_name']] ?? null;

        return new Guest([
            'eng_name' => trim($row['eng_name']),
            'arabic_name' => trim($row['arabic_name']),
            'photo' => $imagePath, // Use the extracted image path
            'seat_number' => trim($row['seat_number']),
            'title_id' => $title->id,
            'status' => trim($row['status']),
        ]);
    }

    /**
     * Register events to handle image extraction
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $drawingCollection = $sheet->getDrawingCollection();

                foreach ($drawingCollection as $drawing) {
                    if ($drawing instanceof MemoryDrawing) {
                        $coordinates = $drawing->getCoordinates(); // Get the cell coordinates (e.g., 'A1')
                        $rowNumber = $this->getRowNumberFromCoordinates($coordinates);

                        // Get the corresponding row data
                        $row = $sheet->rangeToArray('A' . $rowNumber . ':F' . $rowNumber, null, true, false)[0];

                        // Generate a unique image name
                        $imageName = uniqid() . '.png';
                        $imagePath = 'images/' . $imageName;

                        // Save the image to storage
                        Storage::disk('public')->put($imagePath, $drawing->getImageResource());

                        // Map the image to the guest's name
                        $this->images[$row[0]] = $imagePath; // Assuming 'eng_name' is in the first column
                    }
                }
            },
        ];
    }

    /**
     * Extract the row number from cell coordinates (e.g., 'A1' => 1)
     *
     * @param string $coordinates
     * @return int
     */
    private function getRowNumberFromCoordinates($coordinates)
    {
        preg_match('/\d+/', $coordinates, $matches);
        return (int) $matches[0];
    }
}