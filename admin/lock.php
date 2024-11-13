<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        
        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 320px;
        }
        
        .title {
            color: #333;
            margin-bottom: 2rem;
        }
        
        .profile-section {
            margin-bottom: 2rem;
        }
        
        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 1rem;
        }
        
        .admin-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }
        
        .email-input {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .captcha-container {
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            padding: 1rem;
            border-radius: 4px;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }
        
        .footer {
            color: #666;
            font-size: 0.8rem;
            margin-top: 2rem;
        }
        
        .verification-failed {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Admin Verification</h1>
        
        <div class="profile-section">
            <img src="/api/placeholder/80/80" alt="Admin Profile" class="profile-img">
            <div class="admin-name">Ayres Santillan Ilustrisimo</div>
            <input type="email" placeholder="Enter your email" class="email-input">
        </div>
        
        <div class="captcha-container">
            <label>
                <input type="checkbox"> I'm not a robot
            </label>
        </div>
        
        <div class="verification-failed">CAPTCHA verification failed.</div>
        
        <div class="footer">
            <p>Copyright © 2024</p>
            <p>All rights reserved</p>
        </div>
    </div>
</body>
</html>