<?php
namespace App\Http\Controllers;
use App\Models\Attendee;
use Illuminate\Http\Request;
class CheckinController extends Controller
{
    public function index()
    {
        return view('checkin', ['result' => null]);
    }
    public function scan(Request $request)
    {
        $code = strtoupper(trim($request->input('code', '')));
        $a = Attendee::with('booking.event')->where('checkin_code', $code)->first();
        if (!$a) return view('checkin', ['result' => ['ok' => false, 'msg' => "Code $code not found."]]);
        if (!$a->checked_in) { $a->update(['checked_in' => true]); }
        return view('checkin', ['result' => [
            'ok' => true, 'name' => $a->name,
            'event' => $a->booking->event->title ?? '',
            'first' => true,
        ]]);
    }
}