<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\WhatsAppChannel;
use App\Order;


class OrderProcessed extends Notification
{
  use Queueable;


  public $order;
  
  public function __construct($order)
  {
    $this->order = $order;
  }
  
  public function via($notifiable)
  {
    return [WhatsAppChannel::class];
  }
  
  public function toWhatsApp($notifiable)
  {
    $orderUrl = url("/orders/{$this->order['id']}");
    $company = 'Acme';
    $deliveryDate = '25/05/2029';


    return (new WhatsAppMessage)
        ->content("Your {$company} order of {$this->order['name']} has shipped and should be delivered on {$deliveryDate}. Details: {$orderUrl}");
  }
}