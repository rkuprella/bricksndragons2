<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Title};

new #[Title('About')] class extends Component {
    //
}; ?>

<div class="flex flex-col gap-12 lg:gap-24">
    <x-page-hero title="About" />
    <x-about-features />
</div>
