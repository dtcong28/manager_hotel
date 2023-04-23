<?php

namespace App\Http\Middleware;

use App\Http\Resources\CustomerResource;
use App\Http\Resources\HotelResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth.user' => fn () => $request->user()
                ? new UserResource($request->user())
                : null,
            'customer'=> fn () => $request->user('web')
                ? new CustomerResource($request->user('web'))
                : null,
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'flash' => [
                'action_success' => fn () => $request->session()->get('action_success'),
                'action_failed' => fn () => $request->session()->get('action_failed'),
            ],
            'errors' => function () use ($request) {
                return $request->session()->get('errors')
                    ? $request->session()->get('errors')->getBag('default')->getMessages() : (object) [];
            },
            'info_hotel' => function () {
                return new HotelResource();
            },
            'web_login' => function () {
                return auth('web')->check();
            }
        ]);
    }
}
