<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">First</th>
            <th scope="col">Last</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        @forelse ($events as $event)
        <tbody>
            <tr>
              <th scope="row">1</th>
              <td>{{ $event->nama_event }}</td>
              <td>{{ $event->description }}</td>
              <td>{{ $event->location }}</td>
              <td>{{ $event->category }}</td>
              <td>{{ $event->start_date }}</td>
              <td>{{ $event->end_date }}</td>
            </tr>
          </tbody>
        @empty
          <p>No events</p>
        @endforelse
    </table>
    @forelse ($events as $event)
    <div class="card" style="width: 18rem;">
        <img src="{{ Storage::url($event->image)}}" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">{{ $event->nama_event }}</h5>
          <p class="card-text">{{ Str::limit($event->description, 50) }}</p>
          <a href="#" class="btn btn-primary">Lihat Lebih Detail</a>
        </div>
    </div>
    @empty
    <p class="text-dark">No events</p>
    @endforelse

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
