<h2 style="text-align:center;">Update Service</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
@endif
<form action="{{route('services.index')}}" method="get">
    <button type="submit">Service Index</button>
</form>

<div style="
            width: 80%;
            border: 2px dotted black;
        "
    >
    <form action="{{route('services.update', $service->id)}}" method="post">
            <div style="padding: 60px;">
                @csrf
                @method('PUT')
                @foreach ($service->getAttributes() as $column => $value)
                        
                    <h3 style="display: inline-block;">{{\str($column)->headline()}}:</h3>
                    <input style="display: inline-block;" type="text" name="{{$column}}" value="{{$value}}">
                    @error($column)
                        <p><i>{{ $message }}</i></p>
                    @enderror
                    <br>
                    
                @endforeach
                <br>
                <button type="submit">Update</button> 
            </div>
    </form>
</div>