<?php 
include 'conn/conn.php';
$db = new DatabaseHandler();

$rows = $db->getAllRowsFromTable('chatbot_responses');

// Prepare the response data
$keywords = [];
$responses = [];

foreach ($rows as $row) {
    $keywords[] = $row['keyword'];
    $responses[$row['keyword']] = $row['response'];
}



// $data = [
//     'keywords' => ['hello', 'how are you', 'bye', 'thanks', 'help'],
//     'responses' => [
//         'hello' => 'Hi there! How can I assist you today?',
//         'how are you' => 'I am just a bot, but I am doing great! How can I help you?',
//         'bye' => 'Goodbye! Have a great day!',
//         'thanks' => 'You’re welcome! If you have any more questions, feel free to ask.',
//         'help' => 'Sure! What do you need help with?'
//     ]
// ];
// Send the data as JSON
 header('Content-Type: application/json');
 echo json_encode([
     'keywords' => $keywords,
     'responses' => $responses
 ]);
?>
