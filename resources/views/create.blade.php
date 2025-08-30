<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Task</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/business-tasks.css') }}">
    <style>
        .nav-pills {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-top: 0.75rem;
            flex-wrap: wrap;
        }
        
        .nav-pill {
            background: var(--surface);
            color: var(--text-muted);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid var(--border);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        
        .nav-pill.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .nav-pill-separator {
            color: var(--text-muted);
            opacity: 0.5;
            font-size: 0.75rem;
        }
        
        .pill-icon {
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="app-title">Create New Task</h1>
                    <div class="nav-pills">
                        <div class="nav-pill active">
                            <span class="pill-icon">📝</span>
                            <span>New Task</span>
                        </div>
                        <div class="nav-pill-separator">•</div>
                        <div class="nav-pill">
                            <span class="pill-icon">📅</span>
                            <span>{{ date('F j, Y') }}</span>
                        </div>
                        <div class="nav-pill-separator">•</div>
                        <div class="nav-pill">
                            <span class="pill-icon">⏰</span>
                            <span id="live-time">{{ date('g:i A') }}</span>
                        </div>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('tasks.index') }}" class="create-btn">
                        <span class="create-icon">←</span>
                        <span>Back to Tasks</span>
                    </a>
                    <a href="/dashboard" class="create-btn" style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);">
                        <span class="create-icon">🏠</span>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="notification success">{{ session('success') }}</div>
        @endif
        
        <main class="main-content">
            <div class="form-wrapper">
                <form action="{{ route('tasks.store') }}" method="POST" class="task-form">
                    @csrf
                    
                    <div class="form-section">
                        <h2 class="section-title">Basic Information</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="title">Task Title</label>
                                <input type="text" name="title" id="title" placeholder="Enter task title" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3" placeholder="Brief description of the task" required></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="long_description">Detailed Information</label>
                                <textarea name="long_description" id="long_description" rows="4" placeholder="Additional details, notes, or requirements" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="section-title">Task Settings</h2>
                        
                        <div class="form-row form-row-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" required>
                                    <option value="-1">⏸ Pending</option>
                                    <option value="0">⏳ In Progress</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select name="priority" id="priority" required>
                                    <option value="low">🟢 Low</option>
                                    <option value="medium">🟡 Medium</option>
                                    <option value="high">🔴 High</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" required>
                                    <option value="Casual">Casual</option>
                                    <option value="Business">Business</option>
                                    <option value="Fun">Fun</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="due_date">Due Date</label>
                                <div class="date-input-wrapper">
                                    <input type="date" name="due_date" id="due_date" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+5 years')) }}" required>
                                    <div class="quick-date-buttons">
                                        <button type="button" class="quick-date-btn" data-days="0">Today</button>
                                        <button type="button" class="quick-date-btn" data-days="1">Tomorrow</button>
                                        <button type="button" class="quick-date-btn" data-days="7">Next Week</button>
                                        <button type="button" class="quick-date-btn" data-days="30">Next Month</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <span>✓</span>
                            Create Task
                        </button>
                        <br>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <span>✕</span>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quickDateBtns = document.querySelectorAll('.quick-date-btn');
    const dueDateInput = document.getElementById('due_date');
    
    function updateActiveButton() {
        const currentValue = dueDateInput.value;
        const today = new Date();
        
        quickDateBtns.forEach(btn => {
            const days = parseInt(btn.getAttribute('data-days'));
            const targetDate = new Date();
            targetDate.setDate(today.getDate() + days);
            const targetDateStr = targetDate.toISOString().split('T')[0];
            
            if (currentValue === targetDateStr) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }
    
    quickDateBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const days = parseInt(this.getAttribute('data-days'));
            const date = new Date();
            date.setDate(date.getDate() + days);
            
            const formattedDate = date.toISOString().split('T')[0];
            dueDateInput.value = formattedDate;
            
            updateActiveButton();
        });
    });
    
    // Update active button when date input changes manually
    dueDateInput.addEventListener('change', updateActiveButton);
    
    // Initial check
    updateActiveButton();
    
    // Update time every second
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        });
        document.getElementById('live-time').textContent = timeString;
    }
    
    setInterval(updateTime, 1000);
});
</script>
</html>