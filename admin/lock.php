<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Previous styles remain the same */
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
            position: relative;
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

        /* Updated CAPTCHA styles */
        .captcha-container {
            width: 300px;
            margin: 0 auto 1rem;
            background: #f9f9f9;
            border: 1px solid #d3d3d3;
            border-radius: 3px;
            height: 74px;
            position: relative;
        }

        .captcha-checkbox {
            width: 24px;
            height: 24px;
            border: 2px solid #c1c1c1;
            border-radius: 2px;
            position: relative;
            margin: 22px 12px;
            cursor: pointer;
            float: left;
            background: white;
        }

        .captcha-checkbox.checked {
            border-color: #009688;
            background: #009688;
        }

        .captcha-checkbox.checked::after {
            content: '';
            position: absolute;
            left: 7px;
            top: 3px;
            width: 6px;
            height: 12px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .captcha-label {
            float: left;
            padding: 24px 0;
            color: #000;
            font-size: 14px;
        }

        .recaptcha-logo {
            float: right;
            margin: 10px;
        }

        /* Image Selection Modal */
        .image-select-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background: white;
            border-radius: 3px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            z-index: 1000;
        }

        .modal-header {
            padding: 24px;
            background: #4a90e2;
            color: white;
            font-size: 16px;
            border-radius: 3px 3px 0 0;
        }

        .modal-content {
            padding: 16px;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 4px;
            margin-bottom: 16px;
        }

        .image-cell {
            position: relative;
            padding-bottom: 100%;
            border: 4px solid transparent;
            cursor: pointer;
            transition: border-color 0.2s;
        }

        .image-cell.selected {
            border-color: #4a90e2;
        }

        .image-cell img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .modal-footer {
            padding: 16px;
            text-align: right;
            border-top: 1px solid #ddd;
        }

        .verify-images-btn {
            background: #4a90e2;
            color: white;
            border: none;
            padding: 8px 24px;
            border-radius: 3px;
            cursor: pointer;
        }

        .verify-images-btn:hover {
            background: #357abd;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        /* Rest of the previous styles */
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
            <img src="/api/placeholder/80/80" alt="Admin Profile" class="profile-img">
            <div class="admin-name">Ayres Santillan Ilustrisimo</div>
            <div class="email-container">
                <input type="email" placeholder="Enter your email" class="email-input">
                <button class="send-button" title="Send verification" id="sendButton">
                    <i class="arrow"></i>
                </button>
            </div>
        </div>

        <div class="captcha-container">
            <div class="captcha-checkbox" id="captchaCheckbox"></div>
            <div class="captcha-label">I'm not a robot</div>
            <div class="recaptcha-logo">
                <img src="/api/placeholder/32/32" alt="reCAPTCHA">
                <div style="font-size: 10px; color: #555;">reCAPTCHA</div>
                <div style="font-size: 8px; color: #555;">Privacy - Terms</div>
            </div>
        </div>

        <div class="modal-overlay" id="modalOverlay"></div>
        
        <div class="image-select-modal" id="imageSelectModal">
            <div class="modal-header">
                Select all images with cars
            </div>
            <div class="modal-content">
                <div class="image-grid">
                    <div class="image-cell">
                        <img src="/api/placeholder/100/100" alt="Grid Image 1">
                    </div>
                    <div class="image-cell">
                        <img src="/api/placeholder/100/100" alt="Grid Image 2">
                    </div>
                    <div class="image-cell">
                        <img src="/api/placeholder/100/100" alt="Grid Image 3">
                    </div>
                    <div class="image-cell">
                        <img src="/api/placeholder/100/100" alt="Grid Image 4">
                    </div>
                    <div class="image-cell">
                        <img src="/api/placeholder/100/100" alt="Grid Image 5">
                    </div>
                    <div class="image-cell">
                        <img src="/api/placeholder/100/100" alt="Grid Image 6">
                    </div>
                    <div class="image-cell">
                        <img src="/api/placeholder/100/100" alt="Grid Image 7">
                    </div>
                    <div class="image-cell">
                        <img src="/api/placeholder/100/100" alt="Grid Image 8">
                    </div>
                    <div class="image-cell">
                        <img src="/api/placeholder/100/100" alt="Grid Image 9">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="verify-images-btn" id="verifyImagesBtn">VERIFY</button>
            </div>
        </div>

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
            <a class="resend-number" id="resendNumber" style="display: none;">Resend Number</a>
            <button class="verify-button">Verify Number</button>
        </div>
        
        <div class="footer">
            <p>Copyright © 2024 Admin Portal</p>
            <p>All rights reserved</p>
        </div>
    </div>

    <script>
        const captchaCheckbox = document.getElementById('captchaCheckbox');
        const modalOverlay = document.getElementById('modalOverlay');
        const imageSelectModal = document.getElementById('imageSelectModal');
        const verifyImagesBtn = document.getElementById('verifyImagesBtn');
        const sendButton = document.getElementById('sendButton');
        const verificationNumberContainer = document.getElementById('verificationNumberContainer');
        const numberInputs = document.querySelectorAll('.number-input');
        const timerElement = document.getElementById('timer');
        const resendNumberButton = document.getElementById('resendNumber');
        
        // Handle CAPTCHA checkbox click
        captchaCheckbox.addEventListener('click', function() {
            this.classList.add('checked');
            setTimeout(() => {
                modalOverlay.style.display = 'block';
                imageSelectModal.style.display = 'block';
            }, 500);
        });

        // Handle image cell selection
        document.querySelectorAll('.image-cell').forEach(cell => {
            cell.addEventListener('click', function() {
                this.classList.toggle('selected');
            });
        });

        // Handle verify button click
        verifyImagesBtn.addEventListener('click', function() {
            modalOverlay.style.display = 'none';
            imageSelectModal.style.display = 'none';
            sendButton.classList.add('active');
        });
        
        // Handle send verification number
        sendButton.addEventListener('click', function() {
            if (this.classList.contains('active')) {
                verificationNumberContainer.classList.add('show');
                startTimer();
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
            this.style.display = 'none';
            timerElement.style.display = 'block';
            startTimer();
            // Reset inputs
            numberInputs.forEach(input => input.value = '');
            numberInputs[0].focus();
        });
    </script>
</body>
</html>