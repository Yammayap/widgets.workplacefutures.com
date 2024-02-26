<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use App\Models\Enquiry;
use Illuminate\View\View;

class PortalController extends WebController
{
    public function getIndex(): View
    {
        $this->metaTitle('Portal');

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
