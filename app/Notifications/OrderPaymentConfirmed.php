<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderPaymentConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Paiement confirmé pour votre commande #' . $this->order->id)
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Le paiement de votre commande a bien été confirmé.')
            ->line('Numéro de commande : ' . $this->order->id)
            ->line('Montant total : ' . $this->order->total . ' F CFA')
            ->action('Voir ma commande', url(route('shop.orderDetail', $this->order->id)))
            ->line('Merci pour votre confiance !');
    }

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'total' => $this->order->total,
            'payment' => true,
            'created_at' => $this->order->updated_at,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'total' => $this->order->total,
            'payment' => true,
            'created_at' => $this->order->updated_at,
        ];
    }
} 