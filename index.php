<?php
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Tugas</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container my-5">
    <div class="bg-white rounded-4 shadow-sm p-4 p-md-5 mx-auto" style="max-width: 1140px; min-height: 600px;">
        <h2 class="page-title">Daftar Tugas</h2>

        <div class="d-flex justify-content-center gap-3 mb-4 flex-wrap">
            <form method="POST" action="">
                <button type="submit" class="btn btn-danger action-button" name="logout">Keluar</button>
            </form>
            <button class="btn btn-success action-button" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                Tambah Tugas
            </button>
            <a href="task_history.php" class="btn btn-secondary action-button">
                Riwayat Tugas
            </a>
        </div>

        <hr class="my-3">

        <ul id="taskList" class="list-group list-group-flush"></ul>
    </div>
    </div>

    <div class="modal fade" id="addTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Tugas Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="taskInput" class="form-control mb-2" placeholder="Masukkan nama tugas..." required>
                    <input type="date" id="dueDateInput" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="addTaskBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="editTaskInput" class="form-control mb-2" placeholder="Masukkan nama tugas..." required>
                    <input type="date" id="editDueDateInput" class="form-control">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="saveEditTask">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function loadTasks() {
                $.ajax({
                    url: "fetch_tasks.php",
                    type: "GET",
                    success: function (data) {
                        $("#taskList").html(data);
                    }
                });
            }

            loadTasks();

            $("#addTaskBtn").click(function () {
                var task = $("#taskInput").val();
                var due_date = $("#dueDateInput").val();
                if (task && due_date) {
                    $.post("add_task.php", { task: task, due_date: due_date }, function () {
                        $("#taskInput").val("");
                        $("#dueDateInput").val("");
                        $("#addTaskModal").modal("hide");
                        loadTasks();
                    });
                }
            });

            $(document).on("click", ".edit-task", function () {
                $("#editTaskId").val($(this).data("id"));
                $("#editTaskInput").val($(this).data("task"));
                $("#editDueDateInput").val($(this).data("due"));
                $("#editTaskModal").modal("show");
            });

            $("#saveEditTask").click(function () {
                var id = $("#editTaskId").val();
                var task = $("#editTaskInput").val();
                var due_date = $("#editDueDateInput").val();
                $.post("update_task.php", { id: id, task: task, due_date: due_date }, function () {
                    $("#editTaskModal").modal("hide");
                    loadTasks();
                });
            });

            $(document).on("click", ".progress-task", function () {
                var id = $(this).data("id");
                $.get("progress_task.php?id=" + id, function () {
                    loadTasks();
                });
            });

            $(document).on("click", ".complete-task", function () {
                var id = $(this).data("id");
                $.get("complete_task.php?id=" + id, function () {
                    loadTasks();
                });
            });

            $(document).on("click", ".delete-task", function () {
                var id = $(this).data("id");
                $.get("delete_task.php?id=" + id, function () {
                    loadTasks();
                });
            });
        });
    </script>
</body>
</html>
