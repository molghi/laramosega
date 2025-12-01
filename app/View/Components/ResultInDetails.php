<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ResultInDetails extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $type, public array $resultData, public array $details, public array|string $seasons, public array $bookmarkIds)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.result-in-details');
    }
}
