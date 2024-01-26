@extends('layouts.dashboard.dashboardMaster')

@section('content')
<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <h3>Inventory of {{ $product->name }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                  <tr>
                    {{-- <th scope="col">Color</th> --}}
                    <th scope="col">Size</th>
                    <th scope="col">Color</th>
                    <th scope="col">Quantity</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($inventory as $inven)
                    <tr>
                      {{-- <th scope="row">1</th> --}}
                      <td>{{ $inven->relation_to_size->size }}</td>
                      <td style="background: {{ $inven->relation_to_color->color_code }};color: #fff">
                        {{ $inven->relation_to_color->color }}
                      </td>
                      <td>{{ $inven->quantity }}</td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h3>Add Inventory</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('inventory.store', $product->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" disabled value="{{ $product->name }}" class="form-control">
            </div>
            <div class="mb-3">
                <select name="size_id" class="form-control">
                    <option value="">Select Size</option>
                    @foreach ($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->size }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <select name="color_id" class="form-control">
                    <option value="">Select Color</option>
                    @foreach ($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->color }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <input type="number" name="quantity" class="form-control" placeholder="Quantity">
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Add Inventory</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
