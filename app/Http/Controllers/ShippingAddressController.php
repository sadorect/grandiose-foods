<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    private function getOwnedAddress(ShippingAddress $address): ShippingAddress
    {
        return ShippingAddress::query()
            ->where('user_id', Auth::id())
            ->findOrFail($address->id);
    }

  /**
   * Display a listing of the user's shipping addresses.
   *
   * @return \Illuminate\View\View
   */
  public function index()
  {
      $addresses = ShippingAddress::query()
          ->where('user_id', Auth::id())
          ->latest()
          ->get();
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
  
    $validated['user_id'] = Auth::id();
    $address = ShippingAddress::create($validated);
  
      return redirect()->back()->withFragment('shipping-addresses')->with('status', 'Address saved successfully');
  }
  

    public function update(Request $request, ShippingAddress $address)
    {
        $address = $this->getOwnedAddress($address);

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
        $address = $this->getOwnedAddress($address);
        return response()->json($address);
    }
    
    
    public function destroy(ShippingAddress $address)
    {
        $address = $this->getOwnedAddress($address);
        $address->delete();
        return redirect()->back()->withFragment('shipping-addresses')->with('status', 'Address removed successfully');
    }
    
}
