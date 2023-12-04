<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kanban Todo Lista</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="test.css"> <!-- Új CSS fájl hivatkozása -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script>
    <!-- Font Awesome CSS hozzáadása -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
</head>

<body>
    <?php include '../../header/header.php'  ?>
    <!-- nav sáv behívása -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">Projekt Választó</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <input type="text" class="form-control" placeholder="Új projekt neve">
                            <button class="btn btn-primary btn-sm mt-2">Létrehozás</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="kanban-board">
                    <!DOCTYPE html>
                    <html lang="en">

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a class="navbar-brand" href="#">Kanban Todo Lista</a>
                        <!-- Bejelentkezett felhasználó neve, kilépés gomb, stb. -->
                    </nav>
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered kanban-table">
                                    <thead>
                                        <tr>
                                            <th class=" backlog">Backlog</th>
                                            <th class=" ongoing">Ongoing</th>
                                            <th class=" done">Done</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td id="backlog-row" class="kanban-column backlog">
                                            </td>
                                            <td id="ongoing-row" class="kanban-column ongoing">
                                            </td>
                                            <td id="done-row" class="kanban-column done">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    
                </body>
                
                </html>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
                    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
                    crossorigin="anonymous"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
                    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
                    crossorigin="anonymous"></script>
                <script src="test1.js"></script>
