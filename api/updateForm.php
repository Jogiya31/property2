<?php
session_start();
include '../connection/db.php';

header("Content-Type: application/json");

/* ================= INPUT ================= */
$uid        = $_POST['uid'] ?? ($_SESSION['uid'] ?? null);
$id         = $_POST['id'] ?? null;
$action     = $_POST['action'] ?? null; // forward | revert
$remarks    = $_POST['remarks'] ?? null;
$correctOM = isset($_POST['correctOM']) ? (int)$_POST['correctOM'] : 0;
$forward_To = $_POST['employee'] ?? null;

/* ================= VALIDATION ================= */

if (!$uid) {
    echo json_encode(["success" => false, "error" => "User not logged in"]);
    exit;
}

if (!$id) {
    echo json_encode(["success" => false, "error" => "Invalid Form ID"]);
    exit;
}

$conn->beginTransaction();

try {

    /* ================= GET CURRENT DATA ================= */
    $stmtCheck = $conn->prepare("
        SELECT status, current_phase
        FROM forms
        WHERE id = :id
        LIMIT 1
    ");
    $stmtCheck->execute([':id' => $id]);
    $form = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if (!$form) {
        throw new Exception("Form not found");
    }

    $newStatus = $form['status'];
    $newPhase  = $form['current_phase'];

    /* ================= ACTION LOGIC ================= */

    if ($action === "forward") {

        if (!$forward_To) {
            throw new Exception("Please select employee to forward");
        }

        $newStatus = "Forwarded";

    } elseif ($action === "revert") {

        $newStatus = "Rejected";

        // OPTIONAL: you can store previous phase if needed
        $newPhase = null;

    } else {
        throw new Exception("Invalid action");
    }

    /* ================= UPDATE FORM ================= */

    $stmt = $conn->prepare("
        UPDATE forms SET
            status = :status,
            current_phase = :current_phase,
            remarks = :remarks,
            forward_to = :forward_to,
            correctom  = :correctOM,
            updated_by = :uid,
            updated_at = NOW()
        WHERE id = :id
    ");

    $stmt->bindValue(':status', $newStatus);
    $stmt->bindValue(':current_phase', $newPhase);
    $stmt->bindValue(':remarks', $remarks);
    $stmt->bindValue(':forward_to', $forward_To);
    $stmt->bindValue(':correctOM', $correctOM, PDO::PARAM_INT);
    $stmt->bindValue(':uid', $uid, PDO::PARAM_INT);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    $stmt->execute();

    $conn->commit();

    echo json_encode([
        "success" => true,
        "message" => "Form " . strtolower($newStatus) . " successfully",
        "data" => [
            "status" => $newStatus,
            "current_phase" => $newPhase
        ]
    ]);

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}