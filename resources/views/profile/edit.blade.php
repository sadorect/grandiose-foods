@extends('layouts.app')

@section('title', 'Edit Profile')
   
@section('content')
    <div x-data="{ activeTab: 'profile' }" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button @click="activeTab = 'profile'" 
                            :class="{ 'border-lime-600 text-lime-600': activeTab === 'profile', 'border-transparent': activeTab !== 'profile' }"
                            class="px-6 py-4 border-b-2 font-medium hover:text-lime-600 transition">
                            Profile Information
                        </button>
                        <button @click="activeTab = 'addresses'"
                            :class="{ 'border-lime-600 text-lime-600': activeTab === 'addresses', 'border-transparent': activeTab !== 'addresses' }"
                            class="px-6 py-4 border-b-2 font-medium hover:text-lime-600 transition">
                            Shipping Addresses
                        </button>
                        <button @click="activeTab = 'orders'"
                            :class="{ 'border-lime-600 text-lime-600': activeTab === 'orders', 'border-transparent': activeTab !== 'orders' }"
                            class="px-6 py-4 border-b-2 font-medium hover:text-lime-600 transition">
                            Order History
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="p-6">
                    <div x-show="activeTab === 'profile'">
                        @include('profile.partials.profile-form')
                    </div>
                    <div id="shipping-addresses" x-show="activeTab === 'addresses'">
                        @include('profile.partials.shipping-addresses')
                    </div>
                    <div x-show="activeTab === 'orders'">
                        @include('profile.partials.order-history')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
