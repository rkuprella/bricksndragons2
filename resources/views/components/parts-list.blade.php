@props(['csvPath'])

@php
    use League\Csv\Reader;
    use Illuminate\Support\Facades\Storage;

    $parts = [];

    if ($csvPath && Storage::disk('public')->exists($csvPath)) {
        $csv = Reader::createFromPath(Storage::disk('public')->path($csvPath), 'r');
        $csv->setHeaderOffset(0); // Use the first row as the header

        foreach ($csv as $row) {
            $parts[] = [
                'part_number' => $row['BLItemNo'] ?? ($row['LdrawId'] ?? 'Unknown'),
                'name' => $row['PartName'] ?? 'Unknown Part',
                'color' => $row['ColorName'] ?? 'Unknown Color',
                'quantity' => $row['Qty'] ?? 0,
            ];
        }
    }
@endphp

@if (!empty($parts))
    <div class="bg-neutral p-4 rounded-md shadow">
        <h2 class="text-lg font-bold text-foreground mb-2">Parts List</h2>
        <table class="w-full border border-gray-200">
            <thead>
                <tr class=" text-left">
                    <th class="p-2">Part Number</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">Color</th>
                    <th class="p-2">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($parts as $part)
                    <tr class="border-t">
                        <td class="p-2">{{ $part['part_number'] }}</td>
                        <td class="p-2">{{ $part['name'] }}</td>
                        <td class="p-2">{{ $part['color'] }}</td>
                        <td class="p-2 font-bold">{{ $part['quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="text-sm text-foreground-muted">No parts available.</p>
@endif
