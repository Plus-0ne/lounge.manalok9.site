<datalist id="productList">
    @foreach ($data['productsName'] as $row)
        <option value="{{ $row }}">
    @endforeach
</datalist>
