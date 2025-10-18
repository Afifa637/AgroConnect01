@extends('admin.headerFooter')

@section('title', 'Admin Dashboard')

@section('body')
<div class="container-fluid py-4">
<div class="container-fluid">
    <h2 class="text-success fw-bold mb-4">Welcome, {{ Session::get('a_username') }}</h2>

    <!-- 🌾 Summary Cards -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="bi bi-person-lines-fill fs-1 text-success"></i>
                <h6>Farmers</h6>
                <h3>{{ App\Models\farmer_register::count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="bi bi-people fs-1 text-success"></i>
                <h6>Buyers</h6>
                <h3>{{ App\Models\user_register::count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="bi bi-check-circle fs-1 text-success"></i>
                <h6>Published Crops</h6>
                <h3>{{ \App\Models\CropImport::where('Action','Published')->count() }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <i class="bi bi-x-circle fs-1 text-danger"></i>
                <h6>Unpublished Crops</h6>
                <h3>{{ \App\Models\CropImport::where('Action','Unpublished')->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- 📊 Analytics Section -->
    <div class="mt-5">
        <h5 class="fw-bold text-success mb-3">Site Analytics Overview</h5>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm p-3">
                    <h6 class="fw-bold text-center mb-3">Crop Status Overview</h6>
                    <div class="chart-container">
                        <canvas id="cropChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm p-3">
                    <h6 class="fw-bold text-center mb-3">User Distribution</h6>
                    <div class="chart-container">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 🧰 Quick Admin Tools -->
    <div class="mt-5 text-center">
        <h5 class="text-success mb-3">Quick Admin Tools</h5>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('add_categories') }}" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add Category</a>
            <a href="{{ route('add_news') }}" class="btn btn-success"><i class="bi bi-pencil-square"></i> Add News</a>
            <a href="{{ route('manage_news') }}" class="btn btn-outline-success"><i class="bi bi-newspaper"></i> Manage News</a>
            <a href="{{ route('manage_categories') }}" class="btn btn-outline-success"><i class="bi bi-tags"></i> Manage Categories</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Crop Status Chart
    const cropCtx = document.getElementById('cropChart').getContext('2d');
    new Chart(cropCtx, {
        type: 'doughnut',
        data: {
            labels: ['Published', 'Unpublished', 'Deleted'],
            datasets: [{
                data: [
                    {{ \App\Models\CropImport::where('Action','Published')->count() }},
                    {{ \App\Models\CropImport::where('Action','Unpublished')->count() }},
                    {{ \App\Models\CropImport::where('Action','deleted')->count() }}
                ],
                backgroundColor: ['#198754', '#dc3545', '#adb5bd']
            }]
        }
    });

    // User Distribution Chart
    const userCtx = document.getElementById('userChart').getContext('2d');
    new Chart(userCtx, {
        type: 'bar',
        data: {
            labels: ['Farmers', 'Buyers'],
            datasets: [{
                label: 'User Count',
                data: [
                    {{ App\Models\farmer_register::count() }},
                    {{ App\Models\user_register::count() }}
                ],
                backgroundColor: ['#20c997', '#0dcaf0']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
            }
        }
    });
</script>
@endpush
</div>
@endsection
