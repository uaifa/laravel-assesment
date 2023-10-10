<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $table = 'quotes';
    protected $primaryKey = 'id';
    protected $fillable = ['quote', 'created_by'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'favorites', 'quote_id', 'user_id');
    }

}
