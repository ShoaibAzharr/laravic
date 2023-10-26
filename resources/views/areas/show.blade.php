<h2 style="text-align:center;">Show Area</h2>
<form action="{{route('areas.index')}}" method="get">
    <button type="submit">Area Index</button>
</form>
<div style="
            width: 80%;
            border: 2px dotted black;
        "
    >
    @foreach ($area->getAttributes() as $column => $value) 
        <h3 style="padding-left: 50px;"><b>{{\str($column)->headline()}}:&nbsp;</b>{{$value}}</h3>
    @endforeach
</div>