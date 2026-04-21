<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json; charset=UTF-8");

require_once '../connection/db.php';

try {

    // ================= GET INPUT =================
    $uid = $_SESSION['uid'] ?? ($_POST['uid'] ?? null);
    $designation = $_SESSION['designation'] ?? ($_POST['designation'] ?? null);

    // ================= BASE QUERY =================
    $sql = "
        SELECT 
            f.*,
            owner.username AS form_username,
            forwardUser.username AS forward_username

        FROM forms f

        LEFT JOIN users owner 
            ON owner.uid = f.uid::INTEGER

        LEFT JOIN users forwardUser 
            ON forwardUser.uid = f.forward_to::INTEGER

        WHERE 1=1
    ";

    $params = [];

    // ================= ROLE-BASED FILTER =================
    if ($designation === 'SO') {
        // SO → all data
        $sql .= " AND f.reference_no IS NOT NULL AND TRIM(f.reference_no) <> ''";
    } elseif ($designation === 'DDG') {
        // DDG → only forwarded to them
        $sql .= " AND f.reference_no IS NOT NULL AND TRIM(f.reference_no) <> ''";
        $sql .= " AND f.forward_to = :forward_to";
        $params[':forward_to'] = $uid;
    } else {
        // Normal user → own forms
        $sql .= " AND f.uid = :uid";
        $params[':uid'] = $uid;
    }

    // ================= ORDER =================
    $sql .= " ORDER BY f.id DESC";

    // ================= EXECUTE =================
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ================= FORMAT RESPONSE =================
    $data = [];

    foreach ($rows as $row) {
        $data[] = [
            "id" => (int)$row['id'],
            "reference_no" => $row['reference_no'],
            "form_type" => $row["form_type"],
            "purpose" => $row['purpose'],
            "acquired_disposed" => $row['acquired_disposed'],
            "date_acquisition_disposed" => $row['date_acquisition_disposed'],
            "mode_acquisition" => $row['mode_acquisition'],
            "mode_disposal" => $row['mode_disposal'],
            "status" => $row['status'],
            "current_phase" => $row['current_phase'],
            "remarks" => $row['remarks'],

            "user" => [
                "uid" => $row['uid'],
                "username" => $row['form_username']
            ],

            "forward_to" => [
                "uid" => $row['forward_to'],
                "username" => $row['forward_username']
            ],

            "created_at" => $row['created_at']
        ];
    }

    // ================= FINAL RESPONSE =================
    echo json_encode([
        "success" => true,
        "count"   => count($data),
        "data"    => $data
    ], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "error"   => $e->getMessage()
    ]);
}
