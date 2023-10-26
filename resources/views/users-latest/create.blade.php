<h2 style="text-align:center;">Create User</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
    @if (session('user'))
        <form style="display: inline-block;" action="{{route('users.edit', session('user')->id)}}" method="get">
            <button type="submit">Edit</button>
        </form>

        <form style="display: inline-block;" action="{{route('users.show', session('user')->id)}}" method="get">
            <button type="submit">Show</button>
        </form>

        <form style="display: inline-block;" action="{{route('users.destroy', session('user')->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    @endif
@endif
<form action="{{route('users.index')}}" method="get">
    <button type="submit">Users Index</button>
</form>
<div style="
        width: 80%;
        border: 2px dotted black;
    "
>
    <form action="{{route('users.store')}}" method="post">
            <div style="padding: 60px;">
                @csrf
                @foreach (
                    \array_merge(
                        (new \App\Models\User)->getFillable(),
                        [] // EXTRA COLUMNS HERE 
                    ) as $column
                )
                    @php 
                        $methods = ['paragraph', 'sentence', 'word', 'text', 'name', 'realText'];
                        try {
                            $value = fake()->$column();
                        } catch(\Throwable $th) {
                            $method = $methods[\array_rand($methods)];
                            $value = fake()->$method();
                        }
                    @endphp
                    
                    <h3 style="display: inline-block;">{{\str($column)->headline()}}:</h3>
                    <input style="display: inline-block;" type="text" name="{{$column}}" value="{{$value}}">
                    <br>
                    
                @endforeach
                <br>
                <button type="submit">Create</button> 
            </div>
    </form>
</div>