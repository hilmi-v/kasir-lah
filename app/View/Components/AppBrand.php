<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppBrand extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'HTML'
                <a href="/" wire:navigate>
                    <!-- Hidden when collapsed -->
                    <div {{ $attributes->class(["hidden-when-collapsed"]) }}>
                        <div class="flex md:flex-col flex-row items-center gap-2 mb-3">
                            <img src="{{ asset('logo.svg') }}" alt="" class="md:w-24 w-12 -mb-1.5">
                            <span class="font-bold text-2xl text-success  ">
                                Shoeventory
                            </span>
                        </div>
                    </div>

                    <!-- Display when collapsed -->
                    <div class="display-when-collapsed hidden mx-5 mt-5 mb-1 h-[28px]">
                        <img src="{{ asset('logo.svg') }}" alt="" class="w-6 -mb-1.5">
                    </div>
                </a>
            HTML;
    }
}
