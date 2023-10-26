<form action="{{route('product.update', $product->id)}}" method="post">
@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

    @csrf
    @method('PUT')
    <input type="text" name="name" value="{{$product->name}}">
    <!-- <input type="text" name="email" value="{{$product->email}}"> -->
    <button type="submit">Submit</button>
</form>