<?php

// Define the path to your CodeIgniter's writable/logs directory
$logPath = __DIR__ . '/../writable/logs/webhook_raw-' . date('Y-m-d') . '.log';

// --- Capture Everything ---
$headers = getallheaders();
$body = file_get_contents('php://input');
$timestamp = date('Y-m-d H:i:s');

// --- Log Everything to a Separate File for Debugging ---
$log_entry = "--- Webhook Received at {$timestamp} ---\n";
$log_entry .= "Headers: " . json_encode($headers, JSON_PRETTY_PRINT) . "\n";
$log_entry .= "Raw Body: " . $body . "\n";
$log_entry .= "-----------------------------------------\n\n";

file_put_contents($logPath, $log_entry, FILE_APPEND);

// Respond to Doku immediately so it doesn't time out
http_response_code(200);
echo json_encode(['status' => 'SUCCESS']);
exit;
