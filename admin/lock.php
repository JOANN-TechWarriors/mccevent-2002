<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
            width: 95%;
            padding: 0.5rem;
            padding-right: 40px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        .email-input.error {
            border-color: #dc3545;
        }
        
        .email-error {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            display: none;
            text-align: left;
        }
        
        .email-error.show {
            display: block;
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
        
        .recaptcha-container {
            margin-bottom: 1rem;
            display: flex;
            justify-content: center;
        }
        
        .verification-number-container {
            display: none;
            margin-top: 1rem;
        }
        
        .verification-number-container.show {
            display: block;
        }
        
        .number-inputs {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin: 1rem 0;
        }
        
        .number-input {
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
        }
        
        .number-input:focus {
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

        .resend-number {
            color: #4CAF50;
            font-size: 0.9rem;
            text-decoration: none;
            cursor: pointer;
            margin-top: 1rem;
            display: inline-block;
        }

        .resend-number:hover {
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
        <h1 class="title">Admin Verification</h1>
        
        <div class="profile-section">
            <br>
            <div class="admin-name">Ayres Santillan Ilustrisimo</div>
            <div class="email-container">
                <form action="verify_gmail.php">
                <input  type="email" placeholder="Enter your email" class="email-input" required>
                <button class="send-button" title="Send verification" id="sendButton">
                    <i class="arrow"></i>
                </button>
                <div class="email-error">Please enter a valid email address.</div>
            </div>
            </form>
        </div>
        
        <div class="recaptcha-container">
            <div class="g-recaptcha" data-sitekey="6LcsOX0qAAAAAMHHt5C_j6v9iH2hM6RUduOCmxqe" data-callback="onRecaptchaVerified"></div>
        </div>
        
        <div class="verification-failed" id="verificationMessage">Verification failed. Please try again.</div>

        <div class="verification-number-container" id="verificationNumberContainer">
            <p>Please enter the 6-digit verification number sent to your email</p>
            <div class="number-inputs">
                <input type="text" maxlength="1" class="number-input" />
                <input type="text" maxlength="1" class="number-input" />
                <input type="text" maxlength="1" class="number-input" />
                <input type="text" maxlength="1" class="number-input" />
                <input type="text" maxlength="1" class="number-input" />
                <input type="text" maxlength="1" class="number-input" />
            </div>
            <div class="timer" id="timer">Resend number in: 02:00</div>
            <a class="resend-number" id="resendNumber" style="display: none;">Resend</a>
            <button class="verify-button">Verify</button>
        </div>
        
        <div class="footer">
        <strong> Event Judging  System &COPY; <?= date("Y") ?></strong>
                    <p>All rights reserved</p>
        </div>
    </div>

    <script>
        const emailInput = document.querySelector('.email-input');
        const emailError = document.querySelector('.email-error');
        const sendButton = document.getElementById('sendButton');
        const verificationMessage = document.getElementById('verificationMessage');
        const verificationNumberContainer = document.getElementById('verificationNumberContainer');
        const numberInputs = document.querySelectorAll('.number-input');
        const timerElement = document.getElementById('timer');
        const resendNumberButton = document.getElementById('resendNumber');
        
        let isRecaptchaVerified = false;
        
        // Email validation function
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
        
        // Handle email input validation
        emailInput.addEventListener('input', function() {
            const isValidEmail = validateEmail(this.value);
            this.classList.toggle('error', !isValidEmail && this.value !== '');
            emailError.classList.toggle('show', !isValidEmail && this.value !== '');
            updateSendButtonState();
        });
        
        // Callback for reCAPTCHA verification
        function onRecaptchaVerified(response) {
            if (response) {
                isRecaptchaVerified = true;
                verificationMessage.classList.remove('show');
                updateSendButtonState();
            }
        }
        
        // Update send button state based on email and reCAPTCHA
        function updateSendButtonState() {
            const isValidEmail = validateEmail(emailInput.value);
            sendButton.classList.toggle('active', isValidEmail && isRecaptchaVerified);
        }
        
        // Handle send verification number
        sendButton.addEventListener('click', function() {
            if (this.classList.contains('active')) {
                // Verify reCAPTCHA response with your backend
                const recaptchaResponse = grecaptcha.getResponse();
                if (recaptchaResponse) {
                    verificationNumberContainer.classList.add('show');
                    startTimer();
                } else {
                    verificationMessage.classList.add('show');
                }
            } else if (!validateEmail(emailInput.value)) {
                emailError.classList.add('show');
                emailInput.classList.add('error');
            }
        });
        
        // Handle number input auto-focus
        numberInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                if (this.value.length === 1 && index < numberInputs.length - 1) {
                    numberInputs[index + 1].focus();
                }
            });
            
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    numberInputs[index - 1].focus();
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
                
                timerElement.textContent = `Resend number in: ${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    timerElement.style.display = 'none';
                    resendNumberButton.style.display = 'inline-block';
                }
            }, 1000);
        }
        
        // Handle resend number
        resendNumberButton.addEventListener('click', function() {
            if (validateEmail(emailInput.value)) {
                // Verify reCAPTCHA again before resending
                const recaptchaResponse = grecaptcha.getResponse();
                if (recaptchaResponse) {
                    this.style.display = 'none';
                    timerElement.style.display = 'block';
                    startTimer();
                    // Reset inputs
                    numberInputs.forEach(input => input.value = '');
                    numberInputs[0].focus();
                    // Reset reCAPTCHA
                    grecaptcha.reset();
                    isRecaptchaVerified = false;
                    updateSendButtonState();
                } else {
                    verificationMessage.classList.add('show');
                }
            } else {
                emailError.classList.add('show');
                emailInput.classList.add('error');
            }
        });
        
    </script>
</body>
</html>
</a