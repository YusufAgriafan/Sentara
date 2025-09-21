@extends('layouts.admin')

@section('title', 'Class Management')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Class Management</h1>
    <button onclick="openAddClassModal()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
        <i class="fas fa-plus mr-2"></i>Add New Class
    </button>
</div>

<!-- Classes Statistics -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 mr-4">
                <i class="fas fa-chalkboard-teacher text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Classes</p>
                <p class="text-2xl font-bold text-gray-900">{{ $classes->total() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 mr-4">
                <i class="fas fa-user-graduate text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Students</p>
                <p class="text-2xl font-bold text-gray-900">{{ $classes->sum(function($class) { return $class->classLists->count(); }) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 mr-4">
                <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Active Educators</p>
                <p class="text-2xl font-bold text-gray-900">{{ $educators->count() }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 mr-4">
                <i class="fas fa-chart-line text-orange-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Avg Students/Class</p>
                <p class="text-2xl font-bold text-gray-900">{{ $classes->count() > 0 ? round($classes->sum(function($class) { return $class->classLists->count(); }) / $classes->count(), 1) : 0 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Classes Table -->
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">All Classes</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Class Information
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Educator
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Students
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Token
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
                @forelse($classes as $class)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-chalkboard-teacher text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $class->name }}</div>
                                <div class="text-sm text-gray-500">
                                    @if($class->grade && $class->subject)
                                        Grade {{ $class->grade }} - {{ $class->subject }}
                                    @else
                                        {{ Str::limit($class->description ?? 'No description', 30) }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $class->educator->name }}</div>
                        <div class="text-sm text-gray-500">{{ $class->educator->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $class->classLists->count() }} students
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <code class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $class->token }}</code>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $class->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.classes.show', $class) }}" 
                               class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye w-4 h-4"></i>
                            </a>
                            <a href="{{ route('admin.classes.edit', $class) }}" 
                               class="text-green-600 hover:text-green-900">
                                <i class="fas fa-edit w-4 h-4"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.classes.delete', $class) }}" 
                                class="inline" onsubmit="return confirm('Are you sure you want to delete this class?')">
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
                        No classes found. 
                        <button onclick="openAddClassModal()" class="text-blue-600 hover:text-blue-800">
                            Create the first class
                        </button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $classes->links() }}
    </div>
</div>

<!-- Add Class Modal -->
<div id="addClassModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Add New Class</h3>
                <button onclick="closeAddClassModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form method="POST" action="{{ route('admin.classes.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Class Name</label>
                    <input type="text" name="name" id="name" required
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="e.g., Kelas 7 IPS">
                </div>
                
                <div class="mb-4">
                    <label for="educator_id" class="block text-sm font-medium text-gray-700 mb-2">Educator</label>
                    <select name="educator_id" id="educator_id" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Educator</option>
                        @foreach($educators as $educator)
                            <option value="{{ $educator->id }}">{{ $educator->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="grade" class="block text-sm font-medium text-gray-700 mb-2">Grade</label>
                        <input type="number" name="grade" id="grade" min="1" max="12"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="7">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <input type="text" name="subject" id="subject"
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="IPS">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Class description..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeAddClassModal()"
                            class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Create Class
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openAddClassModal() {
    document.getElementById('addClassModal').classList.remove('hidden');
}

function closeAddClassModal() {
    document.getElementById('addClassModal').classList.add('hidden');
    // Reset form
    document.querySelector('#addClassModal form').reset();
}

// Close modal when clicking outside
document.getElementById('addClassModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddClassModal();
    }
});
</script>
@endpush
@endsection