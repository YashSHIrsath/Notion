<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/business-tasks.css') }}">
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="header-content">
                <h1 class="app-title">Edit Task <span class="title-date">{{ $task->created_at->format('M d, Y') }}</span></h1>
                <div class="header-actions">
                    <a href="{{ route('tasks.show', $task->id) }}" class="nav-btn">
                        <i class="fas fa-eye"></i>
                        <span>View</span>
                    </a>
                    <a href="{{ route('tasks.index') }}" class="nav-btn nav-btn-outline">
                        <i class="fas fa-arrow-left"></i>
                        <span>Tasks</span>
                    </a>
                    <a href="/dashboard" class="nav-btn nav-btn-outline">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
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
                                    <option value="-1" {{ $task->status == -1 ? 'selected' : '' }}><i class="fas fa-pause"></i> Pending</option>
                                    <option value="0" {{ $task->status == 0 ? 'selected' : '' }}><i class="fas fa-spinner"></i> In Progress</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select name="priority" id="priority" required>
                                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}><i class="fas fa-circle" style="color: #10b981;"></i> Low</option>
                                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}><i class="fas fa-circle" style="color: #f59e0b;"></i> Medium</option>
                                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}><i class="fas fa-circle" style="color: #ef4444;"></i> High</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" onchange="toggleCustomCategory()" required>
                                    <option value="Casual" {{ $task->category == 'Casual' ? 'selected' : '' }}>Casual</option>
                                    <option value="Business" {{ $task->category == 'Business' ? 'selected' : '' }}>Business</option>
                                    <option value="Fun" {{ $task->category == 'Fun' ? 'selected' : '' }}>Fun</option>
                                    @if(!in_array($task->category, ['Casual', 'Business', 'Fun']))
                                        <option value="{{ $task->category }}" selected>{{ $task->category }}</option>
                                    @endif
                                    <option value="custom">+ Add Custom Category</option>
                                </select>
                                <input type="text" name="custom_category" id="custom_category" placeholder="Enter custom category" style="display:none;margin-top:0.5rem;">
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
                            <i class="fas fa-save"></i>
                            Update Task
                        </button>
                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-secondary">
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