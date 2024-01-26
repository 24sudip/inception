<div class="col-xl-12">
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="page-titles">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">App</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Size Variations</h4>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    @endif
                    <div class="basic-form">
                        {{-- <input type="text" wire:model.live="sudip">
                        <h1>Lekho: {{ $sudip }}</h1> --}}
                        <form wire:submit.prevent="size_insert">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Add Size Variations</label>
                                <div class="col-sm-9 mb-3">
                                    <input type="text" class="form-control" wire:model="size">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Add Size</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Serial</th>
                        <th scope="col">Size</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($sizes as $size)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $size->size }}</td>
                          <td>
                            <button class="btn btn-danger btn-sm" wire:click="delete_size({{ $size->id }})">Delete</button>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
