<form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('patch')

    <div>
        <x-input-label for="name" value="Name" />
        <x-text-input id="name" name="name" type="text" 
            class="mt-1 p-3 block w-full rounded-lg bg-yellow-50 border-lime-500 focus:border-lime-600 focus:ring-lime-500"
            :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
    </div>

    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" 
            class="mt-1 p-3 block w-full rounded-lg bg-yellow-50 border-lime-500 focus:border-lime-600 focus:ring-lime-500"
            :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
    </div>

    <div>
        <x-input-label for="company_name" value="Company Name" />
        <x-text-input id="company_name" name="company_name" type="text" 
            class="mt-1 p-3 block w-full rounded-lg bg-yellow-50 border-lime-500 focus:border-lime-600 focus:ring-lime-500"
            :value="old('company_name', $user->company_name)" />
    </div>

    <div>
        <x-input-label for="phone" value="Phone Number" class="text-black" />
        <x-text-input id="phone" name="phone" type="tel" 
            class="mt-1 p-3 block w-full rounded-lg bg-yellow-50 border-lime-500 focus:border-lime-600 focus:ring-lime-500"
            :value="old('phone', $user->phone)" />
    </div>

    <button type="submit" class="bg-lime-600 text-white px-4 py-2 rounded-lg hover:bg-lime-700 transition">
        Save Changes
    </button>
</form>
