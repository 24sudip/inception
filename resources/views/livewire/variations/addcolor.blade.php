<div class="col-xl-12">
    {{-- If your happiness depends on money, you will never be happy with yourself.wire:click="edit_color({{ $color->id }})" --}}
    <div class="row">
        <div class="col-xl-6 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Color Variations</h4>
                </div>
                <div class="card-body">

                    @if (session('colrAddMsg'))
                        <div class="alert alert-success">
                            {{ session('colrAddMsg') }}
                        </div>
                    @endif

                    <div class="basic-form">
                        <form wire:submit.prevent="color_insert">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Add Color Name</label>
                                <div class="col-sm-9 mb-3">
                                    <input type="text" class="form-control" wire:model="color">
                                    @error('color')
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Add Color Code</label>
                                <div class="col-sm-9 mb-3">
                                    <input type="color" class="form-control" wire:model="color_code">
                                    @error('color_code')
                                    <div class="alert alert-danger">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Color</button>
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
                        <th scope="col">Color</th>
                        <th scope="col">Color Code</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($colors as $color)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $color->color }}</td>
                          <td>
                            <span style="background: {{ $color->color_code }}; color: #fff;">
                                {{ $color->color_code }}
                            </span>
                          </td>
                          <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModal{{ $color->id }}" wire:click="edit_color({{ $color->id }})">
                                Edit
                            </button>
                            <div wire:ignore.self class="modal fade" id="exampleModal{{ $color->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            @if (session('colrUpdtMsg'))
                                                <div class="alert alert-success">
                                                    {{ session('colrUpdtMsg') }}
                                                </div>
                                            @endif

                                            <div class="basic-form">
                                                <form wire:submit.prevent="color_update({{ $color->id }})">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Update Color Name</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="text" class="form-control" wire:model="color"
                                                            value="{{ $color }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">Update Color Code</label>
                                                        <div class="col-sm-9 mb-3">
                                                            <input type="color" class="form-control" wire:model="color_code" value="{{ $color_code }}">
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update Color</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
