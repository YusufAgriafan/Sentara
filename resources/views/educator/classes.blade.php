@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Classes</h1>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Create New Class
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Sample Classes -->
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Mathematics 101</h3>
                <p class="text-gray-600 mb-4">Basic algebra and geometry concepts</p>
                <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                    <span>25 students</span>
                    <span>3 assignments</span>
                </div>
                <div class="flex space-x-2">
                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm">
                        View Class
                    </button>
                    <button class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded text-sm">
                        Settings
                    </button>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Physics 201</h3>
                <p class="text-gray-600 mb-4">Introduction to mechanics and thermodynamics</p>
                <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                    <span>18 students</span>
                    <span>5 assignments</span>
                </div>
                <div class="flex space-x-2">
                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm">
                        View Class
                    </button>
                    <button class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded text-sm">
                        Settings
                    </button>
                </div>
            </div>

            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Chemistry Lab</h3>
                <p class="text-gray-600 mb-4">Hands-on chemical experiments and analysis</p>
                <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                    <span>12 students</span>
                    <span>8 assignments</span>
                </div>
                <div class="flex space-x-2">
                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm">
                        View Class
                    </button>
                    <button class="flex-1 border border-gray-300 hover:bg-gray-50 text-gray-700 px-3 py-2 rounded text-sm">
                        Settings
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection