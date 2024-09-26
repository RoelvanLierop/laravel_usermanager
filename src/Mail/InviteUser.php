<?php

namespace Roelvanlierop\Usermanager\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Roelvanlierop\Usermanager\Models\TeamsInvites;
use Roelvanlierop\Usermanager\Models\Teams;

class InviteUser extends Mailable
{
    use Queueable, SerializesModels;

    private $invite, $team;

    /**
     * @param TeamsInvites $invite
     * @param Teams $team
     */
    public function __construct( TeamsInvites $invite, Teams $team ) {
        $this->invite = $invite;
        $this->team = $team;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation to join the project',
            from: new Address(
                config('usermanager.email_address.mail'),
                config('usermanager.email_address.name')
            ),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'usermanager::mail.invite',
            with: [
                'invite' => $this->invite,
                'team' => $this->team,
                'uri' => route('team_acceptinvite', [ 'key' => $this->invite->invite_key ] )
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

}
