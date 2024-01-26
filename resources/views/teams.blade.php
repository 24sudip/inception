<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teams</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            Add Team Member
                        </div>
                        <div class="card-body">
                            <form action="{{ url('teamInsert') }}" method="POST">
                                @csrf
                                @if (session('teamInsertMsg'))
                                <div class="alert alert-success">
                                    {{ session('teamInsertMsg') }}
                                </div>
                                @endif

                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Name" name="name">
                                </div>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="mb-3">
                                    <input type="tel" class="form-control" placeholder="Number" name="number">
                                </div>
                                @error('number')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-success">Add Member</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            Team Member List
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Number</th>
                                    <th scope="col">Time</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($teams as $team)
                                    <tr>
                                    <th scope="row">{{ $team->id }}</th>
                                    <td>{{ $team->name }}</td>
                                    <td>{{ $team->number }}</td>
                                    <td>{{ $team->created_at }}</td>
                                    <td><a href="{{ url('/teamDelete', $team->id) }}" class="btn btn-danger btn-sm">Delete</a></td>
                                    </tr>
                                    @empty
                                    <div class="alert alert-danger">No Team Member Found</div>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
