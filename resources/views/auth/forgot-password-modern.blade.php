<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - DND COMPUTERS</title>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffc107" stop-opacity="0.1"/><stop offset="100%" stop-color="%23000" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>');
            animation: float 20s ease-in-out infinite;
            z-index: 0;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
            border-color: #ffc107;
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #ffc107 0%, #ffb400 100%);
            transition: all 0.3s ease;
            color: #000;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 193, 7, 0.3);
            color: #000;
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .slide-in {
            animation: slideIn 0.8s ease-out;
            position: relative;
            z-index: 2;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
        }

        .step.active {
            background: linear-gradient(135deg, #ffc107, #ffb400);
            color: #000;
        }

        .step.completed {
            background: #28a745;
            color: #fff;
        }

        .step.inactive {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
        }

        .step::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 40px;
            height: 2px;
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-50%);
        }

        .step:last-child::after {
            display: none;
        }

        .step.completed::after {
            background: #28a745;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            border-radius: 10px;
            margin: 0 0.25rem;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.2);
            outline: none;
        }

        .timer {
            color: #ffc107;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .timer.expired {
            color: #dc3545;
        }

        .success-animation {
            animation: successPulse 0.6s ease-in-out;
        }

        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Input styling */
        input[type="email"],
        input[type="password"] {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: #ffc107 !important;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 4px;
            border-radius: 2px;
            background: rgba(255, 255, 255, 0.2);
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { background: #dc3545; width: 25%; }
        .strength-fair { background: #ffc107; width: 50%; }
        .strength-good { background: #28a745; width: 75%; }
        .strength-strong { background: #20c997; width: 100%; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background Decorations -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full floating-animation"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-5 rounded-full floating-animation" style="animation-delay: -3s;"></div>
        <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-white opacity-10 rounded-full floating-animation" style="animation-delay: -1s;"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo Section -->
        <div class="text-center mb-8 slide-in">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-4">
                <i class="fas fa-key text-2xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Reset Password</h1>
            <p class="text-white text-opacity-80">Don't worry, we'll help you get back in</p>
        </div>

        <!-- Main Form Container -->
        <div class="glass-effect rounded-2xl p-8 slide-in" style="animation-delay: 0.2s;">
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step active" id="step1Indicator">1</div>
                <div class="step inactive" id="step2Indicator">2</div>
                <div class="step inactive" id="step3Indicator">3</div>
            </div>

            <!-- Step 1: Email Input -->
            <div id="step1" class="step-content">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-semibold text-white mb-2">Enter Your Email</h3>
                    <p class="text-white text-opacity-70">We'll send you a verification code</p>
                </div>

                <form id="emailForm" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email Address
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               class="w-full px-4 py-3 rounded-lg input-focus transition-all duration-300"
                               placeholder="Enter your email address">
                        <div id="emailError" class="text-red-300 text-sm mt-1 hidden"></div>
                    </div>

                    <button type="submit" 
                            id="sendOtpBtn"
                            class="w-full btn-gradient text-white font-semibold py-3 px-4 rounded-lg">
                        <span id="sendOtpText">
                            <i class="fas fa-paper-plane mr-2"></i>Send Verification Code
                        </span>
                        <span id="sendOtpLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Sending...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Step 2: OTP Verification -->
            <div id="step2" class="step-content hidden">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-semibold text-white mb-2">Verify Your Email</h3>
                    <p class="text-white text-opacity-70">Enter the 6-digit code sent to</p>
                    <p class="text-yellow-400 font-medium" id="emailDisplay"></p>
                </div>

                <form id="otpForm" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-white mb-3 text-center">
                            <i class="fas fa-shield-alt mr-2"></i>Verification Code
                        </label>
                        <div class="flex justify-center">
                            <input type="text" class="otp-input" maxlength="1" id="otp1">
                            <input type="text" class="otp-input" maxlength="1" id="otp2">
                            <input type="text" class="otp-input" maxlength="1" id="otp3">
                            <input type="text" class="otp-input" maxlength="1" id="otp4">
                            <input type="text" class="otp-input" maxlength="1" id="otp5">
                            <input type="text" class="otp-input" maxlength="1" id="otp6">
                        </div>
                        <div id="otpError" class="text-red-300 text-sm mt-2 text-center hidden"></div>
                    </div>

                    <div class="text-center">
                        <div class="timer mb-4" id="timer">Time remaining: <span id="timeLeft">10:00</span></div>
                        <button type="button" 
                                id="resendBtn" 
                                class="text-white text-opacity-70 hover:text-yellow-400 transition-colors duration-300 disabled:opacity-50"
                                disabled>
                            <i class="fas fa-redo mr-2"></i>Resend Code
                        </button>
                    </div>

                    <button type="submit" 
                            id="verifyOtpBtn"
                            class="w-full btn-gradient text-white font-semibold py-3 px-4 rounded-lg">
                        <span id="verifyOtpText">
                            <i class="fas fa-check-circle mr-2"></i>Verify Code
                        </span>
                        <span id="verifyOtpLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Verifying...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Step 3: New Password -->
            <div id="step3" class="step-content hidden">
                <div class="text-center mb-6">
                    <h3 class="text-xl font-semibold text-white mb-2">Create New Password</h3>
                    <p class="text-white text-opacity-70">Choose a strong password for your account</p>
                </div>

                <form id="passwordForm" class="space-y-6">
                    <div>
                        <label for="newPassword" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-lock mr-2"></i>New Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="newPassword" 
                                   name="password" 
                                   required
                                   class="w-full px-4 py-3 rounded-lg input-focus transition-all duration-300 pr-12"
                                   placeholder="Enter new password">
                            <button type="button" 
                                    id="toggleNewPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-60 hover:text-opacity-100 transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <p class="text-xs text-white text-opacity-60 mt-1" id="strengthText">Password strength</p>
                        </div>
                        <div id="passwordError" class="text-red-300 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="confirmPassword" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-lock mr-2"></i>Confirm Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="confirmPassword" 
                                   name="password_confirmation" 
                                   required
                                   class="w-full px-4 py-3 rounded-lg input-focus transition-all duration-300 pr-12"
                                   placeholder="Confirm new password">
                            <button type="button" 
                                    id="toggleConfirmPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-60 hover:text-opacity-100 transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="confirmPasswordError" class="text-red-300 text-sm mt-1 hidden"></div>
                    </div>

                    <button type="submit" 
                            id="resetPasswordBtn"
                            class="w-full btn-gradient text-white font-semibold py-3 px-4 rounded-lg">
                        <span id="resetPasswordText">
                            <i class="fas fa-key mr-2"></i>Reset Password
                        </span>
                        <span id="resetPasswordLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Resetting...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Success Step -->
            <div id="successStep" class="step-content hidden text-center">
                <div class="success-animation">
                    <i class="fas fa-check-circle fa-4x text-green-400 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-white mb-2">Password Reset Successful!</h3>
                    <p class="text-white text-opacity-70 mb-6">Your password has been successfully reset. You can now login with your new password.</p>
                    <a href="/jwt/login" class="btn-gradient text-white font-semibold py-3 px-6 rounded-lg inline-block text-decoration-none">
                        <i class="fas fa-sign-in-alt mr-2"></i>Go to Login
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <div class="mt-8 pt-6 border-t border-white border-opacity-20">
                <div class="flex justify-between items-center">
                    <button id="backBtn" class="text-white text-opacity-60 hover:text-opacity-100 transition-all duration-300 hidden">
                        <i class="fas fa-arrow-left mr-2"></i>Back
                    </button>
                    <a href="/jwt/login" class="text-white text-opacity-60 hover:text-opacity-100 transition-all duration-300">
                        <i class="fas fa-sign-in-alt mr-2"></i>Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        let userEmail = '';
        let otpTimer;
        let timeLeft = 600; // 10 minutes

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
        });

        function setupEventListeners() {
            // Email form
            document.getElementById('emailForm').addEventListener('submit', handleEmailSubmit);
            
            // OTP form
            document.getElementById('otpForm').addEventListener('submit', handleOtpSubmit);
            setupOtpInputs();
            
            // Password form
            document.getElementById('passwordForm').addEventListener('submit', handlePasswordSubmit);
            setupPasswordToggles();
            setupPasswordStrength();
            
            // Resend button
            document.getElementById('resendBtn').addEventListener('click', resendOtp);
            
            // Back button
            document.getElementById('backBtn').addEventListener('click', goBack);
        }

        // Step 1: Email submission
        async function handleEmailSubmit(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value.trim();
            if (!email || !isValidEmail(email)) {
                showError('emailError', 'Please enter a valid email address');
                return;
            }

            const btn = document.getElementById('sendOtpBtn');
            const btnText = document.getElementById('sendOtpText');
            const btnLoading = document.getElementById('sendOtpLoading');

            setButtonLoading(btn, btnText, btnLoading, true);
            clearError('emailError');

            try {
                const response = await fetch('/api/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email })
                });

                const data = await response.json();

                if (data.success) {
                    userEmail = email;
                    document.getElementById('emailDisplay').textContent = email;
                    goToStep(2);
                    startTimer();
                    showNotification('Verification code sent successfully!', 'success');
                } else {
                    showError('emailError', data.message || 'Failed to send verification code');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('emailError', 'Network error. Please try again.');
            } finally {
                setButtonLoading(btn, btnText, btnLoading, false);
            }
        }

        // Step 2: OTP verification
        async function handleOtpSubmit(e) {
            e.preventDefault();
            
            const otp = getOtpValue();
            if (otp.length !== 6) {
                showError('otpError', 'Please enter the complete 6-digit code');
                return;
            }

            const btn = document.getElementById('verifyOtpBtn');
            const btnText = document.getElementById('verifyOtpText');
            const btnLoading = document.getElementById('verifyOtpLoading');

            setButtonLoading(btn, btnText, btnLoading, true);
            clearError('otpError');

            try {
                const response = await fetch('/api/verify-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email: userEmail, otp })
                });

                const data = await response.json();

                if (data.success) {
                    clearInterval(otpTimer);
                    goToStep(3);
                    showNotification('Email verified successfully!', 'success');
                } else {
                    showError('otpError', data.message || 'Invalid verification code');
                    clearOtpInputs();
                }
            } catch (error) {
                console.error('Error:', error);
                showError('otpError', 'Network error. Please try again.');
            } finally {
                setButtonLoading(btn, btnText, btnLoading, false);
            }
        }

        // Step 3: Password reset
        async function handlePasswordSubmit(e) {
            e.preventDefault();
            
            const password = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Validation
            if (password.length < 8) {
                showError('passwordError', 'Password must be at least 8 characters long');
                return;
            }

            if (password !== confirmPassword) {
                showError('confirmPasswordError', 'Passwords do not match');
                return;
            }

            const btn = document.getElementById('resetPasswordBtn');
            const btnText = document.getElementById('resetPasswordText');
            const btnLoading = document.getElementById('resetPasswordLoading');

            setButtonLoading(btn, btnText, btnLoading, true);
            clearError('passwordError');
            clearError('confirmPasswordError');

            try {
                const response = await fetch('/api/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        email: userEmail, 
                        password, 
                        password_confirmation: confirmPassword 
                    })
                });

                const data = await response.json();

                if (data.success) {
                    goToStep('success');
                    showNotification('Password reset successfully!', 'success');
                } else {
                    showError('passwordError', data.message || 'Failed to reset password');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('passwordError', 'Network error. Please try again.');
            } finally {
                setButtonLoading(btn, btnText, btnLoading, false);
            }
        }

        // OTP input handling
        function setupOtpInputs() {
            const inputs = document.querySelectorAll('.otp-input');
            
            inputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    
                    // Only allow numbers
                    if (!/^\d*$/.test(value)) {
                        e.target.value = '';
                        return;
                    }
                    
                    // Move to next input
                    if (value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                    
                    // Auto-submit when all filled
                    if (index === inputs.length - 1 && value) {
                        const otp = getOtpValue();
                        if (otp.length === 6) {
                            document.getElementById('otpForm').dispatchEvent(new Event('submit'));
                        }
                    }
                });
                
                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
                
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const paste = e.clipboardData.getData('text');
                    const digits = paste.replace(/\D/g, '').slice(0, 6);
                    
                    digits.split('').forEach((digit, i) => {
                        if (inputs[i]) {
                            inputs[i].value = digit;
                        }
                    });
                    
                    if (digits.length === 6) {
                        document.getElementById('otpForm').dispatchEvent(new Event('submit'));
                    }
                });
            });
        }

        function getOtpValue() {
            const inputs = document.querySelectorAll('.otp-input');
            return Array.from(inputs).map(input => input.value).join('');
        }

        function clearOtpInputs() {
            document.querySelectorAll('.otp-input').forEach(input => {
                input.value = '';
            });
            document.getElementById('otp1').focus();
        }

        // Password toggles
        function setupPasswordToggles() {
            document.getElementById('toggleNewPassword').addEventListener('click', function() {
                togglePasswordVisibility('newPassword', this);
            });
            
            document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
                togglePasswordVisibility('confirmPassword', this);
            });
        }

        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength
        function setupPasswordStrength() {
            document.getElementById('newPassword').addEventListener('input', function() {
                const password = this.value;
                const strengthFill = document.getElementById('strengthFill');
                const strengthText = document.getElementById('strengthText');
                
                let strength = 0;
                let strengthLabel = '';
                
                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/)) strength++;
                if (password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;
                
                strengthFill.className = 'strength-fill';
                
                switch (strength) {
                    case 0:
                    case 1:
                        strengthFill.classList.add('strength-weak');
                        strengthLabel = 'Weak';
                        break;
                    case 2:
                        strengthFill.classList.add('strength-fair');
                        strengthLabel = 'Fair';
                        break;
                    case 3:
                    case 4:
                        strengthFill.classList.add('strength-good');
                        strengthLabel = 'Good';
                        break;
                    case 5:
                        strengthFill.classList.add('strength-strong');
                        strengthLabel = 'Strong';
                        break;
                }
                
                strengthText.textContent = password.length > 0 ? `Password strength: ${strengthLabel}` : 'Password strength';
            });
        }

        // Timer functions
        function startTimer() {
            timeLeft = 600; // 10 minutes
            document.getElementById('resendBtn').disabled = true;
            
            otpTimer = setInterval(() => {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                
                document.getElementById('timeLeft').textContent = 
                    `${minutes}:${seconds.toString().padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(otpTimer);
                    document.getElementById('timer').classList.add('expired');
                    document.getElementById('timeLeft').textContent = 'Expired';
                    document.getElementById('resendBtn').disabled = false;
                    showError('otpError', 'Verification code has expired. Please request a new one.');
                }
                
                timeLeft--;
            }, 1000);
        }

        // Resend OTP
        async function resendOtp() {
            const btn = document.getElementById('resendBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';
            
            try {
                const response = await fetch('/api/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email: userEmail })
                });

                const data = await response.json();

                if (data.success) {
                    clearOtpInputs();
                    clearError('otpError');
                    document.getElementById('timer').classList.remove('expired');
                    startTimer();
                    showNotification('New verification code sent!', 'success');
                } else {
                    showError('otpError', data.message || 'Failed to resend code');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('otpError', 'Network error. Please try again.');
            } finally {
                btn.innerHTML = '<i class="fas fa-redo mr-2"></i>Resend Code';
            }
        }

        // Navigation functions
        function goToStep(step) {
            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            
            // Update step indicators
            document.querySelectorAll('.step').forEach(el => {
                el.classList.remove('active', 'completed');
                el.classList.add('inactive');
            });
            
            if (step === 'success') {
                document.getElementById('successStep').classList.remove('hidden');
                document.querySelectorAll('.step').forEach(el => el.classList.add('completed'));
                document.getElementById('backBtn').classList.add('hidden');
            } else {
                currentStep = step;
                document.getElementById(`step${step}`).classList.remove('hidden');
                
                // Update indicators
                for (let i = 1; i <= 3; i++) {
                    const indicator = document.getElementById(`step${i}Indicator`);
                    if (i < step) {
                        indicator.classList.add('completed');
                    } else if (i === step) {
                        indicator.classList.add('active');
                    } else {
                        indicator.classList.add('inactive');
                    }
                }
                
                // Show/hide back button
                if (step > 1) {
                    document.getElementById('backBtn').classList.remove('hidden');
                } else {
                    document.getElementById('backBtn').classList.add('hidden');
                }
            }
        }

        function goBack() {
            if (currentStep > 1) {
                if (currentStep === 2) {
                    clearInterval(otpTimer);
                }
                goToStep(currentStep - 1);
            }
        }

        // Utility functions
        function setButtonLoading(btn, textEl, loadingEl, loading) {
            btn.disabled = loading;
            if (loading) {
                textEl.classList.add('hidden');
                loadingEl.classList.remove('hidden');
            } else {
                textEl.classList.remove('hidden');
                loadingEl.classList.add('hidden');
            }
        }

        function showError(elementId, message) {
            const errorEl = document.getElementById(elementId);
            errorEl.textContent = message;
            errorEl.classList.remove('hidden');
        }

        function clearError(elementId) {
            const errorEl = document.getElementById(elementId);
            errorEl.classList.add('hidden');
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm ${
                type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            } text-white`;
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }
    </script>
</body>
</html>