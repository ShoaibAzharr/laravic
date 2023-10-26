<h2 style="text-align:center;">Create Item</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
    @if (session('item'))
        <form style="display: inline-block;" action="{{route('items.edit', session('item')->id)}}" method="get">
            <button type="submit">Edit</button>
        </form>

        <form style="display: inline-block;" action="{{route('items.show', session('item')->id)}}" method="get">
            <button type="submit">Show</button>
        </form>

        <form style="display: inline-block;" action="{{route('items.destroy', session('item')->id)}}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    @endif
@endif
<form action="{{route('items.index')}}" method="get">
    <button type="submit">Item Index</button>
</form>
<div style="
        width: 80%;
        border: 2px dotted black;
    "
>
    <form action="{{route('items.store')}}" method="post">
        <div style="padding: 60px;">
            @csrf
            @foreach (
                \array_merge(
                    (new \App\Http\Requests\StoreItemRequest)->rules(),
                    [] // EXTRA COLUMNS HERE (ASS. ARRAY)
                ) as $column => $rules
            )
                @php 
                    $methods = ['paragraph', 'name', 'realText', 'randomNumber'];
                    try {
                        $value = $column != 'password' ? fake()->$column() : 'testtest';
                    } catch(\Throwable $th) {
                        $method = !preg_match('~integer~', $rules) ? $methods[\array_rand($methods)] : 'randomNumber';
                        $value = fake()->$method();
                    }
                @endphp
                
                <h3 style="display: inline-block;">{{\str($column)->headline()}}:</h3>
                <input style="display: inline-block;" type="text" name="{{$column}}" value="{{old($column, $value)}}">
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