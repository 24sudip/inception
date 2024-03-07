@extends('layouts.dashboard.dashboardMaster')

@section('content')
<div class="col-xl-12 col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3>Order List</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Total Price</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                    <td>
                        @if ($order->status == 0)
                        Placed
                        @elseif ($order->status == 1)
                        Processing
                        @elseif ($order->status == 2)
                        Shipped
                        @elseif ($order->status == 3)
                        Delivered
                        @elseif ($order->status == 4)
                        Cancel
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('order.status', $order->id) }}" method="POST">
                            @csrf
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <button name="status" value="0" class="dropdown-item" type="submit">Placed</button>
                                    <button name="status" value="1" class="dropdown-item" type="submit">Processing</button>
                                    <button name="status" value="2" class="dropdown-item" type="submit">Shipped</button>
                                    <button name="status" value="3" class="dropdown-item" type="submit">Delivered</button>
                                    <button name="status" value="4" class="dropdown-item" type="submit">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection
