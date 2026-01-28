<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradingPair;
use Illuminate\Http\Request;

class TradingPairController extends Controller
{
    public function index()
    {
        $pairs = TradingPair::latest()->get();
        return view('admin.pairs.index', compact('pairs'));
    }

    public function create()
    {
        return view('admin.pairs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'base_asset' => 'required|string',
            'quote_asset' => 'required|string',
            'icon' => 'nullable|image'
        ]);

        $symbol = strtoupper($request->base_asset)."/".strtoupper($request->quote_asset);
        $binanceSymbol = strtoupper($request->base_asset.$request->quote_asset);

        $iconPath = null;
        if($request->hasFile('icon')){
            $iconPath = $request->file('icon')->store('pair_icons','public');
        }

        TradingPair::create([
            'symbol' => $symbol,
            'base_asset' => strtoupper($request->base_asset),
            'quote_asset' => strtoupper($request->quote_asset),
            'binance_symbol' => $binanceSymbol,
            'icon' => $iconPath,
            'is_active' => true,
        ]);

        return redirect()->route('admin.pairs.index')
            ->with('success','Pair added successfully');
    }


    public function destroy(TradingPair $pair)
    {
        $pair->delete();
        return back()->with('success','Pair removed');
    }

    public function toggle(TradingPair $pair)
    {
        $pair->is_active = !$pair->is_active;
        $pair->save();

        return back()->with('success','Status updated');
    }
}

