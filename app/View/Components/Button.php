<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    public ?string $title;
    public string $class;
    public string $type;
    public ?string $href;
    public string $size;
    public string $variant;
    public string $icon;

    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $title = null,
        string $class = '',
        string $type = 'button',
        ?string $href = null,
        string $size = 'md',
        string $variant = 'primary',
        string $icon = ''
    ) {
        $this->title = $title;
        $this->class = $class;
        $this->type = $type;
        $this->href = $href;
        $this->size = $size;
        $this->variant = $variant;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.button');
    }
}
