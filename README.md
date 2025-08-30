# Task Manager - Modern Laravel Application

A comprehensive task management system built with Laravel, featuring a modern glassmorphism UI design and advanced task organization capabilities.

## 🚀 Features

### Core Functionality
- **User Authentication** - Secure login/register system with custom styling
- **CRUD Operations** - Create, read, update, and delete tasks
- **Task Prioritization** - High, Medium, Low priority levels with color coding
- **Due Date Management** - Date tracking with overdue detection
- **Task Categories** - Organize tasks by Business, Casual, Fun categories
- **Status Tracking** - Pending, In Progress, Completed status management

### Advanced Features
- **Overdue Task Management** - Collapsible overdue tasks with warning indicators
- **Days Remaining Calculator** - Color-coded badges showing time until due date
- **Task Completion Toggle** - JavaScript-powered completion with localStorage persistence
- **Responsive Navigation** - Auto-hiding header on scroll for mobile optimization
- **Real-time Clock** - Live updating time display in navigation pills

### UI/UX Enhancements
- **Glassmorphism Design** - Modern translucent cards with backdrop blur effects
- **Priority-based Styling** - Visual color coding (Red: High, Orange: Medium, Green: Low)
- **Smooth Animations** - Subtle hover effects and transitions
- **Mobile Responsive** - Optimized layout for all screen sizes
- **Interactive Elements** - Confirmation dialogs and visual feedback

### Technical Features
- **Laravel Framework** - Built on Laravel with MVC architecture
- **Carbon Date Handling** - Advanced date manipulation and formatting
- **Custom CSS Architecture** - Modular styling with CSS variables
- **JavaScript Integration** - Enhanced interactivity with vanilla JS
- **Form Validation** - Client and server-side validation
- **Session Management** - Flash messages and user state persistence

## 🛠️ Technology Stack

- **Backend**: Laravel (PHP)
- **Frontend**: Blade Templates, HTML5, CSS3, JavaScript
- **Database**: MySQL/SQLite
- **Styling**: Custom CSS with Glassmorphism effects
- **Fonts**: Inter, Playwrite DE Grund
- **Icons**: Emoji-based icon system

## 📱 User Interface

### Dashboard Features
- User profile display with gradient styling
- Welcome message with highlighted username
- Quick navigation to all sections

### Task Management
- **Task Cards** - Glassmorphism design with priority borders
- **Meta Information** - Due dates, priority badges, category labels
- **Action Buttons** - View, Edit, Delete with confirmation
- **Completion System** - Toggle completion status with visual feedback

### Forms & Navigation
- **Enhanced Forms** - Date pickers with quick selection buttons
- **Pill Navigation** - Modern pill-shaped navigation elements
- **Live Updates** - Real-time clock and dynamic content

## 🎨 Design Philosophy

The application follows a modern design approach with:
- **Glassmorphism** - Translucent elements with backdrop blur
- **Color Psychology** - Priority-based color coding for quick recognition
- **Minimal Animations** - Subtle effects that enhance usability
- **Responsive Design** - Mobile-first approach with adaptive layouts
- **Accessibility** - High contrast ratios and keyboard navigation support

## 📋 Key Components

1. **Authentication System** - Custom styled login/register pages
2. **Task Dashboard** - Main interface with task listing and management
3. **Task Forms** - Create/edit forms with enhanced date inputs
4. **Task Details** - Detailed view with animated containers
5. **Overdue Management** - Special handling for overdue tasks
6. **Mobile Navigation** - Responsive header with scroll behavior

## 🚀 Installation

1. Clone the repository
```bash
git clone https://github.com/yourusername/task-manager.git
```

2. Install dependencies
```bash
composer install
npm install
```

3. Set up environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations
```bash
php artisan migrate
```

5. Start the development server
```bash
php artisan serve
```

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
