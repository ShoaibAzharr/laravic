<h2 style="text-align:center;">Index Teacher</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
@endif
<form action="{{route('teachers.create')}}" method="get">
    <button type="submit">Create a new teacher</button>
</form>

@if ($teachers->isNotEmpty())
    <table>
        <thead>
            <tr>
                @foreach ($columns = \array_keys($teachers->first()->getAttributes()) as $column)
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
                @foreach ($teachers as $teacher)
                    <tr>
                        @foreach ($columns as $column)
                            <td style="
                                    border: 1px solid #dddddd;
                                    text-align: center;
                                    padding: 8px;
                                "
                            >
                                {{$teacher->$column}}
                            </td>
                        @endforeach

                        <td style="
                                border: 1px solid #dddddd;
                                text-align: center;
                                padding: 8px;
                            "
                        >
                            <form style="display: inline-block;" action="{{route('teachers.edit', $teacher->id)}}" method="get">
                                <button type="submit">Edit</button>
                            </form>

                            <form style="display: inline-block;" action="{{route('teachers.show', $teacher->id)}}" method="get">
                                <button type="submit">Show</button>
                            </form>

                            <form style="display: inline-block;" action="{{route('teachers.destroy', $teacher->id)}}" method="post">
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