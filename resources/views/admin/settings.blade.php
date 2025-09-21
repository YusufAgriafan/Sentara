@extends('layouts.admin')

@section('page-title', 'System Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.content-fallback.update') }}" method="POST" class="space-y-8">
        @csrf
        
        <!-- Content Fallback Settings -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-primary to-secondary">
                <h3 class="text-lg font-semibold text-white">Content Fallback Settings</h3>
                <p class="text-sm text-white text-opacity-90 mt-1">Configure default content when classes have no assigned content</p>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Enable Content Fallback -->
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="content_fallback_enabled" name="content_fallback_enabled" value="1"
                                   {{ ($settings['content_fallback_enabled'] ?? true) ? 'checked' : '' }}
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary">
                        </div>
                        <div class="ml-3">
                            <label for="content_fallback_enabled" class="text-sm font-medium text-gray-700">Enable Content Fallback</label>
                            <p class="text-sm text-gray-500">Show admin-selected content when classes have no assigned content</p>
                        </div>
                    </div>

                    <!-- Geography Models Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Fallback Geography Models</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4">
                            @foreach($availableContent['geography_models'] as $model)
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" id="geo_model_{{ $model->id }}" name="fallback_geography_models[]" value="{{ $model->id }}"
                                               {{ in_array($model->id, $settings['fallback_geography_models'] ?? []) ? 'checked' : '' }}
                                               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary">
                                    </div>
                                    <div class="ml-3">
                                        <label for="geo_model_{{ $model->id }}" class="text-sm font-medium text-gray-700">{{ $model->title }}</label>
                                        <p class="text-xs text-gray-500">by {{ $model->educator->name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Places Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Fallback Places</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4">
                            @foreach($availableContent['places'] as $place)
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" id="place_{{ $place->id }}" name="fallback_places[]" value="{{ $place->id }}"
                                               {{ in_array($place->id, $settings['fallback_places'] ?? []) ? 'checked' : '' }}
                                               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary">
                                    </div>
                                    <div class="ml-3">
                                        <label for="place_{{ $place->id }}" class="text-sm font-medium text-gray-700">{{ $place->name }}</label>
                                        <p class="text-xs text-gray-500">{{ $place->location }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Stories Selection -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">Fallback Stories</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-60 overflow-y-auto border border-gray-200 rounded-lg p-4">
                            @foreach($availableContent['stories'] as $story)
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" id="story_{{ $story->id }}" name="fallback_stories[]" value="{{ $story->id }}"
                                               {{ in_array($story->id, $settings['fallback_stories'] ?? []) ? 'checked' : '' }}
                                               class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary">
                                    </div>
                                    <div class="ml-3">
                                        <label for="story_{{ $story->id }}" class="text-sm font-medium text-gray-700">{{ $story->title }}</label>
                                        <p class="text-xs text-gray-500">{{ Str::limit($story->content, 50) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- General Settings -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-primary to-secondary">
                <h3 class="text-lg font-semibold text-white">General Settings</h3>
                <p class="text-sm text-white text-opacity-90 mt-1">Configure basic system settings</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                        <input type="text" id="site_name" name="site_name" value="Sentara" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>
                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
                        <input type="text" id="site_description" name="site_description" value="Learning Management System" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>
                    <div>
                        <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-2">Admin Email</label>
                        <input type="email" id="admin_email" name="admin_email" value="admin@sentara.com" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                    </div>
                    <div>
                        <label for="timezone" class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
                        <select id="timezone" name="timezone" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <option value="UTC">UTC</option>
                            <option value="Asia/Jakarta" selected>Asia/Jakarta</option>
                            <option value="America/New_York">America/New_York</option>
                            <option value="Europe/London">Europe/London</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Registration Settings -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-secondary to-tertiary">
                <h3 class="text-lg font-semibold text-white">User Registration</h3>
                <p class="text-sm text-white text-opacity-90 mt-1">Control how new users can register</p>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="allow_registration" name="allow_registration" checked 
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary">
                        </div>
                        <div class="ml-3">
                            <label for="allow_registration" class="text-sm font-medium text-gray-700">Allow new user registration</label>
                            <p class="text-sm text-gray-500">When enabled, new users can create accounts</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="email_verification" name="email_verification" checked 
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary">
                        </div>
                        <div class="ml-3">
                            <label for="email_verification" class="text-sm font-medium text-gray-700">Require email verification</label>
                            <p class="text-sm text-gray-500">New users must verify their email before accessing the system</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="admin_approval" name="admin_approval" 
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary">
                        </div>
                        <div class="ml-3">
                            <label for="admin_approval" class="text-sm font-medium text-gray-700">Require admin approval</label>
                            <p class="text-sm text-gray-500">New registrations need admin approval before activation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Management -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-tertiary to-orange-500">
                <h3 class="text-lg font-semibold text-white">Default Roles</h3>
                <p class="text-sm text-white text-opacity-90 mt-1">Set default roles for new users</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="default_role" class="block text-sm font-medium text-gray-700 mb-2">Default Role for New Users</label>
                        <select id="default_role" name="default_role" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200">
                            <option value="student" selected>Student</option>
                            <option value="educator">Educator</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Role automatically assigned to new registrations</p>
                    </div>
                    <div>
                        <label for="auto_assign_class" class="block text-sm font-medium text-gray-700 mb-2">Auto-assign to Class</label>
                        <select id="auto_assign_class" name="auto_assign_class" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200">
                            <option value="">No auto-assignment</option>
                            <option value="default">Default Class</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Automatically assign new students to a specific class</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Settings -->
        <div class="bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-700 to-gray-800">
                <h3 class="text-lg font-semibold text-white">Security Settings</h3>
                <p class="text-sm text-white text-opacity-90 mt-1">Configure security and authentication settings</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="session_timeout" class="block text-sm font-medium text-gray-700 mb-2">Session Timeout (minutes)</label>
                        <input type="number" id="session_timeout" name="session_timeout" value="120" min="15" max="480"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200">
                        <p class="text-sm text-gray-500 mt-1">How long users stay logged in</p>
                    </div>
                    <div>
                        <label for="max_login_attempts" class="block text-sm font-medium text-gray-700 mb-2">Max Login Attempts</label>
                        <input type="number" id="max_login_attempts" name="max_login_attempts" value="5" min="3" max="10"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-primary focus:border-primary transition-colors duration-200">
                        <p class="text-sm text-gray-500 mt-1">Number of failed attempts before lockout</p>
                    </div>
                </div>
                
                <div class="mt-6 space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="force_strong_passwords" name="force_strong_passwords" checked
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary">
                        </div>
                        <div class="ml-3">
                            <label for="force_strong_passwords" class="text-sm font-medium text-gray-700">Enforce strong passwords</label>
                            <p class="text-sm text-gray-500">Require passwords to meet complexity requirements</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" id="two_factor_auth" name="two_factor_auth"
                                   class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary">
                        </div>
                        <div class="ml-3">
                            <label for="two_factor_auth" class="text-sm font-medium text-gray-700">Enable two-factor authentication</label>
                            <p class="text-sm text-gray-500">Allow users to enable 2FA for additional security</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end space-x-4">
            <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors duration-200">
                Cancel
            </button>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-primary to-secondary hover:from-secondary hover:to-tertiary text-white rounded-lg font-medium transition-all duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Save Settings</span>
            </button>
        </div>
    </form>
</div>
@endsection