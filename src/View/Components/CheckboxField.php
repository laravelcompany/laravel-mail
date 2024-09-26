<?php

declare(strict_types=1);

namespace LaravelCompany\Mail\View\Components;

use Illuminate\View\Component;

class CheckboxField extends Component
{
    /** @var string  */
    public string $name;

    /** @var string */
    public string $label;

    /** @var int|mixed */
    public int $value;

    /** @var bool */
    public bool $checked;

    /**
     * Create the component instance.
     *
     * @param string $name
     * @param string $label
     * @param int $value
     * @param bool $checked
     */
    public function __construct(string $name, string $label = '', int $value = 1, bool $checked = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->checked = $checked;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('laravel-mail::components.checkbox-field');
    }
}
