<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notion : Task Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/business-tasks.css') }}">
    <style>
        /* Container Animations Only */
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
        
        /* Enhanced Container Styling */
        .task-detail-container {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .task-detail-card {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .task-detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(59, 130, 246, 0.15), 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .task-meta-grid {
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }
        
        .meta-card {
            transition: all 0.3s ease;
        }
        
        .meta-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .task-actions-section {
            animation: fadeInUp 0.6s ease-out 0.4s both;
        }
        
        .action-btn-enhanced {
            transition: all 0.3s ease;
        }
        
        .action-btn-enhanced:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        /* Priority Card Styling */
        .priority-card-high {
            border-left: 4px solid #dc2626;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(220, 38, 38, 0.05));
        }
        
        .priority-card-medium {
            border-left: 4px solid #d97706;
            background: linear-gradient(135deg, rgba(217, 119, 6, 0.1), rgba(217, 119, 6, 0.05));
        }
        
        .priority-card-low {
            border-left: 4px solid #059669;
            background: linear-gradient(135deg, rgba(5, 150, 105, 0.1), rgba(5, 150, 105, 0.05));
        }
        
        .category-badge-enhanced {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
        }
        
        .status-card {
            border-left: 4px solid var(--primary);
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05));
        }
        
        .danger-btn:hover {
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.3) !important;
        }
        
        .date-pill {
            background: var(--surface);
            color: var(--text-muted);
            padding: 0.5rem 1.25rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid var(--border);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            display: inline-block;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="app">
        <header class="header">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="app-title">Task Details</h1>
                    <div class="date-pill">Created {{ \Carbon\Carbon::parse($task->created_at)->format('F j, Y') }}</div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="nav-btn">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
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
            <div class="task-detail-container">
                <article class="task-detail-card">
                    <div class="task-detail-header">
                        <div class="task-title-section">
                            <h2 class="task-detail-title">{{ $task->title }}</h2>
                            <div class="task-id">Task #{{ $task->id }}</div>
                        </div>
                        <div class="task-status-badge">
                            @if ($task->status == 1)
                                <span class="status completed"><i class="fas fa-check-circle"></i></span>
                            @elseif($task->status == 0)
                                <span class="status in-progress"><i class="fas fa-spinner fa-spin"></i></span>
                            @elseif($task->status == -1)
                                <span class="status pending"><i class="fas fa-pause-circle"></i></span>
                            @else
                                <span class="status unknown"><i class="fas fa-question-circle"></i></span>
                            @endif
                        </div>
                    </div>

                    <div class="task-detail-content">
                        <div class="content-section">
                            <h3 class="section-label">Description</h3>
                            <p class="task-description-detail">{{ $task->description }}</p>
                        </div>

                        @if($task->long_description)
                        <div class="content-section">
                            <h3 class="section-label">Detailed Information</h3>
                            <div class="task-long-description-detail">{{ $task->long_description }}</div>
                        </div>
                        @endif

                        <div class="task-meta-grid">
                            <div class="meta-card">
                                <div class="meta-label">Due Date</div>
                                <div class="meta-value"><i class="fas fa-calendar-alt"></i> {{ $task->due_date }}</div>
                            </div>
                            
                            <div class="meta-card priority-card-{{ $task->priority }}">
                                <div class="meta-label">Priority</div>
                                <div class="meta-value priority-{{ $task->priority }}" style="text-transform: capitalize;background-color:transparent;">
                                    @if($task->priority == 'high')
                                        <i class="fas fa-exclamation-triangle" style="color: #ef4444;"></i> High
                                    @elseif($task->priority == 'medium')
                                        <i class="fas fa-exclamation-circle" style="color: #f59e0b;"></i> Medium
                                    @else
                                        <i class="fas fa-info-circle" style="color: #10b981;"></i> Low
                                    @endif
                                </div>
                            </div>
                            
                            <div class="meta-card">
                                <div class="meta-label">Category</div>
                                <div class="meta-value category-badge-enhanced">{{ $task->category }}</div>
                            </div>
                            
                            <div class="meta-card status-card">
                                <div class="meta-label">Status</div>
                                <div class="meta-value">
                                    @if ($task->status == 1)
                                        <i class="fas fa-check-circle" style="color: #10b981;"></i> Completed
                                    @elseif($task->status == 0)
                                        <i class="fas fa-spinner" style="color: #f59e0b;"></i> In Progress
                                    @elseif($task->status == -1)
                                        <i class="fas fa-pause-circle" style="color: #64748b;"></i> Pending
                                    @else
                                        <i class="fas fa-question-circle" style="color: #ef4444;"></i> Unknown
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

                <div class="task-actions-section">
                    <div class="action-buttons">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn-edit action-btn-enhanced">
                            <i class="fas fa-edit"></i>
                            Edit Task
                        </a>
                        <a href="{{ route('tasks.index') }}" class="btn btn-view action-btn-enhanced">
                            <i class="fas fa-list"></i>
                            All Tasks
                        </a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="delete-form">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn-delete action-btn-enhanced danger-btn" onclick="return confirm('Are you sure you want to delete this task?')">
                                <i class="fas fa-trash-alt"></i>
                                Delete Task
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>