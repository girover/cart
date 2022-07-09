<div>
    <table>
    <tr>
        <td>name</td>
        <td>qunatity</td>
        <td>total price</td>
        <td>Delete</td>
    </tr>
    @foreach ($cart_items as $item)
    <tr>
        <td>{{$item->name}}</td>
        <td>{{$item->quantity}}</td>
        <td>{{$item->total_price}}</td>
        <td></td>
    </tr>
    @endforeach
    </table>
</div>