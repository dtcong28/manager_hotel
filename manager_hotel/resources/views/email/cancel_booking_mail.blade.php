<h2>Cancel Booking: DELUXE Hotel</h2><br>
DELUXE Hotel Hanoi<br>
Check in: {{ data_get($record, 'info')->time_check_in }} - Check out: {{ data_get($record, 'info')->time_check_out }}<br>
Phone number: 0967400419<br>
Address: Ha Noi<br>
<hr>
Dear<br>
<br>
Your booking has been canceled for some objective reason.<br>
@foreach(data_get($record, 'room') as $value)
    Room {{ data_get($value, 'room.name') }} has been canceled<br>
@endforeach
<br>
We are very sorry for this inconvenience.<br>
