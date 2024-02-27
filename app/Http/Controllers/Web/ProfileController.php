<?php

namespace App\Http\Controllers\Web;

use App\Actions\Users\UpdateProfileAction;
use App\Http\Controllers\WebController;
use App\Http\Requests\Web\Profile\PostIndexRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Propaganistas\LaravelPhone\PhoneNumber;

class ProfileController extends WebController
{
    /**
     * @return View
     */
    public function getIndex(): View
    {
        $this->metaTitle('Update your profile');

        return view('web.profile.index', [
            'user' => $this->authUser(),
        ]);
    }

    /**
     * @param PostIndexRequest $request
     * @return RedirectResponse
     */
    public function postIndex(PostIndexRequest $request): RedirectResponse
    {
        if ($request->filled('phone')) {
            $phone = new PhoneNumber(
                $request->input('phone'),
                Str::startsWith($request->input('phone'), '+') ? null : 'GB'
            );
        } else {
            $phone = null;
        }

        UpdateProfileAction::run(
            $this->authUser(),
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('company_name'),
            $phone,
            $request->boolean('marketing_opt_in'),
        );

        return redirect(route('web.portal.index'));
    }
}
