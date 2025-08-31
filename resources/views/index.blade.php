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
                        <input type="text" name="search" placeholder="Search..." value="{{ $search }}" class="search-input">
                        <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                    </form>

                    <a href="/dashboard" class="nav-btn nav-btn-outline">
                        <i class="fas fa-home"></i>
                        <span>Home</span>
                    </a>

                    <a href="{{ route('tasks.create') }}" class="nav-btn">
                        <i class="fas fa-plus"></i>
                        <span>Create</span>
                    </a>

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
            <div class="sort-container">
                <form action="{{ route('tasks.index') }}" method="GET" class="sort-form">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <select name="sort" class="sort-select" onchange="this.form.submit()">
                        <option value="due_date_asc" {{ request('sort') == 'due_date_asc' ? 'selected' : '' }}><i class="fas fa-calendar-alt"></i> Due Date △</option>
                        <option value="due_date_desc" {{ request('sort') == 'due_date_desc' ? 'selected' : '' }}><i class="fas fa-calendar-alt"></i> Due Date ▽</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}><i class="fas fa-sort-alpha-down"></i> Title A-Z</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}><i class="fas fa-sort-alpha-up"></i> Title Z-A</option>
                        <option value="created_asc" {{ request('sort') == 'created_asc' ? 'selected' : '' }}><i class="fas fa-calendar-plus"></i> Created △</option>
                        <option value="created_desc" {{ request('sort') == 'created_desc' ? 'selected' : '' }}><i class="fas fa-calendar-plus"></i> Created ▽</option>
                    </select>
                </form>
            </div>
            <div class="tasks-container">
                @forelse ($tasks as $task)
                    @php
                        $isOverdue = \Carbon\Carbon::parse($task->due_date)->isPast() && \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') < date('Y-m-d');
                        $daysRemaining = ceil(\Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($task->due_date), false));
                        $daysRemainingClass = $daysRemaining < 0 ? 'overdue' : ($daysRemaining <= 1 ? 'urgent' : ($daysRemaining <= 3 ? 'warning' : 'safe'));
                    @endphp
                    <article class="task-item priority-{{ $task->priority }} collapsed" data-task-id="{{ $task->id }}">
                        <div class="task-bar" onclick="toggleTask({{ $task->id }})">
                            <div class="task-bar-left">
                                <div class="task-bar-title">{{ ucfirst($task->title) }}</div>
                                <div class="task-bar-meta task-bar-collapsed">
                                    <span class="priority-badge priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                                    @if ($task->status == 1)
                                        <span class="status completed"><i class="fas fa-check-circle"></i></span>
                                    @elseif($task->status == 0)
                                        <span class="status in-progress"><i class="fas fa-spinner"></i></span>
                                    @else
                                        <span class="status pending"><i class="fas fa-pause-circle"></i></span>
                                    @endif
                                    <span class="due-pill">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                                    </span>
                                    <span class="days-pill {{ $daysRemainingClass }}">
                                        <i class="fas fa-clock"></i>
                                        @if($daysRemaining < 0)
                                            {{ abs(ceil($daysRemaining)) }}d overdue
                                        @elseif($daysRemaining == 0)
                                            Due today
                                        @elseif($daysRemaining == 1)
                                            1d left
                                        @else
                                            {{ ceil($daysRemaining) }}d left
                                        @endif
                                    </span>
                                </div>
                                <div class="task-bar-meta task-bar-expanded" style="display: none;">
                                    @if ($task->status == 1)
                                        <span class="status completed"><i class="fas fa-check-circle"></i></span>
                                    @elseif($task->status == 0)
                                        <span class="status in-progress"><i class="fas fa-spinner"></i></span>
                                    @else
                                        <span class="status pending"><i class="fas fa-pause-circle"></i></span>
                                    @endif
                                </div>
                            </div>
                            <div class="task-bar-actions">
                                <button class="task-bar-btn complete-circle" onclick="event.stopPropagation(); toggleComplete({{ $task->id }})" title="@if($task->status == 1)Mark Incomplete @else Mark Complete @endif">
                                    @if($task->status == 1)
                                        <i class="fas fa-check-circle"></i>
                                    @else
                                        <i class="far fa-circle"></i>
                                    @endif
                                </button>
                                <a href="{{ route('tasks.show', $task->id) }}" class="task-bar-btn view" onclick="event.stopPropagation()"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="task-bar-btn edit" onclick="event.stopPropagation()"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="delete-form" style="display: inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="task-bar-btn delete" onclick="event.stopPropagation(); return confirm('Delete task?')"><i class="fas fa-trash"></i></button>
                                </form>
                                <i class="fas fa-chevron-down expand-icon"></i>
                            </div>
                        </div>
                        
                        <div class="task-content">
                            <div class="task-pills-expanded">
                                <span class="priority-badge priority-{{ $task->priority }}">{{ ucfirst($task->priority) }}</span>
                                <span class="due-pill">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                </span>
                                <span class="days-pill {{ $daysRemainingClass }}">
                                    <i class="fas fa-clock"></i>
                                    @if($daysRemaining < 0)
                                        {{ abs(ceil($daysRemaining)) }}d overdue
                                    @elseif($daysRemaining == 0)
                                        Due today
                                    @elseif($daysRemaining == 1)
                                        1d left
                                    @else
                                        {{ ceil($daysRemaining) }}d left
                                    @endif
                                </span>
                                <span class="created-pill">
                                    <i class="fas fa-calendar-plus"></i>
                                    Created {{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y') }}
                                </span>
                                <span class="category-badge">{{ $task->category }}</span>
                            </div>
                            
                            @if($isOverdue && $task->status != 1)
                                <div class="overdue-message">
                                    <span class="overdue-icon"><i class="fas fa-exclamation-triangle"></i></span>
                                    <span class="overdue-text">Task was not completed by due date</span>
                                </div>
                            @endif
                            
                            <div class="task-description-section">
                                <pre class="task-description">{{ ucfirst($task->description) }}</pre>
                            </div>
                            
                            <div class="task-footer">
                                <button class="complete-btn full-width" onclick="toggleComplete({{ $task->id }})">
                                    @if($task->status == 1)
                                        <i class="fas fa-times-circle"></i> Mark Incomplete
                                    @else
                                        <i class="fas fa-check-circle"></i> Mark Complete
                                    @endif
                                </button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <div class="empty-icon"><i class="fas fa-clipboard-list fa-3x"></i></div>
                        <h3>No tasks yet</h3>
                        <p>Create your first task to get started</p>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create Task</a>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</body>

<script src="{{ asset('js/custom.js')  }}"></script>
<script>
function toggleTask(taskId) {
    const taskItem = document.querySelector(`[data-task-id="${taskId}"]`);
    taskItem.classList.toggle('collapsed');
    taskItem.classList.toggle('expanded');
}

function toggleComplete(taskId) {
    // Add your completion toggle logic here
    console.log('Toggle complete for task:', taskId);
}
</script>

</html>
