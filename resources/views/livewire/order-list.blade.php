<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{On, Title};

new #[Title('Order List')] class extends Component {
    public array $orderList = [];

    public function mount()
    {
        $this->orderList = session()->get('orderList', []);
    }

    public function addItem($itemId)
    {
        if (isset($this->orderList[$itemId])) {
            $this->orderList[$itemId]['quantity']++;
        }

        $this->updateOrderList();
    }
    public function removeItem($itemId)
    {
        if (isset($this->orderList[$itemId])) {
            unset($this->orderList[$itemId]);
        }

        $this->updateOrderList();
    }

    public function decreaseItem($itemId)
    {
        if (isset($this->orderList[$itemId])) {
            $this->orderList[$itemId]['quantity']--;

            if ($this->orderList[$itemId]['quantity'] <= 0) {
                unset($this->orderList[$itemId]);
            }
        }

        $this->updateOrderList();
    }

    public function clearOrderList()
    {
        $this->orderList = [];
        $this->updateOrderList();
    }

    private function updateOrderList()
    {
        session()->put('orderList', $this->orderList);
        $this->dispatch('$refresh');
        $this->dispatch('order-list-updated');
    } // ✅ Listen for the Livewire event

    #[On('orderListUpdated')]
    public function refreshOrderList()
    {
        $this->orderList = session()->get('orderList', []);
    }

    public function getOrderCount(): int
    {
        // return count($this->orderList);
        return array_sum(array_column($this->orderList, 'quantity'));
    }

    public function with()
    {
        return [
            'orderList' => $this->orderList,
        ];
    }
}; ?>

