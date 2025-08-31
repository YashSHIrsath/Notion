<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notion : Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/business-tasks.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baumans&family=Playwrite+DE+Grund:wght@100..400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="header-content">
                <div class="header-left">
                    <div class="app-logo">
                        <i class="fas fa-cube logo-icon"></i>
                        <h1 class="app-title">Notion</h1>
                    </div>
                    <div class="welcome-message">Welcome, <span class="user-name-highlight">{{ ucwords(Auth::user()->name) }}</span></div>
                </div>

                <div class="header-actions">
                    <a href="{{ route('tasks.create') }}" class="nav-btn">
                        <i class="fas fa-plus"></i>
                        <span>Create</span>
                    </a>

                    @if(\App\Models\Task::where('user_id', Auth::id())->exists())
                        <a href="{{ route('tasks.index') }}" class="nav-btn nav-btn-outline">
                            <i class="fas fa-list"></i>
                            <span>Tasks</span>
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="nav-btn nav-btn-danger">
                            <i class="fas fa-sign-out-alt"></i>
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
            <div class="dashboard">
                <div class="dashboard-hero">
                    <div class="hero-content">
                        <h1 class="hero-title">
                            @php
                                $hour = date('H');
                                $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
                            @endphp
                            {{ $greeting }}, {{ ucfirst(explode(' ', Auth::user()->name)[0]) }}!
                        </h1>
                        <p class="hero-subtitle">Ready to conquer your goals? Let's make today productive!</p>
                        <div class="hero-stats">
                            <div class="mini-stat">
                                <span class="mini-number">{{ date('d') }}</span>
                                <span class="mini-label">{{ date('M') }}</span>
                            </div>
                            <div class="mini-stat">
                                <span class="mini-number">{{ \App\Models\Task::where('user_id', Auth::id())->count() }}</span>
                                <span class="mini-label">Tasks</span>
                            </div>
                            <div class="mini-stat">
                                <span class="mini-number">{{ date('H:i') }}</span>
                                <span class="mini-label">Time</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero-visual">
                        <div class="floating-card card-1"></div>
                        <div class="floating-card card-2"></div>
                        <div class="floating-card card-3"></div>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <div class="grid-item quick-actions">
                        <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                        <div class="action-buttons">
                            <a href="{{ route('tasks.create') }}" class="action-btn primary">
                                <i class="fas fa-plus"></i>
                                <span>New Task</span>
                            </a>
                            @if(\App\Models\Task::where('user_id', Auth::id())->exists())
                                <a href="{{ route('tasks.index') }}" class="action-btn secondary">
                                    <i class="fas fa-list"></i>
                                    <span>View Tasks</span>
                                </a>
                            @endif
                            <button class="action-btn tertiary" onclick="showTip()">
                                <i class="fas fa-lightbulb"></i>
                                <span>Daily Tip</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid-item productivity-meter">
                        <h3><i class="fas fa-chart-line"></i> Productivity</h3>
                        <div class="meter-container">
                            <div class="circular-progress" data-percentage="75">
                                <div class="progress-circle">
                                    <div class="progress-text">75%</div>
                                </div>
                            </div>
                            <p class="meter-label">Today's Focus</p>
                        </div>
                    </div>

                    <div class="grid-item weather-widget">
                        <h3><i class="fas fa-cloud-sun"></i> Today's Vibe</h3>
                        <div class="weather-content">
                            <div class="weather-icon">☀️</div>
                            <div class="weather-info">
                                <span class="weather-temp">Perfect</span>
                                <span class="weather-desc">Great day to be productive!</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid-item motivational-quote">
                        <h3><i class="fas fa-quote-left"></i> Daily Inspiration</h3>
                        <div class="quote-content">
                            <p class="quote-text">"The way to get started is to quit talking and begin doing."</p>
                            <span class="quote-author">- Walt Disney</span>
                        </div>
                    </div>

                    <div class="grid-item recent-activity">
                        <h3><i class="fas fa-history"></i> Activity Feed</h3>
                        <div class="activity-list">
                            <div class="activity-item">
                                <i class="fas fa-user-plus activity-icon"></i>
                                <span>Welcome to Notion! 🎉</span>
                            </div>
                            <div class="activity-item">
                                <i class="fas fa-star activity-icon"></i>
                                <span>Ready to boost productivity</span>
                            </div>
                            <div class="activity-item">
                                <i class="fas fa-rocket activity-icon"></i>
                                <span>Let's achieve great things!</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid-item shortcuts">
                        <h3><i class="fas fa-keyboard"></i> Quick Tips</h3>
                        <div class="shortcuts-list">
                            <div class="shortcut-item">
                                <kbd>Ctrl</kbd> + <kbd>N</kbd>
                                <span>New Task</span>
                            </div>
                            <div class="shortcut-item">
                                <kbd>Ctrl</kbd> + <kbd>L</kbd>
                                <span>Task List</span>
                            </div>
                            <div class="shortcut-item">
                                <kbd>Ctrl</kbd> + <kbd>D</kbd>
                                <span>Dashboard</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
        .dashboard {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .dashboard-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 3rem;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(16, 185, 129, 0.1));
            border-radius: 2rem;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            flex: 1;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin: 0 0 1rem 0;
            background: linear-gradient(135deg, #3b82f6, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--text-muted);
            margin: 0 0 2rem 0;
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
        }

        .mini-stat {
            text-align: center;
        }

        .mini-number {
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .mini-label {
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .hero-visual {
            position: relative;
            width: 200px;
            height: 200px;
        }

        .floating-card {
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 1rem;
            animation: float 3s ease-in-out infinite;
        }

        .card-1 {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            top: 20px;
            left: 20px;
            animation-delay: 0s;
        }

        .card-2 {
            background: linear-gradient(135deg, #10b981, #059669);
            top: 60px;
            right: 20px;
            animation-delay: 1s;
        }

        .card-3 {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            bottom: 20px;
            left: 50px;
            animation-delay: 2s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
        }

        .grid-item {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .grid-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .grid-item h3 {
            margin: 0 0 1.5rem 0;
            color: var(--text);
            font-size: 1.2rem;
            font-weight: 600;
        }

        .grid-item h3 i {
            margin-right: 0.5rem;
            color: var(--primary);
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-radius: 1rem;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .action-btn.primary {
            background: var(--primary);
            color: white;
        }

        .action-btn.secondary {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
        }

        .action-btn.tertiary {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .action-btn:hover {
            transform: translateX(5px);
        }

        .circular-progress {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 1rem;
        }

        .progress-circle {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: conic-gradient(var(--primary) 270deg, #e5e7eb 270deg);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .progress-circle::before {
            content: '';
            position: absolute;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--card);
        }

        .progress-text {
            position: relative;
            z-index: 1;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .meter-label {
            text-align: center;
            color: var(--text-muted);
            margin: 0;
        }

        .weather-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .weather-icon {
            font-size: 3rem;
        }

        .weather-temp {
            display: block;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text);
        }

        .weather-desc {
            color: var(--text-muted);
        }

        .quote-text {
            font-style: italic;
            font-size: 1.1rem;
            color: var(--text);
            margin: 0 0 1rem 0;
            line-height: 1.6;
        }

        .quote-author {
            color: var(--text-muted);
            font-weight: 600;
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            background: rgba(59, 130, 246, 0.05);
            border-radius: 0.75rem;
        }

        .activity-icon {
            color: var(--primary);
            width: 20px;
        }

        .shortcuts-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .shortcut-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        kbd {
            background: var(--border);
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .dashboard-hero {
                flex-direction: column;
                text-align: center;
                padding: 2rem;
            }

            .hero-visual {
                margin-top: 2rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <script>
        function showTip() {
            const tips = [
                "Break large tasks into smaller, manageable chunks! 🧩",
                "Use the Pomodoro Technique: 25 minutes work, 5 minutes break! ⏰",
                "Prioritize your tasks using the Eisenhower Matrix! 📊",
                "Take regular breaks to maintain focus and productivity! ☕",
                "Set specific, measurable goals for better results! 🎯"
            ];
            const randomTip = tips[Math.floor(Math.random() * tips.length)];
            alert(randomTip);
        }
    </script>
</body>
</html>