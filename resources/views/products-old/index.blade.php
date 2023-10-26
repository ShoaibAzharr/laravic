@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@foreach ($products as $product)
    <h1>{{$product->name}}</h1>
    <h1>{{$product->id}}</h1>
    <form action="{{route('product.destroy', $product->id)}}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    <hr>
@endforeach