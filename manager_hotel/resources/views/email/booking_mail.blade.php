<h2>Confirmation of your reservation: DELUXE Homestay</h2><br>
DELUXE Homestay Hanoi<br>
Check in: {{ data_get($record, 'time_check_in') }} - Check out: {{ data_get($record, 'time_check_out') }}<br>
Phone number: 0967400419<br>
Address: Ha Noi<br>
<hr>
Dear<br>
<br>
Thank you for choosing DELUXE Homestay Hanoi for your next stay in HANOI.<br>
<br>
Please see below for details of your reservation.<br>
<br>
We hope you enjoy your stay!<br>
@foreach(data_get($record, 'room') as $value)
    Room {{ data_get($value, 'room_name') }}: {{number_format(data_get($value, 'price'), 0, '', ',')}} - Number people: {{ data_get($value, 'number_people') }}<br>
@endforeach
@if(!is_null(data_get($record, 'food')))
    @foreach(data_get($record, 'food') as $value)
        Food: {{ $value }}<br>
    @endforeach
@endif
