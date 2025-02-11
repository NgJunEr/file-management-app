<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'contact_name', 'note'];

    public function prs()
    {
        return $this->hasMany(Pr::class);
    }
}
