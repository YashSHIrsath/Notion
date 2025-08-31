<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notion : Create Task</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <div class="app-logo">
                        <i class="fas fa-cube logo-icon"></i>
                        <h1 class="app-title">Create New Task</h1>
                    </div>
                    <div class="nav-pills">
                        <div class="nav-pill active">
                            <i class="fas fa-edit pill-icon"></i>
                            <span>New Task</span>
                        </div>
                        <div class="nav-pill-separator">•</div>
                        <div class="nav-pill">
                            <i class="fas fa-calendar-day pill-icon"></i>
                            <span>{{ date('F j, Y') }}</span>
                        </div>
                        <div class="nav-pill-separator">•</div>
                        <div class="nav-pill">
                            <i class="fas fa-clock pill-icon"></i>
                            <span id="live-time">{{ date('g:i A') }}</span>
                        </div>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('tasks.index') }}" class="nav-btn nav-btn-outline">
                        <i class="fas fa-list"></i> 
                        <span>Tasks</span>
                    </a>
                    <a href="/dashboard" class="nav-btn nav-btn-outline">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
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
                        <h2 class="section-title"><i class="fas fa-info-circle"></i> Basic Information</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="title"><i class="fas fa-tasks"></i> Task Title</label>
                                <input type="text" name="title" id="title" placeholder="Enter task title" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="description"><i class="fas fa-align-left"></i> Description</label>
                                <textarea name="description" id="description" rows="3" placeholder="Brief description of the task" required></textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="long_description"><i class="fas fa-file-alt"></i> Detailed Information</label>
                                <textarea name="long_description" id="long_description" rows="4" placeholder="Additional details, notes, or requirements" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="section-title"><i class="fas fa-cogs"></i> Task Settings</h2>
                        
                        <div class="form-row form-row-3">
                            <div class="form-group">
                                <label for="status"><i class="fas fa-tasks"></i> Status</label>
                                <select name="status" id="status" required>
                                    <option value="-1">⏸ Pending</option>
                                    <option value="0">⟳ In Progress</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="priority"><i class="fas fa-flag"></i> Priority</label>
                                <select name="priority" id="priority" required>
                                    <option value="low" style="color: #10b981;">● Low</option>
                                    <option value="medium" style="color: #f59e0b;">● Medium</option>
                                    <option value="high" style="color: #ef4444;">● High</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category"><i class="fas fa-tags"></i> Category</label>
                                <select name="category" id="category" onchange="toggleCustomCategory()" required>
                                    <option value="Casual">☕ Casual</option>
                                    <option value="Business">💼 Business</option>
                                    <option value="Fun">🎮 Fun</option>
                                    <option value="custom">+ Add Custom Category</option>
                                </select>
                                <input type="text" name="custom_category" id="custom_category" placeholder="Enter custom category" style="display:none;margin-top:0.5rem;">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="due_date"><i class="fas fa-calendar-alt"></i> Due Date</label>
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
                            <i class="fas fa-check"></i>
                            Create Task
                        </button>
                        <br>
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i>
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

function toggleCustomCategory() {
    const categorySelect = document.getElementById('category');
    const customInput = document.getElementById('custom_category');
    
    if (categorySelect.value === 'custom') {
        customInput.style.display = 'block';
        customInput.required = true;
        categorySelect.name = '';
        customInput.name = 'category';
    } else {
        customInput.style.display = 'none';
        customInput.required = false;
        categorySelect.name = 'category';
        customInput.name = 'custom_category';
    }
}
</script>
</html>