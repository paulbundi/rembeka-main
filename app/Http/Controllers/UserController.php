<?php

namespace App\Http\Controllers;

use App\Auth\ImpersonationManager;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can-access:users.view')->only('index');
        $this->middleware('can-access:users.create')->only('create');
        $this->middleware('can-access:users.update')->only('edit');
    }

    /**
     * @return void
     */
    public function index()
    {
        return view('dashboard.page', ['page' => 'users-index']);
    }

    /**
     * @return void
     */
    public function getCorporate()
    {
        return view('dashboard.page', ['page' => 'corporate-users-index']);
    }

    /**
     * @return void
     */
    public function create()
    {
        return view('dashboard.page', ['page' => 'users-create']);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function edit(int $id)
    {
        return view('dashboard.page', ['page' => 'users-create', 'id' => $id]);
    }

    /**
     * @param int $id
     *
     * @return void
     */
    public function show(int $id)
    {
        return view('dashboard.page', ['page' => 'users-show', 'id' => $id]);
    }

    /**
     * Impersonate a user.
     *
     * @param Request              $request
     * @param User                 $user
     * @param ImpersonationManager $manager
     *
     * @return RedirectResponse
     */
    public function impersonate(Request $request, User $user, ImpersonationManager $manager): RedirectResponse
    {
        if ($manager->impersonate($request->user(), $user)) {
            return redirect()->route('dashboard');
        }

        return redirect('/users');
    }

    /**
     * Stop impersonating a user.
     *
     * @param ImpersonationManager $manager
     *
     * @return RedirectResponse
     */
    public function exitImpersonation(ImpersonationManager $manager): RedirectResponse
    {
        $manager->exit();

        return redirect()->route('dashboard');
    }
}
