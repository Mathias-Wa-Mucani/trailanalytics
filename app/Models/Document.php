<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    protected $table = 'rec_z_documents';

    use HasFactory;
    protected $fillable = [
        'description',
        'original_name',
        'path',
        'sections',
        'document_tag',
        'documentable_id',
        'documentable_name',
        'mime_type',
        'document_size',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function documentable()
    {
        return $this->morphTo();
    }
}
