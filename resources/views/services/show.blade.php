<h2 style="text-align:center;">Show Service</h2>
<form action="{{route('services.index')}}" method="get">
    <button type="submit">Service Index</button>
</form>
<div style="
            width: 80%;
            border: 2px dotted black;
        "
    >
    @foreach ($service->getAttributes() as $column => $value) 
        <h3 style="padding-left: 50px;"><b>{{\str($column)->headline()}}:&nbsp;</b>{{$value}}</h3>
    @endforeach
</div>