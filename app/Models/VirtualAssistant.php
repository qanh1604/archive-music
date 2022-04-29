<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Seller;

class VirtualAssistant extends Model
{
    protected $table = "virtual_assistant";
    protected $fillable = ['video'];

    public function seller(){
    	return $this->hasOne(Seller::class);
    }
}
