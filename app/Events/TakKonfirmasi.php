<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\NotifTakMasuk;
use App\Models\Dosen;
use App\Models\Mahasiswa;
class TakKonfirmasi implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $notif;
    public $dosen_nama;
    public $mahasiswa;
    public $dosen_image;
    public $notif_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(NotifTakMasuk $notif, $mahasiswa)
    {
        $this->notif = $notif;
        $this->notif_id = $notif->id;
        $this->dosen_image = $notif->dosen->dosen_image;
        $this->dosen_nama = $notif->dosen->dosen_nama;
        $this->mahasiswa = $mahasiswa;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['takkonfirmasi'.$this->mahasiswa];
    }
}
