@if (count($fees) > 0)
    @foreach ($fees as $fee)
    <tr>
        <td class="column1">{{ $fee->charge_type }}</td>
        <td class="column3">$ {{ $fee->amount }}</td>
        <td class="column4">
            <button class="btn btn-primary" data-id="{{ $fee->id }}" data-bs-toggle="modal" data-bs-target="#editFee" onclick="editFee(this);">
                Edit</button> &nbsp;|&nbsp;
            <button class="btn btn-secondary" data-id="{{ $fee->id }}" data-bs-toggle="modal" data-bs-target="#feeHistory" onclick="historyFee(this);">
                History</button>
        </td>
    </tr>
    @endforeach
@else
    <tr style="text-align: center; color:brown">
        <td colspan="3">
            No Data Found!
        </td>
    </tr>
@endif
