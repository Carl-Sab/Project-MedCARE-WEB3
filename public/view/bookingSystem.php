<?php
require '../../includes/connection.php';

// Get doctor_id from URL
$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;
if ($doctor_id <= 0) {
    die("Invalid doctor ID.");
}

// Get the time range for the doctor (assuming only one record in time_slots defines range)
$sql = "SELECT start_time, End_time FROM time_slots WHERE id_doctor = $doctor_id LIMIT 1";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    die("No schedule found for this doctor.");
}

$row = $result->fetch_assoc();
$start_time = new DateTime($row['start_time']);
$end_time = new DateTime($row['End_time']);

// Fetch already booked slots
$booked_slots = [];
$booked_sql = "SELECT start_time FROM time_slots WHERE id_doctor = $doctor_id AND is_booked = 1";
$booked_result = $conn->query($booked_sql);
if ($booked_result && $booked_result->num_rows > 0) {
    while ($booked_row = $booked_result->fetch_assoc()) {
        $booked_slots[] = $booked_row['start_time'];
    }
}

// Generate all 1-hour slots
$slots = [];
$current = clone $start_time;
while ($current < $end_time) {
    $next = clone $current;
    $next->modify('+1 hour');
    if ($next > $end_time) break;

    $slots[] = [
        'start_time' => $current->format('Y-m-d H:i:s'),
        'end_time' => $next->format('Y-m-d H:i:s'),
        'is_booked' => in_array($current->format('Y-m-d H:i:s'), $booked_slots) ? 1 : 0
    ];

    $current = $next;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MedCare Booking</title>
    <link rel="stylesheet" href="../css/bookingSystem.css">
</head>
<body>
<div class="container">
    <a href="doctorSelect.php" class="btn back-btn">← Back</a>
    <h1>MedCare Booking</h1>
    <h2>All Slots</h2>
    <table>
        <tr>
            <th>#</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($slots as $index => $slot): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $slot['start_time']; ?></td>
                <td><?php echo $slot['end_time']; ?></td>
                <td id="status-<?php echo $index; ?>">
                    <?php echo ($slot['is_booked']) ? 'Unavailable' : 'Available'; ?>
                </td>
                <td>
                    <?php if (!$slot['is_booked']): ?>
                        <button id="book-btn-<?php echo $index; ?>" onclick="bookSlot('<?php echo $slot['start_time']; ?>', '<?php echo $slot['end_time']; ?>', <?php echo $doctor_id; ?>, <?php echo $index; ?>)">
                            Book
                        </button>
                    <?php else: ?>
                        <button disabled>Booked</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<script>
function bookSlot(startTime, endTime, doctorId, index) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'bookSlot.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;

            if (response.includes('Slot booked successfully')) {
                document.getElementById('status-' + index).textContent = 'Unavailable';
                var button = document.getElementById('book-btn-' + index);
                button.disabled = true;
                button.textContent = 'Booked';
            } else {
                alert(response);
            }
        }
    };

    xhr.send('start_time=' + encodeURIComponent(startTime) + '&end_time=' + encodeURIComponent(endTime) + '&doctor_id=' + doctorId);
}
</script>
</body>
</html>
