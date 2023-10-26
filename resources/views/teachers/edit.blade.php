<h2 style="text-align:center;">Update Teacher</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
@endif
<form action="{{route('teachers.index')}}" method="get">
    <button type="submit">Teacher Index</button>
</form>

<div style="
            width: 80%;
            border: 2px dotted black;
        "
    >
    <form action="{{route('teachers.update', $teacher->id)}}" method="post">
            <div style="padding: 60px;">
                @csrf
                @method('PUT')
                @foreach ($teacher->getAttributes() as $column => $value)
                        
                    <h3 style="display: inline-block;">{{\str($column)->headline()}}:</h3>
                    <input style="display: inline-block;" type="text" name="{{$column}}" value="{{old($column, $value)}}">
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