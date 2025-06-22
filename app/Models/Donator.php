<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donator extends Model
{


    protected $table = 'donators';
    protected $primaryKey ='id';
    protected $fillable = ['Name1','amount'];
   // use HasFactory;


    public function transactions() 
    {
    return $this->hasMany(Transaction::class);
    }   


   
}
