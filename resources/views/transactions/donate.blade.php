@extends('layouts.donate')

@section('title', 'Donation Form')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="donation-card w-100">
       <h2 class="mb-4 text-center fw-bold text-primary">
    Donation Form
</h2>
        <form id="donationForm" action="{{ route('transaction.donate.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="donator_name" class="form-label">Your Name:</label>
                <input type="text" id="donator_name" name="donator_name" class="form-control" required>
            </div>
            <div class="table-responsive">
                <table class="table align-middle" id="donationTable">
                    <thead class="table-light">
                        <tr>
                            <th>Recipient</th>
                            <th>Remarks</th>
                            <th>Amount (RM)</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="donations[0][recipient_id]" class="form-control recipient-select" data-row="0" required>
                                    <option value="">-- Select Recipient --</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{ $organization->id }}">
                                            {{ $organization->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="recipient-details" id="recipient-details-0"></div>
                            </td>
                            <td>
                                <input type="text" name="donations[0][remarks]" class="form-control" placeholder="Remarks">
                            </td>
                            <td>
                                <input type="number" name="donations[0][amount]" class="form-control" min="0" step="0.01" placeholder="Amount" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row" disabled>
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <button type="button" id="addRow" class="btn btn-green">
                    <i class="fa-solid fa-plus me-1"></i> Add Donation
                </button>
                <button type="submit" class="btn btn-yellow">
                    <i class="fa-solid fa-paper-plane me-1"></i> Donate
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let rowIdx = 1;
    const recipients = @json($organizations);

    // Prepare details for each organization
    const orgDetails = {};
    recipients.forEach(function(org) {
        orgDetails[org.id] = `<strong>${org.name}</strong>`
            + (org.address ? '<br><span>' + org.address + '</span>' : '')
            + (org.description ? '<br><span>' + org.description + '</span>' : '');
    });

    // Show details for the first row if selected
    document.querySelectorAll('.recipient-select').forEach(function(select) {
        select.addEventListener('change', function() {
            const row = this.getAttribute('data-row');
            const detailsDiv = document.getElementById('recipient-details-' + row);
            detailsDiv.innerHTML = orgDetails[this.value] || '';
        });
    });

    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.querySelector('#donationTable tbody');
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <select name="donations[${rowIdx}][recipient_id]" class="form-control recipient-select" data-row="${rowIdx}" required>
                    <option value="">-- Select Recipient --</option>
                    ${recipients.map(r => `<option value="${r.id}">${r.name}</option>`).join('')}
                </select>
                <div class="recipient-details" id="recipient-details-${rowIdx}"></div>
            </td>
            <td>
                <input type="text" name="donations[${rowIdx}][remarks]" class="form-control" placeholder="Remarks">
            </td>
            <td>
                <input type="number" name="donations[${rowIdx}][amount]" class="form-control" min="0" step="0.01" placeholder="Amount" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm remove-row">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);

        // Add event listener for new select
        tr.querySelector('.recipient-select').addEventListener('change', function() {
            const row = this.getAttribute('data-row');
            const detailsDiv = document.getElementById('recipient-details-' + row);
            detailsDiv.innerHTML = orgDetails[this.value] || '';
        });

        rowIdx++;
    });

    document.querySelector('#donationTable').addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const row = e.target.closest('tr');
            if (document.querySelectorAll('#donationTable tbody tr').length > 1) {
                row.remove();
            }
        }
    });

    // Prevent double submission
    document.getElementById('donationForm').addEventListener('submit', function(e) {
        this.querySelector('button[type="submit"]').disabled = true;
    });
});
</script>
@endsection