<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanApplication extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function loan_type (){
        return $this->belongsTo(LoanTypes::class);
    }
}
