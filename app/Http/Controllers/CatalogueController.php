<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class CatalogueController extends Controller
{
    function index(Request $request) {
        // $cat_parts=Catalogue::all();
        // $cat_parts = Catalogue::paginate(50);
        $searchQuery = $request->input('search');
    
    $cat_parts = Catalogue::query()
        ->when($searchQuery, function($query, $searchQuery) {
            return $query->where('part_no', 'like', "%{$searchQuery}%")
                         ->orWhere('nsn', 'like', "%{$searchQuery}%")
                         ->orWhere('description', 'like', "%{$searchQuery}%");
        })
        ->paginate(30);
        return view('admin.catalogue.index',compact('cat_parts','searchQuery'));
    }









    function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'cat_file' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cat_filePath = $request->file('cat_file')->getRealPath();

        // Load cat_file file using Laravel cat_file
        $rows = Excel::toArray([], $cat_filePath);

        // dd($rows);

        foreach ($rows[0] as $row) {
            // Modify the column indices according to your Excel file structure
            $item_no = isset($row[0]) ? $row[0] : null;
            $smr_code = isset($row[1]) ? $row[1] : null;
            $nsn = isset($row[2]) ? $row[2] : null;
            $cagec = isset($row[3]) ? $row[3] : null;
            $part_no = isset($row[4]) ? $row[4] : null;
            $description = isset($row[5]) ? $row[5] : null;
            $page_no = isset($row[7]) ? $row[7] : null;

            // Check if item_no is an integer, if not, skip this row
            // if (!is_numeric($item_no)) {
            //     continue;
            // }
            

            // Create a new CatalogPartList instance
            $catalogPartList = new Catalogue();

            // Set the values for attributes
            $catalogPartList->item_no = $item_no;
            $catalogPartList->part_no = $part_no;
            $catalogPartList->nsn = $nsn;
            $catalogPartList->description = $description;
            $catalogPartList->cagec = $cagec;
            $catalogPartList->page_no = $page_no;

            // Save the record
            $catalogPartList->save();
        }

        return redirect()->back()->with('success_message', 'Excel data loaded and saved successfully.');
    }


   
}