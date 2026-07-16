<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
        <style>
            body { margin: 0; font-family: Inter, system-ui, sans-serif; background: #f8fafc; color: #111827; }
            .page { min-height: 100vh; display: grid; place-items: center; padding: 24px; }
            .card { width: min(100%, 540px); background: white; border-radius: 18px; box-shadow: 0 24px 50px rgba(15, 23, 42, 0.08); padding: 32px; text-align: center; }
            h1 { margin: 0 0 16px; font-size: 2rem; }
            p { color: #4b5563; margin: 0 0 24px; }
            form { display: inline-block; }
            button { padding: 14px 24px; border: none; border-radius: 12px; background: #111827; color: white; font-size: 1rem; cursor: pointer; }
        </style>
    </head>
    <body>
        <main class="page">
            <section class="card">
                <h1>Selamat datang!</h1>
                <p>Anda sudah berhasil masuk. Klik tombol di bawah untuk keluar.</p>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            </section>
        </main>
    </body>
</html>
