<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentDeletionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'requested_by',
        'reason',
        'status',
        'processed_by',
        'rejection_reason',
        'processed_at',
        'document_title',
        'document_file_number'
    ];

    protected $casts = [
        'processed_at' => 'datetime'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class)->withTrashed();
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
