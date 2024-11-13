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
        
        .email-container {
            position: relative;
            margin-bottom: 1rem;
        }
        
        .email-input {
            width: 100%;
            padding: 0.5rem;
            padding-right: 40px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .send-button {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            padding: 5px;
            font-size: 1.2rem;
        }
        
        .send-button:hover {
            color: #333;
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

        /* Arrow styling */
        .arrow {
            border: solid #666;
            border-width: 0 2px 2px 0;
            display: inline-block;
            padding: 3px;
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            margin-top: -2px;
        }

        .send-button:hover .arrow {
            border-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Admin Lock Screen</h1>
        
        <div class="profile-section">
            <img src="/api/placeholder/80/80" alt="Admin Profile" class="profile-img">
            <div class="admin-name">HITSUGAYA TOSHI</div>
            <div class="email-container">
                <input type="email" placeholder="Enter your email" class="email-input">
                <button class="send-button" title="Send verification">
                    <i class="arrow"></i>
                </button>
            </div>
        </div>
        
        <div class="captcha-container">
            <label>
                <input type="checkbox"> I'm not a robot
            </label>
        </div>
        
        <div class="verification-failed">CAPTCHA verification failed.</div>
        
        <div class="footer">
            <p>Copyright © 2024 Admin Portal</p>
            <p>All rights reserved</p>
        </div>
    </div>
</body>
</html>