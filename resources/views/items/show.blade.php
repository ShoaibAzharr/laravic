<h2 style="text-align:center;">Show Item</h2>
<form action="{{route('items.index')}}" method="get">
    <button type="submit">Item Index</button>
</form>
<div style="
            width: 80%;
            border: 2px dotted black;
        "
    >
    @foreach ($item->getAttributes() as $column => $value) 
        <h3 style="padding-left: 50px;"><b>{{\str($column)->headline()}}:&nbsp;</b>{{$value}}</h3>
    @endforeach
</div>