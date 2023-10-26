<h2 style="text-align:center;">Index Item</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
@endif
<form action="{{route('items.create')}}" method="get">
    <button type="submit">Create a new item</button>
</form>

@if ($items->isNotEmpty())
    <table>
        <thead>
            <tr>
                @foreach ($columns = \array_keys($items->first()->getAttributes()) as $column)
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
                @foreach ($items as $item)
                    <tr>
                        @foreach ($columns as $column)
                            <td style="
                                    border: 1px solid #dddddd;
                                    text-align: center;
                                    padding: 8px;
                                "
                            >
                                {{$item->$column}}
                            </td>
                        @endforeach

                        <td style="
                                border: 1px solid #dddddd;
                                text-align: center;
                                padding: 8px;
                            "
                        >
                            <form style="display: inline-block;" action="{{route('items.edit', $item->id)}}" method="get">
                                <button type="submit">Edit</button>
                            </form>

                            <form style="display: inline-block;" action="{{route('items.show', $item->id)}}" method="get">
                                <button type="submit">Show</button>
                            </form>

                            <form style="display: inline-block;" action="{{route('items.destroy', $item->id)}}" method="post">
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