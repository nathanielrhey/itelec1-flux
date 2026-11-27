<style>
    :root {
        --bg: #f6f8f7;
        --surface: #ffffff;
        --surface-muted: #f0f4f2;
        --border: #dce4e0;
        --text: #18231e;
        --muted: #566860;
        --primary: #0f766e;
        --primary-dark: #0d5e57;
        --primary-soft: #e6f4f1;
        --accent: #b45309;
        --accent-soft: #fef3c7;
        --danger: #b91c1c;
        --danger-soft: #fef2f2;
        --danger-border: #fecaca;
        --success: #15803d;
        --success-soft: #f0fdf4;
        --success-border: #bbf7d0;
        --info: #1d4ed8;
        --info-soft: #eff6ff;
        --info-border: #bfdbfe;
        --radius: 12px;
        --shadow: 0 2px 10px rgba(15, 23, 20, 0.05);
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--bg);
        color: var(--text);
        line-height: 1.5;
    }

    a {
        color: var(--primary);
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .container {
        width: 100%;
        max-width: 1120px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .topbar {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        position: sticky;
        top: 0;
        z-index: 20;
    }

    .topbar-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 0;
        position: relative;
    }

    .nav-toggle {
        display: none;
        flex-direction: column;
        justify-content: center;
        gap: 5px;
        width: 36px;
        height: 36px;
        background: none;
        border: 1px solid var(--border);
        border-radius: 8px;
        cursor: pointer;
        padding: 6px;
        flex-shrink: 0;
    }

    .nav-toggle span {
        display: block;
        height: 2px;
        background: var(--text);
        border-radius: 2px;
        transition: transform 0.2s ease, opacity 0.2s ease;
    }

    /* Hamburger → X animation */
    .nav-toggle.is-open span:nth-child(1) {
        transform: translateY(7px) rotate(45deg);
    }
    .nav-toggle.is-open span:nth-child(2) {
        opacity: 0;
        transform: scaleX(0);
    }
    .nav-toggle.is-open span:nth-child(3) {
        transform: translateY(-7px) rotate(-45deg);
    }

    .brand {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text);
    }

    .brand:hover {
        text-decoration: none;
    }

    .brand-logo {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: contain;
        display: block;
    }

    .brand-text {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    .brand-sub {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        color: var(--muted);
        text-transform: uppercase;
    }

    .hero-brand {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .hero-logo {
        height: 78px;
        width: auto;
        object-fit: contain;
        display: block;
        border-radius: 10px;
        background: #ffffff;
        padding: 4px 8px;
        border: 1px solid var(--border);
    }

    .landing-hero {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(240px, 0.85fr);
        gap: 24px;
        align-items: center;
        background: linear-gradient(135deg, #ffffff 0%, #eef7f5 100%);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 30px;
        box-shadow: var(--shadow);
        margin-bottom: 24px;
    }

    .landing-eyebrow {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 999px;
        background: var(--primary-soft);
        color: var(--primary-dark);
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-bottom: 12px;
    }

    .landing-title {
        margin: 0 0 10px;
        font-size: clamp(1.4rem, 5vw, 2rem);
        line-height: 1.2;
        font-weight: 800;
    }

    .landing-copy {
        margin: 0 0 20px;
        color: var(--muted);
        font-size: 1rem;
        max-width: 58ch;
    }

    .landing-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .landing-logo-box {
        background: #ffffff;
        border: 1px solid var(--border);
        border-radius: 14px;
        padding: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow);
    }

    .landing-logo-img {
        width: 100%;
        max-width: 190px;
        height: auto;
        display: block;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 16px 18px;
        box-shadow: var(--shadow);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-dark);
        line-height: 1.2;
    }

    .stat-label {
        margin-top: 4px;
        font-size: 0.84rem;
        color: var(--muted);
        font-weight: 600;
    }

    .filter-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .filter-pills {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-pill {
        padding: 7px 14px;
        border-radius: 999px;
        border: 1px solid var(--border);
        background: var(--surface);
        color: var(--muted);
        font-size: 0.86rem;
        font-weight: 600;
    }

    .filter-pill:hover {
        background: var(--surface-muted);
        color: var(--text);
        text-decoration: none;
    }

    .filter-pill.active {
        background: var(--primary);
        border-color: var(--primary);
        color: #ffffff;
    }

    .search-form {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    @media (max-width: 900px) {
        .landing-hero {
            grid-template-columns: 1fr;
            padding: 22px;
        }

        .landing-logo-box {
            padding: 16px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .search-form input[type="search"],
        .search-form .form-control {
            width: 100%;
        }

        .search-form {
            width: 100%;
        }
    }

    @media (max-width: 640px) {
        .container {
            padding: 0 14px;
        }

        .nav-toggle {
            display: flex;
        }

        .nav {
            display: none;
            flex-direction: column;
            align-items: stretch;
            gap: 4px;
            position: absolute;
            top: calc(100% + 1px);
            left: 0;
            right: 0;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            border-top: 1px solid var(--border);
            padding: 10px 14px 14px;
            z-index: 30;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }

        .nav.nav-open {
            display: flex;
        }

        .nav-link {
            padding: 11px 14px;
            border-radius: 8px;
            font-size: 0.98rem;
            border: 1px solid transparent;
        }

        .nav-link.active {
            border-color: #cce5df;
        }

        .session-bar-inner {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .landing-hero {
            padding: 18px 16px;
            margin-bottom: 18px;
        }

        .landing-title {
            font-size: 1.35rem;
        }

        .landing-copy {
            font-size: 0.93rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-card {
            padding: 12px 14px;
        }

        .stat-value {
            font-size: 1.25rem;
        }

        .filter-bar {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            padding: 16px;
        }

        .filter-pills {
            gap: 6px;
        }

        .filter-pill {
            padding: 6px 12px;
            font-size: 0.82rem;
        }

        .search-form {
            flex-direction: column;
            width: 100%;
        }

        .search-form input,
        .search-form .form-control {
            width: 100% !important;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
        }

        .page-header > div:last-child,
        .page-header > a:last-child {
            align-self: flex-start;
        }

        .card {
            padding: 16px;
        }

        .product-name {
            font-size: 0.97rem;
        }

        .dl-grid {
            grid-template-columns: 1fr;
            gap: 6px;
        }

        .dl-grid dt {
            margin-bottom: 0;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .dl-grid dd {
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border);
        }

        .dl-grid dd:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .form-layout {
            gap: 16px;
        }

        .grid-2,
        .grid-3 {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .main-content {
            padding: 18px 0 36px;
        }

        th, td {
            padding: 10px 10px;
            font-size: 0.84rem;
        }

        .btn {
            padding: 9px 14px;
            font-size: 0.88rem;
        }

        .btn-sm {
            padding: 6px 10px;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 400px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        .brand-text span:first-child {
            font-size: 1rem;
        }
    }

    /* Desktop nav — hidden on mobile via the 640px block below */
    .nav {
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    @media (min-width: 641px) {
        .nav {
            display: flex;
        }
    }

    .nav-link {
        padding: 8px 14px;
        border-radius: 8px;
        color: var(--muted);
        font-weight: 600;
        font-size: 0.92rem;
        transition: background-color 0.15s ease, color 0.15s ease;
    }

    .nav-link:hover {
        background: var(--surface-muted);
        color: var(--text);
        text-decoration: none;
    }

    .nav-link.active {
        background: var(--primary-soft);
        color: var(--primary-dark);
    }

    .session-bar {
        background: var(--primary-soft);
        border-bottom: 1px solid #cce5df;
        font-size: 0.9rem;
    }

    .session-bar-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 0;
        flex-wrap: wrap;
    }

    .session-details {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        color: var(--primary-dark);
    }

    .main-content {
        padding: 28px 0 48px;
    }

    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .page-title {
        margin: 0;
        font-size: clamp(1.25rem, 5vw, 1.7rem);
        font-weight: 700;
        line-height: 1.25;
    }

    .page-subtitle {
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 0.96rem;
    }

    .card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        padding: 22px;
    }

    .card-title {
        margin: 0 0 14px;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .grid-3 {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .form-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.5fr) minmax(280px, 1fr);
        gap: 22px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .grid-3, .grid-2, .form-layout {
            grid-template-columns: 1fr;
        }
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 18px;
        border-radius: 8px;
        border: 1px solid transparent;
        font-size: 0.93rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.15s ease, border-color 0.15s ease;
    }

    .btn:hover {
        text-decoration: none;
    }

    .btn-primary {
        background: var(--primary);
        color: #ffffff;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-secondary {
        background: var(--surface);
        border-color: var(--border);
        color: var(--text);
    }

    .btn-secondary:hover {
        background: var(--surface-muted);
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 0.85rem;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .badge-success {
        background: var(--success-soft);
        color: var(--success);
        border: 1px solid var(--success-border);
    }

    .badge-warning {
        background: var(--accent-soft);
        color: var(--accent);
        border: 1px solid #fde68a;
    }

    .badge-danger {
        background: var(--danger-soft);
        color: var(--danger);
        border: 1px solid var(--danger-border);
    }

    .badge-info {
        background: var(--info-soft);
        color: var(--info);
        border: 1px solid var(--info-border);
    }

    .alert {
        border-radius: 10px;
        padding: 14px 16px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        font-size: 0.94rem;
    }

    .alert-success {
        background: var(--success-soft);
        border-color: var(--success-border);
        color: #14532d;
    }

    .alert-info {
        background: var(--info-soft);
        border-color: var(--info-border);
        color: #1e3a8a;
    }

    .alert-danger {
        background: var(--danger-soft);
        border-color: var(--danger-border);
        color: #7f1d1d;
    }

    .alert ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        font-size: 0.93rem;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 0.95rem;
        font-family: inherit;
        background: #fff;
        color: var(--text);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.14);
    }

    .form-control.is-invalid {
        border-color: var(--danger);
        background: #fffafa;
    }

    .form-hint {
        margin-top: 5px;
        font-size: 0.84rem;
        color: var(--muted);
    }

    .field-error {
        margin-top: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--danger);
    }

    .category-section {
        margin-bottom: 32px;
    }

    .category-header {
        margin-bottom: 14px;
    }

    .category-header h2 {
        margin: 0;
        font-size: 1.25rem;
    }

    .category-header p {
        margin: 4px 0 0;
        color: var(--muted);
        font-size: 0.92rem;
    }

    .product-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 14px;
    }

    .product-name {
        margin: 0 0 6px;
        font-size: 1.04rem;
        font-weight: 700;
    }

    .product-desc {
        margin: 0;
        color: var(--muted);
        font-size: 0.9rem;
    }

    .product-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 12px;
        border-top: 1px solid var(--surface-muted);
    }

    .price {
        font-size: 1.08rem;
        font-weight: 700;
        color: var(--text);
    }

    .dl-grid {
        display: grid;
        grid-template-columns: minmax(100px, 150px) 1fr;
        gap: 10px 14px;
        margin: 0;
        font-size: 0.94rem;
    }

    .dl-grid dt {
        color: var(--muted);
        font-weight: 600;
    }

    .dl-grid dd {
        margin: 0;
        font-weight: 500;
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.92rem;
    }

    th, td {
        padding: 12px 14px;
        text-align: left;
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }

    th {
        background: var(--surface-muted);
        font-weight: 700;
        color: var(--muted);
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    tr.highlight-row {
        background: var(--primary-soft);
    }

    .footer {
        border-top: 1px solid var(--border);
        padding: 18px 0;
        color: var(--muted);
        font-size: 0.86rem;
        text-align: center;
    }

    /* ── Contact Page ── */
    .contact-layout {
        display: grid;
        grid-template-columns: minmax(0, 1.6fr) minmax(260px, 1fr);
        gap: 24px;
        align-items: start;
    }

    .contact-sidebar {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .contact-info-list {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .contact-info-list li {
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }

    .contact-icon {
        font-size: 1.3rem;
        line-height: 1.4;
        flex-shrink: 0;
    }

    .contact-info-list strong {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text);
        margin-bottom: 2px;
    }

    .contact-info-list p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--muted);
        line-height: 1.5;
    }

    .contact-note-card {
        background: var(--primary-soft);
        border-color: #cce5df;
    }

    .contact-note-text {
        margin: 0;
        font-size: 0.9rem;
        color: var(--primary-dark);
        line-height: 1.6;
    }

    .contact-form-footer {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-top: 4px;
    }

    .required-star {
        color: var(--danger);
        font-weight: 700;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 130px;
    }

    @media (max-width: 860px) {
        .contact-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
