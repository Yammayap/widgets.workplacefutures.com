<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Models\Enquiry;
use Illuminate\View\View;

class PortalController extends WebController
{
    /**
     * @return View
     */
    public function getIndex(): View
    {
        $this->metaTitle('Welcome to your portal');

        $enquiries = Enquiry::query()
            ->where('user_id', $this->authUser()->id)
            ->with('spaceCalculatorInput')
            ->orderBy('id', 'DESC') // todo: discuss - better to sort by this or date?
            ->paginate();

        return view('web.portal.index', [
            'enquiries' => $enquiries,
        ]);
    }
}
