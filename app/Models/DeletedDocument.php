<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Document;
use App\Models\User;
use App\Models\DocumentDeletionRequest;

class DeletedDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'deleted_by',
        'deletion_request_id',
        'reason'
    ];

    public function document()
    {
        return $this->belongsTo(Document::class)->withTrashed();
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function deletionRequest()
    {
        return $this->belongsTo(DocumentDeletionRequest::class);
    }
}
