<form action="{{route('user.store')}}" method="post">

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

    @csrf
    <input type="text" name="name">
    <button type="submit">Submit</button>
</form>