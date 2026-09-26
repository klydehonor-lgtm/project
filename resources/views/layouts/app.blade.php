<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HONOR's Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9; /* slate-100 */
            color: #1e293b;
        }

        .sidebar {
            background: linear-gradient(180deg, #1e3a8a 0%, #1d4ed8 100%);
        }

        .nav-item {
            color: #bfdbfe;
            transition: all 0.15s ease;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        .nav-item-active {
            background: #ffffff;
            color: #1d4ed8;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.06);
        }

        .field {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #0f172a;
            transition: all 0.15s ease;
        }

        .field:focus {
            outline: none;
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            background: #ffffff;
        }

        .btn-primary {
            background: #2563eb;
            color: #ffffff;
            transition: background 0.15s ease;
        }
        .btn-primary:hover { background: #1d4ed8; }

        .btn-secondary {
            background: #e2e8f0;
            color: #334155;
            transition: background 0.15s ease;
        }
        .btn-secondary:hover { background: #cbd5e1; }

        .btn-danger {
            background: #ef4444;
            color: #ffffff;
            transition: background 0.15s ease;
        }
        .btn-danger:hover { background: #dc2626; }

        .table-row:hover { background: #f8fafc; }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
    </style>
</head>
<body class="h-full flex flex-col md:flex-row overflow-x-hidden">

    <!-- SIDEBAR -->
    <aside class="sidebar w-full md:w-64 flex flex-col justify-between p-5 shrink-0 md:min-h-screen z-20 text-white">
        <div>
            <!-- Branding -->
            <div class="flex items-center gap-3 mb-8 px-1">
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center">
                    <i class="fa-solid fa-check text-white"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-base leading-tight">HONOR's Task</h1>
                    <p class="text-[11px] text-blue-200 font-medium">Plan. Do. Achieve.</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1.5">
                <button onclick="setFilter('all')" id="nav-dashboard" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium nav-item-active">
                    <i class="fa-solid fa-house w-4"></i> Dashboard
                </button>
                <button onclick="setFilter('all')" id="nav-all" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium nav-item">
                    <i class="fa-solid fa-list-check w-4"></i> All Tasks
                </button>
                <button onclick="setFilter('pending')" id="nav-pending" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium nav-item">
                    <i class="fa-regular fa-clock w-4"></i> Pending
                </button>
                <button onclick="setFilter('completed')" id="nav-completed" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium nav-item">
                    <i class="fa-regular fa-circle-check w-4"></i> Completed
                </button>
            </nav>

            <div class="border-t border-white/15 my-5"></div>

            <button onclick="openModal()" class="w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium nav-item">
                <i class="fa-solid fa-circle-plus w-4"></i> Add Task
            </button>
        </div>

        <p class="text-[11px] text-blue-200/80 italic px-1">"Small steps make big progress."</p>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col min-h-screen">

        <!-- TOP BAR -->
        <header class="w-full bg-white border-b border-slate-200 px-4 md:px-8 py-3.5 flex items-center justify-end gap-4">
            <button class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                <i class="fa-regular fa-bell text-sm"></i>
            </button>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-user text-xs"></i>
                </div>
                <span class="text-xs font-semibold text-slate-700 hidden sm:inline">Student</span>
            </div>
        </header>

        <div class="flex-1 px-4 md:px-8 py-6 space-y-6 max-w-7xl w-full mx-auto">

            <div id="alertBox" class="hidden px-4 py-2.5 rounded-xl card text-emerald-600 text-xs font-medium items-center gap-2">
                <i class="fa-solid fa-circle-check"></i> <span id="alertText">Task added successfully.</span>
            </div>

            <!-- WELCOME HERO -->
            <div class="card rounded-2xl p-6 md:p-8 flex items-center justify-between bg-blue-50 gap-6 overflow-hidden">
                <div>
                    <p class="text-[11px] font-bold text-blue-500 uppercase tracking-wider mb-1">Welcome back!</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800">Personal Task Manager</h2>
                    <p class="text-sm text-slate-500 mt-1">Stay organized, stay productive.</p>
                </div>
                <div class="hidden sm:flex w-20 h-20 md:w-24 md:h-24 rounded-full bg-blue-500/10 items-center justify-center shrink-0">
                    <i class="fa-solid fa-laptop-code text-blue-500 text-3xl md:text-4xl"></i>
                </div>
            </div>

            <!-- STAT CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="card rounded-2xl p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500 flex items-center justify-center text-white shrink-0">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Total Tasks</p>
                        <h3 id="statTotal" class="text-2xl font-bold text-slate-800">0</h3>
                    </div>
                </div>
                <div class="card rounded-2xl p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-400 flex items-center justify-center text-white shrink-0">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Pending</p>
                        <h3 id="statPending" class="text-2xl font-bold text-slate-800">0</h3>
                    </div>
                </div>
                <div class="card rounded-2xl p-4 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500 flex items-center justify-center text-white shrink-0">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-500">Completed</p>
                        <h3 id="statCompleted" class="text-2xl font-bold text-slate-800">0</h3>
                    </div>
                </div>
            </div>

            <!-- TASK TABLE -->
            <div class="card rounded-2xl p-5 md:p-6 space-y-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3">
                    <div>
                        <h2 class="font-bold text-lg text-slate-800">My Tasks</h2>
                        <p id="registryFilterTag" class="text-xs text-slate-400">Showing all tasks</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                        <div class="relative flex-1 md:flex-none md:w-56">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </span>
                            <input type="text" id="searchInput" oninput="handleSearch()" placeholder="Search tasks..." class="w-full field pl-9 pr-3 py-2 rounded-lg text-xs font-medium">
                        </div>
                        <select id="priorityFilter" onchange="renderTasks()" class="field px-3 py-2 rounded-lg text-xs font-medium">
                            <option value="all">All Priorities</option>
                            <option value="Urgent">Urgent</option>
                            <option value="Reminder">Reminder</option>
                        </select>
                        <button onclick="openModal()" class="btn-primary px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2 shrink-0">
                            <i class="fa-solid fa-plus text-[10px]"></i> Add New Task
                        </button>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="hidden py-14 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-sm">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>
                    <h3 class="font-semibold text-sm text-slate-600">No tasks found</h3>
                    <p class="text-xs text-slate-400 mt-1">Click "Add New Task" to create your first item.</p>
                </div>

                <!-- Table -->
                <div id="tableWrapper" class="overflow-x-auto -mx-1">
                    <table class="w-full text-sm min-w-[720px]">
                        <thead>
                            <tr class="text-left text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200">
                                <th class="py-2 px-3 w-10">#</th>
                                <th class="py-2 px-3">Task Name</th>
                                <th class="py-2 px-3">Description</th>
                                <th class="py-2 px-3">Priority</th>
                                <th class="py-2 px-3">Due Date</th>
                                <th class="py-2 px-3">Status</th>
                                <th class="py-2 px-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="taskTableBody" class="divide-y divide-slate-100">
                            <!-- Dynamic rows -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- ADD/EDIT TASK MODAL -->
    <div id="taskModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm hidden">
        <div class="card rounded-2xl p-6 w-full max-w-md shadow-2xl relative">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-200">
                <h3 id="modalTitle" class="font-bold text-base text-slate-800">Add New Task</h3>
                <button onclick="closeModal()" class="w-7 h-7 rounded-lg btn-secondary flex items-center justify-center text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form id="taskForm" onsubmit="handleFormSubmit(event)" class="space-y-4">
                <input type="hidden" id="taskId">

                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Task Name</label>
                    <input type="text" id="taskTitle" required placeholder="Enter task name..." class="w-full field px-3.5 py-2.5 rounded-xl text-sm">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Description</label>
                    <textarea id="taskDesc" rows="3" placeholder="Enter task description..." class="w-full field px-3.5 py-2.5 rounded-xl text-sm resize-none"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Due Date</label>
                        <input type="date" id="taskDueDate" required class="w-full field px-3.5 py-2.5 rounded-xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 mb-1">Priority</label>
                        <select id="taskPriority" class="w-full field px-3.5 py-2.5 rounded-xl text-sm">
                            <option value="Reminder">Reminder</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Status</label>
                    <select id="taskStatusSelect" class="w-full field px-3.5 py-2.5 rounded-xl text-sm">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal()" class="btn-secondary px-4 py-2 rounded-xl text-xs font-semibold">Cancel</button>
                    <button type="submit" id="submitBtn" class="btn-primary px-5 py-2 rounded-xl text-xs font-semibold">Save Task</button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE CONFIRMATION MODAL -->
    <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm hidden">
        <div class="card rounded-2xl p-6 w-full max-w-sm shadow-2xl relative text-center">
            <div class="flex justify-end">
                <button onclick="closeDeleteModal()" class="w-7 h-7 rounded-lg btn-secondary flex items-center justify-center text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="w-14 h-14 mx-auto rounded-full bg-rose-100 flex items-center justify-center text-rose-500 text-xl mb-3 -mt-2">
                <i class="fa-solid fa-trash-can"></i>
            </div>
            <h3 class="font-bold text-base text-slate-800">Are you sure?</h3>
            <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">This task will be permanently deleted.<br>This action cannot be undone.</p>
            <div class="flex items-center justify-center gap-2 pt-5">
                <button onclick="closeDeleteModal()" class="btn-secondary px-5 py-2 rounded-xl text-xs font-semibold flex-1">Cancel</button>
                <button onclick="confirmDelete()" class="btn-danger px-5 py-2 rounded-xl text-xs font-semibold flex-1">Delete</button>
            </div>
        </div>
    </div>

    <!-- SCRIPT ENGINE -->
    <script>
    // Bridge Laravel database records into your front-end JavaScript
    let tasks = @json($tasks);

    let currentFilter = 'all';
    let currentSearchQuery = '';
    let pendingDeleteId = null;

    const NAV_ACTIVE = "w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium nav-item-active";
    const NAV_INACTIVE = "w-full flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium nav-item";

    window.onload = function() {
        const dueDateInput = document.getElementById('taskDueDate');
        if (dueDateInput) {
            dueDateInput.min = new Date().toISOString().split('T')[0];
        }
        renderApp();
    };

    function setFilter(filter) {
        currentFilter = filter;

        const dashboardBtn = document.getElementById('nav-dashboard');
        const allBtn = document.getElementById('nav-all');
        const pendingBtn = document.getElementById('nav-pending');
        const completedBtn = document.getElementById('nav-completed');

        if (dashboardBtn) dashboardBtn.className = filter === 'all' ? NAV_ACTIVE : NAV_INACTIVE;
        if (allBtn) allBtn.className = filter === 'all' ? NAV_ACTIVE : NAV_INACTIVE;
        if (pendingBtn) pendingBtn.className = filter === 'pending' ? NAV_ACTIVE : NAV_INACTIVE;
        if (completedBtn) completedBtn.className = filter === 'completed' ? NAV_ACTIVE : NAV_INACTIVE;

        const filterTag = document.getElementById('registryFilterTag');
        if (filterTag) {
            filterTag.innerText = filter === 'all' ? 'Showing all tasks' : `Showing ${filter} tasks`;
        }
        renderTasks();
    }

    function handleSearch() {
        const searchInput = document.getElementById('searchInput');
        currentSearchQuery = searchInput ? searchInput.value.toLowerCase().trim() : '';
        renderTasks();
    }

    function openModal(id = null) {
        const modal = document.getElementById('taskModal');
        if (!modal) return;
        modal.classList.remove('hidden');

        if (id) {
            const task = tasks.find(t => String(t.id) === String(id));
            if (!task) return;
            document.getElementById('modalTitle').innerText = 'Edit Task';
            document.getElementById('submitBtn').innerText = 'Update Task';
            document.getElementById('taskId').value = task.id;
            document.getElementById('taskTitle').value = task.title || '';
            document.getElementById('taskDesc').value = task.description || '';
            document.getElementById('taskPriority').value = task.priority || 'Reminder';
            document.getElementById('taskDueDate').value = task.due_date || task.dueDate || '';
            document.getElementById('taskStatusSelect').value = task.status ? task.status.toLowerCase() : 'pending';
        } else {
            document.getElementById('modalTitle').innerText = 'Add New Task';
            document.getElementById('submitBtn').innerText = 'Save Task';
            document.getElementById('taskForm').reset();
            document.getElementById('taskId').value = '';
        }
    }

    function closeModal() {
        const modal = document.getElementById('taskModal');
        if (modal) modal.classList.add('hidden');
    }

    function openDeleteModal(id) {
        pendingDeleteId = id;
        const modal = document.getElementById('deleteModal');
        if (modal) modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        pendingDeleteId = null;
        const modal = document.getElementById('deleteModal');
        if (modal) modal.classList.add('hidden');
    }

    function showAlert(msg) {
        const alertBox = document.getElementById('alertBox');
        const alertText = document.getElementById('alertText');
        if (alertBox && alertText) {
            alertText.innerText = msg;
            alertBox.classList.remove('hidden');
            alertBox.classList.add('flex');
            setTimeout(() => { alertBox.classList.add('hidden'); alertBox.classList.remove('flex'); }, 3000);
        }
    }

    function renderApp() {
        updateStats();
        renderTasks();
    }

    function updateStats() {
        if (typeof tasks === 'undefined') return;
        const total = tasks.length;
        const pending = tasks.filter(t => (t.status || '').toLowerCase() === 'pending').length;
        const completed = tasks.filter(t => (t.status || '').toLowerCase() === 'completed').length;

        const setElementText = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.innerText = val;
        };

        setElementText('statTotal', total);
        setElementText('statPending', pending);
        setElementText('statCompleted', completed);
    }

    function renderTasks() {
        if (typeof tasks === 'undefined') return;
        const priorityFilterEl = document.getElementById('priorityFilter');
        const priorityVal = priorityFilterEl ? priorityFilterEl.value : 'all';

        const filtered = tasks.filter(t => {
            const status = (t.status || '').toLowerCase();
            if (currentFilter !== 'all' && status !== currentFilter.toLowerCase()) return false;
            if (priorityVal !== 'all' && t.priority !== priorityVal) return false;
            if (currentSearchQuery &&
                !(t.title || '').toLowerCase().includes(currentSearchQuery) &&
                !(t.description || '').toLowerCase().includes(currentSearchQuery)) return false;
            return true;
        });

        const tbody = document.getElementById('taskTableBody');
        const emptyState = document.getElementById('emptyState');
        const tableWrapper = document.getElementById('tableWrapper');
        if (!tbody || !emptyState || !tableWrapper) return;

        tbody.innerHTML = '';

        if (filtered.length === 0) {
            emptyState.classList.remove('hidden');
            tableWrapper.classList.add('hidden');
            return;
        } else {
            emptyState.classList.add('hidden');
            tableWrapper.classList.remove('hidden');
        }

        filtered.forEach((task, index) => {
            const isCompleted = (task.status || '').toLowerCase() === 'completed';
            const dueDateStr = task.due_date || task.dueDate || '';
            const row = document.createElement('tr');
            row.className = "table-row transition-colors";
            row.innerHTML = `
                <td class="py-3 px-3 text-slate-400 text-xs align-top">${index + 1}</td>
                <td class="py-3 px-3 align-top">
                    <span class="font-semibold text-slate-800 text-sm ${isCompleted ? 'line-through opacity-50' : ''}">${escapeHtml(task.title || '')}</span>
                </td>
                <td class="py-3 px-3 align-top text-slate-500 text-xs max-w-xs">
                    <span class="line-clamp-2">${escapeHtml(task.description || 'No description provided.')}</span>
                </td>
                <td class="py-3 px-3 align-top">
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase ${task.priority === 'Urgent' ? 'bg-rose-100 text-rose-600' : 'bg-blue-100 text-blue-600'}">${escapeHtml(task.priority || 'Normal')}</span>
                </td>
                <td class="py-3 px-3 align-top text-xs text-slate-500 whitespace-nowrap">${escapeHtml(dueDateStr)}</td>
                <td class="py-3 px-3 align-top">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase ${isCompleted ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600'}">
                        ${isCompleted ? 'Completed' : 'Pending'}
                    </span>
                </td>
                <td class="py-3 px-3 align-top text-right whitespace-nowrap">
                    <div class="flex items-center justify-end gap-1.5">
                        <button onclick="toggleStatus('${task.id}')" title="${isCompleted ? 'Reopen' : 'Complete'}" class="w-8 h-8 rounded-lg btn-secondary flex items-center justify-center text-xs">
                            <i class="fa-solid ${isCompleted ? 'fa-rotate-left' : 'fa-check'} text-[11px]"></i>
                        </button>
                        <button onclick="openModal('${task.id}')" title="Edit" class="w-8 h-8 rounded-lg btn-primary flex items-center justify-center text-xs">
                            <i class="fa-solid fa-pen text-[10px]"></i>
                        </button>
                        <button onclick="openDeleteModal('${task.id}')" title="Delete" class="w-8 h-8 rounded-lg btn-danger flex items-center justify-center text-xs">
                            <i class="fa-solid fa-trash-can text-[10px]"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(row);
        });
        updateStats();
    }

    async function handleFormSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('taskId').value;
        const title = document.getElementById('taskTitle').value.trim();
        const description = document.getElementById('taskDesc').value.trim();
        const priority = document.getElementById('taskPriority').value;
        const due_date = document.getElementById('taskDueDate').value;
        const status = document.getElementById('taskStatusSelect').value;

        if (!title || !due_date) return;

        const formData = { title, description, priority, due_date, status };
        const url = id ? `/tasks/${id}` : '/tasks';
        const method = id ? 'PUT' : 'POST';

        try {
            let response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });

            if (response.ok) {
                showAlert(id ? 'Task updated successfully.' : 'Task added successfully.');
                closeModal();
                location.reload();
            } else {
                const errorData = await response.json();
                console.error('Validation Errors:', errorData);

                let message = 'Failed to save task.';
                if (errorData.errors) {
                    message += ' ' + Object.values(errorData.errors).flat().join(' ');
                } else if (errorData.message) {
                    message += ' ' + errorData.message;
                }
                alert(message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An unexpected network error occurred.');
        }
    }

    async function toggleStatus(id) {
        try {
            let response = await fetch(`/tasks/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.ok) {
                location.reload();
            } else {
                alert('Failed to update status.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function confirmDelete() {
        if (!pendingDeleteId) return;
        const id = pendingDeleteId;

        try {
            let response = await fetch(`/tasks/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.ok) {
                closeDeleteModal();
                showAlert('Task deleted.');
                location.reload();
            } else {
                alert('Failed to delete task.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }
    </script>
</body>
</html>