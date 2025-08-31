document.addEventListener("DOMContentLoaded", function () {
    // Load completed and not complete tasks from localStorage
    let completedTasks = JSON.parse(localStorage.getItem("completedTasks")) || [];
    let notCompleteTasks = JSON.parse(localStorage.getItem("notCompleteTasks")) || [];

    // Apply completed styling on page load
    completedTasks.forEach((taskId) => {
        const taskItem = document.querySelector(`[data-task-id="${taskId}"]`);
        if (taskItem) {
            applyCompletedStyling(taskItem);
        }
    });

    // Apply not complete styling on page load
    notCompleteTasks.forEach((taskId) => {
        const taskItem = document.querySelector(`[data-task-id="${taskId}"]`);
        if (taskItem) {
            removeCompletedStyling(taskItem);
        }
    });

    // Add event listeners for complete buttons and circle buttons
    document.querySelectorAll(".complete-btn, .complete-circle").forEach((button) => {
        button.addEventListener("click", function () {
            const taskItem = this.closest(".task-item");
            const taskId = getTaskId(taskItem);
            if (!taskId) return;

            const isCurrentlyCompleted = completedTasks.includes(taskId) || this.innerHTML.includes("Not Complete");

            if (isCurrentlyCompleted) {
                // Mark as not complete
                removeCompletedStyling(taskItem);
                completedTasks = completedTasks.filter((id) => id !== taskId);
                
                const status = taskItem.querySelector(".status");
                if (status && status.classList.contains("completed")) {
                    if (!notCompleteTasks.includes(taskId)) {
                        notCompleteTasks.push(taskId);
                    }
                }
                
                // Sort only when moving from completed to incomplete (going up)
                setTimeout(sortTasks, 100);
            } else {
                // Mark as complete
                applyCompletedStyling(taskItem);
                if (!completedTasks.includes(taskId)) {
                    completedTasks.push(taskId);
                }
                notCompleteTasks = notCompleteTasks.filter((id) => id !== taskId);
                
                // Sort when marking as complete (going down)
                setTimeout(sortTasks, 100);
            }

            localStorage.setItem("completedTasks", JSON.stringify(completedTasks));
            localStorage.setItem("notCompleteTasks", JSON.stringify(notCompleteTasks));
        });
    });

    function getTaskId(taskItem) {
        const viewLink = taskItem.querySelector(".btn-view");
        if (viewLink) {
            return viewLink.getAttribute("href").split("/").pop();
        }
        
        const deleteForm = taskItem.querySelector(".delete-form");
        if (deleteForm) {
            return deleteForm.getAttribute("action").split("/").pop();
        }
        
        return null;
    }

    function applyCompletedStyling(taskItem) {
        if (!taskItem) return;

        taskItem.style.background = "#2d1b69";
        taskItem.style.borderLeft = "4px solid #8b5cf6";
        taskItem.style.opacity = "0.9";
        taskItem.style.color = "#e5e7eb";
        taskItem.classList.add('task-completed');

        // Add line-through to task title
        const taskTitle = taskItem.querySelector(".task-bar-title");
        if (taskTitle) {
            taskTitle.style.textDecoration = "line-through";
        }

        // Disable view and edit buttons
        const viewBtn = taskItem.querySelector(".task-bar-btn.view");
        const editBtn = taskItem.querySelector(".task-bar-btn.edit");
        if (viewBtn) {
            viewBtn.style.opacity = "0.3";
            viewBtn.style.pointerEvents = "none";
        }
        if (editBtn) {
            editBtn.style.opacity = "0.3";
            editBtn.style.pointerEvents = "none";
        }

        const completeBtn = taskItem.querySelector(".complete-btn");
        if (completeBtn) {
            completeBtn.innerHTML = '<i class="fas fa-times-circle"></i> Mark Incomplete';
        }

        // Update circle button
        const circleBtn = taskItem.querySelector(".complete-circle");
        if (circleBtn) {
            circleBtn.innerHTML = '<i class="fas fa-check-circle"></i>';
        }

        // Replace overdue warning with congratulations for overdue tasks
        const overdueMessage = taskItem.querySelector(".overdue-message");
        if (overdueMessage && taskItem.classList.contains("overdue")) {
            overdueMessage.innerHTML = '<span class="overdue-icon">🎉</span><span class="overdue-text" style="color: #10b981;">Congratulations! You completed an overdue task!</span>';
        } else if (overdueMessage) {
            overdueMessage.style.display = "none";
        }

        const status = taskItem.querySelector(".status");
        if (status) {
            if (!taskItem.getAttribute("data-original-status")) {
                if (status.classList.contains("in-progress")) {
                    taskItem.setAttribute("data-original-status", "in-progress");
                } else if (status.classList.contains("pending")) {
                    taskItem.setAttribute("data-original-status", "pending");
                }
            }
            status.className = "status completed";
            status.textContent = "✓";
        }
    }

    function removeCompletedStyling(taskItem) {
        if (!taskItem) return;

        taskItem.style.background = "";
        taskItem.style.opacity = "";
        taskItem.style.color = "";
        taskItem.style.borderLeft = "";
        taskItem.classList.remove('task-completed');

        // Remove line-through from task title
        const taskTitle = taskItem.querySelector(".task-bar-title");
        if (taskTitle) {
            taskTitle.style.textDecoration = "";
        }

        // Re-enable view and edit buttons
        const viewBtn = taskItem.querySelector(".task-bar-btn.view");
        const editBtn = taskItem.querySelector(".task-bar-btn.edit");
        if (viewBtn) {
            viewBtn.style.opacity = "";
            viewBtn.style.pointerEvents = "";
        }
        if (editBtn) {
            editBtn.style.opacity = "";
            editBtn.style.pointerEvents = "";
        }

        const completeBtn = taskItem.querySelector(".complete-btn");
        if (completeBtn) {
            completeBtn.innerHTML = '<i class="fas fa-check-circle"></i> Mark Complete';
        }

        // Update circle button
        const circleBtn = taskItem.querySelector(".complete-circle");
        if (circleBtn) {
            circleBtn.innerHTML = '<i class="far fa-circle"></i>';
        }

        // Restore overdue warning when not completed (if overdue)
        const overdueMessage = taskItem.querySelector(".overdue-message");
        if (overdueMessage && taskItem.classList.contains("overdue")) {
            overdueMessage.innerHTML = '<span class="overdue-icon">⚠️</span><span class="overdue-text">Task was not completed by due date</span>';
            overdueMessage.style.display = "";
        }

        const status = taskItem.querySelector(".status");
        if (status) {
            const originalStatus = taskItem.getAttribute("data-original-status");
            if (originalStatus === "in-progress") {
                status.className = "status in-progress";
                status.textContent = "⏳";
            } else if (originalStatus === "pending") {
                status.className = "status pending";
                status.textContent = "⏸";
            }
        }
    }
    
    // Sort tasks: incomplete first, then completed
    function sortTasks() {
        const container = document.querySelector('.tasks-container');
        if (!container) return;
        
        // Remove existing separator and add task button
        const existingSeparator = container.querySelector('.completed-separator');
        if (existingSeparator) {
            existingSeparator.remove();
        }
        const existingAddBtn = container.querySelector('.all-completed-add-task');
        if (existingAddBtn) {
            existingAddBtn.remove();
        }
        
        const tasks = Array.from(container.querySelectorAll('.task-item'));
        const incompleteTasks = [];
        const completedTasksArray = [];
        
        tasks.forEach(task => {
            if (task.classList.contains('task-completed')) {
                completedTasksArray.push(task);
            } else {
                incompleteTasks.push(task);
            }
        });
        
        // If all tasks are completed and there are tasks, show add task button
        if (tasks.length > 0 && incompleteTasks.length === 0) {
            const addTaskBtn = document.createElement('div');
            addTaskBtn.className = 'all-completed-add-task';
            addTaskBtn.innerHTML = `
                <div style="text-align: center; padding: 3rem 0; color: #8b5cf6;">
                    <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.7;"></i>
                    <h3 style="margin-bottom: 1rem;">All tasks completed! 🎉</h3>
                    <a href="/tasks/create" class="nav-btn primary" style="display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                        <i class="fas fa-plus"></i> Add New Task
                    </a>
                </div>
            `;
            container.insertBefore(addTaskBtn, container.firstChild);
        }
        
        // Reorder tasks in container
        incompleteTasks.forEach(task => container.appendChild(task));
        
        // Add separator if there are completed tasks and incomplete tasks
        if (completedTasksArray.length > 0 && incompleteTasks.length > 0) {
            const separator = document.createElement('div');
            separator.className = 'completed-separator';
            separator.innerHTML = `
                <div class="completed-section-divider">
                    <div class="divider-line"></div>
                    <div class="completed-heading-container">
                        <div class="completed-heading" onclick="toggleCompletedTasks()">
                            <i class="fas fa-check-circle completed-icon"></i>
                            <span class="completed-text">Completed Tasks</span>
                            <div class="completed-badge">${completedTasksArray.length}</div>
                            <i class="fas fa-chevron-down completed-toggle-icon"></i>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(separator);
        }
        
        // Add completed tasks
        completedTasksArray.forEach(task => container.appendChild(task));
    }
    

    
    // Sort tasks on page load
    setTimeout(sortTasks, 100);
    
    // Toggle completed tasks visibility
    window.toggleCompletedTasks = function() {
        const completedTasks = document.querySelectorAll('.task-item.task-completed');
        const toggleIcon = document.querySelector('.completed-toggle-icon');
        const isHidden = completedTasks[0]?.style.display === 'none';
        
        completedTasks.forEach(task => {
            task.style.display = isHidden ? 'block' : 'none';
        });
        
        if (toggleIcon) {
            toggleIcon.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(-90deg)';
        }
    };
    
    // Navigation hide/show on scroll
    const header = document.querySelector('header');
    let lastScrollTop = 0;
    
    if (header) {
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop === 0) {
                header.style.transform = 'translateY(0)';
            } else if (scrollTop > lastScrollTop) {
                header.style.transform = 'translateY(-100%)';
            }
            
            lastScrollTop = scrollTop;
        });
    }
});