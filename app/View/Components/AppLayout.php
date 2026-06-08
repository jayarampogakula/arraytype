<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $hideLeftSidebar;
    public $hideRightSidebar;

    public function __construct($hideLeftSidebar = false, $hideRightSidebar = false)
    {
        $this->hideLeftSidebar = filter_var($hideLeftSidebar, FILTER_VALIDATE_BOOLEAN);
        $this->hideRightSidebar = filter_var($hideRightSidebar, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
