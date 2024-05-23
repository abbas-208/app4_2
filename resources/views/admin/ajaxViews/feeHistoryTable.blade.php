@foreach ($feeHistory as $fee)
<tr>
    <td class="column1">{{ $fee->created_at->toDateString() }}</td>
    <td class="column3">{{ $fee->amount }}</td>
</tr>
@endforeach