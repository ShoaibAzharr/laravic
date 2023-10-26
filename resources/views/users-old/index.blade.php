@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@foreach ($users as $user)
    <h1>{{$user->name}}</h1>
    <h1>{{$user->email}}</h1>
    <form action="{{route('user.destroy', $user->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    <hr>
@endforeach