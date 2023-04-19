<h2>Confirmation of your reservation: DELUXE Hotel</h2><br>
DELUXE Hotel Hanoi<br>
Check in: {{ data_get($record, 'time_check_in') }} - Check out: {{ data_get($record, 'time_check_out') }}<br>
Phone number: 0967400419<br>
Address: Ha Noi<br>
<hr>
Dear<br>
<br>
Thank you for choosing DELUXE Hotel Hanoi for your next stay in HANOI.<br>
<br>
Please see below for details of your reservation.<br>
<br>
We hope you enjoy your stay!<br>
@foreach(data_get($record, 'room') as $value)
    Room {{ data_get($value, 'room_name') }}: {{number_format(data_get($value, 'price'), 0, '', ',')}} - Number people: {{ data_get($value, 'number_people') }}<br>
@endforeach
@foreach(data_get($record, 'food') as $value)
    Food: {{ $value }}<br>
@endforeach
