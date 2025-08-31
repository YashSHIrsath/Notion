// Global Keyboard Shortcuts for Notion App
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('keydown', function(e) {
        // Check if Ctrl key is pressed (or Cmd on Mac)
        if (e.ctrlKey || e.metaKey) {
            switch(e.key.toLowerCase()) {
                case 'b':
                    e.preventDefault();
                    window.location.href = '/tasks/create';
                    break;
                case 'l':
                    e.preventDefault();
                    window.location.href = '/tasks';
                    break;
                case 'd':
                    e.preventDefault();
                    window.location.href = '/dashboard';
                    break;
            }
        }
    });
});