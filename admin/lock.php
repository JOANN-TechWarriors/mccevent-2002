<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Verification</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
        
        .loading {
            display: none;
            margin: 10px 0;
            color: #666;
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
        
        .timer {
            color: #666;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
        
        .resend-number {
            color: #4CAF50;
            cursor: pointer;
            display: none;
        }
        
        .verification-failed {
            color: #dc3545;
            display: none;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Admin Verification</h1>
        
        <div class="profile-section">
            <div class="admin-name">Ayres Santillan Ilustrisimo</div>
            <div class="email-container">
                <form id="verificationForm" onsubmit="return false;">
                    <input type="email" placeholder="Enter your email" class="email-input" name="email" required>
                    <button class="send-button" title="Send verification" id="sendButton">
                        <i class="arrow">➤</i>
                    </button>
                    <div class="email-error">Please enter a valid email address.</div>
                    <div class="loading">Sending verification code...</div>
                </form>
            </div>
        </div>
        
        <div class="recaptcha-container">
            <div class="g-recaptcha" data-sitekey="6LcsOX0qAAAAAMHHt5C_j6v9iH2hM6RUduOCmxqe" data-callback="onRecaptchaVerified"></div>
        </div>
        
        <div class="verification-failed" id="verificationMessage">Verification failed. Please try again.</div>
        
        <div class="verification-number-container" id="verificationNumberContainer">
            <p>Please enter the 6-digit verification code sent to your email</p>
            <div class="number-inputs">
                <input type="text" maxlength="1" class="number-input" />
                <input type="text" maxlength="1" class="number-input" />
                <input type="text" maxlength="1" class="number-input" />
                <input type="text" maxlength="1" class="number-input" />
                <input type="text" maxlength="1" class="number-input" />
                <input type="text" maxlength="1" class="number-input" />
            </div>
            <div class="timer" id="timer">Resend code in: 02:00</div>
            <a class="resend-number" id="resendNumber">Resend code</a>
            <button class="verify-button" id="verifyButton">Verify</button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const emailInput = document.querySelector('.email-input');
            const emailError = document.querySelector('.email-error');
            const sendButton = document.getElementById('sendButton');
            const verificationMessage = document.getElementById('verificationMessage');
            const verificationNumberContainer = document.getElementById('verificationNumberContainer');
            const numberInputs = document.querySelectorAll('.number-input');
            const timerElement = document.getElementById('timer');
            const resendNumberButton = document.getElementById('resendNumber');
            const loadingDiv = document.querySelector('.loading');
            const verifyButton = document.getElementById('verifyButton');
            
            let isRecaptchaVerified = false;
            
            function validateEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }
            
            function updateSendButtonState() {
                const isValidEmail = validateEmail(emailInput.value);
                sendButton.classList.toggle('active', isValidEmail && isRecaptchaVerified);
            }
            
            emailInput.addEventListener('input', function() {
                const isValidEmail = validateEmail(this.value);
                this.classList.toggle('error', !isValidEmail && this.value !== '');
                emailError.classList.toggle('show', !isValidEmail && this.value !== '');
                updateSendButtonState();
            });
            
            function onRecaptchaVerified(response) {
                isRecaptchaVerified = true;
                updateSendButtonState();
            }
            
            window.onRecaptchaVerified = onRecaptchaVerified;
            
            sendButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (this.classList.contains('active')) {
                    const recaptchaResponse = grecaptcha.getResponse();
                    if (recaptchaResponse) {
                        loadingDiv.style.display = 'block';
                        
                        $.ajax({
                            url: 'verify_gmail.php',
                            method: 'POST',
                            data: {
                                email: emailInput.value,
                                recaptcha: recaptchaResponse
                            },
                            dataType: 'json',
                            success: function(response) {
                                loadingDiv.style.display = 'none';
                                
                                if (response.success) {
                                    verificationNumberContainer.classList.add('show');
                                    startTimer();
                                    verificationMessage.classList.remove('show');
                                } else {
                                    verificationMessage.textContent = response.message;
                                    verificationMessage.classList.add('show');
                                }
                            },
                            error: function() {
                                loadingDiv.style.display = 'none';
                                verificationMessage.textContent = 'Server error. Please try again.';
                                verificationMessage.classList.add('show');
                            }
                        });
                    }
                }
            });
            
            numberInputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (this.value.length === 1) {
                        if (index < numberInputs.length - 1) {
                            numberInputs[index + 1].focus();
                        }
                    }
                });
                
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        numberInputs[index - 1].focus();
                    }
                });
            });
            
            verifyButton.addEventListener('click', function() {
                const code = Array.from(numberInputs).map(input => input.value).join('');
                if (code.length === 6) {
                    $.ajax({
                        url: 'verify_code.php',
                        method: 'POST',
                        data: {
                            email: emailInput.value,
                            code: code
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                window.location.href = response.redirect;
                            } else {
                                verificationMessage.textContent = response.message;
                                verificationMessage.classList.add('show');
                            }
                        },
                        error: function() {
                            verificationMessage.textContent = 'Server error. Please try again.';
                            verificationMessage.classList.add('show');
                        }
                    });
                }
            });
            
            function startTimer() {
                let timeLeft = 120;
                const timer = setInterval(() => {
                    timeLeft--;
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    
                    timerElement.textContent = `Resend code in: ${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
                    
                    if (timeLeft <= 0) {
                        clearInterval(timer);
                        timerElement.style.display = 'none';
                        resendNumberButton.style.display = 'inline-block';
                    }
                }, 1000);
            }
        });
    </script>
</body>
</html>
