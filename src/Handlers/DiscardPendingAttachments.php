<?php

namespace Brgmn\NovaCKEditor\Handlers;

use Illuminate\Http\Request;
use Brgmn\NovaCKEditor\Models\PendingAttachment;

class DiscardPendingAttachments
{
    /**
     * Discard pendings attachments on the field.
     *
     * @param  Request $request
     * @return void
     */
    public function __invoke(Request $request)
    {
        config('ckeditor.pending_attachment_model')::where('draft_id', $request->draftId)
            ->get()
            ->each
            ->purge();
    }
}
