<h2 style="text-align:center;">Index Area</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
@endif
<form action="{{route('areas.create')}}" method="get">
    <button type="submit">Create a new area</button>
</form>

@if ($areas->isNotEmpty())
    <table>
        <thead>
            <tr>
                @foreach ($columns = \array_keys($areas->first()->getAttributes()) as $column)
                    <th 
                        style="
                            border: 1px solid #dddddd;
                            text-align: center;
                            padding: 8px;
                        "
                    >
                        {{\str($column)->headline()}}
                    </th>
                @endforeach
                <th 
                    style="
                        border: 1px solid #dddddd;
                        text-align: center;
                        padding: 8px;
                    "
                >
                    Actions
                </th>
            </tr>
        </thead>
            <tbody>
                @foreach ($areas as $area)
                    <tr>
                        @foreach ($columns as $column)
                            <td style="
                                    border: 1px solid #dddddd;
                                    text-align: center;
                                    padding: 8px;
                                "
                            >
                                {{$area->$column}}
                            </td>
                        @endforeach

                        <td style="
                                border: 1px solid #dddddd;
                                text-align: center;
                                padding: 8px;
                            "
                        >
                            <form style="display: inline-block;" action="{{route('areas.edit', $area->id)}}" method="get">
                                <button type="submit">Edit</button>
                            </form>

                            <form style="display: inline-block;" action="{{route('areas.show', $area->id)}}" method="get">
                                <button type="submit">Show</button>
                            </form>

                            <form style="display: inline-block;" action="{{route('areas.destroy', $area->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
    </table>
@else
    <h3 style="text-align:center;">No record found</h3>
@endif