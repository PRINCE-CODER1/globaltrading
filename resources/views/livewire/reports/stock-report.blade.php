<div>
    <div class="container">
        <div class="row mt-5 mb-3">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h4>Stock Report</h4>
            </div>
        </div>
    </div>
    
    <div class="container my-4">
        <div class="card shadow-sm rounded bg-secondary">
            <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-flex flex-wrap align-items-center justify-content-start gap-3">
                    

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
                        wire:click="export('xlsx')" 
                        wire:loading.attr="disabled" 
                        class="btn btn-dark btn-wave fw-bold d-flex align-items-center">
                        <i class="ri-file-excel-2-line me-1"></i> Export as Excel
                    </button>
                    
                    <!-- Export as CSV -->
                    <button 
                        wire:click="export('csv')" 
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
                            <table class="table text-nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Opening Stock</th>
                                        <th>Purhcase Stock</th>
                                        <th>Sales Stock</th>
                                        <th>Closing Stock</th>
                                        <th>Re-Order Stock</th>
                                        <th>Product Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($productreport as $report)
                                        <tr>
                                            <td>{{ $report->product_name }}</td>
                                            <td>{{ $report->stock->opening_stock }}</td>
                                            <td>
                                                <button type="button" class="badge btn-secondary" data-bs-toggle="modal" data-bs-target="#purchaseModal{{ $report->id }}">
                                                    {{ $report->purchase_count ?? 'N/A' }}
                                                </button>
                                                <!-- Purchase Modal -->
                                                <div wire:ignore.self class="modal fade" id="purchaseModal{{ $report->id }}" tabindex="-1" aria-labelledby="purchaseModalLabel{{ $report->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-secondary">
                                                                <h5 class="text-white modal-title" id="purchaseModalLabel{{ $report->id }}">Purchase Details for {{ $report->product_name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if($report->purchase->isEmpty())
                                                                    <p class="text-center mb-0 text-muted">No purchases found for this product.</p>
                                                                @else
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-striped table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Purchase ID</th>
                                                                                    <th>Quantity</th>
                                                                                    <th>Price</th>
                                                                                    <th>Date</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($report->purchase as $purchase)
                                                                                    <tr>
                                                                                        <td>{{ $purchase->purchaseOrder->purchase_order_no ?? 'N/A' }}</td>
                                                                                        <td>{{ $purchase->quantity }}</td>
                                                                                        <td>{{ $purchase->price }}</td>
                                                                                        <td>{{ $purchase->created_at->format('d-m-Y') }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="badge btn-secondary" data-bs-toggle="modal" data-bs-target="#saleModal{{ $report->id }}">
                                                    {{ $report->sale_count ?? 'N/A' }}
                                                </button>
                                                <!-- Sales Modal -->
                                                <div wire:ignore.self class="modal fade" id="saleModal{{ $report->id }}" tabindex="-1" aria-labelledby="saleModalLabel{{ $report->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-secondary">
                                                                <h5 class="modal-title text-white" id="saleModalLabel{{ $report->id }}">Sales Details for {{ $report->product_name }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                @if($report->sale->isEmpty())
                                                                    <p class="text-center mb-0 text-muted">No sales found for this product.</p>
                                                                @else
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-striped table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Sale ID</th>
                                                                                    <th>Quantity</th>
                                                                                    <th>Price</th>
                                                                                    <th>Date</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($report->sale as $sale)
                                                                                    <tr>
                                                                                        <td>{{ $sale->saleOrder->sale_order_no ?? 'n/a' }}</td>
                                                                                        <td>{{ $sale->quantity }}</td>
                                                                                        <td>{{ $sale->price }}</td>
                                                                                        <td>{{ $sale->created_at->format('d-m-Y') }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <!-- Table Row with Trigger for Modal -->
                                            <td>
                                                @php
                                                    $stocks = $report->stock()->get();

                                                    $stocks = $stocks->filter(function($stock) {
                                                        return $stock->opening_stock > 0;
                                                    });

                                                    $totalOpeningStock = $stocks->sum('opening_stock');
                                                    $closingStock = $totalOpeningStock + $report->purchase_count - $report->sale_count;

                                                    $productName = $report->product_name ?? 'N/A';
                                                @endphp

                                                <div>
                                                    <strong>Closing Stock:</strong> {{ $closingStock ?? 'N/A' }}
                                                </div>

                                                <button type="button" class="btn btn-info btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#stockModal{{ $report->id }}">
                                                    <i class="ri-eye-fill"></i> View Product Details
                                                </button>

                                                <div class="modal fade" id="stockModal{{ $report->id }}" tabindex="-1" aria-labelledby="stockModalLabel{{ $report->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-secondary">
                                                                <h5 class="modal-title text-white" id="stockModalLabel{{ $report->id }}">Stock Details for {{ $productName }}</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Product Name:</strong> <span id="productName{{ $report->id }}">{{ $productName }}</span></p>
                                                                <p><strong>Closing Stock:</strong> <span id="closingStock{{ $report->id }}">{{ $closingStock }}</span></p>
                                                
                                                                @if($stocks->isEmpty())
                                                                    <p>No stock available in any location for this product.</p>
                                                                @else
                                                                    <div class="table-responsive">
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead class="table-dark">
                                                                                <tr>
                                                                                    <th>Branch</th>
                                                                                    <th>Godown</th>
                                                                                    <th>Quantity</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @foreach($stocks as $stock)
                                                                                    <tr>
                                                                                        <td>{{ $stock->branch->name ?? 'N/A' }}</td>
                                                                                        <td>{{ $stock->godown->godown_name ?? 'N/A' }}</td>
                                                                                        <td>{{ $stock->opening_stock ?? 'N/A' }}</td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            

                                            </td>



                                            <td>{{ $report->stock->reorder_stock }}</td>
                                            <td>{{ $report->price }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No Records Found</td>
                                        </tr>
                                    @endforelse


                                </tbody>
                            </table>
                            <div class="mb-3">
                                {{$productreport->links('custom-pagination-links')}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
