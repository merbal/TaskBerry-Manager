<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/php/pages/index.php">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/php/pages/login/login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/php/pages/login/signup.php">Sign Up</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/php/pages/todo/todo.php">Todo</a>
            </li>
        </ul>
        
        <?php 
        if (isset($_SESSION['user_name']) or isset($_SESSION['user_id'])) {
            echo "<div class=user_datas>Hello ". $_SESSION['user_name']."</div>";
            echo "<div><a href='/php/pages/login/logout.php'>Logout</a></div>";
        }
        ?>
    </div>
</nav>
