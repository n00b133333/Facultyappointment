<div class="d-flex p-fixed flex-column flex-shrink-0 p-3 bg-dark text-light shadow-lg d-none d-lg-flex" style="width: 280px; height:100vh; z-index:10;" id="sidebar">
    <a href="/" class="d-flex text-center align-items-center mb-3 mb-md-0 me-md-auto link-light text-decoration-none">
    <div class="dropdown text-center">
        <a href="#" class="w-full align-items-center link-light text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../uploads/<?php echo userinfo($conn,$_SESSION['admin_ID'])->profile ?>" alt="" width="80" height="80" class="rounded-circle me-2"><br>
            <strong  style=" font-size:25px; "><?php echo userinfo($conn,$_SESSION['admin_ID'])->username ?></strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
        
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="dashboard.php" class="nav-link link-light <?php if ($page == 'Dashboard'){echo 'active text-light';} ?>">
            <svg class="w-6 h-6 text-gray-800 light:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6.025A7.5 7.5 0 1 0 17.975 14H10V6.025Z"/>
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 3c-.169 0-.334.014-.5.025V11h7.975c.011-.166.025-.331.025-.5A7.5 7.5 0 0 0 13.5 3Z"/>
</svg>

                Dashboard
            </a>
        </li>
        <li>
            <a href="faculty.php" class="nav-link link-light <?php if ($page == 'Faculty'){echo 'active text-light';} ?>">
            <svg class="w-6 h-6 text-gray-800 light:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Zm7 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
</svg>

                Faculty
            </a>
        </li>
        <li>
            <a href="users.php" class="nav-link link-light <?php if ($page == 'Users'){echo 'active text-light';} ?>">
            <svg class="w-6 h-6 text-gray-800 light:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
</svg>

                Users
            </a>
        </li>


        <!-- <li>
            <a href="admins.php" class="nav-link link-light <?php if ($page == 'Admins'){echo 'active text-light';} ?>">
            <svg class="w-6 h-6 text-gray-800 light:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
</svg>


                Admins
            </a>
        </li> -->
        <li>
            <a href="schedules.php" class="nav-link link-light <?php if ($page == 'Schedules'){echo 'active text-light';} ?>">
            <svg class="w-6 h-6 text-gray-800 light:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z"/>
</svg>

                Schedules
            </a>
        </li>
        <li>
            <a href="logs.php" class="nav-link link-light <?php if ($page == 'Logs'){echo 'active text-light';} ?>">
            <svg class="w-6 h-6 text-gray-800 light:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M9 8h10M9 12h10M9 16h10M4.99 8H5m-.02 4h.01m0 4H5"/>
</svg>

                Logs
            </a>
        </li>

        <li>
            <a href="archives.php" class="nav-link link-light <?php if ($page == 'Archives'){echo 'active text-light';} ?>">
            <svg class="w-6 h-6 text-gray-800 light:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M10 12v1h4v-1m4 7H6a1 1 0 0 1-1-1V9h14v9a1 1 0 0 1-1 1ZM4 5h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z"/>
</svg>


                Archives
            </a>
        </li>

        <li>
            <a href="profile.php" class="nav-link link-light <?php if ($page == 'Profile'){echo 'active text-light';} ?>">
            <svg class="w-6 h-6 text-gray-800 light:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
</svg>


                Profile
            </a>
        </li>
    
        <li>
            <a href="includes/logout.php" class="nav-link link-light <?php if ($page == ''){echo 'active text-light';} ?>">
            <svg class="w-6 h-6 text-gray-800 dark:text-white me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H8m12 0-4 4m4-4-4-4M9 4H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h2"/>
</svg>



                Logout
            </a>
        </li>
    </ul>
    <hr>
    <!-- <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-light text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../uploads/<?php echo userinfo($conn,$_SESSION['admin_ID'])->profile ?>" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>mdo</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
        
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div> -->
</div>

<!-- Bootstrap Navbar for mobile view -->
<nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none shadow-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4">

            <a class="nav-link fw-bold" href="#" >
                      
                       <?php echo $page; ?>
                    </a>

            </span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link " href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="faculty.php">Faculty</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="users.php">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="schedules.php">Schedules</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="logs.php">Logs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="archives.php">Archives</a>
                </li>
                <hr>
          
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../uploads/<?php echo userinfo($conn,$_SESSION['admin_ID'])->profile ?>" alt="" width="32" height="32" class="rounded-circle me-2">
                        <?php echo userinfo($conn,$_SESSION['admin_ID'])->username ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="main-content gap-3" >
