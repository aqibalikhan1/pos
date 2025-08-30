@extends('layouts.material-app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Import Products</h4>
                    <p class="card-category">Import products from Excel file</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($failures ?? false)
                        <div class="alert alert-danger">
                            <h5>Import Errors:</h5>
                            <ul>
                                @foreach($failures as $failure)
                                    <li>
                                        Row {{ $failure->row() }}: {{ $failure->errors()[0] }}
                                        @if($failure->attribute())
                                            (Field: {{ $failure->attribute() }})
                                        @endif
                                        @if($failure->values())
                                            (Value: {{ $failure->values()[$failure->attribute()] ?? 'N/A' }})
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-8">
                            <form action="{{ route('products.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="import_file">Excel File</label>
                                    <input type="file" class="form-control-file" id="import_file" name="import_file" required accept=".xlsx,.xls,.csv">
                                    <small class="form-text text-muted">
                                        Supported formats: .xlsx, .xls, .csv
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-primary">Import Products</button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Excel Template Format</h5>
                                </div>
                                <div class="card-body">
                                    <p>Your Excel file should have the following columns:</p>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Column Name</th>
                                                <th>Description</th>
                                                <th>Required</th>
                                                <th>Example</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>name</td>
                                                <td>Product name</td>
                                                <td>Yes</td>
                                                <td>Product ABC</td>
                                            </tr>
                                            <tr>
                                                <td>sku</td>
                                                <td>Unique SKU code</td>
                                                <td>Yes</td>
                                                <td>PROD-001</td>
                                            </tr>
                                            <tr>
                                                <td>description</td>
                                                <td>Product description</td>
                                                <td>No</td>
                                                <td>This is a product description</td>
                                            </tr>
                                            <tr>
                                                <td>company_id</td>
                                                <td>Company ID or name</td>
                                                <td>Yes</td>
                                                <td>1 or "Company Name"</td>
                                            </tr>
                                            <tr>
                                                <td>category_id</td>
                                                <td>Category ID or name</td>
                                                <td>Yes</td>
                                                <td>1 or "Category Name"</td>
                                            </tr>
                                            <tr>
                                                <td>purchase_price</td>
                                                <td>Purchase price</td>
                                                <td>Yes</td>
                                                <td>100.00</td>
                                            </tr>
                                            <tr>
                                                <td>trade_price</td>
                                                <td>Trade price</td>
                                                <td>Yes</td>
                                                <td>120.00</td>
                                            </tr>
                                            <tr>
                                                <td>print_price</td>
                                                <td>Print price</td>
                                                <td>Yes</td>
                                                <td>130.00</td>
                                            </tr>
                                            <tr>
                                                <td>wholesale_price</td>
                                                <td>Wholesale price</td>
                                                <td>Yes</td>
                                                <td>140.00</td>
                                            </tr>
                                            <tr>
                                                <td>stock_quantity</td>
                                                <td>Stock quantity</td>
                                                <td>No</td>
                                                <td>100</td>
                                            </tr>
                                            <tr>
                                                <td>min_stock_level</td>
                                                <td>Minimum stock level</td>
                                                <td>No</td>
                                                <td>10</td>
                                            </tr>
                                            <tr>
                                                <td>barcode</td>
                                                <td>Barcode</td>
                                                <td>No</td>
                                                <td>1234567890123</td>
                                            </tr>
                                            <tr>
                                                <td>unit</td>
                                                <td>Unit of measurement</td>
                                                <td>No</td>
                                                <td>pcs</td>
                                            </tr>
                                            <tr>
                                                <td>pieces_per_pack</td>
                                                <td>Pieces per pack</td>
                                                <td>No</td>
                                                <td>12</td>
                                            </tr>
                                            <tr>
                                                <td>packaging_type</td>
                                                <td>Packaging type</td>
                                                <td>No</td>
                                                <td>box</td>
                                            </tr>
                                            <tr>
                                                <td>is_active</td>
                                                <td>Active status (1/0)</td>
                                                <td>No</td>
                                                <td>1</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
