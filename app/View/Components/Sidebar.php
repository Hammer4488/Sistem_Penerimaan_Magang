<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public $active;

    /**
     * Buat instance komponen baru.
     *
     * @param string $active
     * @return void
     */
    public function __construct($active = 'berandapelamar')
    {
        $this->active = $active;
    }

    /**
     * Dapatkan view / konten yang merepresentasikan komponen.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar');
    }
}