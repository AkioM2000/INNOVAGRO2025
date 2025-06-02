<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpkPpbj extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nomor_dokumen',
        'tanggal',
        'perihal',
        'keterangan',
        'lampiran',
        'uploaded_by',
        'approver_name',
        'approved_at',
        'approval_notes'
    ];

    protected $dates = ['tanggal'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal' => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user who uploaded this document
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
