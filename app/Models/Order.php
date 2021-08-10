<?php

namespace App\Models;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email'];

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalAttribute(){
        return $this->items->sum(function(OrderItem $item){
            return $item->price * $item->quantity;
        });
    }
}
