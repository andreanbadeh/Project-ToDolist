<?php include 'database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Riwayat Tugas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-primary">RIWAYAT TUGAS</h2>
        <a href="index.php" class="btn btn-secondary mb-3">⬅ Kembali ke Daftar Tugas</a>

        <ul class="list-group">
            <?php
            $result = $conn->query("SELECT * FROM task_history ORDER BY completed_at DESC");
            while ($row = $result->fetch_assoc()) {
                $badge = ($row["status"] == "completed") ? "bg-success" : "bg-danger";

                $statusText = "";
                switch ($row["status"]) {
                    case "completed":
                        $statusText = "Selesai";
                        break;
                    case "overdue":
                        $statusText = "Terlambat";
                        break;
                    default:
                        $statusText = ucfirst($row["status"]); // fallback
                        break;
                }

                echo '<li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            '.$row["task"].' <small class="text-muted">(Batas waktu: '.$row["due_date"].')</small>
                        </div>
                        <span class="badge '.$badge.'">'.$statusText.'</span>
                    </li>';
            }
            ?>
        </ul>
    </div>
</body>
</html>
