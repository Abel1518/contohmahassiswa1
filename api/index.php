<?php
include 'koneksi.php';

$query  = mysqli_query($conn, "SELECT * FROM mahasiswa");
$rows   = [];
while ($data = mysqli_fetch_assoc($query)) {
    $rows[] = $data;
}
$total = count($rows);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Aplikasi manajemen data mahasiswa berbasis PHP dengan TiDB Cloud" />
  <title>Data Mahasiswa | Sistem Informasi Akademik</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --bg-primary:   #0f172a;
      --bg-card:      #1e293b;
      --accent:       #3b82f6;
      --accent-light: #60a5fa;
      --text-primary: #f1f5f9;
      --text-muted:   #94a3b8;
      --border:       #334155;
      --danger:       #ef4444;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: var(--bg-primary);
      color: var(--text-primary);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* ── Header ── */
    header {
      background: linear-gradient(135deg, #1e3a5f 0%, #0f2744 100%);
      border-bottom: 1px solid var(--border);
      padding: 20px 32px;
      display: flex;
      align-items: center;
      gap: 16px;
      box-shadow: 0 4px 24px rgba(0,0,0,.4);
    }
    .header-icon {
      width: 44px; height: 44px;
      border-radius: 12px;
      background: var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-size: 22px; flex-shrink: 0;
    }
    header h1 { font-size: 1.4rem; font-weight: 700; line-height: 1.2; }
    header p  { font-size: .82rem; color: var(--text-muted); margin-top: 3px; }

    /* ── Main ── */
    main { flex: 1; max-width: 900px; margin: 40px auto; padding: 0 24px; width: 100%; }

    .top-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
    }
    .top-bar h2 { font-size: 1.1rem; font-weight: 600; }
    .badge {
      background: rgba(59,130,246,.15);
      color: var(--accent-light);
      border: 1px solid rgba(59,130,246,.3);
      border-radius: 20px;
      padding: 4px 14px;
      font-size: .8rem;
      font-weight: 600;
    }

    /* ── Table ── */
    .table-wrap {
      background: var(--bg-card);
      border-radius: 16px;
      border: 1px solid var(--border);
      overflow: hidden;
      box-shadow: 0 8px 32px rgba(0,0,0,.3);
    }
    table { width: 100%; border-collapse: collapse; }
    thead tr { background: rgba(59,130,246,.12); }
    th {
      padding: 14px 20px;
      font-size: .78rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: .06em;
      color: var(--accent-light);
      border-bottom: 1px solid var(--border);
      text-align: left;
    }
    th:first-child { text-align: center; width: 50px; }
    td { padding: 14px 20px; border-bottom: 1px solid var(--border); }
    tbody tr:last-child td { border-bottom: none; }
    tbody tr { transition: background .2s; }
    tbody tr:hover { background: rgba(255,255,255,.04); }

    .td-num    { text-align: center; color: var(--text-muted); font-size: .85rem; }
    .td-nama   { font-weight: 600; }
    .td-nim    { color: var(--accent-light); font-family: monospace; font-size: .88rem; }
    .td-badge {
      display: inline-block;
      background: rgba(59,130,246,.12);
      border: 1px solid rgba(59,130,246,.25);
      color: var(--accent-light);
      border-radius: 8px;
      padding: 3px 10px;
      font-size: .82rem;
      font-weight: 500;
    }

    /* ── Empty / Error ── */
    .empty {
      text-align: center;
      padding: 60px 0;
      color: var(--text-muted);
      font-size: .95rem;
    }
    .error-box {
      background: rgba(239,68,68,.1);
      border: 1px solid rgba(239,68,68,.4);
      border-radius: 12px;
      padding: 20px 24px;
      color: #fca5a5;
    }

    /* ── Animate rows ── */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    tbody tr { animation: fadeInUp .3s ease both; }
    <?php foreach ($rows as $i => $_): ?>
    tbody tr:nth-child(<?= $i + 1 ?>) { animation-delay: <?= $i * 0.05 ?>s; }
    <?php endforeach; ?>

    /* ── Footer ── */
    footer {
      text-align: center;
      padding: 24px;
      color: var(--text-muted);
      font-size: .78rem;
      border-top: 1px solid var(--border);
      margin-top: 60px;
    }
  </style>
</head>
<body>

  <header>
    <div class="header-icon">🎓</div>
    <div>
      <h1>Sistem Informasi Mahasiswa</h1>
      <p>Powered by PHP &amp; TiDB Cloud · Hosted on Vercel</p>
    </div>
  </header>

  <main>
    <div class="top-bar">
      <h2>Daftar Mahasiswa</h2>
      <span class="badge"><?= $total ?> mahasiswa</span>
    </div>

    <?php if ($total === 0): ?>
      <p class="empty">📂 Belum ada data mahasiswa.</p>
    <?php else: ?>
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Nama</th>
              <th>NIM</th>
              <th>Jurusan</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $i => $m): ?>
            <tr>
              <td class="td-num"><?= $i + 1 ?></td>
              <td class="td-nama"><?= htmlspecialchars($m['nama']) ?></td>
              <td class="td-nim"><?= htmlspecialchars($m['nim']) ?></td>
              <td><span class="td-badge"><?= htmlspecialchars($m['jurusan']) ?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </main>

  <footer>
    Data Mahasiswa App &middot; PHP + TiDB Cloud &middot; Hosted on Vercel
  </footer>

</body>
</html>
