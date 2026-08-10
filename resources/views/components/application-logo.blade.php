<div {{ ($attributes ?? new \Illuminate\View\ComponentAttributeBag)->merge(['class' => 'flex items-center gap-3']) }}>
    <div class="relative flex items-center justify-center w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-emerald-500 shadow-md shadow-indigo-500/20 ring-1 ring-white/20">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="none" class="w-7 h-7 text-white">
            <rect x="25" y="24" width="50" height="8" rx="4" fill="currentColor" fill-opacity="0.9" />
            <rect x="32" y="18" width="6" height="12" rx="3" fill="currentColor" />
            <rect x="62" y="18" width="6" height="12" rx="3" fill="currentColor" />
            <path d="M34 54 L44 64 L66 42" stroke="currentColor" stroke-width="7" stroke-linecap="round" stroke-linejoin="round" />
            <circle cx="66" cy="42" r="3.5" fill="#10B981" />
        </svg>
    </div>
    <div class="flex flex-col text-right">
        <span class="text-xl font-black tracking-tight text-slate-900 dark:text-white font-sans">إجـــازات</span>
        <span class="text-[10px] font-bold tracking-widest text-indigo-600 dark:text-indigo-400 uppercase -mt-1">Ajazat Platform</span>
    </div>
</div>
