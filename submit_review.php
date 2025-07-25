<?php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['product_id'], $input['reviewer_name'], $input['rating'], $input['review_text'])) {
    $reviews_file = __DIR__ . '/reviews.json';
    $reviews = [];

    if (file_exists($reviews_file)) {
        $reviews = json_decode(file_get_contents($reviews_file), true);
    }

    $new_review = [
        'id' => uniqid(),
        'product_id' => $input['product_id'],
        'reviewer_name' => htmlspecialchars($input['reviewer_name']),
        'rating' => intval($input['rating']),
        'review_text' => htmlspecialchars($input['review_text']),
        'status' => 'pending',
        'created_at' => date('Y-m-d H:i:s')
    ];

    $reviews[] = $new_review;

    if (file_put_contents($reviews_file, json_encode($reviews, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'message' => 'Review submitted successfully. It will be visible after approval.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save review.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
}
?>
