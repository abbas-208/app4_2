@foreach ($trades as $trade)
<tr>
    <td class="column1">{{ $trade->created_at->toDateString() }}</td>
    <td class="column3">{{ $trade->volume }}</td>
    <td class="column3">$ {{ $trade->trade_price - $trade->admin_fee }}</td>
    <td class="column3">{{ Auth::user()->zone->name }}</td>
</tr>
@endforeach