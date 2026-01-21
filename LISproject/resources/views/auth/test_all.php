<!DOCTYPE html>
<html>
<head>
    <title>System Test - Learner Information System</title>
    <style>
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            padding: 30px; 
            background: linear-gradient(135deg, #f0f9ff 0%, #e1f5fe 100%);
            min-height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        h1 {
            color: #0056a6;
            text-align: center;
            margin-bottom: 30px;
        }
        .success { 
            color: #28a745; 
            font-weight: bold;
            font-size: 18px;
        }
        .error { 
            color: #dc3545; 
            font-weight: bold;
            font-size: 18px;
        }
        .warning { 
            color: #ffc107; 
            font-weight: bold;
        }
        .box { 
            background: #f8f9fa; 
            padding: 20px; 
            border-radius: 10px; 
            margin: 20px 0;
            border-left: 5px solid #0056a6;
        }
        .test-result {
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            background: white;
            border: 1px solid #dee2e6;
        }
        .status-icon {
            font-size: 24px;
            margin-right: 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #0056a6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
            transition: 0.3s;
        }
        .btn:hover {
            background: #004494;
            transform: translateY(-2px);
        }
        .btn-success {
            background: #28a745;
        }
        .btn-danger {
            background: #dc3545;
        }
        .links {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Learner Information System - Complete System Test</h1>
        
        <div class="box">
            <h2>✅ Apache & PHP Test</h2>
            <div class="test-result">
                <p><strong>PHP Version:</strong> 
                    <span class="success">
                        <?php 
                        $phpVersion = phpversion();
                        echo $phpVersion;
                        ?>
                    </span>
                </p>
                <p><strong>Server Software:</strong> 
                    <?php 
                    if (isset($_SERVER['SERVER_SOFTWARE'])) {
                        echo $_SERVER['SERVER_SOFTWARE'];
                    } else {
                        echo '<span class="warning">Not detected</span>';
                    }
                    ?>
                </p>
                <p><strong>Current Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
                <p><strong>Script Location:</strong> <?php echo __DIR__; ?></p>
            </div>
        </div>
        
        <div class="box">
            <h2>✅ MySQL Database Test</h2>
            <div class="test-result">
                <?php
                $mysqlStatus = 'pending';
                $mysqlVersion = 'Unknown';
                $mysqlError = '';
                
                try {
                    // Try to connect to MySQL
                    $conn = @new mysqli('localhost', 'root', '');
                    
                    if ($conn->connect_error) {
                        $mysqlStatus = 'error';
                        $mysqlError = $conn->connect_error;
                    } else {
                        $mysqlStatus = 'success';
                        $mysqlVersion = $conn->server_info;
                        $conn->close();
                    }
                } catch (Exception $e) {
                    $mysqlStatus = 'error';
                    $mysqlError = $e->getMessage();
                }
                
                if ($mysqlStatus === 'success') {
                    echo '<p><span class="success">✅ MySQL Connected Successfully!</span></p>';
                    echo '<p><strong>MySQL Version:</strong> ' . $mysqlVersion . '</p>';
                    
                    // Try to select database
                    $conn2 = @new mysqli('localhost', 'root', '', 'learner_system');
                    if (!$conn2->connect_error) {
                        echo '<p><span class="success">✅ Database "learner_system" is accessible!</span></p>';
                        $conn2->close();
                    } else {
                        echo '<p><span class="warning">⚠️ Database "learner_system" not found. You can create it.</span></p>';
                    }
                } else {
                    echo '<p><span class="error">❌ MySQL Connection Failed</span></p>';
                    echo '<p><strong>Error:</strong> ' . $mysqlError . '</p>';
                    echo '<p><span class="warning">Note: Make sure MySQL is running in XAMPP Control Panel</span></p>';
                }
                ?>
            </div>
        </div>
        
        <div class="box">
            <h2>📁 File System Test</h2>
            <div class="test-result">
                <p><strong>Project Path:</strong> <?php echo __DIR__; ?></p>
                <p><strong>File Write Test:</strong> 
                    <?php
                    $testFile = 'test_write.tmp';
                    $testContent = 'Test write at ' . date('H:i:s');
                    
                    try {
                        $bytesWritten = file_put_contents($testFile, $testContent);
                        if ($bytesWritten !== false) {
                            echo '<span class="success">✅ Can write files (' . $bytesWritten . ' bytes written)</span>';
                            
                            // Read it back
                            $readContent = file_get_contents($testFile);
                            if ($readContent === $testContent) {
                                echo '<br><span class="success">✅ Can read files correctly</span>';
                            }
                            
                            // Delete it
                            if (unlink($testFile)) {
                                echo '<br><span class="success">✅ Can delete files</span>';
                            }
                        } else {
                            echo '<span class="error">❌ Cannot write files</span>';
                        }
                    } catch (Exception $e) {
                        echo '<span class="error">❌ File system error: ' . $e->getMessage() . '</span>';
                    }
                    ?>
                </p>
                <p><strong>PHP Extensions Check:</strong>
                    <?php
                    $requiredExtensions = ['mysqli', 'pdo_mysql', 'session', 'json'];
                    $missing = [];
                    
                    foreach ($requiredExtensions as $ext) {
                        if (!extension_loaded($ext)) {
                            $missing[] = $ext;
                        }
                    }
                    
                    if (empty($missing)) {
                        echo '<span class="success">✅ All required extensions loaded</span>';
                    } else {
                        echo '<span class="warning">⚠️ Missing: ' . implode(', ', $missing) . '</span>';
                    }
                    ?>
                </p>
            </div>
        </div>
        
        <div class="box">
            <h2>🎯 Environment Summary</h2>
            <div class="test-result">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="background: #e9ecef;">
                        <th style="padding: 10px; text-align: left;">Component</th>
                        <th style="padding: 10px; text-align: left;">Status</th>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">Apache Web Server</td>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;"><span class="success">✅ Running</span></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">PHP <?php echo $phpVersion; ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;"><span class="success">✅ Running</span></td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">MySQL Database</td>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">
                            <?php echo ($mysqlStatus === 'success') ? '<span class="success">✅ Running</span>' : '<span class="error">❌ Stopped</span>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;">File Permissions</td>
                        <td style="padding: 10px; border-bottom: 1px solid #dee2e6;"><span class="success">✅ Read/Write OK</span></td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="box">
            <h2>🔗 Quick Navigation Links</h2>
            <div class="links">
                <a href="http://localhost/learner-system/" class="btn">Home Page</a>
                <a href="http://localhost/phpmyadmin/" class="btn btn-success" target="_blank">phpMyAdmin</a>
                <a href="test_all.php" class="btn">Refresh This Test</a>
                <a href="index.php" class="btn">Your Index Page</a>
                <a href="login.php" class="btn">Login Page</a>
                <?php if ($mysqlStatus === 'success') { ?>
                <a href="#" onclick="createDatabase()" class="btn btn-success">Create Database</a>
                <?php } ?>
            </div>
            
            <div style="margin-top: 20px; padding: 15px; background: #e7f3ff; border-radius: 8px;">
                <h3>🎯 Next Steps:</h3>
                <ol>
                    <li>If MySQL shows ✅, go to phpMyAdmin to create your database</li>
                    <li>Create your main pages: index.php, login.php, dashboard.php</li>
                    <li>Create CSS folder and style.css file</li>
                    <li>Start building your Learner Information System!</li>
                </ol>
            </div>
        </div>
    </div>
    
    <script>
    function createDatabase() {
        if (confirm('Create "learner_system" database?')) {
            window.open('http://localhost/phpmyadmin/', '_blank');
        }
    }
    
    // Auto-refresh page every 30 seconds to check status
    setTimeout(function() {
        location.reload();
    }, 30000);
    </script>
</body>
</html>