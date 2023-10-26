<h2 style="text-align:center;">Index User</h2>
@if (session('success'))
    <h3>
        {{ session('success') }}
    </h3>
@endif
<form action="{{route('users.create')}}" method="get">
    <button type="submit">Create a new user</button>
</form>

@if ($users->isNotEmpty())
    <table>
        <thead>
            <tr>
                @foreach ($columns = \array_keys($users->first()->getAttributes()) as $column)
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
                @foreach ($users as $user)
                    <tr>
                        @foreach ($columns as $column)
                            <td style="
                                    border: 1px solid #dddddd;
                                    text-align: center;
                                    padding: 8px;
                                "
                            >
                                {{$user->$column}}
                            </td>
                        @endforeach

                        <td style="
                                border: 1px solid #dddddd;
                                text-align: center;
                                padding: 8px;
                            "
                        >
                            <form style="display: inline-block;" action="{{route('users.edit', $user->id)}}" method="get">
                                <button type="submit">Edit</button>
                            </form>

                            <form style="display: inline-block;" action="{{route('users.show', $user->id)}}" method="get">
                                <button type="submit">Show</button>
                            </form>

                            <form style="display: inline-block;" action="{{route('users.destroy', $user->id)}}" method="post">
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