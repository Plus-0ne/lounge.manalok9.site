<datalist id="rabbit_breeds">
    @php
        $rabbit = ['American', 'American Chinchilla', 'American Fuzzy Lop', 'American Sable', 'Argente Brun', 'Belgian Hare', 'Beveren', 'Blance de Hotot', 'Britannia Petite', 'Californian', "Champagne D'argent", 'Checkered Giant', 'Cinnamon', "Creme D'argent", 'Dutch', 'Dwarf Hotot', 'English Angora', 'English Lop', 'English Spot', 'Flemish Giant', 'Florida White', 'French Angora', 'French Lop', 'Giant Angora', 'Giant Chinchilla', 'Harlequin', 'Havana', 'Himalayan', 'Holland Lop', 'Jersey Wooly', 'Lilac', 'Lionhead', 'Mini Lop', 'Mini Rex', 'Mini Satin', 'Netherland Dwarf', 'New Zealand', 'Palomino', 'Polish', 'Rex', 'Rhinelander', 'Satin', 'Satin Angora', 'Silver', 'Silver Fox', 'Silver Marten', 'Standard Chinchilla', 'Tan', 'Thrianta'];
    @endphp

    @foreach ($rabbit as $row)
        <option value="{{ $row }}"> {{ $row }} </option>
    @endforeach

</datalist>
