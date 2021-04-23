<?php

namespace App\View\Components\Web\Home;

use App\Eloquent\Scopes\OrderByScope;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RandomContributors extends Component
{
    public function __construct(public int $limit = 6)
    {
    }

    public function render(): View
    {
        return view('components.web.home.random-contributors');
    }

    public function contributors(): Collection
    {
        return User::query()
            ->withoutGlobalScope(OrderByScope::class)
            ->inRandomOrder()
            ->whereIsRegistered()
            ->has('contributions')
            ->limit($this->limit)
            ->get();
    }
}
