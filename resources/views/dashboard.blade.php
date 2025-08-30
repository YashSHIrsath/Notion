<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Task Manager</title>
    <link rel="stylesheet" href="{{ asset('css/business-tasks.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Baumans&family=Playwrite+DE+Grund:wght@100..400&display=swap');
        .dashboard-hero {
            background: var(--card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 3rem;
            margin: 2rem auto;
            max-width: 900px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.1), 0 4px 25px -5px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
        }
        
        .dashboard-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.8s;
        }
        
        .dashboard-hero:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 20px 60px -10px rgba(59, 130, 246, 0.2), 0 8px 40px -5px rgba(0, 0, 0, 0.15);
        }
        
        .dashboard-hero:hover::before {
            left: 100%;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            justify-content: center;
        }
        
        .profile-image {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--primary);
            box-shadow: var(--shadow);
        }
        
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            font-weight: 600;
        }
        
        .profile-image img {
            transition: var(--transition);
        }
        
        .profile-image img:hover {
            transform: scale(1.05);
        }
        
        .profile-info {
            text-align: left;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .hero-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--text);
            margin: 0 0 0.5rem 0;
            line-height: 1.2;
        }
        
        .user-email {
            color: var(--text-muted);
            font-size: 1rem;
            margin: 0;
            font-weight: 500;
        }
        
        .user-name-highlight-dashboard {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 600;
            font-family: "Playwrite DE Grund", cursive;
        }
        
        .user-email-highlight-dashboard {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 500;
            font-family: "Playwrite DE Grund", cursive;
        }
        

        
        .hero-subtitle {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin: 0 0 2.5rem;
            font-weight: 500;
            line-height: 1.5;
        }
        
        .hero-actions {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .hero-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            border-radius: 2rem;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            box-shadow: var(--shadow);
            min-width: 180px;
            justify-content: center;
        }
        
        .hero-btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .hero-btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }
        
        .hero-btn-secondary {
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border: 1px solid rgba(13, 110, 253, 0.2);
        }
        
        .hero-btn-secondary:hover {
            background: #0d6efd;
            color: white;
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }
        
        @media (max-width: 768px) {
            .dashboard-hero {
                padding: 2rem;
                margin: 1rem;
            }
            
            .user-profile {
                flex-direction: column;
                text-align: center;
            }
            
            .hero-title {
                font-size: 1.875rem;
            }
            
            .hero-actions {
                flex-direction: column;
                align-items: center;
            }
            
            .hero-btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="app-title">Notion</h1>
                    <div class="welcome-message">Welcome, <span class="user-name-highlight">{{ ucwords(Auth::user()->name) }}</span></div>
                </div>

                <div class="header-actions">
                    <a href="{{ route('tasks.create') }}" class="create-btn">
                        <span class="create-icon">+</span>
                        <span>New Task</span>
                    </a>

                    @if(\App\Models\Task::where('user_id', Auth::id())->exists())
                        <a href="{{ route('tasks.index') }}" class="create-btn" style="background:transparent;border:1px solid rgba(255,255,255,0.12);">
                            <span class="create-icon">📋</span>
                            <span>All Tasks</span>
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <span class="logout-icon">⏻</span>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="notification success">{{ session('success') }}</div>
        @endif

        <main class="main-content">
            <section class="dashboard-hero">
                <div class="user-profile">
                    <div class="profile-image">
                        <div class="profile-placeholder">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                    <div class="profile-info">
                        <h2 class="hero-title"><span class="user-name-highlight-dashboard">{{ ucwords(Auth::user()->name) }}</span></h2>
                        <p class="user-email"><span class="user-email-highlight-dashboard">{{ Auth::user()->email }}</span></p>
                    </div>
                </div>
                <p class="hero-subtitle">Manage your tasks efficiently and stay organized with your personal task management system.</p>

                <div class="hero-actions">
                    <a href="{{ route('tasks.create') }}" class="hero-btn hero-btn-primary">
                        <span>✨</span>
                        <span>Create New Task</span>
                    </a>
                    @if(\App\Models\Task::where('user_id', Auth::id())->exists())
                        <a href="{{ route('tasks.index') }}" class="hero-btn hero-btn-secondary">
                            <span>📋</span>
                            <span>View All Tasks</span>
                        </a>
                    @endif
                </div>
            </section>
        </main>
    </div>
</body>
</html>
