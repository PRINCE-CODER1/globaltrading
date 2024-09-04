<!-- resources/views/livewire/product-form.blade.php -->
<div>
    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <label for="product_category_id" class="form-label">Product Category<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-folder"></i></div>
                <select wire:model.live="product_category_id" id="product_category_id" class="form-control" required>
                    <option value="">Select a Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('product_category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="child_category_id" class="form-label">Child Category<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-folder"></i></div>
                <select wire:model.live="child_category_id" id="child_category_id" class="form-control" required>
                    <option value="">Select a Child Category</option>
                    @foreach($childcategories as $childcategory)
                        <option value="{{ $childcategory->id }}">{{ $childcategory->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('child_category_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="series_id">Series</label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-tag"></i></div>
                <select wire:model="series_id" id="series_id" class="form-control">
                    <option value="">Select Series</option>
                    @foreach($series as $ser)
                        <option value="{{ $ser->id }}">{{ $ser->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('series_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-box"></i></div>
                <input type="text" wire:model="product_name" id="product_name" class="form-control" required>
            </div>
            @error('product_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="product_description" class="form-label">Product Description</label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-file-text"></i></div>
                <textarea wire:model="product_description" id="product_description" class="form-control"></textarea>
            </div>
            @error('product_description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tax" class="form-label">Tax</label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-percent"></i></div>
                <select wire:model="tax" id="tax" class="form-control" required>
                    <option value="">Select a Tax</option>
                    @foreach($taxes as $tax)
                        <option value="{{ $tax->value }}">{{ $tax->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('tax')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="hsn_code" class="form-label">HSN Code<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-bar-chart"></i></div>
                <input type="text" wire:model="hsn_code" id="hsn_code" class="form-control" required>
            </div>
            @error('hsn_code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-cash"></i></div>
                <input type="number" step="0.01" wire:model="price" id="price" class="form-control" required>
            </div>
            @error('price')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="product_code" class="form-label">Product Code<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-code-slash"></i></div>
                <input type="text" wire:model="product_code" id="product_code" class="form-control" required>
            </div>
            @error('product_code')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="opening_stock" class="form-label">Opening Stock<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-box-seam"></i></div>
                <input type="number" wire:model="opening_stock" id="opening_stock" class="form-control" required>
            </div>
            @error('opening_stock')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="reorder_stock" class="form-label">Re-order Stock<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-arrow-repeat"></i></div>
                <input type="number" wire:model="reorder_stock" id="reorder_stock" class="form-control" required>
            </div>
            @error('reorder_stock')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="branch_id" class="form-label">Select Branch<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-building"></i></div>
                <select wire:model.live="branch_id" id="branch_id" class="form-control" required>
                    <option value="">Select a Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('branch_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="godown_id" class="form-label">Select Godown<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="bi bi-archive"></i></div>
                <select wire:model="godown_id" id="godown_id" class="form-control" required>
                    <option value="">Select a Godown</option>
                    @foreach($godowns as $godown)
                        <option value="{{ $godown->id }}">{{ $godown->godown_name }}</option>
                    @endforeach
                </select>
            </div>
            @error('godown_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="unit_id" class="form-label">Select Unit<sup class="text-danger">*</sup></label>
            <div class="input-group">
                <div class="input-group-text"><i class="ri-formula"></i></div>
                <select wire:model="unit_id" id="unit_id" class="form-control" required>
                    <option value="">Select a Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->formula_name }}</option>
                    @endforeach
                </select>
            </div>
            @error('unit_id')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-secondary">
            <i class="bi bi-save"></i> Save
        </button>
    </form>
</div>
