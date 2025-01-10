<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $query = Catalogue::query();

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('part_no', 'like', "%{$search}%")
                ->orWhere('nsn', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        }

        // Paginate the results
        $cat_parts = $query->paginate(20); // 20 rows per page

        return view('admin.catalogue.index', compact('cat_parts'));
    }

    



    function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'cat_file' => 'required|mimes:xlsx,xls',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cat_filePath = $request->file('cat_file')->getRealPath();

        $rows = Excel::toArray([], $cat_filePath);

        foreach ($rows[0] as $row) {
            $item_no = isset($row[0]) ? $row[0] : null;
            $smr_code = isset($row[1]) ? $row[1] : null;
            $nsn = isset($row[2]) ? $row[2] : null;
            $cagec = isset($row[3]) ? $row[3] : null;
            $part_no = isset($row[4]) ? $row[4] : null;
            $description = isset($row[5]) ? $row[5] : null;
            $page_no = isset($row[7]) ? $row[7] : null;

            $catalogPartList = new Catalogue();

            $catalogPartList->item_no = $item_no;
            $catalogPartList->part_no = $part_no;
            $catalogPartList->nsn = $nsn;
            $catalogPartList->description = $description;
            $catalogPartList->cagec = $cagec;
            $catalogPartList->page_no = $page_no;

            $catalogPartList->save();
        }

        return redirect()->back()->with('success_message', 'Excel data loaded and saved successfully.');
    }





    public function update(Request $request, Catalogue $catalogue)
    {
        $validated = $request->validate([
            'item_no' => 'nullable|integer',
            'cagec' => 'nullable|string|max:255',
            'nsn' => 'nullable|string|max:255',
            'part_no' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'page_no' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update the catalogue fields
        $catalogue->item_no = $validated['item_no'] ?? $catalogue->item_no;
        $catalogue->cagec = $validated['cagec'] ?? $catalogue->cagec;
        $catalogue->nsn = $validated['nsn'] ?? $catalogue->nsn;
        $catalogue->part_no = $validated['part_no'] ?? $catalogue->part_no;
        $catalogue->description = $validated['description'] ?? $catalogue->description;
        $catalogue->page_no = $validated['page_no'] ?? $catalogue->page_no;

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($catalogue->image_path && file_exists(storage_path('app/public/' . $catalogue->image_path))) {
                unlink(storage_path('app/public/' . $catalogue->image_path));
            }

            // Rename the uploaded image using `part_no`
            $newImageName = $catalogue->part_no . '.' . $request->file('image')->extension();
            $imagePath = $request->file('image')->storeAs('catalogue_images', $newImageName, 'public');
            $catalogue->image_path = $imagePath;
        }

        // Save the updated catalogue
        $catalogue->save();

        return redirect()->back()->with('success_message', $catalogue->description.' updated successfully!');
    }



   
}