<?php



function calculateNextDueDate($lastUpdatedDate, $currentDate, $schedule) {
    
    $nextDueDate = new DateTime($lastUpdatedDate); 
    // Update the next due date based on the schedule
    switch ($schedule) {
        case 'Daily':
            $nextDueDate->modify('+1 day');
            break;
        case 'Weekly':
            $nextDueDate->modify('+1 week');
            break;
        case 'Monthly':
            $nextDueDate->modify('+1 month');
            break;
        case 'Yearly':
            $nextDueDate->modify('+1 year');
            break;
        default:
            echo 'Invalid schedule provided';
            return null;
    }

    // If the next due date is still less than the current date, keep adding the schedule interval
    while ($nextDueDate <= $currentDate) {
        switch ($schedule) {
            case 'Daily':
                $nextDueDate->modify('+1 day');
                break;
            case 'Weekly':
                $nextDueDate->modify('+1 week');
                break;
            case 'Monthly':
                $nextDueDate->modify('+1 month');
                break;
            case 'Yearly':
                $nextDueDate->modify('+1 year');
                break;
        }
    }

    return $nextDueDate->format('Y-m-d');
}

?>