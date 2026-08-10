<style>
    /* =========================================================
       Ajazat Platform — Modern Dashboard & Sidebar Theme
       Light & Dark Mode Optimized
       ========================================================= */

    /* Root Colors & Font */
    :root {
        --brand-indigo: #4f46e5;
        --brand-indigo-light: #6366f1;
        --brand-emerald: #10b981;
    }

    /* 1. Global Page Background & Smooth Transitions */
    .fi-body, body {
        background-color: #f8fafc !important;
        font-family: 'Cairo', system-ui, sans-serif !important;
        transition: background-color 0.3s ease, color 0.3s ease !important;
    }

    .dark .fi-body, .dark body {
        background-color: #090d16 !important;
    }

    /* 2. Glassmorphism Sidebar */
    .fi-sidebar,
    .fi-main-sidebar,
    div.fi-sidebar,
    #fi-main-sidebar {
        background: rgba(241, 245, 249, 0.88) !important;
        backdrop-filter: blur(16px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(16px) saturate(180%) !important;
        border-inline-end: 1px solid rgba(226, 232, 240, 0.8) !important;
        box-shadow: 4px 0 24px 0 rgba(15, 23, 42, 0.04) !important;
    }

    .dark .fi-sidebar,
    .dark .fi-main-sidebar,
    .dark div.fi-sidebar,
    .dark #fi-main-sidebar {
        background: rgba(15, 23, 42, 0.85) !important;
        backdrop-filter: blur(20px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(20px) saturate(180%) !important;
        border-inline-end: 1px solid rgba(255, 255, 255, 0.08) !important;
        box-shadow: 4px 0 30px 0 rgba(0, 0, 0, 0.4) !important;
    }

    /* Sidebar Header (Logo Container) */
    .fi-sidebar-header-ctn,
    .fi-sidebar-header {
        background: rgba(255, 255, 255, 0.6) !important;
        backdrop-filter: blur(10px) !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
    }

    .dark .fi-sidebar-header-ctn,
    .dark .fi-sidebar-header {
        background: rgba(15, 23, 42, 0.7) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    /* Sidebar Group Titles */
    .fi-sidebar-group-label,
    .fi-sidebar-group-label * {
        color: #475569 !important;
        font-weight: 800 !important;
        font-size: 0.75rem !important;
        letter-spacing: 0.05em !important;
    }

    .dark .fi-sidebar-group-label,
    .dark .fi-sidebar-group-label * {
        color: #94a3b8 !important;
    }

    /* Sidebar Navigation Items */
    .fi-sidebar-item-btn,
    .fi-sidebar-item a,
    .fi-sidebar-group-btn {
        border-radius: 0.75rem !important;
        transition: all 0.2s ease-in-out !important;
        margin-top: 2px !important;
        margin-bottom: 2px !important;
        color: #334155 !important;
        font-weight: 600 !important;
    }

    .dark .fi-sidebar-item-btn,
    .dark .fi-sidebar-item a,
    .dark .fi-sidebar-group-btn {
        color: #cbd5e1 !important;
    }

    /* Hover Item */
    .fi-sidebar-item-btn:hover,
    .fi-sidebar-item a:hover,
    .fi-sidebar-group-btn:hover {
        background: rgba(99, 102, 241, 0.1) !important;
        color: #4f46e5 !important;
    }

    .dark .fi-sidebar-item-btn:hover,
    .dark .fi-sidebar-item a:hover,
    .dark .fi-sidebar-group-btn:hover {
        background: rgba(99, 102, 241, 0.2) !important;
        color: #a5b4fc !important;
    }

    /* Active Item (Glowing Indigo Pill) */
    .fi-sidebar-item-active,
    .fi-sidebar-item-active .fi-sidebar-item-btn,
    .fi-sidebar-item-active a,
    a.fi-sidebar-item-active {
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%) !important;
        box-shadow: 0 4px 16px 0 rgba(79, 70, 229, 0.35) !important;
        border-radius: 0.75rem !important;
    }

    .fi-sidebar-item-active *,
    .fi-sidebar-item-active .fi-sidebar-item-label,
    .fi-sidebar-item-active .fi-sidebar-item-icon {
        color: #ffffff !important;
        font-weight: 700 !important;
    }

    /* 3. Topbar Glass Styling */
    .fi-topbar {
        background: rgba(255, 255, 255, 0.8) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.8) !important;
    }

    .dark .fi-topbar {
        background: rgba(15, 23, 42, 0.8) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    /* 4. Stat Widgets & Card Containers */
    .fi-wi-stats-overview-stat,
    .fi-section,
    .fi-ta,
    .fi-card {
        border-radius: 1.25rem !important;
        border: 1px solid rgba(226, 232, 240, 0.9) !important;
        background: #ffffff !important;
        box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.04), 0 2px 6px -1px rgba(15, 23, 42, 0.02) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }

    .dark .fi-wi-stats-overview-stat,
    .dark .fi-section,
    .dark .fi-ta,
    .dark .fi-card {
        background: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5) !important;
    }

    .fi-wi-stats-overview-stat:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 12px 28px -4px rgba(79, 70, 229, 0.12) !important;
    }

    /* 5. Table Header & Rows */
    .fi-ta-header {
        padding: 1.25rem 1.5rem !important;
    }

    .fi-ta-table th {
        font-weight: 700 !important;
        color: #475569 !important;
        background: rgba(248, 250, 252, 0.7) !important;
    }

    .dark .fi-ta-table th {
        color: #94a3b8 !important;
        background: rgba(15, 23, 42, 0.5) !important;
    }

    .fi-ta-row:hover {
        background-color: rgba(241, 245, 249, 0.6) !important;
    }

    .dark .fi-ta-row:hover {
        background-color: rgba(30, 41, 59, 0.6) !important;
    }

    /* 6. Custom Sleek Scrollbars */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    ::-webkit-scrollbar-track {
        background: transparent;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(148, 163, 184, 0.4);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(99, 102, 241, 0.6);
    }
</style>
