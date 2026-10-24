<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GenericForm extends Component
{
    public array $breadcrumbs;
    public array $field;
    public string $title;
    public string $icon;
    public string $action;
    public string $method;

    /**
     * Create a new component instance.
     */
    public function __construct(
        array $breadcrumbs  = [],
        array $field = [],
        string $title = '',
        string $icon = '',
        string $action = '',
        string $method = 'POST'
    ) {
        $this->breadcrumbs = $breadcrumbs;
        $this->field = $field;
        $this->title = $title;
        $this->icon = $icon;
        $this->action = $action;
        $this->method = strtoupper($method);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.generic-form');
    }
}
