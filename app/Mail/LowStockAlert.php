<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LowStockAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $productName;
    public $batchId;
    public $quantity;

    public function __construct($productName, $batchId, $quantity)
    {
        $this->productName = $productName;
        $this->batchId = $batchId;
        $this->quantity = $quantity;
    }

    public function build()
    {
        return $this->subject('Low Stock Alert')
            ->view('emails.low_stock_alert');
    }
}
