<?php

namespace Maatwebsitevthree\Excel\Tests\Data\Stubs;

use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Maatwebsitevthree\Excel\Concerns\FromView;
use Maatwebsitevthree\Excel\Concerns\Exportable;

class SheetForUsersFromView implements FromView
{
    use Exportable;

    /**
     * @var Collection
     */
    protected $users;

    /**
     * @param Collection $users
     */
    public function __construct(Collection $users)
    {
        $this->users = $users;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('users', [
            'users' => $this->users,
        ]);
    }
}
