<?php

namespace App\Events;

use App\Models\Promo;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PromoProcessed
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * The push notification instance.
     *
     * @var \App\Models\Promo
     */
    public $promo;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Promo $promo)
    {
        $this->$promo = $promo;
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
