<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 space-y-6">
    <h1 class="text-3xl font-bold text-gray-800">የክፍያ ማረጋገጫዎች መቆጣጠሪያ (Payment Approvals)</h1>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead class="bg-blue-900 text-white text-sm">
                <tr>
                    <th class="p-4">የሰልጣኝ ስም</th>
                    <th class="p-4">ትራንዛክሽን ኮድ</th>
                    <th class="p-4">ደረሰኝ (Screenshot)</th>
                    <th class="p-4">ሁኔታ</th>
                    <th class="p-4">ተግባር (Action)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @foreach($payments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="p-4 font-semibold">{{ $payment->user->name }}<br><span class="text-xs text-gray-500">{{ $payment->user->email }}</span></td>
                        <td class="p-4 font-mono font-bold">{{ $payment->transaction_code }}</td>
                        <td class="p-4">
                            <a href="{{ asset('storage/' . $payment->screenshot) }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1 font-semibold">
                                <i class="fas fa-image"></i> ምስሉን እይ
                            </a>
                        </td>
                        <td class="p-4">
                            @if($payment->status === 'approved')
                                <span class="bg-green-100 text-green-800 text-xs px-2.5 py-1 rounded-full font-bold">Approved</span>
                            @elseif($payment->status === 'rejected')
                                <span class="bg-red-100 text-red-800 text-xs px-2.5 py-1 rounded-full font-bold">Rejected</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2.5 py-1 rounded-full font-bold">Pending</span>
                            @endif
                        </td>
                        <td class="p-4 flex gap-2">
                            @if($payment->status === 'pending')
                                <form action="{{ route('admin.payments.approve', $payment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-bold transition">ፈቅድ (Approve)</button>
                                </form>
                                <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-bold transition">ከልክል (Reject)</button>
                                </form>
                            @else
                                <span class="text-gray-400 text-xs italic">ተጠናቋል</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
</body>
</html>