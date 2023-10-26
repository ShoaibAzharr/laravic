<form action="{{route('user.update', $user->id)}}" method="post">
@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{$user->name}}">
    <input type="text" name="email" value="{{$user->email}}">
    <button type="submit">Submit</button>
</form>