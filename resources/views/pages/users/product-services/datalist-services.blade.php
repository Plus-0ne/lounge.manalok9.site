<datalist id="servicesList">
    @foreach ($data['serviceNames'] as $row)
        <option value="{{ $row }}">
    @endforeach
</datalist>
