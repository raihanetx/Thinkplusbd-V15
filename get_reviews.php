<?php
header('Content-Type: application/json');

$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

if ($product_id) {
    $reviews_file = __DIR__ . '/reviews.json';
    $reviews = [];

    if (file_exists($reviews_file)) {
        $all_reviews = json_decode(file_get_contents($reviews_file), true);
        foreach ($all_reviews as $review) {
            if ($review['product_id'] == $product_id && $review['status'] == 'approved') {
                $reviews[] = $review;
            }
        }
    }
    echo json_encode($reviews);
} else {
    echo json_encode([]);
}
?>
