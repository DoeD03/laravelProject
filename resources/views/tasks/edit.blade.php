<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Entry — The Daybook</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --paper: #f6f1e7;
            --panel: #fffdf9;
            --ink: #2a2420;
            --ink-soft: #6b6156;
            --rule: #ddd2bc;
            --green: #33513a;
            --green-light: #4c6e52;
            --red: #a5483f;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--paper);
            color: var(--ink);
            margin: 0;
            min-height: 100vh;
            padding: 3rem 1.25rem;
        }

        .page {
            max-width: 480px;
            margin: 0 auto;
            background: var(--panel);
            border: 1px solid var(--rule);
            box-shadow: 4px 4px 0 -2px var(--paper), 4px 4px 0 -1px var(--rule);
            padding: 2.5rem 2.25rem 2rem;
        }

        h1 {
            font-family: 'Fraunces', serif;
            font-weight: 600;
            font-size: 1.7rem;
            margin: 0 0 1.6rem;
            padding-bottom: .8rem;
            border-bottom: 2px solid var(--ink);
        }

        .field { margin-bottom: 1.3rem; }

        label {
            display: block;
            font-size: .78rem;
            color: var(--ink-soft);
            margin-bottom: .4rem;
            letter-spacing: .01em;
        }

        input, textarea {
            width: 100%;
            padding: .6rem 0;
            border: none;
            border-bottom: 1px solid var(--rule);
            background: transparent;
            font: inherit;
            font-size: .95rem;
            color: var(--ink);
            transition: border-color .15s ease;
        }

        input::placeholder, textarea::placeholder { color: #b0a692; }

        input:hover, textarea:hover { border-bottom-color: var(--ink-soft); }

        input:focus, textarea:focus {
            outline: none;
            border-bottom-color: var(--green);
        }

        textarea { min-height: 90px; resize: vertical; }

        .invalid { border-bottom-color: var(--red); }
        .error-text { color: var(--red); font-size: .78rem; margin-top: .35rem; }

        .buttons { display: flex; gap: 1.3rem; align-items: center; margin-top: 1.8rem; }

        .btn {
            display: inline-block;
            padding: .6rem 1.3rem;
            border-radius: 2px;
            border: 1px solid var(--green);
            background: var(--green);
            color: var(--panel);
            font-size: .87rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background-color .15s ease, border-color .15s ease, transform .1s ease;
        }

        .btn:hover {
            background: var(--green-light);
            border-color: var(--green-light);
            transform: translateY(-1px);
        }

        .cancel {
            font-size: .85rem;
            color: var(--ink-soft);
            text-decoration: none;
            border-bottom: 1px solid transparent;
        }

        .cancel:hover { color: var(--ink); border-bottom-color: var(--ink-soft); }
    </style>
</head>
<body>
<div class="page">

    <h1>Edit entry</h1>

    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')

        <div class="field">
            <label for="task_name">Task</label>
            <input type="text" id="task_name" name="task_name"
                   value="{{ old('task_name', $task->task_name) }}"
                   class="@error('task_name') invalid @enderror" autofocus>
            @error('task_name')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="description">Notes (optional)</label>
            <textarea id="description" name="description"
                      class="@error('description') invalid @enderror">{{ old('description', $task->description) }}</textarea>
            @error('description')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="field">
            <label for="due_date">Due (optional)</label>
            <input type="date" id="due_date" name="due_date"
                   value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}"
                   class="@error('due_date') invalid @enderror">
            @error('due_date')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="buttons">
            <button type="submit" class="btn">Save changes</button>
            <a href="{{ route('tasks.index') }}" class="cancel">Cancel</a>
        </div>
    </form>

</div>
</body>
</html>