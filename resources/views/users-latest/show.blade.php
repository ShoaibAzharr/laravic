<h2 style="text-align:center;">Show User</h2>
<form action="{{route('users.index')}}" method="get">
    <button type="submit">Users Index</button>
</form>
<div style="
            width: 80%;
            border: 2px dotted black;
        "
    >
    @foreach ($user->getAttributes() as $column => $value) 
        <h3 style="padding-left: 50px;"><b>{{\str($column)->headline()}}:&nbsp;</b>{{$value}}</h3>
    @endforeach
</div>