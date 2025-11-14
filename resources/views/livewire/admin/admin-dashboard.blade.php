<div class="container mt-4">
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="row">
        <!-- Card: Total Courses -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Total Courses</h5>
                    <h2>{{ $totalCourses ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <!-- Card: Total Modules -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Total Modules</h5>
                    <h2>{{ $totalModules ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <!-- Card: Total Lessons -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Total Lessons</h5>
                    <h2>{{ $totalLessons ?? 0 }}</h2>
                </div>
            </div>
        </div>

        <!-- Card: Total Users -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-danger shadow-sm rounded-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <h2>{{ $totalUsers ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Recent Activities</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Activity</th>
                        <th>User</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities ?? [] as $activity)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $activity->description }}</td>
                            <td>{{ $activity->user->name ?? '-' }}</td>
                            <td>{{ $activity->created_at->format('d M Y - H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">No recent activity.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
