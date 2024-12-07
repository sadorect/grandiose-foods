<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;

class ShippingAddressController extends Controller
{
  /**
   * Display a listing of the user's shipping addresses.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
      $addresses = auth()->user()->addresses()->latest()->get();
      return view('profile.addresses.index', compact('addresses'));
  }

  public function store(Request $request)
  {
      $validated = $request->validate([
          'label' => 'required|string|max:255',
          'street' => 'required|string|max:255',
          'city' => 'required|string|max:255',
          'state' => 'required|string|max:255',
          'zip' => 'required|string|max:20',
      ]);
  
      $address = auth()->user()->addresses()->create($validated);
  
      return redirect()->back()->withFragment('shipping-addresses')->with('status', 'Address saved successfully');
  }
  

    public function update(Request $request, ShippingAddress $address)
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'string', 'max:20'],
        ]);

        $address->update($validated);

        return back()->with('status', 'Address updated successfully');
    }
    public function edit(ShippingAddress $address)
    {
        return response()->json($address);
    }
    
    
    public function destroy(ShippingAddress $address)
    {
        $address->delete();
        return redirect()->back()->withFragment('shipping-addresses')->with('status', 'Address removed successfully');
    }
    
}
