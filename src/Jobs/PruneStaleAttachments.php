<?php

namespace Brgmn\NovaCKEditor\Jobs;

use Brgmn\NovaCKEditor\Models\PendingAttachment;

class PruneStaleAttachments
{
    /**
     * Prune the stale attachments from the system.
     *
     * @return void
     */
    public function __invoke()
    {
        config('ckeditor.pending_attachment_model')::where('created_at', '<=', now()->subDays(1))
            ->orderBy('id', 'desc')
            ->chunk(100, function ($attachments) {
                $attachments->each->purge();
            });
    }
}
