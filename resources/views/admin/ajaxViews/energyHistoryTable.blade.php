@foreach ($energyHistory as $energy)
<tr>
    <td class="column1">{{ $energy->created_at }}</td>
    <td class="column3">{{ $energy->market_price }}</td>
</tr>
@endforeach