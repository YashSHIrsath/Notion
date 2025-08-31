<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notion : Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/business-tasks.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            grid-template-rows: auto auto;
            gap: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .welcome-card {
            grid-column: 1 / -1;
            background: var(--card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 2rem;
            transition: var(--transition);
        }
        
        .welcome-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
        }
        
        .welcome-left {
            flex: 1;
        }
        
        .greeting-badge {
            display: inline-block;
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1rem;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }
        
        .welcome-left h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text);
            margin: 0 0 0.5rem 0;
            line-height: 1.1;
        }
        
        .welcome-left p {
            color: var(--text-muted);
            margin: 0;
            font-size: 1.1rem;
            line-height: 1.5;
        }
        
        .welcome-right {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
        
        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 600;
            color: white;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        }
        
        .current-time {
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 500;
            text-align: center;
        }
        
        .stats-card {
            background: var(--card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .action-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.5rem;
            border-radius: 1rem;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            border: 1px solid transparent;
        }
        
        .action-btn.primary {
            background: var(--primary);
            color: white;
        }
        
        .action-btn.primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }
        
        .action-btn.secondary {
            background: var(--surface);
            color: var(--text);
            border-color: var(--border);
        }
        
        .action-btn.secondary:hover {
            background: var(--card);
            transform: translateY(-2px);
        }
        
        .productivity-card {
            grid-column: 1 / -1;
            background: var(--card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 1.5rem;
            padding: 2rem;
            transition: var(--transition);
        }
        
        .productivity-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text);
            margin: 0 0 0.75rem 0;
        }
        
        .productivity-card p {
            color: var(--text-muted);
            margin: 0 0 1.5rem 0;
            line-height: 1.6;
        }
        
        .productivity-features {
            display: flex;
            gap: 2rem;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.875rem;
        }
        
        .feature-item i {
            color: var(--primary);
        }
        
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .welcome-content {
                flex-direction: column;
                text-align: center;
            }
            
            .welcome-text h1 {
                font-size: 1.5rem;
            }
            
            .productivity-features {
                flex-direction: column;
                gap: 1rem;
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
            <div class="dashboard-grid">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <div class="welcome-left">
                            <div class="greeting-badge">{{ date('H') < 12 ? 'Good Morning' : (date('H') < 18 ? 'Good Afternoon' : 'Good Evening') }}</div>
                            <h1>{{ ucwords(Auth::user()->name) }}</h1>
                            <p>Let's make today productive and organized</p>
                        </div>
                        <div class="welcome-right">
                            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                            <div class="current-time">{{ date('M j, Y') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="stats-card">
                    <div class="stat-item">
                        <div class="stat-number">{{ \App\Models\Task::where('user_id', Auth::id())->count() }}</div>
                        <div class="stat-label">Total Tasks</div>
                    </div>
                </div>
                
                <div class="quick-actions">
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
                </div>
                
                <div class="productivity-card">
                    <h3>Stay Productive</h3>
                    <p>Organize your workflow and achieve your goals with our intuitive task management system.</p>
                    <div class="productivity-features">
                        <div class="feature-item">
                            <i class="fas fa-bolt"></i>
                            <span>Fast & Efficient</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-mobile-alt"></i>
                            <span>Mobile Friendly</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
