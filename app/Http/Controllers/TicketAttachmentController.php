<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TicketAttachmentController extends Controller
{
    public function download(Ticket $ticket, TicketAttachment $attachment): StreamedResponse
    {
        $this->authorizeAttachment($ticket, $attachment);

        abort_unless(Storage::disk('public')->exists($attachment->filename), 404);

        return Storage::disk('public')->download($attachment->filename, $attachment->original_name);
    }

    private function authorizeAttachment(Ticket $ticket, TicketAttachment $attachment): void
    {
        abort_unless($attachment->ticket_id === $ticket->id, 404);

        $user = request()->user();

        if ($user && ($user->isAdmin() || $ticket->user_id === $user->id)) {
            return;
        }

        abort(403);
    }
}