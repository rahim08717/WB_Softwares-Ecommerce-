<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Inertia\Inertia;

class PageViewController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return Inertia::render('Page', ['page' => $page]);
    }
}
