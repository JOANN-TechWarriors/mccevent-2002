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
            <form action="verify_gmail.php" method="post">
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
// Constants for configuration
const CONFIG = {
    TIMER_DURATION: 120, // 2 minutes in seconds
    CODE_LENGTH: 6,
    API_ENDPOINTS: {
        VERIFY_EMAIL: 'verify_gmail.php'
    }
};

// DOM Elements
const elements = {
    emailInput: document.querySelector('.email-input'),
    emailError: document.querySelector('.email-error'),
    sendButton: document.getElementById('sendButton'),
    verificationMessage: document.getElementById('verificationMessage'),
    verificationContainer: document.getElementById('verificationNumberContainer'),
    numberInputs: document.querySelectorAll('.number-input'),
    timerElement: document.getElementById('timer'),
    resendButton: document.getElementById('resendNumber'),
    verifyButton: document.querySelector('.verify-button'),
    form: document.querySelector('form')
};

// State management
const state = {
    isRecaptchaVerified: false,
    timerInterval: null,
    isProcessing: false
};

// Utility functions
const utils = {
    validateEmail: (email) => {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email.toLowerCase());
    },

    showError: (message) => {
        elements.verificationMessage.textContent = message;
        elements.verificationMessage.classList.add('show');
    },

    hideError: () => {
        elements.verificationMessage.classList.remove('show');
    },

    disableForm: () => {
        elements.sendButton.disabled = true;
        elements.verifyButton.disabled = true;
        state.isProcessing = true;
    },

    enableForm: () => {
        elements.sendButton.disabled = false;
        elements.verifyButton.disabled = false;
        state.isProcessing = false;
    },

    formatTime: (seconds) => {
        const minutes = Math.floor(seconds / 60);
        const remainingSeconds = seconds % 60;
        return `${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
    }
};

// Core functionality
const core = {
    updateSendButtonState: () => {
        const isValidEmail = utils.validateEmail(elements.emailInput.value);
        elements.sendButton.classList.toggle('active', isValidEmail && state.isRecaptchaVerified);
    },

    startTimer: () => {
        let timeLeft = CONFIG.TIMER_DURATION;
        elements.timerElement.style.display = 'block';
        elements.resendButton.style.display = 'none';

        // Clear existing timer if any
        if (state.timerInterval) {
            clearInterval(state.timerInterval);
        }

        state.timerInterval = setInterval(() => {
            timeLeft--;
            elements.timerElement.textContent = `Resend number in: ${utils.formatTime(timeLeft)}`;

            if (timeLeft <= 0) {
                clearInterval(state.timerInterval);
                elements.timerElement.style.display = 'none';
                elements.resendButton.style.display = 'inline-block';
            }
        }, 1000);
    },

    resetVerificationInputs: () => {
        elements.numberInputs.forEach(input => {
            input.value = '';
            input.disabled = false;
        });
        elements.numberInputs[0].focus();
    },

    handleApiResponse: async (response) => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        if (data.status !== 'success') {
            throw new Error(data.message || 'Server error occurred');
        }
        return data;
    },

    sendVerificationRequest: async (formData) => {
        try {
            utils.disableForm();
            const response = await fetch(CONFIG.API_ENDPOINTS.VERIFY_EMAIL, {
                method: 'POST',
                body: formData
            });
            const data = await core.handleApiResponse(response);
            elements.verificationContainer.classList.add('show');
            core.startTimer();
            utils.hideError();
            core.resetVerificationInputs();
            return true;
        } catch (error) {
            console.error('Verification request error:', error);
            utils.showError(error.message || 'An error occurred. Please try again.');
            return false;
        } finally {
            utils.enableForm();
        }
    },

    verifyCode: async () => {
        const code = Array.from(elements.numberInputs).map(input => input.value).join('');
        if (code.length !== CONFIG.CODE_LENGTH) {
            utils.showError('Please enter the complete 6-digit code.');
            return;
        }

        const formData = new FormData();
        formData.append('verify_code', '1');
        formData.append('email', elements.emailInput.value);
        formData.append('code', code);

        try {
            utils.disableForm();
            const response = await fetch(CONFIG.API_ENDPOINTS.VERIFY_EMAIL, {
                method: 'POST',
                body: formData
            });
            const data = await core.handleApiResponse(response);
            window.location.href = 'dashboard.php';
        } catch (error) {
            console.error('Code verification error:', error);
            utils.showError(error.message || 'An error occurred. Please try again.');
            core.resetVerificationInputs();
        } finally {
            utils.enableForm();
        }
    }
};

// Event Handlers
const handlers = {
    onEmailInput: (e) => {
        const isValidEmail = utils.validateEmail(e.target.value);
        e.target.classList.toggle('error', !isValidEmail && e.target.value !== '');
        elements.emailError.classList.toggle('show', !isValidEmail && e.target.value !== '');
        core.updateSendButtonState();
    },

    onNumberInput: (e, index) => {
        const input = e.target;
        
        // Allow only numbers
        input.value = input.value.replace(/[^0-9]/g, '');

        if (input.value.length === 1 && index < elements.numberInputs.length - 1) {
            elements.numberInputs[index + 1].focus();
        }
    },

    onNumberKeydown: (e, index) => {
        if (e.key === 'Backspace' && !e.target.value && index > 0) {
            elements.numberInputs[index - 1].focus();
        }
    },

    onSendButtonClick: async (e) => {
        e.preventDefault();
        
        if (!elements.sendButton.classList.contains('active')) {
            if (!utils.validateEmail(elements.emailInput.value)) {
                elements.emailError.classList.add('show');
                elements.emailInput.classList.add('error');
            }
            return;
        }

        const recaptchaResponse = grecaptcha.getResponse();
        if (!recaptchaResponse) {
            utils.showError('Please complete the reCAPTCHA verification.');
            return;
        }

        const formData = new FormData();
        formData.append('email', elements.emailInput.value);
        formData.append('g-recaptcha-response', recaptchaResponse);
        
        await core.sendVerificationRequest(formData);
    }
};

// Initialize event listeners
function initializeEventListeners() {
    elements.emailInput.addEventListener('input', handlers.onEmailInput);
    elements.sendButton.addEventListener('click', handlers.onSendButtonClick);
    elements.verifyButton.addEventListener('click', core.verifyCode);
    elements.resendButton.addEventListener('click', handlers.onSendButtonClick);

    elements.numberInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => handlers.onNumberInput(e, index));
        input.addEventListener('keydown', (e) => handlers.onNumberKeydown(e, index));
    });

    // Prevent form submission
    elements.form.addEventListener('submit', (e) => e.preventDefault());
}

// reCAPTCHA callback
function onRecaptchaVerified(response) {
    if (response) {
        state.isRecaptchaVerified = true;
        utils.hideError();
        core.updateSendButtonState();
    }
}

// Initialize the application
function initialize() {
    initializeEventListeners();
    core.updateSendButtonState();
}

// Start the application
initialize();
</script>
</body>
</html>
</a