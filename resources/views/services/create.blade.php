<h2 style="text-align:center;">Create Service</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
    @if (session('service'))
        <form style="display: inline-block;" action="{{route('services.edit', session('service')->id)}}" method="get">
            <button type="submit">Edit</button>
        </form>

        <form style="display: inline-block;" action="{{route('services.show', session('service')->id)}}" method="get">
            <button type="submit">Show</button>
        </form>

        <form style="display: inline-block;" action="{{route('services.destroy', session('service')->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    @endif
@endif
<form action="{{route('services.index')}}" method="get">
    <button type="submit">Service Index</button>
</form>
<div style="
        width: 80%;
        border: 2px dotted black;
    "
>
    <form action="{{route('services.store')}}" method="post">
        <div style="padding: 60px;">
            @csrf
            @foreach (
                \array_merge(
                    (new \App\Models\Service)->getFillable(),
                    [] // EXTRA COLUMNS HERE 
                ) as $column
            )
                @php 
                    $methods = ['paragraph', 'sentence', 'word', 'text', 'name', 'realText'];
                    try {
                        $value = $column != 'password' ? fake()->$column() : 'testtest';
                    } catch(\Throwable $th) {
                        $method = $methods[\array_rand($methods)];
                        $value = fake()->$method();
                    }
                @endphp
                
                <h3 style="display: inline-block;">{{\str($column)->headline()}}:</h3>
                <input style="display: inline-block;" type="text" name="{{$column}}" value="{{$value}}">
                @error($column)
                    <p><i>{{ $message }}</i></p>
                @enderror
                <br>
                
            @endforeach
            <br>
            <button type="submit">Create</button> 
        </div>
    </form>
</div>