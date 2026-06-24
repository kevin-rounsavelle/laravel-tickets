<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketReply;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketAttachmentService
{
    /**
     * @param  array<int, UploadedFile>  $files
     */
    public function storeForTicket(Ticket $ticket, array $files, ?TicketReply $reply = null): void
    {
        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $filename = $file->store('ticket-attachments/'.$ticket->id, 'public');

            TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'ticket_reply_id' => $reply?->id,
                'filename' => $filename,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType() ?? 'application/octet-stream',
                'size' => $file->getSize() ?? 0,
            ]);
        }
    }

    public function extractReplyTokenFromEmail(string $recipient): ?string
    {
        if (preg_match('/reply\+([a-zA-Z0-9]+)@/', $recipient, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function stripQuotedReply(string $body): string
    {
        $lines = preg_split('/\R/', $body) ?: [];
        $clean = [];

        foreach ($lines as $line) {
            if (preg_match('/^(On .+ wrote:|From:|>|-----Original Message-----)/i', trim($line))) {
                break;
            }

            $clean[] = $line;
        }

        return trim(implode("\n", $clean));
    }
}