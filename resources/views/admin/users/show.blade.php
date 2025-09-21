@extends('layouts.admin')

@section('page-title', 'User Details')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-primary to-secondary text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold">User Details</h1>
                    <p class="text-sm text-white text-opacity-90 mt-1">View user information and activity</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.users.edit', $user) }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 flex items-center space-x-2">
                        <i class="fas fa-edit"></i>
                        <span>Edit User</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200">
                        Back to Users
                    </a>
                </div>
            </div>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- User Info -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="h-16 w-16 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center shadow-lg">
                                    <span class="text-xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <h2 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h2>
                                    <p class="text-gray-600">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 pt-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Role</label>
                                    <div class="mt-1">
                                        @if($user->role === 'admin')
                                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                                <i class="fas fa-user-shield mr-2"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        @elseif($user->role === 'educator')
                                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <i class="fas fa-chalkboard-teacher mr-2"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        @else
                                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                                <i class="fas fa-user-graduate mr-2"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                            <span class="w-2 h-2 bg-green-600 rounded-full mr-2"></span>
                                            Active
                                        </span>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Member Since</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Last Activity</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div>
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                        
                        @if($user->role === 'educator')
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Classes</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ $userStats['total_classes'] ?? 0 }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Students</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ $userStats['total_students'] ?? 0 }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Geography Models</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ $userStats['total_geography_models'] ?? 0 }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Stories</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ $userStats['total_stories'] ?? 0 }}</span>
                                </div>
                            </div>
                        @elseif($user->role === 'student')
                            <div class="space-y-4">
                                <div>
                                    <span class="text-sm text-gray-600">Current Class</span>
                                    <p class="text-lg font-semibold text-gray-900">{{ $userStats['current_class'] ?? 'Not enrolled' }}</p>
                                </div>
                                @if(isset($userStats['joined_at']))
                                <div>
                                    <span class="text-sm text-gray-600">Joined Class</span>
                                    <p class="text-lg font-semibold text-gray-900">{{ $userStats['joined_at']->format('M d, Y') }}</p>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-user-shield text-4xl text-gray-400 mb-2"></i>
                                <p class="text-gray-600">Admin user</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection