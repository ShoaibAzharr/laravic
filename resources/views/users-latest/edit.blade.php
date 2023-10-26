<h2 style="text-align:center;">Update User</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
@endif
<form action="{{route('users.index')}}" method="get">
    <button type="submit">Users Index</button>
</form>

<div style="
            width: 80%;
            border: 2px dotted black;
        "
    >
    <form action="{{route('users.update', $user->id)}}" method="post">
            <div style="padding: 60px;">
                @csrf
                @method('PUT')
                @foreach ($user->getAttributes() as $column => $value)
                        
                    <h3 style="display: inline-block;">{{\str($column)->headline()}}:</h3>
                    <input style="display: inline-block;" type="text" name="{{$column}}" value="{{$value}}">
                    <br>
                    
                @endforeach
                <br>
                <button type="submit">Update</button> 
            </div>
    </form>
</div>