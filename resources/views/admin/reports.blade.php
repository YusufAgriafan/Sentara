@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Reports & Analytics</h1>
    <div class="flex space-x-2">
        <select class="border border-gray-300 rounded-md px-3 py-2 text-sm" onchange="updateDateRange(this.value)">
            <option value="7">Last 7 days</option>
            <option value="30" selected>Last 30 days</option>
            <option value="90">Last 90 days</option>
            <option value="365">Last year</option>
        </select>
        <button onclick="exportReport()" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
            <i class="fas fa-download mr-2"></i>Export Report
        </button>
    </div>
</div>

<!-- Key Metrics Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 mr-4">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Users</p>
                <p class="text-2xl font-bold text-gray-900">{{ $userGrowth['total'] }}</p>
                <p class="text-sm {{ $userGrowth['growth'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $userGrowth['growth'] >= 0 ? '+' : '' }}{{ $userGrowth['growth'] }}% from last period
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 mr-4">
                <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Active Students</p>
                <p class="text-2xl font-bold text-gray-900">{{ $usersByRole['student'] ?? 0 }}</p>
                <p class="text-sm text-gray-500">
                    {{ round(($usersByRole['student'] ?? 0) / max($userGrowth['total'], 1) * 100) }}% of total users
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 mr-4">
                <i class="fas fa-chalkboard-teacher text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Educators</p>
                <p class="text-2xl font-bold text-gray-900">{{ $usersByRole['educator'] ?? 0 }}</p>
                <p class="text-sm text-gray-500">
                    {{ round(($usersByRole['educator'] ?? 0) / max($userGrowth['total'], 1) * 100) }}% of total users
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 mr-4">
                <i class="fas fa-file-alt text-orange-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600">Total Content</p>
                <p class="text-2xl font-bold text-gray-900">{{ $contentStats['total'] }}</p>
                <p class="text-sm text-orange-600">
                    {{ $contentStats['public'] }} public items
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- User Growth Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">User Growth</h3>
        <canvas id="userGrowthChart" width="400" height="200"></canvas>
    </div>

    <!-- Content Distribution Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Content Distribution</h3>
        <canvas id="contentDistributionChart" width="400" height="200"></canvas>
    </div>
</div>

<!-- Activity Summary -->
<div class="bg-white rounded-lg shadow-sm p-6 mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activity Summary</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Recent Users -->
        <div>
            <h4 class="text-md font-medium text-gray-700 mb-3">Recent Registrations</h4>
            <div class="space-y-3">
                @foreach($activitySummary['recent_users'] as $user)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                            <i class="fas fa-user text-gray-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($user->role) }}</p>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Content -->
        <div>
            <h4 class="text-md font-medium text-gray-700 mb-3">Recent Content</h4>
            <div class="space-y-3">
                @foreach($activitySummary['recent_content'] as $content)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                            <i class="fas fa-{{ $content['type'] === 'geography' ? 'globe' : ($content['type'] === 'place' ? 'map-marker-alt' : 'book') }} text-blue-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ Str::limit($content['title'], 20) }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($content['type']) }} by {{ $content['creator'] }}</p>
                        </div>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ $content['created_at']->diffForHumans() }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- System Stats -->
        <div>
            <h4 class="text-md font-medium text-gray-700 mb-3">System Statistics</h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Classes Created</span>
                    <span class="text-sm font-medium text-gray-900">{{ $systemStats['classes'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Active Classes</span>
                    <span class="text-sm font-medium text-gray-900">{{ $systemStats['active_classes'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Content with Fallback</span>
                    <span class="text-sm font-medium text-gray-900">{{ $systemStats['fallback_enabled'] }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Average Content per User</span>
                    <span class="text-sm font-medium text-gray-900">{{ $systemStats['avg_content_per_user'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Reports -->
<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Detailed Reports</h3>
        <div class="flex space-x-2">
            <button onclick="generateReport('users')" class="bg-blue-600 text-white px-3 py-2 rounded text-sm hover:bg-blue-700">
                User Report
            </button>
            <button onclick="generateReport('content')" class="bg-green-600 text-white px-3 py-2 rounded text-sm hover:bg-green-700">
                Content Report
            </button>
            <button onclick="generateReport('activity')" class="bg-purple-600 text-white px-3 py-2 rounded text-sm hover:bg-purple-700">
                Activity Report
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="font-medium text-gray-800 mb-2">Content Performance</h4>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Most Active Creator</span>
                    <span class="font-medium">{{ $contentStats['top_creator']['name'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Content Count</span>
                    <span class="font-medium">{{ $contentStats['top_creator']['count'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="font-medium text-gray-800 mb-2">User Engagement</h4>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Daily Active Users</span>
                    <span class="font-medium">{{ $systemStats['daily_active'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Weekly Active Users</span>
                    <span class="font-medium">{{ $systemStats['weekly_active'] ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="font-medium text-gray-800 mb-2">Content Quality</h4>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Public Content Ratio</span>
                    <span class="font-medium">{{ round($contentStats['public'] / max($contentStats['total'], 1) * 100) }}%</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Admin Content</span>
                    <span class="font-medium">{{ $contentStats['admin_content'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="border border-gray-200 rounded-lg p-4">
            <h4 class="font-medium text-gray-800 mb-2">System Health</h4>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Database Size</span>
                    <span class="font-medium">{{ $systemStats['db_size'] ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Storage Used</span>
                    <span class="font-medium">{{ $systemStats['storage_used'] ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// User Growth Chart
const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
const userGrowthChart = new Chart(userGrowthCtx, {
    type: 'line',
    data: {
        labels: @json($chartData['userGrowth']['labels']),
        datasets: [{
            label: 'New Users',
            data: @json($chartData['userGrowth']['data']),
            borderColor: 'rgb(59, 130, 246)',
            backgroundColor: 'rgba(59, 130, 246, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Content Distribution Chart
const contentDistributionCtx = document.getElementById('contentDistributionChart').getContext('2d');
const contentDistributionChart = new Chart(contentDistributionCtx, {
    type: 'doughnut',
    data: {
        labels: @json($chartData['contentDistribution']['labels']),
        datasets: [{
            data: @json($chartData['contentDistribution']['data']),
            backgroundColor: [
                'rgba(59, 130, 246, 0.8)',
                'rgba(34, 197, 94, 0.8)',
                'rgba(168, 85, 247, 0.8)',
                'rgba(249, 115, 22, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

function updateDateRange(days) {
    const url = new URL(window.location);
    url.searchParams.set('days', days);
    window.location = url;
}

function exportReport() {
    // This would trigger a download of the current report
    window.open('/admin/reports/export?' + new URLSearchParams(window.location.search), '_blank');
}

function generateReport(type) {
    // This would open a detailed report in a new window or modal
    window.open(`/admin/reports/detailed/${type}?` + new URLSearchParams(window.location.search), '_blank');
}
</script>
@endpush
@endsection