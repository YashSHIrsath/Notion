document.addEventListener("DOMContentLoaded", function () {
    let completedTasks = JSON.parse(localStorage.getItem("completedTasks") || "[]");
    let notCompleteTasks = JSON.parse(localStorage.getItem("notCompleteTasks") || "[]");

    // Process each task on page load
    document.querySelectorAll(".task-item").forEach((taskItem) => {
        const taskId = getTaskId(taskItem);
        if (!taskId) return;

        // Handle overdue tasks - check if completed via JS
        if (taskItem.classList.contains("overdue")) {
            if (completedTasks.includes(taskId)) {
                applyCompletedStyling(taskItem);
            }
            return;
        }

        const status = taskItem.querySelector(".status");
        const isDbCompleted = status && status.classList.contains("completed");

        // Apply localStorage overrides
        if (notCompleteTasks.includes(taskId)) {
            removeCompletedStyling(taskItem);
        } else if (completedTasks.includes(taskId) || isDbCompleted) {
            applyCompletedStyling(taskItem);
            if (isDbCompleted && !completedTasks.includes(taskId)) {
                completedTasks.push(taskId);
                localStorage.setItem("completedTasks", JSON.stringify(completedTasks));
            }
        }
    });

    // Add click handlers to complete buttons and circle buttons
    document.querySelectorAll(".complete-btn, .complete-circle").forEach((button) => {
        button.addEventListener("click", function () {
            const taskItem = this.closest(".task-item");

            const taskId = getTaskId(taskItem);
            if (!taskId) return;

            const isCurrentlyCompleted = completedTasks.includes(taskId) || 
                                       this.innerHTML.includes("Not Complete");

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
            } else {
                // Mark as complete
                applyCompletedStyling(taskItem);
                if (!completedTasks.includes(taskId)) {
                    completedTasks.push(taskId);
                }
                notCompleteTasks = notCompleteTasks.filter((id) => id !== taskId);
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

        taskItem.style.background = "linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05))";
        taskItem.style.opacity = "0.8";

        const title = taskItem.querySelector(".task-title");
        const description = taskItem.querySelector(".task-description");
        if (title) title.style.textDecoration = "line-through";
        if (description) description.style.textDecoration = "line-through";

        const viewBtn = taskItem.querySelector(".btn-view");
        const editBtn = taskItem.querySelector(".btn-edit");
        const completeBtn = taskItem.querySelector(".complete-btn");

        if (viewBtn) {
            viewBtn.style.opacity = "0.5";
            viewBtn.style.pointerEvents = "none";
        }
        if (editBtn) {
            editBtn.style.opacity = "0.5";
            editBtn.style.pointerEvents = "none";
        }
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

        const title = taskItem.querySelector(".task-title");
        const description = taskItem.querySelector(".task-description");
        if (title) title.style.textDecoration = "";
        if (description) description.style.textDecoration = "";

        const viewBtn = taskItem.querySelector(".btn-view");
        const editBtn = taskItem.querySelector(".btn-edit");
        const completeBtn = taskItem.querySelector(".complete-btn");

        if (viewBtn) {
            viewBtn.style.opacity = "";
            viewBtn.style.pointerEvents = "";
        }
        if (editBtn) {
            editBtn.style.opacity = "";
            editBtn.style.pointerEvents = "";
        }
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
    
    // Navigation hide/show on scroll
    const header = document.querySelector('header');
    let lastScrollTop = 0;
    
    if (header) {
        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop === 0) {
                // At top - show header
                header.style.transform = 'translateY(0)';
            } else if (scrollTop > lastScrollTop) {
                // Scrolling down - hide header
                header.style.transform = 'translateY(-100%)';
            }
            
            lastScrollTop = scrollTop;
        });
    }
});