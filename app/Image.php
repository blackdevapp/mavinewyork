<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/** use soft delete to add a delete_at record instead of remove data @by: @MAGIC 20191011 */
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
    protected $table = 'image';
}
