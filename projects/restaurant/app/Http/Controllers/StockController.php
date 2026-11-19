<?php
namespace App\Http\Controllers;
use App\Models\InventoryItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
class StockController extends Controller
{
    public function adjust(Request $request, InventoryItem $item)
    {
        $data = $request->validate([
            'direction' => 'required|in:in,out',
            'qty' => 'required|numeric|min:0.01',
            'reason' => 'nullable|string|max:255',
        ]);
        if ($data['direction'] === 'out' && $data['qty'] > $item->qty) {
            return back()->with('error', 'Cannot remove more than current stock.');
        }
        $item->increment('qty', $data['direction'] === 'in' ? $data['qty'] : -$data['qty']);
        StockMovement::create($data + ['inventory_id' => $item->id, 'user_id' => auth()->id()]);
        return back()->with('ok', 'Stock ' . $data['direction'] . ' recorded.');
    }
    public function movements()
    {
        $rows = StockMovement::with(['item','user'])->latest()->paginate(20)->withQueryString();
        return view('movements.index', compact('rows'));
    }
}