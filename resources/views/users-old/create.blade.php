<form action="{{route('user.store')}}" method="post">

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

    @csrf
    <input type="text" name="name">
    <input type="text" name="email">
    <input type="text" name="password">
    <button type="submit">Submit</button>
</form>