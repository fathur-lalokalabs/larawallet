@if ($success = Session::get('success'))

<div class="mt-6 bg-green-100 rounded-lg p-4 text-gray-600">
    {{ $success }}
</div>
@endif

@if ($error = Session::get('error'))
<div class="mt-6 bg-red-100 rounded-lg p-4 text-gray-600">
    {{ $error }}
</div>
@endif

@if ($otp_errors = Session::get('otp_errors'))
    <div class="mt-6 bg-red-100 rounded-lg p-4 text-gray-600">
        @foreach($otp_errors as $key => $error_row)

            @if (is_array($error_row))

                @foreach($error_row as $error_row_val)
                    <p>{{ $key }} - {{ $error_row_val }}</p>
                @endforeach

            @else
                <p>{{ $error_row }}</p>
            @endif

        @endforeach
    </div>
@endif