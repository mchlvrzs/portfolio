<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        return view('portfolio.index', [
            'profile' => Profile::query()->first(),
            'services' => Service::query()->orderBy('sort_order')->get(),
            'skills' => Skill::query()->orderBy('sort_order')->get()->groupBy('category'),
            'projects' => Project::query()->orderBy('sort_order')->get()->groupBy('category'),
            'experiences' => Experience::query()->orderBy('sort_order')->get(),
        ]);
    }
}
