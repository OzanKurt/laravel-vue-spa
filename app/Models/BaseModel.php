<?php

namespace App\Models;

use App\Models\Traits\HasDates;
use App\Models\Traits\NullableFields;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 *
 * @package App\Models
 */
class BaseModel extends Model
{
    use HasDates, NullableFields;
}