<x-menu-drawer side="right" size="lg" :iconBadge="$this->getOrderCount()">
    <x-slot:buttonIcon>
        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 512 512">
            <path fill="currentColor"
                d="M103.432 17.844a87 87 0 0 0-3.348.08q-3.822.163-7.604.678c-20.167 2.747-39.158 13.667-52.324 33.67c-24.613 37.4 2.194 98.025 56.625 98.025c.536 0 1.058-.012 1.583-.022v.704h60.565c-10.758 31.994-30.298 66.596-52.448 101.43a283 283 0 0 0-6.29 10.406l34.878 35.733l-56.263 9.423c-32.728 85.966-27.42 182.074 48.277 182.074v-.002l9.31.066c23.83-.57 46.732-4.298 61.325-12.887c4.174-2.458 7.63-5.237 10.467-8.42h-32.446c-20.33 5.95-40.8-6.94-47.396-25.922c-8.956-25.77 7.52-52.36 31.867-60.452a55.6 55.6 0 0 1 17.565-2.834v-.406h178.33c-.57-44.403 16.35-90.125 49.184-126c23.955-26.176 42.03-60.624 51.3-94.846l-41.225-24.932l38.272-6.906l-43.37-25.807h-.005l.002-.002l.002.002l52.127-8.85c-5.232-39.134-28.84-68.113-77.37-68.113C341.14 32.26 222.11 35.29 149.34 28.496c-14.888-6.763-30.547-10.723-45.908-10.652m.464 18.703c13.137.043 27.407 3.804 41.247 10.63l.033-.07c4.667 4.735 8.542 9.737 11.68 14.985H82.92l10.574 14.78c10.608 14.83 19.803 31.99 21.09 42.024c.643 5.017-.11 7.167-1.814 8.836c-1.705 1.67-6.228 3.875-15.99 3.875c-40.587 0-56.878-44.952-41.012-69.06C66.238 46.64 79.582 39.22 95.002 37.12a64 64 0 0 1 8.894-.573M118.5 80.78h46.28c4.275 15.734 3.656 33.07-.544 51.51H131.52c1.9-5.027 2.268-10.574 1.6-15.77c-1.527-11.913-7.405-24.065-14.62-35.74m101.553 317.095c6.44 6.84 11.192 15.31 13.37 24.914c3.797 16.736 3.092 31.208-1.767 43.204c-4.526 11.175-12.576 19.79-22.29 26h237.19c14.448 0 24.887-5.678 32.2-14.318c7.312-8.64 11.2-20.514 10.705-32.352a47.7 47.7 0 0 0-2.407-13.18l-69.91-8.205l42.017-20.528c-8.32-3.442-18.64-5.537-31.375-5.537H220.053zm-42.668.506a37 37 0 0 0-3.457.153a34.8 34.8 0 0 0-7.824 1.63c-15.11 5.02-25.338 21.54-20.11 36.583c3.673 10.57 15.347 17.71 25.654 13.938l1.555-.57h43.354c.946-6.36.754-13.882-1.358-23.192c-3.71-16.358-20.543-28.483-37.815-28.54z" />
        </svg>
    </x-slot:buttonIcon>
    <x-slot:header>
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 512 512">
                <path fill="currentColor"
                    d="M103.432 17.844a87 87 0 0 0-3.348.08q-3.822.163-7.604.678c-20.167 2.747-39.158 13.667-52.324 33.67c-24.613 37.4 2.194 98.025 56.625 98.025c.536 0 1.058-.012 1.583-.022v.704h60.565c-10.758 31.994-30.298 66.596-52.448 101.43a283 283 0 0 0-6.29 10.406l34.878 35.733l-56.263 9.423c-32.728 85.966-27.42 182.074 48.277 182.074v-.002l9.31.066c23.83-.57 46.732-4.298 61.325-12.887c4.174-2.458 7.63-5.237 10.467-8.42h-32.446c-20.33 5.95-40.8-6.94-47.396-25.922c-8.956-25.77 7.52-52.36 31.867-60.452a55.6 55.6 0 0 1 17.565-2.834v-.406h178.33c-.57-44.403 16.35-90.125 49.184-126c23.955-26.176 42.03-60.624 51.3-94.846l-41.225-24.932l38.272-6.906l-43.37-25.807h-.005l.002-.002l.002.002l52.127-8.85c-5.232-39.134-28.84-68.113-77.37-68.113C341.14 32.26 222.11 35.29 149.34 28.496c-14.888-6.763-30.547-10.723-45.908-10.652m.464 18.703c13.137.043 27.407 3.804 41.247 10.63l.033-.07c4.667 4.735 8.542 9.737 11.68 14.985H82.92l10.574 14.78c10.608 14.83 19.803 31.99 21.09 42.024c.643 5.017-.11 7.167-1.814 8.836c-1.705 1.67-6.228 3.875-15.99 3.875c-40.587 0-56.878-44.952-41.012-69.06C66.238 46.64 79.582 39.22 95.002 37.12a64 64 0 0 1 8.894-.573M118.5 80.78h46.28c4.275 15.734 3.656 33.07-.544 51.51H131.52c1.9-5.027 2.268-10.574 1.6-15.77c-1.527-11.913-7.405-24.065-14.62-35.74m101.553 317.095c6.44 6.84 11.192 15.31 13.37 24.914c3.797 16.736 3.092 31.208-1.767 43.204c-4.526 11.175-12.576 19.79-22.29 26h237.19c14.448 0 24.887-5.678 32.2-14.318c7.312-8.64 11.2-20.514 10.705-32.352a47.7 47.7 0 0 0-2.407-13.18l-69.91-8.205l42.017-20.528c-8.32-3.442-18.64-5.537-31.375-5.537H220.053zm-42.668.506a37 37 0 0 0-3.457.153a34.8 34.8 0 0 0-7.824 1.63c-15.11 5.02-25.338 21.54-20.11 36.583c3.673 10.57 15.347 17.71 25.654 13.938l1.555-.57h43.354c.946-6.36.754-13.882-1.358-23.192c-3.71-16.358-20.543-28.483-37.815-28.54z" />
            </svg>
            <div class="text-lg font-semibold">Order List</div>
        </div>
    </x-slot:header>

    <div class="flex flex-col gap-4" x-data x-init="window.addEventListener('order-list-updated', () => { Livewire.dispatch('orderListUpdated'); })">
        @if (count($orderList) === 0)
            <x-app-paragraph>Your order list is empty.</x-app-paragraph>
        @else
            <div class="flex flex-col gap-2">
                @foreach ($orderList as $itemId => $item)
                    <div class="flex items-center justify-between bg-neutral px-4 py-2 rounded-lg">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('storage/' . $item['image']) }}" alt=""
                                class="size-16 object-cover rounded-md" />
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-between gap-2 w-full bg-neutral rounded-full">
                                <x-app-button wire:click="decreaseItem({{ $itemId }})" variant="ghost"
                                    rounded><svg class="size-6" data-slot="icon" fill="currentColor" viewBox="0 0 16 16"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z"></path>
                                    </svg></x-app-button>
                                <div class="px-3 py-1.5 text-lg font-bold text-center">{{ $item['quantity'] }}</div>
                                <x-app-button
                                    wire:click="addItem({{ $itemId }}, '{{ $item['name'] }}', '{{ $item['image'] }}')"
                                    variant="ghost" rounded><svg class="size-6" data-slot="icon" fill="currentColor"
                                        viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path
                                            d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z">
                                        </path>
                                    </svg>
                                </x-app-button>
                            </div>

                            <x-app-button wire:click="removeItem({{ $itemId }})" color="danger" size="small">

                                <svg class="size-4" data-slot="icon" fill="currentColor" viewBox="0 0 16 16"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path
                                        d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z">
                                    </path>
                                </svg>
                            </x-app-button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    <x-slot:footer>
        @if (count($orderList) > 0)
            <x-app-button wire:click="clearOrderList" label="Clear all" color="danger" />
        @endif
    </x-slot:footer>
</x-menu-drawer>
