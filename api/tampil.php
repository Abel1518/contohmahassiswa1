<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Aplikasi manajemen data mahasiswa - Client Side dengan Fetch API" />
  <title>Data Mahasiswa | Fetch API View</title>
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
      transition: all 0.3s ease;
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

    /* ── Empty / Error / Loading ── */
    .empty, .error, .loading {
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
      max-width: 600px;
      margin: 0 auto;
    }
    
    /* Loading Spinner */
    .spinner {
      border: 3px solid rgba(255,255,255,0.1);
      border-left-color: var(--accent-light);
      border-radius: 50%;
      width: 30px;
      height: 30px;
      animation: spin 1s linear infinite;
      margin: 0 auto 16px auto;
    }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* ── Animate rows ── */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    tbody tr { animation: fadeInUp .3s ease both; }

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
    <div class="header-icon">🚀</div>
    <div>
      <h1>Sistem Informasi Mahasiswa</h1>
      <p>Data Client Side dengan JavaScript Fetch API &middot; Tema Premium</p>
    </div>
  </header>

  <main>
    <div class="top-bar">
      <h2>Daftar Mahasiswa</h2>
      <span class="badge" id="total-badge">Memuat data...</span>
    </div>

    <!-- Container akan dirender menggunakan API -->
    <div id="content-container">
        <div class="loading">
            <div class="spinner"></div>
            Menghubungkan ke API...
        </div>
    </div>
  </main>

  <footer>
    Data Mahasiswa App &middot; HTML/JS + PHP API &middot; Web App Modern UI
  </footer>

  <script>
    // Fungsi untuk mencegah XSS jika data mengandung markup HTML
    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe
             .toString()
             .replace(/&/g, "&amp;")
             .replace(/</g, "&lt;")
             .replace(/>/g, "&gt;")
             .replace(/"/g, "&quot;")
             .replace(/'/g, "&#039;");
    }

    // Melakukan fetch data ke file API PHP
    fetch('api_mahasiswa.php')
      .then(response => {
          if (!response.ok) {
              throw new Error('Terjadi kesalahan pada jaringan/server.');
          }
          return response.json();
      })
      .then(data => {
          const container = document.getElementById('content-container');
          const totalBadge = document.getElementById('total-badge');
          
          totalBadge.textContent = `${data.length} mahasiswa`;

          if (data.length === 0) {
              container.innerHTML = '<p class="empty">📂 Belum ada data mahasiswa dalam Database.</p>';
              return;
          }

          let tableHTML = `
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
                <tbody id="hasil">
                </tbody>
              </table>
            </div>
          `;
          
          container.innerHTML = tableHTML;
          
          const tbody = document.getElementById('hasil');
          let output = '';
          
          // Looping data json hasil fetch
          data.forEach((item, index) => {
              // Format data ke baris tabel. Item id bisa digunakan juga jika perlu: item.id
              output += `
                <tr style="animation-delay: ${index * 0.05}s">
                  <td class="td-num">${index + 1}</td>
                  <td class="td-nama">${escapeHtml(item.nama)}</td>
                  <td class="td-nim">${escapeHtml(item.nim)}</td>
                  <td><span class="td-badge">${escapeHtml(item.jurusan)}</span></td>
                </tr>
              `;
          });
          
          tbody.innerHTML = output;
      })
      .catch(error => {
          console.error("Fetch error: ", error);
          const container = document.getElementById('content-container');
          container.innerHTML = `
            <div class="error-box">
                <b>⚠️ Error:</b> Gagal mengambil data melalui API.<br><br>
                <small>${error.message}</small>
            </div>
          `;
          document.getElementById('total-badge').textContent = 'Error';
          document.getElementById('total-badge').style.background = 'rgba(239,68,68,.15)';
          document.getElementById('total-badge').style.color = '#ef4444';
          document.getElementById('total-badge').style.border = '1px solid rgba(239,68,68,.3)';
      });
  </script>

</body>
</html>
