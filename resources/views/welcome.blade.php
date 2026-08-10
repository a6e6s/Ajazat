<!DOCTYPE html>
<html lang="ar" dir="rtl" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>منصة إجازات | نظام إدارة الإجازات الذكي</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo-icon.svg') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Vite / CDN fallback for absolute stability) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            direction: 'rtl',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Cairo', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            900: '#312e81',
                        }
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .gradient-text {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #10B981 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 50%, #059669 100%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-indigo-500 selection:text-white min-h-screen flex flex-col justify-between">

    <!-- Top Navigation Header -->
    <header class="sticky top-0 z-50 glass-panel border-b border-slate-200/80 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-500 to-emerald-500 flex items-center justify-center shadow-lg shadow-indigo-500/25 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" viewBox="0 0 100 100" fill="none">
                        <rect x="25" y="24" width="50" height="8" rx="4" fill="currentColor" fill-opacity="0.9"/>
                        <rect x="32" y="18" width="6" height="12" rx="3" fill="currentColor"/>
                        <rect x="62" y="18" width="6" height="12" rx="3" fill="currentColor"/>
                        <path d="M34 54 L44 64 L66 42" stroke="currentColor" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="66" cy="42" r="3.5" fill="#10B981"/>
                    </svg>
                </div>
                <div class="flex flex-col text-right">
                    <span class="text-2xl font-black tracking-tight text-slate-900 leading-tight">إجـــازات</span>
                    <span class="text-[10px] font-bold tracking-widest text-indigo-600 uppercase">منصة إدارة الإجازات</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-8 font-semibold text-slate-600 text-sm">
                <a href="#features" class="hover:text-indigo-600 transition-colors">المميزات</a>
                <a href="#stats" class="hover:text-indigo-600 transition-colors">الإحصائيات</a>
                <a href="#workflow" class="hover:text-indigo-600 transition-colors">كيف يعمل النظام</a>
            </nav>

            <!-- Authentication CTA Button -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="/admin" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-white gradient-bg hover:opacity-95 shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 h1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        لوحة التحكم
                    </a>
                @else
                    <a href="/admin/login" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-white gradient-bg hover:opacity-95 shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        تسجيل الدخول
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-12 pb-20 md:pt-20 md:pb-32 overflow-hidden bg-gradient-to-b from-indigo-50/50 via-white to-slate-50">
        <!-- Background Ambient Glow -->
        <div class="absolute top-1/4 right-1/2 translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-200/40 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/3 right-1/4 w-[400px] h-[400px] bg-emerald-200/30 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-100/80 border border-indigo-200 text-indigo-800 text-xs font-bold mb-8 shadow-sm">
                <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span>النظام العصري لإدارة إجازات وأرصدة الموظفين</span>
            </div>

            <!-- Main Headline -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-slate-900 tracking-tight leading-tight max-w-4xl mx-auto mb-6">
                إدارة إجازات فريقك <br>
                <span class="gradient-text">بذكاء، سرعة وشفافية مطلقة</span>
            </h1>

            <!-- Subtitle -->
            <p class="text-lg sm:text-xl text-slate-600 max-w-2xl mx-auto font-medium leading-relaxed mb-10">
                منصة متكاملة تُربط الأقسام، تُحسب أرصدة الإجازات تلقائياً، وتتيح دورة موافقات شفافة وسلسة للمدراء والموظفين.
            </p>

            <!-- Call to Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                <a href="/admin/login" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-lg font-bold text-white gradient-bg shadow-xl shadow-indigo-500/30 hover:shadow-indigo-500/50 hover:-translate-y-1 transition-all duration-200">
                    <span>الدخول إلى النظام</span>
                    <svg class="w-6 h-6 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="#features" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-lg font-bold text-slate-700 bg-white border border-slate-200 shadow-sm hover:bg-slate-50 hover:border-slate-300 transition-all duration-200">
                    استكشاف المميزات
                </a>
            </div>

            <!-- UI Showcase Card Mockup -->
            <div class="relative max-w-5xl mx-auto rounded-3xl p-3 bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-500 shadow-2xl shadow-indigo-500/20">
                <div class="bg-slate-900 rounded-2xl p-6 sm:p-8 text-right text-white overflow-hidden shadow-inner">
                    <!-- Dashboard Mock Header -->
                    <div class="flex items-center justify-between pb-6 border-b border-slate-800 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="flex items-center gap-2 bg-slate-800/80 px-4 py-1.5 rounded-xl text-xs text-slate-300 font-mono">
                            <span>admin@admin.com</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        </div>
                    </div>

                    <!-- Mini Grid Mock -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Card 1 -->
                        <div class="bg-slate-800/60 p-5 rounded-xl border border-slate-700/50">
                            <div class="text-slate-400 text-xs font-bold mb-1">الرصيد المتبقي (سنوي)</div>
                            <div class="text-3xl font-black text-emerald-400">18 يوم</div>
                            <div class="text-slate-400 text-[11px] mt-2">من أصل 21 يوم مستحق</div>
                        </div>
                        <!-- Card 2 -->
                        <div class="bg-slate-800/60 p-5 rounded-xl border border-slate-700/50">
                            <div class="text-slate-400 text-xs font-bold mb-1">طلبات قيد الانتظار</div>
                            <div class="text-3xl font-black text-amber-400">2 طلبات</div>
                            <div class="text-slate-400 text-[11px] mt-2">بانتظار موافقة المدير المباشر</div>
                        </div>
                        <!-- Card 3 -->
                        <div class="bg-slate-800/60 p-5 rounded-xl border border-slate-700/50">
                            <div class="text-slate-400 text-xs font-bold mb-1">إجمالي الأقسام</div>
                            <div class="text-3xl font-black text-indigo-400">4 أقسام</div>
                            <div class="text-slate-400 text-[11px] mt-2">هيكلية إدارية منظمة</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-bold uppercase tracking-widest text-indigo-600 mb-2">مميزات المنصة</h2>
                <p class="text-3xl sm:text-4xl font-extrabold text-slate-900">كل ما تحتاجه لإدارة إجازات المؤسسة في مكان واحد</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200/70 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-6 font-bold text-2xl">
                        ⚖️
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">احتساب الأرصدة تلقائياً</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        تتبع فوري للأيام المستحقة والمستهلكة والتعديلات مع احتساب المتبقي تلقائياً لكل موظف.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200/70 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mb-6 font-bold text-2xl">
                        ✅
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">اعتماد ورفض بلمسة واحدة</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        إمكانية الموافقة، الرفض مع بيان السبب، أو إلغاء الطلبات مع تسجيل كامل لسجل القرارات.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200/70 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mb-6 font-bold text-2xl">
                        🏢
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">تنظيم الأقسام والموظفين</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        ربط الموظفين بالأقسام والمدراء المباشرين لتحديد التسلسل الإداري والصلاحيات بدقة.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-slate-50 p-8 rounded-2xl border border-slate-200/70 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center mb-6 font-bold text-2xl">
                        🎨
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">أنواع إجازات مخصصة</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        إمكانية تعريف أنواع إجازات متعددة (سنوية، مرضية، طارئة) بألوان متميزة واشتراط المرفقات.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-16 gradient-bg text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl sm:text-5xl font-black mb-2">100%</div>
                    <div class="text-indigo-100 text-sm font-semibold">دقة في احتساب رصيد الإجازات</div>
                </div>
                <div>
                    <div class="text-4xl sm:text-5xl font-black mb-2">&lt; 1 دقيقة</div>
                    <div class="text-indigo-100 text-sm font-semibold">معدل تنفيذ واعتماد الطلبات</div>
                </div>
                <div>
                    <div class="text-4xl sm:text-5xl font-black mb-2">24/7</div>
                    <div class="text-indigo-100 text-sm font-semibold">وصول مباشر من أي جهاز</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-icon.svg') }}" class="w-8 h-8" alt="إجازات">
                <span class="text-lg font-bold text-white">إجـــازات | Ajazat Platform</span>
            </div>
            <div class="text-xs text-slate-500">
                جميع الحقوق محفوظة &copy; {{ date('Y') }} منصة إجازات لإدارة الموارد البشرية.
            </div>
            <div>
                <a href="/admin/login" class="text-xs font-bold text-indigo-400 hover:text-indigo-300 underline">
                    تسجيل دخول المشرفين والموظفين
                </a>
            </div>
        </div>
    </footer>

</body>
</html>
