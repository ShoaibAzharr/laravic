<h2 style="text-align:center;">Index Service</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
@endif
<form action="{{route('services.create')}}" method="get">
    <button type="submit">Create a new service</button>
</form>

@if ($services->isNotEmpty())
    <table>
        <thead>
            <tr>
                @foreach ($columns = \array_keys($services->first()->getAttributes()) as $column)
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
                @foreach ($services as $service)
                    <tr>
                        @foreach ($columns as $column)
                            <td style="
                                    border: 1px solid #dddddd;
                                    text-align: center;
                                    padding: 8px;
                                "
                            >
                                {{$service->$column}}
                            </td>
                        @endforeach

                        <td style="
                                border: 1px solid #dddddd;
                                text-align: center;
                                padding: 8px;
                            "
                        >
                            <form style="display: inline-block;" action="{{route('services.edit', $service->id)}}" method="get">
                                <button type="submit">Edit</button>
                            </form>

                            <form style="display: inline-block;" action="{{route('services.show', $service->id)}}" method="get">
                                <button type="submit">Show</button>
                            </form>

                            <form style="display: inline-block;" action="{{route('services.destroy', $service->id)}}" method="post">
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