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
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
        <form id="verificationForm" class="email-container">
            <input type="email" placeholder="Enter your email" class="email-input" required>
            <button type="button" class="send-button" title="Send verification" id="sendButton">
                <i class="arrow"></i>
            </button>
            <div class="email-error">Please enter a valid email address.</div>
        </form>
    </div>
    
    <div class="recaptcha-container">
        <div class="g-recaptcha" data-sitekey="6LcsOX0qAAAAAMHHt5C_j6v9iH2hM6RUduOCmxqe" data-callback="onRecaptchaVerified"></div>
    </div>
    
    <div class="verification-failed" id="verificationMessage">Verification failed. Please try again.</div>

    <div class="verification-number-container" id="verificationNumberContainer">
        <p>Please enter the 6-digit verification number sent to your email</p>
        <div class="number-inputs">
            <input type="text" maxlength="1" class="number-input" inputmode="numeric">
            <input type="text" maxlength="1" class="number-input" inputmode="numeric">
            <input type="text" maxlength="1" class="number-input" inputmode="numeric">
            <input type="text" maxlength="1" class="number-input" inputmode="numeric">
            <input type="text" maxlength="1" class="number-input" inputmode="numeric">
            <input type="text" maxlength="1" class="number-input" inputmode="numeric">
        </div>
        <div class="timer" id="timer">Resend number in: 02:00</div>
        <a class="resend-number" id="resendNumber" style="display: none;">Resend</a>
        <button class="verify-button">Verify</button>
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
const verifyButton = document.querySelector('.verify-button');

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
function onRecaptchaVerified() {
    isRecaptchaVerified = true;
    verificationMessage.classList.remove('show');
    updateSendButtonState();
}

// Update send button state based on email and reCAPTCHA
function updateSendButtonState() {
    const isValidEmail = validateEmail(emailInput.value);
    sendButton.classList.toggle('active', isValidEmail && isRecaptchaVerified);
}

// Function to show error message
function showError(message) {
    verificationMessage.textContent = message;
    verificationMessage.classList.add('show');
}

// Function to clear error message
function clearError() {
    verificationMessage.classList.remove('show');
}

// Handle send verification number
sendButton.addEventListener('click', async function(e) {
    e.preventDefault();
    
    if (!this.classList.contains('active')) {
        if (!validateEmail(emailInput.value)) {
            emailError.classList.add('show');
            emailInput.classList.add('error');
        }
        return;
    }

    try {
        const recaptchaResponse = grecaptcha.getResponse();
        if (!recaptchaResponse) {
            showError('Please complete the reCAPTCHA verification');
            return;
        }

        const formData = new FormData();
        formData.append('email', emailInput.value);
        formData.append('g-recaptcha-response', recaptchaResponse);

        const response = await fetch('verify_gmail.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        
        if (data.status === 'success') {
            clearError();
            verificationNumberContainer.classList.add('show');
            startTimer();
            // Reset number inputs
            numberInputs.forEach(input => input.value = '');
            numberInputs[0].focus();
        } else {
            showError(data.message || 'Verification failed. Please try again.');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('An error occurred. Please try again.');
    } finally {
        // Reset reCAPTCHA
        grecaptcha.reset();
        isRecaptchaVerified = false;
        updateSendButtonState();
    }
});

// Handle number input auto-focus
numberInputs.forEach((input, index) => {
    // Allow only numbers
    input.addEventListener('keypress', function(e) {
        if (!/[0-9]/.test(e.key)) {
            e.preventDefault();
        }
    });

    // Handle input
    input.addEventListener('input', function() {
        if (this.value.length === 1) {
            if (index < numberInputs.length - 1) {
                numberInputs[index + 1].focus();
            }
        }
    });

    // Handle backspace
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace') {
            if (!this.value && index > 0) {
                numberInputs[index - 1].focus();
                numberInputs[index - 1].value = '';
            } else {
                this.value = '';
            }
            e.preventDefault();
        }
    });

    // Handle paste
    input.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
        pastedData.split('').forEach((digit, i) => {
            if (i < numberInputs.length) {
                numberInputs[i].value = digit;
            }
        });
        if (pastedData.length === 6) {
            numberInputs[5].focus();
        }
    });
});

// Timer functionality
function startTimer() {
    let timeLeft = 120; // 2 minutes in seconds
    timerElement.style.display = 'block';
    resendNumberButton.style.display = 'none';

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

    return timer;
}

// Handle resend number
resendNumberButton.addEventListener('click', async function() {
    if (!validateEmail(emailInput.value)) {
        emailError.classList.add('show');
        emailInput.classList.add('error');
        return;
    }

    try {
        const recaptchaResponse = grecaptcha.getResponse();
        if (!recaptchaResponse) {
            showError('Please complete the reCAPTCHA verification');
            return;
        }

        const formData = new FormData();
        formData.append('email', emailInput.value);
        formData.append('g-recaptcha-response', recaptchaResponse);

        const response = await fetch('verify_gmail.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        
        if (data.status === 'success') {
            clearError();
            this.style.display = 'none';
            startTimer();
            numberInputs.forEach(input => input.value = '');
            numberInputs[0].focus();
        } else {
            showError(data.message || 'Failed to resend verification code');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('An error occurred. Please try again.');
    } finally {
        grecaptcha.reset();
        isRecaptchaVerified = false;
        updateSendButtonState();
    }
});

// Handle verify button click
verifyButton.addEventListener('click', async function() {
    const code = Array.from(numberInputs).map(input => input.value).join('');
    
    if (code.length !== 6) {
        showError('Please enter the complete 6-digit code.');
        return;
    }

    try {
        const formData = new FormData();
        formData.append('verify_code', '1');
        formData.append('email', emailInput.value);
        formData.append('code', code);

        const response = await fetch('verify_gmail.php', {
            method: 'POST',
            body: formData
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        
        if (data.status === 'success') {
            window.location.href = 'dashboard.php';
        } else {
            showError(data.message || 'Verification failed. Please try again.');
            // Clear inputs on failed verification
            numberInputs.forEach(input => input.value = '');
            numberInputs[0].focus();
        }
    } catch (error) {
        console.error('Error:', error);
        showError('An error occurred. Please try again.');
    }
});
    </script>
</body>

</html>
</a