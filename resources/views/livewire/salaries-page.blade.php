<div>
    @include('backend.users-tabs')

    <div class="h4 mt-4">Salary History</div>

    <table class="table table-sm mt-4">
        <thead>
            <tr>
                <th>Amount</th>
                <th>Effective Date</th>
                <th>Is Current</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($row->salaries()->orderBy('effective_date', 'desc')->get() ?? [] as $salary)
                <tr>
                    <td>{{ $salary->currency }} {{ $salary->amount }}</td>
                    <td>{{ $salary->effective_date?->format('d F, y') }}</td>
                    <td>{{ $salary->is_current ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
