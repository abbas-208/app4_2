@if (count($energies) > 0)
    @foreach ($energies as $energy)
    <tr>
        <td class="column1">{{ $energy->type }}</td>
        <td class="column3">{{ $energy->market_price }}</td>
    </tr>
    @endforeach
@else
    <tr>
        <td colspan="2" style="text-align: center; color:brown">
            <h5>No Data Found!</h5>
        </td>
    </tr>
@endif
