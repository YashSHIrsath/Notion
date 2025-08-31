<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Task Manager</title>
    <link rel="stylesheet" href="{{ asset('css/business-tasks.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .auth-card {
            background: var(--card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 2rem;
            padding: 4rem;
            width: 100%;
            max-width: 600px;
            box-shadow: var(--shadow-lg);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: slideInUp 0.8s ease-out;
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .auth-card:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 30px 60px -12px rgba(59, 130, 246, 0.15), 0 18px 36px -18px rgba(0, 0, 0, 0.3);
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .company-name {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            margin: 0 0 0.5rem;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
        }
        
        .auth-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--text);
            margin: 0 0 0.5rem;
        }
        
        .auth-subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin: 0;
        }
        
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        
        .form-field {
            position: relative;
            animation: fadeInLeft 0.6s ease-out;
            animation-fill-mode: both;
        }
        
        .form-field:nth-child(1) { animation-delay: 0.1s; }
        .form-field:nth-child(2) { animation-delay: 0.2s; }
        .form-field:nth-child(3) { animation-delay: 0.3s; }
        .form-field:nth-child(4) { animation-delay: 0.4s; }
        .form-field:nth-child(5) { animation-delay: 0.5s; }
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .form-field input {
            width: 100%;
            padding: 1.25rem 1.25rem 1.25rem 3.5rem;
            border: 1px solid var(--border);
            border-radius: 2rem;
            background: rgba(255, 255, 255, 0.9);
            color: var(--text);
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        

        
        .form-field input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15), 0 8px 25px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px) scale(1.02);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .form-field input::placeholder {
            color: var(--text-muted);
            opacity: 0.7;
        }
        
        .form-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.25rem;
            pointer-events: none;
            transition: all 0.3s ease;
        }
        
        .form-field input:focus + .form-icon,
        .form-field:focus-within .form-icon {
            color: var(--primary);
            transform: translateY(-50%) scale(1.1);
        }
        
        .register-btn {
            width: 100%;
            padding: 1.25rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            border: none;
            border-radius: 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.6s ease-out 0.6s both;
        }
        
        .register-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .register-btn:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 15px 35px rgba(59, 130, 246, 0.4), 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .register-btn:hover::before {
            left: 100%;
        }
        
        .register-btn:active {
            transform: translateY(0);
        }
        
        .error-message {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 1.5rem;
            padding: 1.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 1.5rem;
            animation: shake 0.5s ease-in-out;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .error-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .error-list li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .error-list li:last-child {
            margin-bottom: 0;
        }
        
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
        }
        
        .auth-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .auth-link:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }
        
        @media (prefers-color-scheme: dark) {
            .form-field input {
                background: rgba(255, 255, 255, 0.05);
                border-color: var(--border);
                color: var(--text);
            }
            
            .form-field input:focus {
                background: rgba(255, 255, 255, 0.1);
            }
        }
        
        @media (max-width: 480px) {
            .auth-container {
                padding: 1rem;
            }
            
            .auth-card {
                padding: 2.5rem;
                max-width: 90vw;
            }
            
            .auth-form {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .form-field:nth-child(5),
            .form-field:nth-child(6) {
                grid-column: 1;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="company-name">Notion</div>
                <h1 class="auth-title">Create Account</h1>
                <p class="auth-subtitle">Join your very own Task Manager</p>
            </div>
            
            <form method="POST" action="/register" class="auth-form">
                @csrf
                
                <div class="form-field">
                    <input type="text" name="name" placeholder="Enter your full name" required value="{{ old('name') }}">
                    <i class="fas fa-user form-icon"></i>
                </div>
                
                <div class="form-field">
                    <input type="email" name="email" placeholder="Enter your email" required value="{{ old('email') }}">
                    <i class="fas fa-envelope form-icon"></i>
                </div>
                
                <div class="form-field">
                    <input type="password" name="password" placeholder="Create a password" required>
                    <i class="fas fa-lock form-icon"></i>
                </div>
                
                <div class="form-field">
                    <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
                    <i class="fas fa-key form-icon"></i>
                </div>
                
                <div class="form-field">
                    <button type="submit" class="register-btn">
                        <i class="fas fa-user-plus"></i>
                        <span>Create Account</span>
                    </button>
                </div>
            </form>
            
            @if($errors->any())
                <div class="error-message">
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>{{ $error }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <div class="auth-footer">
                <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0;">
                    Already have an account? 
                    <a href="/login" class="auth-link">Sign in here</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
