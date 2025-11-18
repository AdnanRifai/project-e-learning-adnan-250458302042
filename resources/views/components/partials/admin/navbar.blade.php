<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li>
                <a wire:navigate class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-fire"></i>
                    <span>Dashboard</span></a>
            </li>

            <li class="menu-header">Courses</li>
            <li>
                <a wire:navigate class="nav-link" href="{{ route('admin.courses.index') }}"><i class="fas fa-book"></i>
                    <span>Courses</span></a>
            </li>
            <li>
                <a wire:navigate class="nav-link" href="{{ route('admin.modules.index') }}"><i class="fas fa-layer-group"></i>
                    <span>Modules</span></a>
            </li>
            <li>
                <a wire:navigate class="nav-link" href="{{ route('admin.lesson.index') }}"><i class="fas fa-chalkboard-teacher"></i>
                    <span>Lessons</span></a>
            </li>

            <li class="menu-header">Assessment</li>
            <li>
                <a wire:navigate class="nav-link" href="{{ route('admin.quiz.index') }}"><i class="fas fa-question-circle"></i>
                    <span>Quiz</span></a>
            </li>
            <li>
                <a wire:navigate class="nav-link" href="{{ route('admin.question.index') }}"><i class="fas fa-question-circle"></i>
                    <span>Questions</span></a>
            </li>
            <li>
            <li class="menu-header">Community</li>
            <li>
                <a wire:navigate class="nav-link" href="{{ route('admin.comments.index') }}"><i class="fas fa-comments"></i>
                    <span>Comments</span></a>
            </li>

            <li class="menu-header">Analytics</li>
            <li>
                <a wire:navigate class="nav-link" href="{{ route('admin.statistics.index') }}"><i class="fas fa-chart-line"></i>
                    <span>Statistics</span></a>
            </li>

            <li class="menu-header">Settings</li>
            <li>
                <a wire:navigate class="nav-link" href="{{ route('admin.profile.edit') }}"><i class="fas fa-user-cog"></i>
                    <span>Profile</span></a>
            </li>
        </ul>

    </aside>
</div>
