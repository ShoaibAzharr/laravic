<h2 style="text-align:center;">Show Teacher</h2>
<form action="{{route('teachers.index')}}" method="get">
    <button type="submit">Teacher Index</button>
</form>
<div style="
            width: 80%;
            border: 2px dotted black;
        "
    >
    @foreach ($teacher->getAttributes() as $column => $value) 
        <h3 style="padding-left: 50px;"><b>{{\str($column)->headline()}}:&nbsp;</b>{{$value}}</h3>
    @endforeach
</div>