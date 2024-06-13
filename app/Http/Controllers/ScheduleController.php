<?php

namespace App\Http\Controllers;

use App\Services\Contract\SchedulerService;

class ScheduleController extends Controller
{
    public function __construct(private SchedulerService $scheduler)
    {

    }
    public function index()
    {
        return $this->scheduler->generate();
    }

}
