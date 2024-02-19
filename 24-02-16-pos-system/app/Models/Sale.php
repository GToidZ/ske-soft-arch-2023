<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\LineItem;
use App\Models\Payment;
use App\Models\Member;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id'
    ];

    protected function items(): Attribute {
        return Attribute::make(
            get: fn () => LineItem::where('sale_id', $this->id)->get()
        );
    }

    protected function paid(): Attribute {
        return Attribute::make(
            get: fn () => Payment::where('sale_id', $this->id)->get()->isNotEmpty()
        );
    }

    public function addItem(int $itemId, int $quantity = 1) {
        LineItem::create([
            'sale_id' => $this->id,
            'item_id' => $itemId,
            'quantity' => $quantity
        ]);
    }

    public function updateItem(int $lineId, int $quantity) {
        if (!$this->items->contains($lineId)) {
            abort(403);
        }
        $line = $this->items->find($lineId);
        $line->update(['quantity' => $quantity]);
    }

    public function removeItem(int $lineId) {
        if (!$this->items->contains($lineId)) {
            abort(403);
        }
        $line = $this->items->find($lineId);
        $line->delete(); 
    }

    public function setMemberId(int $memberId) {
        if (Member::find($memberId)) {
            $this->update([
                'member_id' => $memberId
            ]);
        }
    }

    public function pay(int $amount): bool {
        $total = 0.0;
        foreach ($this->items as $i) {
            $total += $i->getItem()->price * $i->quantity;
        }

        if ($this->member_id) $total = $total * 0.9;
        
        if ($amount == $total) {
            Payment::create([
                'sale_id' => $this->id,
                'amount' => $amount
            ]);
            return true;
        }

        return false;
    }
}
