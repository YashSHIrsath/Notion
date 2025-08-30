<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
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
                    <h1 class="app-title">Notion</h1>
                    <div class="welcome-message">Welcome, <span class="user-name-highlight">{{ ucwords(Auth::user()->name) }}</span></div>
                </div>

                <div class="header-actions">
                    <form action="{{ route('tasks.index') }}" method="GET" class="search-form">
                        <input type="text" name="search" placeholder="Search tasks..." value="{{ $search }}" class="search-input">
                        <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                    </form>
                    
                    <a href="/dashboard" class="create-btn" style="background:transparent;border:1px solid rgba(255,255,255,0.12);">
                        <span class="create-icon"><i class="fas fa-home"></i></span>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('tasks.create') }}" class="create-btn">
                        <span class="create-icon"><i class="fas fa-plus"></i></span>
                        <span>New Task</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <span class="logout-icon"><i class="fas fa-sign-out-alt"></i></span>
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
            <div class="sort-container">
                <form action="{{ route('tasks.index') }}" method="GET" class="sort-form">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <select name="sort" class="sort-select" onchange="this.form.submit()">
                        <option value="due_date_asc" {{ request('sort') == 'due_date_asc' ? 'selected' : '' }}>📅 Due Date ↑</option>
                        <option value="due_date_desc" {{ request('sort') == 'due_date_desc' ? 'selected' : '' }}>📅 Due Date ↓</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>📝 Title A-Z</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>📝 Title Z-A</option>
                        <option value="created_asc" {{ request('sort') == 'created_asc' ? 'selected' : '' }}>📆 Created ↑</option>
                        <option value="created_desc" {{ request('sort') == 'created_desc' ? 'selected' : '' }}>📆 Created ↓</option>
                    </select>
                </form>
            </div>
            <div class="tasks-container">
                @forelse ($tasks as $task)
                    @php
                        $isOverdue = \Carbon\Carbon::parse($task->due_date)->isPast() && \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') < date('Y-m-d');
                        $daysRemaining = ceil(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($task->due_date), false));
                        $daysRemainingClass = $daysRemaining < 0 ? 'overdue' : ($daysRemaining <= 3 ? 'urgent' : ($daysRemaining <= 7 ? 'warning' : 'safe'));
                    @endphp
                    <article class="task-item priority-{{ $task->priority }} {{ $isOverdue ? 'overdue collapsed' : '' }}" data-task-id="{{ $task->id }}">
                        @if($isOverdue)
                            <div class="overdue-bar" onclick="toggleOverdueTask({{ $task->id }})">
                                <div class="overdue-bar-content">
                                    <span class="overdue-bar-title">{{ ucfirst($task->title) }}</span>
                                    <span class="overdue-bar-date">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
                                    <span class="overdue-expand-icon"><i class="fas fa-chevron-down"></i></span>
                                </div>
                            </div>
                        @endif
                        <div class="task-header {{ $isOverdue ? 'task-content' : '' }}">
                            <div class="task-title-section">
                                <span class="task-id">{{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y') }}</span>
                                <h3 class="task-title">{{ ucfirst($task->title) }}</h3>
                            </div>
                            @if ($task->status == 1)
                                <span class="status completed"><i class="fas fa-check"></i></span>
                            @elseif($task->status == 0)
                                <span class="status in-progress"><i class="fas fa-clock"></i></span>
                            @elseif($task->status == -1)
                                <span class="status pending"><i class="fas fa-pause"></i></span>
                            @else
                                <span class="status unknown"><i class="fas fa-question"></i></span>
                            @endif
                        </div>
                        
                        @if($isOverdue && $task->status != 1)
                            <div class="overdue-message">
                                <span class="overdue-icon"><i class="fas fa-exclamation-triangle"></i></span>
                                <span class="overdue-text">Task was not completed by due date</span>
                            </div>
                        @endif

                        <div class="task-meta {{ $isOverdue ? 'task-content' : '' }}">
                            <div class="meta-item due-date-highlight">
                                <span class="meta-icon"><i class="fas fa-calendar-alt"></i></span>
                                <span class="meta-label">Due:</span>
                                <span class="meta-value">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="meta-item priority-highlight">
                                <span class="priority-badge priority-{{ $task->priority }}">{{ ucfirst($task->priority) }} Priority</span>
                            </div>
                            <div class="meta-item category-highlight">
                                <span class="category-badge">{{ $task->category }}</span>
                            </div>
                            <div class="meta-item days-remaining-highlight">
                                <span class="days-remaining-badge {{ $daysRemainingClass }}">
                                    @if($daysRemaining < 0)
                                        {{ abs(ceil($daysRemaining)) }} days overdue
                                    @elseif($daysRemaining == 0)
                                        Due today
                                    @elseif($daysRemaining == 1)
                                        1 day left
                                    @else
                                        {{ ceil($daysRemaining) }} days left
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div class="task-description-section {{ $isOverdue ? 'task-content' : '' }}">
                            <pre class="task-description">{{ ucfirst($task->description) }}</pre>
                        </div>
                        
                        <div class="task-footer {{ $isOverdue ? 'task-content' : '' }}">
                            @if($isOverdue)
                                <button class="collapse-btn" onclick="toggleOverdueTask({{ $task->id }})">
                                    <span><i class="fas fa-chevron-up"></i></span>
                                    <span>Collapse</span>
                                </button>
                            @endif
                            <div class="task-actions">
                                @if(!$isOverdue)
                                    <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-view"><i class="fas fa-eye"></i> View</a>
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                @endif
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="delete-form">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this task?')"><i class="fas fa-trash"></i> Delete{{ $isOverdue ? ' Task' : '' }}</button>
                                </form>
                            </div>
                            
                            <button class="complete-btn {{ $isOverdue ? '' : 'full-width' }}">
                                @if($task->status == 1)
                                    ❌ Not Complete
                                @else
                                    ✅ Mark Complete
                                @endif
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <h3>No tasks yet</h3>
                        <p>Create your first task to get started</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">✨ Create Task</a>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</body>

<script src="{{ asset('js/custom.js')  }}"></script>
<script>
function toggleOverdueTask(taskId) {
    const taskItem = document.querySelector(`[data-task-id="${taskId}"]`);
    if (taskItem.classList.contains('collapsed')) {
        taskItem.classList.remove('collapsed');
        taskItem.classList.add('expanded');
    } else {
        taskItem.classList.remove('expanded');
        taskItem.classList.add('collapsed');
    }
}
</script>

</html>
