<div> 
    <div class="container mt-5">
        <div class="row mb-4">
            <h1 class="mb-4 fw-bold">Agent <span class="text-secondary">Dashboard</span></h1>
            <hr>
            <hr>
            <div class="btn-group mb-3" role="group" aria-label="Time Range Selection">
                <button type="button" class="btn btn-outline-secondary" onclick="fetchLeadsData('day')">Day</button>
                <button type="button" class="btn btn-outline-secondary" onclick="fetchLeadsData('week')">Week</button>
                <button type="button" class="btn btn-outline-secondary" onclick="fetchLeadsData('month')">Month</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h4 class="mb-4 fw-bold">Leads Overview</h4>
                    <hr>
                    <div style="max-width: 100%;max-height: 400px; margin: 0 auto;">
                        <canvas id="leadsChart" ></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-4">
        <div class="card shadow-sm rounded bg-secondary">
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex flex-wrap align-items-center justify-content-start gap-3">
                    <!-- Status Filter -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                            Filter: {{ $statusFilter ?: 'All' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" wire:click="$set('statusFilter', '')">All</a></li>
                            @foreach ($statuses as $status)
                                <li>
                                    <a class="dropdown-item" wire:click="$set('statusFilter', '{{ $status->name }}')">
                                        {{ $status->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Team Filter -->
                    {{-- <div class="btn-group">
                        <button type="button" class="btn btn-dark btn-wave dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                            Teams: {{ $teamFilter ?: 'All' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" wire:click="$set('teamFilter', '')">All</a></li>
                            @foreach ($teams as $team)
                                <li>
                                    <a class="dropdown-item" wire:click="$set('teamFilter', '{{ $team->name }}')">
                                        {{ $team->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div> --}}

                    <!-- Per Page Filter -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark btn-wave dropdown-toggle fw-bold" data-bs-toggle="dropdown" aria-expanded="false">
                            Per Page: {{ $perPage }}
                        </button>
                        <ul class="dropdown-menu">
                            @foreach ([2, 5, 10, 20] as $size)
                                <li>
                                    <a class="dropdown-item" href="#" wire:click.prevent="updatePerPage({{ $size }})">
                                        {{ $size }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
               <!-- Export Lead -->
                <div class="d-flex justify-content-between gap-3 mb-1 position-relative align-items-center">
                    <!-- Export as Excel -->
                    <button 
                        wire:click="exportLeads('xlsx')" 
                        wire:loading.attr="disabled" 
                        class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                        <i class="ri-file-excel-2-line me-1"></i> Export as Excel
                    </button>
                    
                    <!-- Export as CSV -->
                    <button 
                        wire:click="exportLeads('csv')" 
                        wire:loading.attr="disabled" 
                        class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                        <i class="ri-export-line me-1"></i> Export as CSV
                    </button>
                    
                    <!-- Loading Spinner -->
                    <div wire:loading class="spinner-border text-dark ms-2" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>



                {{-- Search and Filters Row --}}
                <div class="col-md-12 mt-3">
                    <div class=" d-flex align-items-center justify-content-between">
                        <div class="d-flex gap-3 ">
                            <!-- Search Input -->
                            <div>
                                <input wire:model.live="search" type="text" id="search" class="form-control fw-bold" placeholder="Search">
                            </div>
                            <!-- Date Filters -->
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <label for="" class="text-white fw-bold">Start</label>
                                <input wire:model.live="startDate" type="date" class="form-control fw-bold">
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <label for="" class="text-white fw-bold">End</label>
                                <input wire:model.live="endDate" type="date" class="form-control fw-bold">
                            </div>
                        </div>
                        {{-- Reset Filters --}}
                        <div class="d-flex justify-content-end">
                            <button wire:click="resetFilters" class="btn btn-danger fw-bold">
                                <i class="bi bi-arrow-clockwise"></i> Reset Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>   
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="fw-bold">Refrence Id</th>
                                        <th class="fw-bold">Customer Name</th>
                                        <th class="fw-bold">Status</th>
                                        <th class="fw-bold">Series</th>
                                        <th class="fw-bold">Amount</th>
                                        <th class="fw-bold">Next Follow Up Date</th>
                                        <th class="fw-bold">Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($leads as $lead)
                                        <tr>
                                            <td>{{ $lead->reference_id }}</td>
                                            <td>{{ $lead->customer->name }}</td>
                                            <td><span class="badge" style="background-color: {{ $lead->leadStatus->color }}; color: #fff;">{{ $lead->leadStatus->name }}</span></td>
                                            <td>{{ $lead->Series->name ?? 'N/A' }}</td>
                                            <td>{{ $lead->amount ?? 'N/A' }}</td>
                                            <td>{{ $lead->remarks->last()?->date ?? 'N/A' }}</td>
                                            <td>{{ $lead->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center fw-bold" colspan="10">No records found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $leads->links('custom-pagination-links') }} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('leadsChart').getContext('2d');
            let leadsChart;

            function renderChart(data) {
                const labels = data.map(item => item.date);
                const newLeads = data.map(item => item.new_leads);
                const inProgressLeads = data.map(item => item.in_progress_leads);
                const completedLeads = data.map(item => item.completed_leads);
                const lostLeads = data.map(item => item.lost_leads);

                if (leadsChart) {
                    leadsChart.destroy(); // Destroy the previous chart instance if it exists
                }

                leadsChart = new Chart(ctx, {
                    type: 'bar', // You can change this to 'line', 'bar', etc.
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'New Leads',
                                data: newLeads,
                                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'In-Progress Leads',
                                data: inProgressLeads,
                                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Completed Leads',
                                data: completedLeads,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                            },
                            {
                                label: 'Lost Leads',
                                data: lostLeads,
                                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                            },
                        },
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date',
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Number of Leads',
                                },
                                beginAtZero: true,
                            }
                        }
                    }
                });
            }

            window.addEventListener('leadsDataUpdated', event => {
                renderChart(event.detail); // Use the leads data received from the backend
            });

            // Trigger an initial chart render
            renderChart(@json($leadsPerDay)); // Ensure this variable is available in your view
        });
    </script>
    @endpush


    
</div>