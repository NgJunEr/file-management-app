<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'contact', 'note'];

    public function prs()
    {
        return $this->hasMany(Pr::class);
    }
}
