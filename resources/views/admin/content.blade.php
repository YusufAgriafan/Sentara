@extends('layouts.admin')

@section('title', 'Content Management')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Content Management</h1>
</div>

<!-- Content Statistics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 mr-4">
                <i class="fas fa-globe text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Geography Models</p>
                <p class="text-2xl font-bold text-gray-900">{{ $geographyModels->total() }}</p>
                <p class="text-sm text-green-600">
                    {{ $geographyModels->where('is_active', true)->count() }} active
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 mr-4">
                <i class="fas fa-map-marker-alt text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Places</p>
                <p class="text-2xl font-bold text-gray-900">{{ $places->total() }}</p>
                <p class="text-sm text-blue-600">
                    {{ $places->where('is_public', true)->count() }} public
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 mr-4">
                <i class="fas fa-book text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Stories</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stories->total() }}</p>
                <p class="text-sm text-purple-600">
                    {{ $stories->where('is_public', true)->count() }} public
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 mr-4">
                <i class="fas fa-user-tie text-orange-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Admin Content</p>
                <p class="text-2xl font-bold text-gray-900">{{ $adminContentCount }}</p>
                <p class="text-sm text-orange-600">Ready for fallback</p>
            </div>
        </div>
    </div>
</div>

<!-- Content Tabs -->
<div class="bg-white rounded-lg shadow-sm">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex">
            <button onclick="showTab('geography')" id="geography-tab" 
                class="tab-button active py-2 px-4 border-b-2 border-blue-500 text-sm font-medium text-blue-600">
                Geography Models
            </button>
            <button onclick="showTab('places')" id="places-tab" 
                class="tab-button py-2 px-4 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
                Places
            </button>
            <button onclick="showTab('stories')" id="stories-tab" 
                class="tab-button py-2 px-4 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:text-gray-700">
                Stories
            </button>
        </nav>
    </div>

    <!-- Geography Models Tab -->
    <div id="geography-content" class="tab-content p-6">
        <div class="mb-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Geography Models</h3>
            <div class="flex space-x-2">
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm" 
                    onchange="filterContent('geography', this.value)">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm" 
                    onchange="filterContent('geography', this.value, 'public')">
                    <option value="">All Visibility</option>
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Model
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Creator
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Visibility
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($geographyModels as $model)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-globe text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $model->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($model->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $model->educator->name ?? 'No Educator' }}</div>
                            <div class="text-sm text-gray-500">{{ $model->educator ? ucfirst($model->educator->role) : 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $model->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $model->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $model->is_public ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $model->is_public ? 'Public' : 'Private' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $model->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <form method="POST" action="{{ route('admin.geography-models.toggle-status', $model) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                        class="text-{{ $model->is_active ? 'red' : 'green' }}-600 hover:text-{{ $model->is_active ? 'red' : 'green' }}-900">
                                        <i class="fas fa-{{ $model->is_active ? 'pause' : 'play' }} w-4 h-4"></i>
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.geography-models.toggle-public', $model) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                        class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-{{ $model->is_public ? 'lock' : 'unlock' }} w-4 h-4"></i>
                                    </button>
                                </form>
                                
                                <form method="POST" action="{{ route('admin.geography-models.delete', $model) }}" 
                                    class="inline" onsubmit="return confirm('Are you sure you want to delete this geography model?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No geography models found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $geographyModels->links() }}
        </div>
    </div>

    <!-- Places Tab -->
    <div id="places-content" class="tab-content p-6 hidden">
        <div class="mb-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Places</h3>
            <div class="flex space-x-2">
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm" 
                    onchange="filterContent('places', this.value)">
                    <option value="">All Visibility</option>
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Place
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Creator
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Visibility
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Coordinates
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($places as $place)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-map-marker-alt text-green-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $place->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($place->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $place->user->name ?? 'No User' }}</div>
                            <div class="text-sm text-gray-500">{{ $place->user ? ucfirst($place->user->role) : 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $place->is_public ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $place->is_public ? 'Public' : 'Private' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $place->latitude }}, {{ $place->longitude }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $place->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form method="POST" action="{{ route('admin.places.delete', $place) }}" 
                                class="inline" onsubmit="return confirm('Are you sure you want to delete this place?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No places found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $places->links() }}
        </div>
    </div>

    <!-- Stories Tab -->
    <div id="stories-content" class="tab-content p-6 hidden">
        <div class="mb-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Stories</h3>
            <div class="flex space-x-2">
                <select class="border border-gray-300 rounded-md px-3 py-2 text-sm" 
                    onchange="filterContent('stories', this.value)">
                    <option value="">All Visibility</option>
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Story
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Creator
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Visibility
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Era
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($stories as $story)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                        <i class="fas fa-book text-purple-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $story->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($story->description, 50) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $story->user->name ?? 'No User' }}</div>
                            <div class="text-sm text-gray-500">{{ $story->user ? ucfirst($story->user->role) : 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $story->is_public ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $story->is_public ? 'Public' : 'Private' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $story->era ?? 'Not specified' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $story->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form method="POST" action="{{ route('admin.stories.delete', $story) }}" 
                                class="inline" onsubmit="return confirm('Are you sure you want to delete this story?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No stories found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $stories->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-content').classList.remove('hidden');
    
    // Add active class to selected tab button
    const activeButton = document.getElementById(tabName + '-tab');
    activeButton.classList.add('active', 'border-blue-500', 'text-blue-600');
    activeButton.classList.remove('border-transparent', 'text-gray-500');
}

function filterContent(type, value, field = 'status') {
    // This would typically make an AJAX request to filter content
    // For now, we'll just reload the page with query parameters
    const url = new URL(window.location);
    url.searchParams.set(`${type}_${field}`, value);
    window.location = url;
}

// Initialize first tab as active
document.addEventListener('DOMContentLoaded', function() {
    showTab('geography');
});
</script>
@endpush
@endsection