<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderStatusUpdated extends Notification
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
        return (new MailMessage)
            ->subject('Mise à jour du statut de votre commande #' . $this->order->id)
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Le statut de votre commande a été mis à jour.')
            ->line('Nouveau statut : ' . ucfirst(str_replace('_', ' ', $this->order->status)))
            ->action('Voir ma commande', url(route('shop.orderDetail', $this->order->id)))
            ->line('Merci pour votre confiance !');
    }
} 