<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class PostAttachments extends Model
{
    use HasFactory;

    protected $table='post_attachments';

    protected $fillable = [
        'post_uuid',
        'post_user_uuid',
        'file_path',
        'file_type',
        'file_extension',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the Post that owns the PostAttachments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Post(): BelongsTo
    {
        return $this->belongsTo(PostFeed::class, 'post_id', 'post_uuid');
    }

    /**
     * Get the sharedSource that owns the PostAttachments
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function SharedPost(): BelongsTo
    {
        return $this->belongsTo(PostFeed::class, 'share_source', 'post_uuid');
    }

}
