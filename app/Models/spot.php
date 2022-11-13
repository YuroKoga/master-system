<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spot extends Model
{
    use HasFactory;
    protected $table = 'spots';
    public function getData()
    {
        return 'スポット名：' . $this->name;
    }
}
