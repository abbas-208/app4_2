@if (count($energies) > 0)
    @foreach ($energies as $energy)
    <tr>
        <td class="column1">{{ $energy->type }}</td>
        <td class="column3">$ {{ $energy->market_price }}</td>
        <td class="column4">
            <button class="btn btn-primary" data-id="{{ $energy->id }}" data-bs-toggle="modal" data-bs-target="#editEnergy" onclick="editEnergy(this);">
                Edit</button> &nbsp;|&nbsp;
            <button class="btn btn-danger" data-id="{{ $energy->id }}" data-type="Energy" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="deleteItem(this);">
                Delete</button> &nbsp;|&nbsp;
            <button class="btn btn-secondary" data-id="{{ $energy->id }}" data-bs-toggle="modal" data-bs-target="#energyHistory" onclick="historyEnergy(this);">
                History</button>
        </td>
    </tr>
    @endforeach
@else
    <tr>
        <td colspan="3" style="text-align: center; color:brown">
            <h5>No Data Found!</h5>
        </td>
    </tr>
@endif
