<div>
        <div class="container">
            <div class="row">
                <div class="col-12 mt-5 d-flex align-items-center justify-content-between mb-3">
                    <h4>Manage Lead Sources</h4>
                    <a href="{{route('lead-source.create')}}" class="btn btn-secondary btn-wave float-end" >Create</a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Per Page : {{ $perPage }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(2)">2</a></li>
                            <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(5)">5</a></li>
                            <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(10)">10</a></li>
                            <li><a class="dropdown-item" href="#" wire:click.prevent="updatePerPage(20)">20</a></li>
                        </ul>
                    </div>
                    <!-- Search Input -->
                    <div class="d-flex align-items-center">
                        <div class="col-auto d-none d-md-block">
                            <label for="search" class="form-label">Search</label>
                        </div>
                        <div class="col-auto">
                            <input wire:model.live="search" type="text" id="search" class="form-control" placeholder="Search">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="container">
                    <div class="col-md-12 shadow">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">
                                                    <input type="checkbox" wire:model.live="selectAll">
                                                </th>
                                                <th scope="col" wire:click="setSortBy('name')">
                                                    Name
                                                    @if ($sortBy === 'name')
                                                        @if ($sortDir === 'asc')
                                                            <i class="ri-arrow-up-s-line"></i>
                                                        @else
                                                            <i class="ri-arrow-down-s-line"></i>
                                                        @endif
                                                    @else
                                                        <i class="ri-expand-up-down-fill"></i>
                                                    @endif
                                                </th>
                                                <th scope="col">Status</th>
                                                <th scope="col" wire:click="setSortBy('created_at')" >Created On
                                                    @if ($sortBy === 'created_at')
                                                        @if ($sortDir === 'asc')
                                                            <i class="ri-arrow-up-s-line"></i>
                                                        @else
                                                            <i class="ri-arrow-down-s-line"></i>
                                                        @endif
                                                    @else
                                                        <i class="ri-expand-up-down-fill"></i>
                                                    @endif
                                                </th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($leadSources as $leadSource)
                                            <tr wire:key="{{ $leadSource->id }}">
                                                <td>
                                                    <input type="checkbox" wire:model.live.debounce.300ms="selectedLeadSources" value="{{ $leadSource->id }}">
                                                </td>
                                                <td>{{ $leadSource->name }}</td>
                                                <td>
                                                    <label class="switch">
                                                        <input type="checkbox" 
                                                               wire:click="toggleStatus({{ $leadSource->id }})" 
                                                               {{ $leadSource->active ? 'checked' : '' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($leadSource->created_at)->format('d M, Y') }}</td>
                                                <td>
                                                    <div class="hstack gap-2 flex-wrap">
                                                        <a href="{{route('lead-source.edit',$leadSource->id)}}" class="btn btn-link text-info fs-14 lh-1 p-0"><i class="ri-edit-line"></i></a>
                                                        <button class="btn btn-link text-danger fs-14 lh-1 p-0" data-bs-toggle="modal" data-bs-target="#deleteSegmentModal" wire:click="confirmDelete({{ $leadSource->id }})"><i class="ri-delete-bin-5-line"></i></button>
                                                        <!-- Delete Modal -->
                                                        <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="deleteSegmentModal" tabindex="-1" aria-labelledby="deleteSegmentModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteSegmentModalLabel">Delete</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form wire:submit.prevent="deleteConfirmed">
                                                                        <div class="modal-body">
                                                                            <h6>Are you sure you want to delete this lead source?</h6>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No lead sources found.</td>
                                                </tr>
                                            @endforelse                 
                                        </tbody>
                                    </table>
                                     <!-- Bulk Delete Button -->
                                    <div class="mt-2">
                                        @if($selectedLeadSources)
                                            <button class="btn btn-outline-danger btn-wave" data-bs-toggle="modal" data-bs-target="#bulkDeleteConfirmationModal" >
                                                Delete
                                            </button>
                                            <!-- Bulk Delete Confirmation Modal -->
                                            <div wire:ignore.self class="modal fade" data-bs-dismiss="modal" id="bulkDeleteConfirmationModal" tabindex="-1" aria-labelledby="bulkDeleteConfirmationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="bulkDeleteConfirmationModalLabel">Confirm Bulk Delete</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>Are you sure you want to delete the selected leads?</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="button" class="btn btn-danger" wire:click="bulkDelete">
                                                                Confirm Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                   

                                    <div class="mt-3">
                                        {{ $leadSources->links('custom-pagination-links') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
