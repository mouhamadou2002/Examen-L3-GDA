<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderPlaced extends Notification
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $pdf = \PDF::loadView('invoices.invoice_pdf', ['order' => $this->order]);
        $filename = 'facture_commande_' . $this->order->id . '.pdf';

        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Confirmation de votre commande #' . $this->order->id)
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Votre commande a bien été enregistrée.')
            ->line('Numéro de commande : ' . $this->order->id)
            ->line('Montant total : ' . number_format($this->order->total, 0, ',', ' ') . ' F CFA')
            ->line('Statut : ' . ucfirst(str_replace('_', ' ', $this->order->status)))
            ->action('Voir mes commandes', url(route('shop.myOrders')))
            ->line('Merci pour votre confiance !')
            ->attachData($pdf->output(), $filename, [
                'mime' => 'application/pdf',
            ]);
    }
} 