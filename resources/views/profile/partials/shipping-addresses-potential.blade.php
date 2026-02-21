<div class="space-y-6">
    @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded relative">
            {{ session('status') }}
        </div>
    @endif

    <!-- Existing Addresses -->
    <div class="space-y-4 mb-8">
        @foreach(auth()->user()->addresses as $address)
            <div class="bg-yellow-50 border border-lime-200 rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-medium text-lime-900">{{ $address->label }}</h3>
                        <p class="text-gray-600">{{ $address->street }}</p>
                        <p class="text-gray-600">{{ $address->city }}, {{ $address->state }} {{ $address->zip }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="editAddress({{ $address->id }})" 
                                class="text-lime-700 hover:text-lime-800">
                            Edit
                        </button>
                        <form action="{{ route('profile.addresses.destroy', $address) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to remove this address?');"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Add/Edit Address Form -->
    <form id="addressForm" method="POST" action="{{ route('profile.addresses.store') }}" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="label" value="Address Label" />
                <x-text-input id="label" name="label" type="text" placeholder="e.g., Main Warehouse"
                    class="mt-1 block w-full rounded-lg bg-yellow-50 border-lime-500 focus:border-lime-600 focus:ring-lime-500" />
            </div>
            <div>
                <x-input-label for="street" value="Street Address" />
                <x-text-input id="street" name="street" type="text"
                    class="mt-1 block w-full rounded-lg bg-yellow-50 border-lime-500 focus:border-lime-600 focus:ring-lime-500" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-input-label for="city" value="City" />
                <x-text-input id="city" name="city" type="text"
                    class="mt-1 block w-full rounded-lg bg-yellow-50 border-lime-500 focus:border-lime-600 focus:ring-lime-500" />
            </div>
            <div>
                <x-input-label for="state" value="State" />
                <x-text-input id="state" name="state" type="text"
                    class="mt-1 block w-full rounded-lg bg-yellow-50 border-lime-500 focus:border-lime-600 focus:ring-lime-500" />
            </div>
            <div>
                <x-input-label for="zip" value="ZIP Code" />
                <x-text-input id="zip" name="zip" type="text"
                    class="mt-1 block w-full rounded-lg bg-yellow-50 border-lime-500 focus:border-lime-600 focus:ring-lime-500" />
            </div>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-lime-700 text-white px-4 py-2 rounded-lg hover:bg-lime-800 transition">
                Save Address
            </button>
            <button type="button" 
                    onclick="resetForm()" 
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition"
                    style="display: none;">
                Cancel
            </button>
        </div>
    </form>

    <script>
        let isEditing = false;
        
        function editAddress(addressId) {
            isEditing = true;
            document.querySelector('button[type="button"]').style.display = 'block';
            const form = document.getElementById('addressForm');
            
            fetch(`/profile/addresses/${addressId}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('label').value = data.label;
                    document.getElementById('street').value = data.street;
                    document.getElementById('city').value = data.city;
                    document.getElementById('state').value = data.state;
                    document.getElementById('zip').value = data.zip;
                    
                    form.action = `/profile/addresses/${addressId}`;
                    if (!form.querySelector('input[name="_method"]')) {
                        form.insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PATCH">');
                    }
                    form.querySelector('button[type="submit"]').textContent = 'Update Address';
                });
        }
        
        function resetForm() {
            const form = document.getElementById('addressForm');
            form.reset();
            form.action = "{{ route('profile.addresses.store') }}";
            const methodField = form.querySelector('input[name="_method"]');
            if (methodField) methodField.remove();
            form.querySelector('button[type="submit"]').textContent = 'Save Address';
            document.querySelector('button[type="button"]').style.display = 'none';
            isEditing = false;
        }
    </script>
</div>
