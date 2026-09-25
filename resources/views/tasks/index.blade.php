<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>The Daybook</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --paper: #f6f1e7;
            --panel: #fffdf9;
            --ink: #2a2420;
            --ink-soft: #6b6156;
            --rule: #ddd2bc;
            --green: #33513a;
            --green-light: #4c6e52;
            --amber: #a5691f;
            --amber-bg: #f3e4c8;
            --green-bg: #dfe8de;
            --red: #a5483f;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--paper);
            background-image:
                repeating-linear-gradient(transparent, transparent 39px, var(--rule) 39px, var(--rule) 40px);
            background-attachment: local;
            color: var(--ink);
            margin: 0;
            min-height: 100vh;
            padding: 3rem 1.25rem;
        }

        .page {
            max-width: 700px;
            margin: 0 auto;
            background: var(--panel);
            border: 1px solid var(--rule);
            box-shadow: 0 1px 0 var(--rule), 4px 4px 0 -2px var(--paper), 4px 4px 0 -1px var(--rule);
            padding: 2.75rem 2.5rem 2rem;
        }

        .masthead {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            border-bottom: 2px solid var(--ink);
            padding-bottom: .9rem;
            margin-bottom: .3rem;
        }

        h1 {
            font-family: 'Fraunces', serif;
            font-optical-sizing: auto;
            font-weight: 600;
            font-size: 2rem;
            margin: 0;
            color: var(--ink);
        }

        .dateline {
            font-size: .8rem;
            color: var(--ink-soft);
            font-variant-numeric: tabular-nums;
        }

        .add-link {
            display: block;
            text-align: right;
            margin: .9rem 0 .5rem;
            font-size: .85rem;
        }

        .add-link a {
            color: var(--green);
            text-decoration: none;
            border-bottom: 1px solid var(--green-light);
            padding-bottom: 1px;
            transition: color .15s ease, padding-left .15s ease;
        }

        .add-link a:hover {
            color: var(--green-light);
            padding-left: .15rem;
        }

        .flash {
            font-size: .82rem;
            color: var(--green);
            background: var(--green-bg);
            border-left: 3px solid var(--green);
            padding: .55rem .8rem;
            margin: 1rem 0;
        }

        ul.ledger { list-style: none; margin: .5rem 0 0; padding: 0; }

        .entry {
            display: grid;
            grid-template-columns: 1.9rem 1fr auto;
            align-items: start;
            gap: .9rem;
            padding: 1.05rem .6rem;
            margin: 0 -.6rem;
            border-bottom: 1px dashed var(--rule);
            border-radius: 3px;
            transition: background-color .15s ease;
        }

        .entry:last-child { border-bottom: none; }

        .entry:hover { background-color: rgba(51, 81, 58, .05); }

        .check-form { margin: 0; }

        .check-btn {
            width: 1.5rem;
            height: 1.5rem;
            border-radius: 50%;
            border: 1.5px solid var(--ink-soft);
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: border-color .15s ease, background-color .15s ease, transform .1s ease;
        }

        .check-btn:hover {
            border-color: var(--green);
            transform: scale(1.08);
        }

        .check-btn.done {
            background: var(--green);
            border-color: var(--green);
            color: var(--panel);
        }

        .check-btn.done:hover { background: var(--green-light); border-color: var(--green-light); }

        .check-btn svg { width: .8rem; height: .8rem; opacity: 0; }
        .check-btn.done svg { opacity: 1; }

        .task-main .name {
            font-family: 'Fraunces', serif;
            font-size: 1.08rem;
            font-weight: 500;
            transition: color .15s ease;
        }

        .entry:hover .task-main .name:not(.done) { color: var(--green); }

        .task-main .name.done {
            text-decoration: line-through;
            color: var(--ink-soft);
        }

        .task-main .desc {
            font-size: .84rem;
            color: var(--ink-soft);
            margin-top: .2rem;
            line-height: 1.4;
        }

        .task-meta {
            text-align: right;
            font-size: .78rem;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: .45rem;
        }

        .due {
            font-variant-numeric: tabular-nums;
            color: var(--ink-soft);
        }

        .status-word {
            font-size: .68rem;
            letter-spacing: .03em;
            padding: .12rem .5rem;
            border-radius: 3px;
        }

        .status-word.Pending { background: var(--amber-bg); color: var(--amber); }
        .status-word.Completed { background: var(--green-bg); color: var(--green); }

        .row-actions { display: flex; gap: .6rem; }

        .row-actions form { margin: 0; }

        .row-actions a, .row-actions button {
            font: inherit;
            font-size: .74rem;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: var(--ink-soft);
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: color .15s ease, border-color .15s ease;
        }

        .row-actions a:hover, .row-actions button:hover {
            color: var(--ink);
            border-bottom-color: var(--ink-soft);
        }

        .row-actions .delete:hover { color: var(--red); border-bottom-color: var(--red); }

        .status-word {
            transition: transform .15s ease;
        }

        .entry:hover .status-word { transform: translateY(-1px); }

        .empty {
            text-align: center;
            padding: 3rem 1rem 2rem;
            color: var(--ink-soft);
            font-size: .9rem;
            font-style: italic;
        }

        @media (max-width: 520px) {
            .page { padding: 2rem 1.4rem 1.5rem; }
            .entry { grid-template-columns: 1.6rem 1fr; }
            .task-meta { grid-column: 2; align-items: flex-start; flex-direction: row; gap: .7rem; margin-top: .3rem; }
        }
    </style>
</head>
<body>
<div class="page">

    <div class="masthead">
        <h1>The Daybook</h1>
        <div class="dateline">{{ now()->format('l, F j') }}</div>
    </div>

    <div class="add-link">
        <a href="{{ route('tasks.create') }}">+ add an entry</a>
    </div>

    @if (session('success'))
        <div class="flash">{{ session('success') }}</div>
    @endif

    <ul class="ledger">
        @forelse ($tasks as $task)
            <li class="entry">
                <form method="POST" action="{{ route('tasks.status', $task) }}" class="check-form">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="check-btn {{ $task->status === 'Completed' ? 'done' : '' }}"
                            aria-label="{{ $task->status === 'Completed' ? 'Mark pending' : 'Mark done' }}">
                        <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 8.5L6.2 11.5L13 4.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </form>

                <div class="task-main">
                    <div class="name {{ $task->status === 'Completed' ? 'done' : '' }}">{{ $task->task_name }}</div>
                    @if ($task->description)
                        <div class="desc">{{ $task->description }}</div>
                    @endif
                </div>

                <div class="task-meta">
                    <span class="due">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M j') : 'no date' }}</span>
                    <span class="status-word {{ $task->status }}">{{ $task->status }}</span>
                    <div class="row-actions">
                        <a href="{{ route('tasks.edit', $task) }}">edit</a>
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                              onsubmit="return confirm('Delete this entry?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete">delete</button>
                        </form>
                    </div>
                </div>
            </li>
        @empty
            <li class="empty">Nothing on the page yet. Add your first entry.</li>
        @endforelse
    </ul>

</div>
</body>
</html>