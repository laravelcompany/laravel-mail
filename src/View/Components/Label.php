<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Label extends Component
{
    /** @var string */
    public string $name;

    /**
     * Create the component instance.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     */
    public function render(): View
    {
        return view('laravel-mail::components.label');
    }
}
