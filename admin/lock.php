<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup {
            border-radius: 8px !important;
            padding: 20px !important;
            background-color: #f8f9fa !important;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1) !important;
        }

        .swal2-title {
            font-size: 1.25rem !important;
            font-weight: bold !important;
            color: #374151 !important;
        }

        .swal2-content {
            color: #6b7280 !important;
        }

        .swal2-icon {
            margin-right: 1rem !important;
        }

        .input-field {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
        }

        .spinner {
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-left-color: #4caf50;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
            display: inline-block;
            vertical-align: middle;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            max-width: 500px;
        }
    </style>
</head>

<body class="bg-gray-100 flex justify-center items-center h-screen font-sans">
    <div class="bg-white p-8 rounded-md shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-8 text-gray-800">Admin Verification</h1>
        <div class="mb-8">
            <div class="text-gray-700 mb-2">Ayres Santillan Ilustrisimo</div>
            <div class="relative">
                <form id="emailForm" action="verify_gmail.php" method="POST">
                    <input type="email" placeholder="Enter your email" name="email"
                        class="w-full input-field px-4 py-2 focus:border-green-500 focus:ring-green-500" required>
                    <button
                        class="absolute right-2 top-1/2 -translate-y-1/2 bg-transparent border-none text-gray-600 hover:text-gray-800 cursor-pointer flex items-center"
                        type="submit" title="Send verification" id="sendButton">
                        <svg class="w-6 h-6 transform rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        <div class="spinner hidden ml-2"></div>
                    </button>
                </form>
                <div class="text-red-500 text-sm mt-2 hidden" id="emailError">Please enter a valid email address.</div>
            </div>
        </div>
        <div class="hidden" id="verificationNumberContainer">
            <p class="mb-4 text-gray-700">Please enter the 6-digit verification number sent to your email</p>
            <form id="verificationForm" action="verify_code.php" method="POST">
                <div class="flex justify-center gap-2 mb-4">
                    <input type="text" maxlength="1" name="code[]"
                        class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                        required />
                    <input type="text" maxlength="1" name="code[]"
                        class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                        required />
                    <input type="text" maxlength="1" name="code[]"
                        class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                        required />
                    <input type="text" maxlength="1" name="code[]"
                        class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                        required />
                    <input type="text" maxlength="1" name="code[]"
                        class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                        required />
                    <input type="text" maxlength="1" name="code[]"
                        class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                        required />
                </div>
                <button class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md w-full"
                    type="submit">Verify</button>
            </form>
            <div class="text-gray-600 text-sm mt-2" id="timer">Resend number in: 02:00</div>
            <a class="text-green-500 text-sm mt-2 hidden cursor-pointer" id="resendNumber">Resend</a>
        </div>
        <div class="flex justify-between items-center mt-8">
            <div class="text-gray-600 text-sm">
                <strong>Event Judging System &COPY; <?= date("Y") ?></strong>
                <p>All rights reserved</p>
            </div>
            <button id="tryAnotherWayBtn" class="text-green-500 text-sm cursor-pointer">Try Another Way</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 class="text-2xl font-bold mb-4">Alternative Verification</h2>
            <form id="alternativeForm" action="verify_number.php" method="POST">
                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 font-medium mb-2">Please enter your phone
                        number</label>
                    <div class="relative">
                        <input type="tel" id="phone" name="phone" class="w-full input-field px-4 py-2"
                            placeholder="Enter your phone number" required>
                        <button
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-transparent border-none text-gray-600 hover:text-gray-800 cursor-pointer flex items-center"
                            type="submit" title="Submit">
                            <svg class="w-6 h-6 transform rotate-45" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                            </svg>
                            <div class="spinner hidden ml-2"></div>
                        </button>
                    </div>
                </div>


            </form>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Enter the 6-digit verification code</label>
                <form id="phoneVerificationForm" action="verify_code_number.php" method="POST">
                    <div class="flex justify-center gap-2 mb-4">
                        <input type="text" maxlength="1" name="code[]"
                            class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                            required />
                        <input type="text" maxlength="1" name="code[]"
                            class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                            required />
                        <input type="text" maxlength="1" name="code[]"
                            class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                            required />
                        <input type="text" maxlength="1" name="code[]"
                            class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                            required />
                        <input type="text" maxlength="1" name="code[]"
                            class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                            required />
                        <input type="text" maxlength="1" name="code[]"
                            class="w-12 h-12 input-field text-center text-2xl font-bold focus:border-green-500 focus:ring-green-500"
                            required />
                    </div>
                    <button class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md w-full"
                        type="submit">Verify</button>
                </form>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailForm = document.getElementById('emailForm');
        const emailInput = document.querySelector('input[name="email"]');
        const emailError = document.getElementById('emailError');
        const sendButton = document.getElementById('sendButton');
        const verificationNumberContainer = document.getElementById('verificationNumberContainer');
        const numberInputs = document.querySelectorAll('input[name="code[]"]');
        const timerElement = document.getElementById('timer');
        const resendNumberButton = document.getElementById('resendNumber');
        const alternativeForm = document.getElementById('alternativeForm');
        const phoneVerificationForm = document.getElementById('phoneVerificationForm');

        // Email validation function
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Function to show a custom SweetAlert2 alert
        function showCustomAlert(icon, title, text) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                customClass: {
                    popup: 'rounded-lg'
                },
                toast: true,
                showClass: {
                    popup: 'animate__animated animate__fadeInRight'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutRight'
                }
            });
        }

        // Handle email input validation
        emailInput.addEventListener('input', function () {
            const isValidEmail = validateEmail(this.value);
            this.classList.toggle('border-red-500', !isValidEmail && this.value !== '');
            emailError.classList.toggle('block', !isValidEmail && this.value !== '');
            updateSendButtonState();
        });

        // Update send button state based on email
        function updateSendButtonState() {
            const isValidEmail = validateEmail(emailInput.value);
            sendButton.classList.toggle('opacity-100', isValidEmail);
            sendButton.classList.toggle('opacity-50', !isValidEmail);
            sendButton.classList.toggle('cursor-pointer', isValidEmail);
            sendButton.classList.toggle('cursor-not-allowed', !isValidEmail);
        }

        // Handle send verification number
        emailForm.addEventListener('submit', function (event) {
            event.preventDefault();
            if (validateEmail(emailInput.value)) {
                const spinner = sendButton.querySelector('.spinner');
                const svgIcon = sendButton.querySelector('svg');
                spinner.classList.remove('hidden');
                svgIcon.classList.add('hidden');

                fetch('verify_gmail.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams(new FormData(emailForm))
                })
                .then(response => response.json())
                .then(data => {
                    spinner.classList.add('hidden');
                    svgIcon.classList.remove('hidden');

                    if (data.status === 'success') {
                        showCustomAlert('success', '', data.message);
                        verificationNumberContainer.classList.remove('hidden');
                        startTimer();
                    } else {
                        showCustomAlert('error', '', data.message);
                    }
                })
                .catch(error => {
                    spinner.classList.add('hidden');
                    svgIcon.classList.remove('hidden');
                    showCustomAlert('error', '', 'An unexpected error occurred.');
                });
            } else {
                emailError.classList.add('block');
                emailInput.classList.add('border-red-500');
            }
        });

        // Handle number input auto-focus
        numberInputs.forEach((input, index) => {
            input.addEventListener('input', function () {
                if (this.value.length === 1 && index < numberInputs.length - 1) {
                    numberInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', function (e) {
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

                timerElement.textContent =
                    `Resend number in: ${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

                if (timeLeft <= 0) {
                    clearInterval(timer);
                    timerElement.style.display = 'none';
                    resendNumberButton.style.display = 'inline-block';
                }
            }, 1000);
        }

        // Handle resend number
        resendNumberButton.addEventListener('click', function () {
            if (validateEmail(emailInput.value)) {
                this.style.display = 'none';
                timerElement.style.display = 'block';
                startTimer();
                numberInputs.forEach(input => input.value = '');
                numberInputs[0].focus();
            } else {
                emailError.classList.add('block');
                emailInput.classList.add('border-red-500');
            }
        });

        // Handle verification form submission
        const verificationForm = document.getElementById('verificationForm');
        verificationForm.addEventListener('submit', function (event) {
            event.preventDefault();
            fetch('verify_code.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(new FormData(verificationForm))
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showCustomAlert('success', 'Success', data.message);
                    setTimeout(() => {
                        window.location.href = `admin_login.php?token=${data.token}`;
                    }, 3000); // Redirect after 3 seconds
                } else {
                    showCustomAlert('error', 'Error', data.message);
                }
            })
            .catch(error => {
                showCustomAlert('error', 'Error', 'An unexpected error occurred.');
            });
        });

        // Handle alternative verification form submission
        alternativeForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const phoneInput = document.querySelector('input[name="phone"]');
            const spinner = alternativeForm.querySelector('.spinner');
            const svgIcon = alternativeForm.querySelector('svg');

            spinner.classList.remove('hidden');
            svgIcon.classList.add('hidden');

            fetch('verify_number.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(new FormData(alternativeForm))
            })
            .then(response => response.json())
            .then(data => {
                spinner.classList.add('hidden');
                svgIcon.classList.remove('hidden');

                if (data.success) {
                    showCustomAlert('success', '', data.message);
                } else {
                    showCustomAlert('error', '', data.message);
                }
            })
            .catch(error => {
                spinner.classList.add('hidden');
                svgIcon.classList.remove('hidden');
                showCustomAlert('error', '', 'An unexpected error occurred.');
            });
        });

        // Handle phone verification form submission
        phoneVerificationForm.addEventListener('submit', function (event) {
            event.preventDefault();
            fetch('verify_code_number.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(new FormData(phoneVerificationForm))
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showCustomAlert('success', 'Success', data.message);
                    setTimeout(() => {
                        window.location.href = `admin_login.php?token=${data.token}`;
                    }, 3000); // Redirect after 3 seconds
                } else {
                    showCustomAlert('error', 'Error', data.message);
                }
            })
            .catch(error => {
                showCustomAlert('error', 'Error', 'An unexpected error occurred.');
            });
        });

        // Modal functionality
        const modal = document.getElementById("myModal");
        const btn = document.getElementById("tryAnotherWayBtn");
        const span = document.getElementsByClassName("close-button")[0];

        btn.addEventListener("click", function () {
            modal.style.display = "block";
        });

        span.addEventListener("click", function () {
            modal.style.display = "none";
        });

        window.addEventListener("click", function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        });
    });
</script>
</body>

</html>