<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\LengthAwarePaginator;
class DataController extends Controller
{

    public function show(Request $request) {

        $filePath = storage_path('app/data.json');

        if (File::exists($filePath)) {
            $jsonData = File::get($filePath);
            if ($jsonData) {
                $data = json_decode($jsonData);
            } else {
                $data = $this->getDataFromJson();
            }

            // Sort selected criteria
            $sortBy = $request->input('sort_by', 'id');

            //sorting for IDs
            if ($sortBy === 'id') {
                usort($data, function($a, $b) {
                    return $a->id - $b->id;
                });
            } else {
                // Use string comparison
                usort($data, function($a, $b) use ($sortBy) {
                    return strcmp($a->$sortBy, $b->$sortBy);
                });
            }
            return view('crudapp', compact('data', 'sortBy'));
        } else {

            abort(404, 'JSON file not found');
        }
    }
    public function crudappPost(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required',
            'gender' => 'required',
        ]);

        $filename = storage_path('app/data.json');
        $currentData = json_decode(file_get_contents($filename), true) ?? [];
        //         if($currentData)
        //         echo 'hello';
        // print_r($currentData);
        if (!empty($currentData)) {
            $id = max(array_column($currentData, 'id')) + 1; /// check previous id and create new id
        }else{
            $id=1; /// if previous data not present then id  should be start from 1
        }
        echo $id;
       // die;
        $data = [
            'id' => $id,
            'name' => $request->input('name'),

            'image' => $request->file('image')->store('images', 'public'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
        ];

        $currentData[] = $data;
        file_put_contents($filename, json_encode($currentData));

        return redirect()->back()->with('success', 'Data saved successfully!');
    }
    public function update(Request $request, $id)
    {
         // Data from the JSON file
        $jsonData = File::get(storage_path('app/data.json'));
        $data = json_decode($jsonData, true);
        // Find the item by ID
        foreach ($data as $index => $item) {
            if ($item['id'] == $id) {
                // Update the data
                $data[$index]['name'] = $request->input('name');
                $data[$index]['address'] = $request->input('address');
                $data[$index]['gender'] = $request->input('gender');

                $request->validate([
                    'name' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                    'address' => 'required',
                    'gender' => 'required',
                ]);

                // Update the image if new file is uploaded
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('images', 'public');
                    $data[$index]['image'] = $imagePath;
                }

                // Save the updated data into JSON file
                File::put(storage_path('app/data.json'), json_encode($data));

                return redirect()->back()->with('success', 'Data updated successfully!');
            }
        }

        return redirect()->back()->with('error', 'Data not found.');
    }
    public function view($id)
    {
        $jsonData = Storage::get('data.json');
        $data = json_decode($jsonData);
        // Find the data by ID
        $selectedData = null;
        foreach ($data as $item) {
            if ($item->id == $id) {
                $selectedData = $item;
                break;
            }
        }

        // Check if data ID exists
        if (!$selectedData) {
            abort(404);
        }

        return view('crudapp', ['data' => $selectedData]);
    }

    private function getDataFromJson()
    {
        $filePath = storage_path('app/data.json');
        $jsonData = File::get($filePath);
        return json_decode($jsonData);
    }

    public function destroy($id)
    {
        $filePath = storage_path('app/data.json');

        if (File::exists($filePath)) {
            $jsonData = File::get($filePath);
            $data = json_decode($jsonData, true);

            // Find the index of the item to delete according to ID
            $index = array_search($id, array_column($data, 'id'));

            if ($index !== false) {
                // Get the image path
                $imagePath = public_path('storage/') . $data[$index]['image'];
                if (File::exists($imagePath)) {
                    // Delete the image file
                    File::delete($imagePath);
                }

                // Remove the item from the array
                array_splice($data, $index, 1);
                $jsonData = json_encode($data);
                File::put($filePath, $jsonData);
                return redirect()->back()->with('success', 'Item deleted successfully.');
            } else {
                return redirect()->back()->with('error', 'Item not found.');
            }
        } else {
            return redirect()->back()->with('error', 'JSON file not found.');
        }
    }

}
