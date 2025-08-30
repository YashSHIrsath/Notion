<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/business-tasks.css') }}">
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="header-content">
                <h1 class="app-title">Edit Task <span class="title-date">{{ $task->created_at->format('M d, Y') }}</span></h1>
                <div class="header-actions">
                    <a href="{{ route('tasks.show', $task->id) }}" class="create-btn btn-view-header">
                        <span class="create-icon">👁️</span>
                        <span>View Task</span>
                    </a>
                    <a href="{{ route('tasks.index') }}" class="create-btn">
                        <span class="create-icon">←</span>
                        <span>Back to task</span>
                    </a>
                </div>
            </div>
        </header>
        
        <main class="main-content">
            <div class="form-wrapper">
                <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="task-form">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section">
                        <h2 class="section-title">Basic Information</h2>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="title">Task Title</label>
                                <input type="text" name="title" id="title" value="{{ $task->title }}" placeholder="Enter task title" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3" placeholder="Brief description of the task" required>{{ $task->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="long_description">Detailed Information</label>
                                <textarea name="long_description" id="long_description" rows="4" placeholder="Additional details, notes, or requirements" required>{{ $task->long_description }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="section-title">Task Settings</h2>
                        
                        <div class="form-row form-row-3">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" required>
                                    <option value="-1" {{ $task->status == -1 ? 'selected' : '' }}>⏸ Pending</option>
                                    <option value="0" {{ $task->status == 0 ? 'selected' : '' }}>⏳ In Progress</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select name="priority" id="priority" required>
                                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>🟢 Low</option>
                                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>🔴 High</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" required>
                                    <option value="Casual" {{ $task->category == 'Casual' ? 'selected' : '' }}>Casual</option>
                                    <option value="Business" {{ $task->category == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Fun" {{ $task->category == 'Fun' ? 'selected' : '' }}>Fun</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="due_date">Due Date</label>
                                <div class="date-input-wrapper">
                                    <input type="date" name="due_date" id="due_date" value="{{ $task->due_date }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+5 years')) }}" required>
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
                            <span>💾</span>
                            Update Task
                        </button>
                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-secondary">
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
});
</script>
</html>