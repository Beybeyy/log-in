<?php
session_start();

// Set session timeout in seconds (example: 10 minutes = 600s)
$inactive = 600; 

if (!isset($_SESSION['email'])) {
    // User not logged in
    header("Location: login.blade.php?message=not_logged_in");
    exit();
}

// Check if session started and last activity is set
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $inactive)) {
    // Last request was more than $inactive ago
    session_unset();     // Unset session variables
    session_destroy();   // Destroy session
    header("Location: login.blade.php?message=session_expired");
    exit();
}

// Update last activity time stamp
$_SESSION['LAST_ACTIVITY'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Module | LIS</title>
    <style>
        :root {
            --deped-blue: #0b3c78;
            --deped-red: #e31a31;
            --tab-gray: #d1d1d1;
        }

        body { margin: 0; font-family: "Times New Roman", serif; background-color: #fff; }

        /* NAVBAR & BURGER */
        .top-nav {
            background-color: var(--deped-blue);
            color: white;
            padding: 10px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-links { display: flex; align-items: center; gap: 30px; }
        .nav-links a { color: white; text-decoration: none; }
        .burger-menu { cursor: pointer; font-size: 24px; position: relative; }
        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 35px;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 100;
            min-width: 150px;
            border-radius: 4px;
        }
        .dropdown-content a { color: black; padding: 12px 16px; display: block; border-bottom: 1px solid #eee; font-size: 14px; }
        .dropdown-content a:hover { background-color: #f1f1f1; }

        /* PROFILE */
        .header-profile { padding: 20px 60px; display: flex; align-items: center; gap: 20px; }
        .user-avatar { width: 60px; height: 60px; background: #555; border-radius: 50%; }
        .sy-btn { background: var(--deped-blue); color: white; padding: 2px 10px; border-radius: 4px; text-decoration: none; font-size: 13px; }

        /* TABS */
        .tabs { padding: 0 40px; display: flex; gap: 4px; }
        .tab { 
            padding: 10px 30px; 
            cursor: pointer; 
            border-radius: 8px 8px 0 0; 
            font-size: 18px;
            border: none;
            font-family: inherit;
        }
        .tab.active { background: var(--deped-blue); color: white; }
        .tab.inactive { background: var(--tab-gray); color: #333; }

        /* MAIN CONTAINER */
        .container { margin: 0 20px 40px; border: 3px solid var(--deped-blue); border-radius: 10px; min-height: 400px; }
        .blue-bar { 
            background: var(--deped-blue); 
            color: white; 
            padding: 12px 25px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }

        /* RIGHT ACTIONS (Dropdown + Buttons) */
        .action-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .quarter-select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-family: inherit;
            font-size: 13px;
            cursor: pointer;
        }

        /* TABLES */
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { background: #e0e0e0; border: 1px solid #ccc; padding: 8px; font-weight: normal; }
        td { border: 1px solid #eee; padding: 8px; text-align: center; }
        .bg-alt { background: #f9f9f9; }

        .subjects,
        .scores {
             display: flex;
            justify-content: space-between;
            gap: 18px;            /* controls spacing */
            font-size: 12px;
        }

        .subjects span,
        .scores span {
            min-width: 35px;      /* keeps columns aligned */
            text-align: center;
        }

        /* BUTTONS */
        .red-btn { background: var(--deped-red); color: white; border: none; padding: 8px 20px; border-radius: 6px; cursor: pointer; }
        .gen-copy { color: white; text-decoration: underline; font-size: 14px; }

        /* MODULE DISPLAY */
        .module-section { display: none; }
        .module-section.active-section { display: block; }

                .logout-btn {
            padding: 10px 20px;
            background-color: #d9534f;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .logout-btn:hover {
            background-color: #c9302c;
        }

        /* Modal overlay */
        .modal {
            display: none; /* hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        /* Modal content box */
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px 30px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            font-family: Arial, sans-serif;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        /* Buttons inside modal */
        .modal-buttons button {
            padding: 8px 16px;
            margin: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        #confirmLogout {
            background-color: #d9534f;
            color: #fff;
        }
        #confirmLogout:hover {
            background-color: #c9302c;
        }

        #cancelLogout {
            background-color: #6c757d;
            color: #fff;
        }
        #cancelLogout:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

    <div class="top-nav">
        <div>Department of Education<br><small>Learning Information System</small></div>
        <div class="nav-links">
            

            <div class="burger-menu" onclick="toggleBurger()">
                ☰
                <div id="burgerDropdown" class="dropdown-content">
                    <a href="#">Dashboard</a>
                    <a href="#">Profile</a>
                    <a href="#">About</a>
                    <a href="#">Settings</a>
                    <<button id="logoutBtn" class="logout-btn">Logout</button>
                    
                    
                </div>
            </div>
        </div>
    </div>
            <!-- Confirmation Modal -->
        <div id="logoutModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to log out?</p>
            <div class="modal-buttons">
            <button id="confirmLogout">Yes</button>
            <button id="cancelLogout">No</button>
            </div>
        </div>
        </div>

    <div class="header-profile">
        <div class="user-avatar"></div>
        <div>
            <h2 style="margin:0">Hi, Mr. Juan Dela Cruz</h2>
            <p style="margin:5px 0">SY: Current Year 2025-2026 <a href="#" class="sy-btn">View Previous Year</a></p>
            <small>Teacher Dashboard</small>
        </div>
    </div>

    <div class="tabs">
        <button id="tab-advisory" class="tab active" onclick="switchTab('advisory')">Advisory</button>
        <button id="tab-subject" class="tab inactive" onclick="switchTab('subject')">Subject Handed</button>
    </div>

    <div class="container">
        
        <div id="section-advisory" class="module-section active-section">
            <div class="blue-bar">
                <span>Section : Name &nbsp;&nbsp; Grade Level : 7</span>
                <div class="action-group">
                    <select class="quarter-select">
                        <option>1st Quarter</option>
                        <option>2nd Quarter</option>
                        <option>3rd Quarter</option>
                        <option>4th Quarter</option>
                    </select>
                    <a href="#" class="gen-copy">Generate Copy</a>
                    <button class="red-btn">Edit Student</button>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Name</th>
                        <th rowspan="2">Section</th>
                        <th rowspan="2">Gender</th>
                        <th>Subject Enrolled</th>
                        <th rowspan="2">Remarks</th>
                        <th rowspan="2">Status</th>
                    </tr>
                    <th>
                        <div class="subjects">
                            <span>Math</span>
                            <span>Eng</span>
                            <span>Fil</span>
                            <span>Sci</span>
                            <span>AP</span>
                            <span>MAPEH</span>
                            <span>ESP</span>
                            <span>Ave</span>
                        </div>
                    </th>
                </thead>
                <tbody>
                    <tr>
                        <td>0101</td>
                        <td style="text-align:left">Domingo, Le Bron Franco</td>
                        <td>Papaya</td>
                        <td>Male</td>
                <td>
                    <div class="scores">
                        <span>90</span>
                        <span>90</span>
                        <span>90</span>
                        <span>90</span>
                        <span>90</span>
                        <span>90</span>
                        <span>90</span>
                        <span>90</span>
                    </div>
                </td>
                        
                        <td></td>
                        <td><span style="background:#bfffb1; padding:2px 5px">Active</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="section-subject" class="module-section">
            <div class="blue-bar">
                <div style="display:flex; gap:10px; align-items:center;">
                    Subject & Section : 
                    <select class="quarter-select" style="background:white; color:black;">
                        <option>Grade 1</option>
                        <option>Grade 2</option>
                        <option>Grade 3</option>
                        <option>Grade 4</option>
                        <option>Grade 5</option>
                        <option>Grade 6</option>
                        <option>Grade 7</option>
                        <option>Grade 8</option>
                        <option>Grade 9</option>
                        <option>Grade 10</option>

                    </select>
                    <select class="quarter-select" style="background:white; color:black;">
                        <option>Talong</option>
                        <option>Kamatis</option>
                        <option>Sitaw</option>
                        <option>Patola</option>
                        <option>Mustasa</option>

                </select>
                </div>
                <h3 style="margin:0">Pending Grades</h3>
                <div class="action-group">
                    <select class="quarter-select">
                        <option>1st Quarter</option>
                        <option>2nd Quarter</option>
                        <option>3rd Quarter</option>
                        <option>4th Quarter</option>
                    </select>
                    <a href="#" class="gen-copy">Generate Copy</a>
                    <button class="red-btn">Encode Grade</button>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Section</th>
                        <th>Gender</th>
                        <th>1st Q</th>
                        <th>2nd Q</th>
                        <th>3rd Q</th>
                        <th>4th Q</th>
                        <th>Ave</th>
                        <th>Remarks</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-alt">
                        <td>0101</td>
                        <td style="text-align:left">Domingo, Le Bron Franco</td>
                        <td>Papaya</td>
                        <td>Male</td>
                        <td>90</td>
                        <td>90</td>
                        <td>90</td>
                        <td>67.5</td>
                        <td>45</td>
                        <td></td>
                        <td>Enrolled</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function switchTab(type) {
            document.getElementById('tab-advisory').className = (type === 'advisory') ? 'tab active' : 'tab inactive';
            document.getElementById('tab-subject').className = (type === 'subject') ? 'tab active' : 'tab inactive';
            document.getElementById('section-advisory').className = (type === 'advisory') ? 'module-section active-section' : 'module-section';
            document.getElementById('section-subject').className = (type === 'subject') ? 'module-section active-section' : 'module-section';
        }

        function toggleBurger() {
            var menu = document.getElementById("burgerDropdown");
            menu.style.display = (menu.style.display === "block") ? "none" : "block";
        }

        window.onclick = function(event) {
            if (!event.target.matches('.burger-menu')) {
                document.getElementById("burgerDropdown").style.display = "none";
            }
        }
        
            // Get elements
    var logoutBtn = document.getElementById("logoutBtn");
    var modal = document.getElementById("logoutModal");
    var confirmBtn = document.getElementById("confirmLogout");
    var cancelBtn = document.getElementById("cancelLogout");

    // Show modal on logout button click
    logoutBtn.onclick = function() {
        modal.style.display = "block";
    }

    // Cancel logout
    cancelBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Confirm logout
    confirmBtn.onclick = function() {
        window.location.href = "logout.php"; // redirect to logout
    }

    // Close modal if click outside content
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
}
 
    // Auto logout after 10 seconds of inactivity
    // let inactivityTime = 10000; // 10,000ms = 10 seconds
    // let inactivityTimer;

    function resetTimer() {
        clearTimeout(inactivityTimer);
        inactivityTimer = setTimeout(logout, inactivityTime);
    }

    function logout() {
        // Redirect to logout.php, which destroys session and goes to login.blade.php
        window.location.href = "logout.php";
    }

    // Reset timer on user actions
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onclick = resetTimer;
    document.onscroll = resetTimer;
    

    </script>
</body>
</html>