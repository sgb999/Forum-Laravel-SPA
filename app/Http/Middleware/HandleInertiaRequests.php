<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

use function array_merge;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request) : ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     */
    public function share(Request $request) : array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'login' => auth()->check(),
                'user'  => [
                    'id'       => auth()->check() ? auth()->id() : null,
                    'username' => auth()->check() ? auth()->user()->username : null,
                ],
            ],
            'csrf' => csrf_token(),
        ]);
    }
}
