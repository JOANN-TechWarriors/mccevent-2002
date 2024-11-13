<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        
        .verification-code-container {
            display: none;
            margin-top: 1rem;
        }
        
        .verification-code-container.show {
            display: block;
        }
        
        .code-inputs {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin: 1rem 0;
        }
        
        .code-input {
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .code-input:focus {
            border-color: #4CAF50;
            outline: none;
        }
        
        .verify-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 0.5rem 2rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            margin-top: 1rem;
        }
        
        .verify-button:hover {
            background-color: #45a049;
        }
        
        .recaptcha-logo {
            display: flex;
            align-items: center;
            gap: 4px;
            color: #555;
            font-size: 0.8rem;
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

        .resend-code {
            color: #4CAF50;
            font-size: 0.9rem;
            text-decoration: none;
            cursor: pointer;
            margin-top: 1rem;
            display: inline-block;
        }

        .resend-code:hover {
            text-decoration: underline;
        }

        .timer {
            color: #666;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Admin Verification </h1>
        
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

        <div class="verification-code-container" id="verificationCodeContainer">
            <p>Please enter the verification code sent to your email</p>
            <div class="code-inputs">
                <input type="text" maxlength="1" class="code-input" />
                <input type="text" maxlength="1" class="code-input" />
                <input type="text" maxlength="1" class="code-input" />
                <input type="text" maxlength="1" class="code-input" />
                <input type="text" maxlength="1" class="code-input" />
                <input type="text" maxlength="1" class="code-input" />
            </div>
            <div class="timer" id="timer">Resend code in: 02:00</div>
            <a class="resend-code" id="resendCode" style="display: none;">Resend Code</a>
            <button class="verify-button">Verify Code</button>
        </div>
        
        <div class="footer">
            <p>Copyright © 2024 Admin Portal</p>
            <p>All rights reserved</p>
        </div>
    </div>

    <script>
        const captchaCheckmark = document.getElementById('captchaCheckmark');
        const captchaContainer = document.getElementById('captchaContainer');
        const sendButton = document.getElementById('sendButton');
        const verificationMessage = document.getElementById('verificationMessage');
        const verificationCodeContainer = document.getElementById('verificationCodeContainer');
        const codeInputs = document.querySelectorAll('.code-input');
        const timerElement = document.getElementById('timer');
        const resendCodeButton = document.getElementById('resendCode');
        
        // Handle CAPTCHA verification
        captchaCheckmark.addEventListener('click', function() {
            setTimeout(() => {
                this.classList.add('checked');
                captchaContainer.classList.add('verified');
                sendButton.classList.add('active');
                verificationMessage.classList.remove('show');
            }, 1000);
        });
        
        // Handle send verification code
        sendButton.addEventListener('click', function() {
            if (this.classList.contains('active')) {
                verificationCodeContainer.classList.add('show');
                startTimer();
            }
        });
        
        // Handle code input auto-focus
        codeInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1 && index < codeInputs.length - 1) {
                    codeInputs[index + 1].focus();
                }
            });
            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    codeInputs[index - 1].focus();
                }
            });
        });
        
        // Timer functionality
        function startTimer() {
            let timeLeft = 120; // 2 minutes in seconds
            const timer = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                
                timerElement.textContent = `Resend code in: ${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    timerElement.style.display = 'none';
                    resendCodeButton.style.display = 'inline-block';
                }
            }, 1000);
        }
        
        // Handle resend code
        resendCodeButton.addEventListener('click', function() {
            this.style.display = 'none';
            timerElement.style.display = 'block';
            startTimer();
            // Reset inputs
            codeInputs.forEach(input => input.value = '');
            codeInputs[0].focus();
        });
    </script>
</body>
</html>