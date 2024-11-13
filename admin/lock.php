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
            opacity: 0.5;
            pointer-events: none;
        }
        
        .send-button.active {
            opacity: 1;
            pointer-events: auto;
        }
        
        .send-button.active:hover {
            color: #333;
        }
        
        .captcha-container {
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            padding: 1rem;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f9f9f9;
        }
        
        .captcha-container.verified {
            background-color: #e8f5e9;
            border-color: #a5d6a7;
        }
        
        .captcha-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .checkmark {
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .checkmark.checked {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        
        .checkmark.checked::after {
            content: "✓";
            color: white;
            font-size: 14px;
        }
        
        .recaptcha-logo {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #555;
            font-size: 0.8rem;
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
            display: none;
        }
        
        .verification-failed.show {
            display: block;
        }

        .arrow {
            border: solid #666;
            border-width: 0 2px 2px 0;
            display: inline-block;
            padding: 3px;
            transform: rotate(-45deg);
            -webkit-transform: rotate(-45deg);
            margin-top: -2px;
        }

        .send-button.active:hover .arrow {
            border-color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Admin verification</h1>
        
        <div class="profile-section">
            <img src="/api/placeholder/80/80" alt="Admin Profile" class="profile-img">
            <div class="admin-name">Ayres Santillan Ilustrisimo</div>
            <div class="email-container">
                <input type="email" placeholder="Enter your email" class="email-input">
                <button class="send-button" title="Send verification" id="sendButton">
                    <i class="arrow"></i>
                </button>
            </div>
        </div>
        
        <div class="captcha-container" id="captchaContainer">
            <div class="captcha-left">
                <div class="checkmark" id="captchaCheckmark"></div>
                <span>I'm not a robot</span>
            </div>
            <div class="recaptcha-logo">
                <img src="/api/placeholder/20/20" alt="reCAPTCHA logo">
            </div>
        </div>
        
        <div class="verification-failed" id="verificationMessage">CAPTCHA verification failed.</div>
        
        <div class="footer">
            <p>Copyright © 2024</p>
            <p>All rights reserved</p>
        </div>
    </div>

    <script>
        const captchaCheckmark = document.getElementById('captchaCheckmark');
        const captchaContainer = document.getElementById('captchaContainer');
        const sendButton = document.getElementById('sendButton');
        const verificationMessage = document.getElementById('verificationMessage');
        
        captchaCheckmark.addEventListener('click', function() {
            // Simulate CAPTCHA verification
            setTimeout(() => {
                this.classList.add('checked');
                captchaContainer.classList.add('verified');
                sendButton.classList.add('active');
                verificationMessage.classList.remove('show');
            }, 1000);
        });
        
        sendButton.addEventListener('click', function() {
            if (this.classList.contains('active')) {
                // Handle email verification code sending
                console.log('Sending verification code...');
            }
        });
    </script>
</body>
</html>