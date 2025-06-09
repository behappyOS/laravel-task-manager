<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8" />
    <title>Minha App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <style>
        body, .container {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>
<body>
<div class="text-end p-3">
    <button
        id="toggle-theme"
        class="btn btn-outline-secondary btn-sm"
        aria-label="Alternar tema"
        title="Alternar tema"
    >
        <i class="fa-solid fa-moon"></i>
    </button>
</div>

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleBtn = document.getElementById('toggle-theme');
        const htmlTag = document.documentElement;
        const moonIcon = '<i class="fa-solid fa-moon"></i>';
        const sunIcon = '<i class="fa-solid fa-sun"></i>';

        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        let theme = localStorage.getItem('theme') || (systemPrefersDark ? 'dark' : 'light');
        htmlTag.setAttribute('data-bs-theme', theme);
        toggleBtn.innerHTML = theme === 'dark' ? sunIcon : moonIcon;

        toggleBtn.addEventListener('click', () => {
            theme = htmlTag.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            htmlTag.setAttribute('data-bs-theme', theme);
            localStorage.setItem('theme', theme);
            toggleBtn.innerHTML = theme === 'dark' ? sunIcon : moonIcon;
        });
    });
</script>
</body>
</html>
