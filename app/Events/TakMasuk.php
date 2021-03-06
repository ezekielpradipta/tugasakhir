<?php

namespace App\Events;
use App\Models\Inputtak;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TakMasuk implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
  

    public $inputtak;
    public $user;
    public $dosen;
    public $mahasiswa_image;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Inputtak $inputtak,$dosen)
    {
        $this->inputtak = $inputtak;
        $this->user = $inputtak->mahasiswa->mahasiswa_nama;
        $this->mahasiswa_image = $inputtak->mahasiswa->mahasiswa_image;
        $this->dosen = $dosen;
    
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['takmasuk'.$this->dosen];
     
    }
}
