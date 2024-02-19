<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class Register extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    // GET /sales: List all sales instances in database and return list view of Sale.
    public function index(Request $req)
    {
        $sales = Sale::all(); // array of Sale objects probably.
        return view("sales.index", [
            "sales" => $sales,
        ]);
    }

    // POST /sales: Create sale instance and redirect to sale details page.
    public function store(Request $req)
    {
        $sale = Sale::create();
        return redirect("/sales/" . $sale->id . "/edit");
    }

    // GET /sales/{id}/edit: See details of Sale and edit them in this page.
    public function edit(Request $req, int $id)
    {
        $sale = Sale::findOrFail($id);
        return view("sales.details", [
            "sale" => $sale,
        ]);
    }

    // PUT /sales/{id}: Edit details of Sale.
    public function update(Request $req, int $id)
    {
        $sale = Sale::findOrFail($id);
        $endRoute = redirect("/sales/" . $id . "/edit");
        $updateMethods = ["add_item", "update_item", "remove_item", "set_member"];
        if ($req->perform == $updateMethods[0]) {
            // Add item to Sale
            $sale->addItem($req->item_id, $req->quantity);
            return $endRoute;
        }
        if ($req->perform == $updateMethods[1]) {
            // Update item on Sale
            $sale->updateItem($req->line_id, $req->quantity);
            return $endRoute;
        }
        if ($req->perform == $updateMethods[2]) {
            // Remove item from  Sale
            $sale->removeItem($req->line_id);
            return $endRoute;
        }
        if ($req->perform == $updateMethods[3]) {
            $sale->setMemberId($req->member_id);
            return $endRoute;
        }
        abort(403);
    }

    // POST /sales/{id}/pay: Start payment process of Sale.
    public function pay(Request $req, int $id) {
        $sale = Sale::findOrFail($id);
        $endRoute = redirect("/sales/" . $id . "/edit");
        if ($req->amount_paid) {
            $state = $sale->pay($req->amount_paid);
            if ($state) return redirect()->route("sales.index");
        }
        return $endRoute;
    }
}
