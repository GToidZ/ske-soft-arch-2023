<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;
use App\Models\Item;

class LineItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'item_id',
        'quantity'
    ];

    public function getSale() {
        return Sale::findOrFail($this->sale_id);
    }

    public function getItem() {
        return Item::findOrFail($this->item_id);
    }
}
