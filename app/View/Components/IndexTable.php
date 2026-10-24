<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Contracts\Pagination\Paginator;

class IndexTable extends Component
{
    public array $breadcrumbs;
    public array $columns;
    public Paginator $datas;
    public array $actions;
    public array $filters;

    public function __construct(
        array $columns,
        array $breadcrumbs  = [],
        Paginator $datas,
        array $actions = [],
        array $filters = []
    ) {
        $this->columns = $columns;
        $this->breadcrumbs = $breadcrumbs;
        $this->datas = $datas;
        $this->actions = $actions;
        $this->filters = $filters;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.index-table');
    }
}
