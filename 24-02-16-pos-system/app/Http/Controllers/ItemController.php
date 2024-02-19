<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Item;

class ItemController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $req) {
        return view('items.index', [
            'items' => Item::all()
        ]);
    }

    public function store(Request $req) {
        $validator = Validator::make($req->all(), [
            'description' => 'required|min:4',
            'price' => 'required'
        ]);

        if (!$validator->fails()) {
            Item::create([
                'description' => $req->description,
                'price' => $req->price
            ]);
        }
        
        return redirect()->route('items.index');
    }

    public function edit(Request $req, int $id) {
        $item = Item::findOrFail($id);
        return view('item.details', [
            'item' => $item
        ]);
    }

    public function update(Request $req, int $id) {
        Item::find($id)->update($req->all());
        return redirect('items.index');
    }

    public function destroy(Request $req, int $id) {
        Item::find($id)->delete();
        return redirect('items.index');
    }
}
