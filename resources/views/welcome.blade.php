<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Полиграфия «Splash»</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <style>
            :root{
                --bg:#FDFDFC;
                --text:#1b1b18;
                --muted:#706f6c;
                --card:#ffffff;
                --border: rgba(27,27,24,.12);
                --shadow: 0 10px 30px rgba(0,0,0,.06);
                --radius: 14px;
            }
            @media (prefers-color-scheme: dark){
                :root{
                    --bg:#0a0a0a;
                    --text:#ededec;
                    --muted:#a1a09a;
                    --card:#161615;
                    --border: rgba(255,255,255,.10);
                    --shadow: 0 10px 30px rgba(0,0,0,.35);
                }
            }
            *{box-sizing:border-box}
            body{
                margin:0;
                font-family: "Instrument Sans", ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
                background:var(--bg);
                color:var(--text);
            }
            .wrap{max-width:1100px;margin:0 auto;padding:24px}
            .topbar{display:flex;align-items:center;justify-content:flex-end}
            .hero{
                margin-top:18px;
                border:1px solid var(--border);
                background:var(--card);
                border-radius:var(--radius);
                box-shadow:var(--shadow);
                overflow:hidden;
            }
            .hero-inner{
                display:grid;
                grid-template-columns: 1.2fr 0.8fr;
                gap:24px;
                padding:28px;
            }
            @media (max-width: 900px){
                .hero-inner{grid-template-columns:1fr}
            }
            .badge{
                display:inline-flex;
                gap:8px;
                align-items:center;
                border:1px solid var(--border);
                padding:6px 10px;
                border-radius:999px;
                font-size:12px;
                color:var(--muted);
                width:max-content;
            }
            h1{font-size:40px;line-height:1.1;margin:14px 0 10px}
            @media (max-width: 600px){ h1{font-size:32px} }
            p{margin:0 0 14px;color:var(--muted);line-height:1.6}
            .btns{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px}
            .btn{
                display:inline-flex;align-items:center;justify-content:center;
                padding:10px 14px;border-radius:10px;
                border:1px solid var(--border);
                text-decoration:none;color:var(--text);
                font-weight:600;font-size:14px;
                transition: transform .12s ease, background .12s ease;
            }
            .btn:hover{transform: translateY(-1px)}
            .btn-primary{background:var(--text);color:var(--bg);border-color: transparent}
            .btn-primary:hover{filter:brightness(1.05)}
            .grid{
                display:grid;
                grid-template-columns: repeat(3, 1fr);
                gap:12px;
                margin-top:18px;
            }
            @media (max-width: 900px){ .grid{grid-template-columns:1fr} }
            .card{
                border:1px solid var(--border);
                border-radius:12px;
                padding:14px;
                background: transparent;
            }
            .card h3{margin:0 0 6px;font-size:16px}
            .card p{margin:0;font-size:13px}
            .side{
                border-left:1px dashed var(--border);
                padding-left:24px;
            }
            @media (max-width: 900px){
                .side{border-left:none;border-top:1px dashed var(--border);padding-left:0;padding-top:18px}
            }
            .list{margin:12px 0 0;padding:0;list-style:none;display:grid;gap:10px}
            .li{
                display:flex;gap:10px;align-items:flex-start;
                padding:10px;border:1px solid var(--border);
                border-radius:12px;
            }
            .dot{
                width:10px;height:10px;border-radius:999px;margin-top:4px;
                background: color-mix(in oklab, var(--text) 30%, transparent);
            }
            .li strong{display:block;font-size:14px;margin-bottom:2px}
            .li span{display:block;font-size:13px;color:var(--muted);line-height:1.4}
            .footer{
                margin:16px 0 0;
                padding:14px 4px 0;
                color:var(--muted);
                font-size:12px;
                display:flex;
                justify-content:space-between;
                gap:10px;
                flex-wrap:wrap;
            }
        </style>

        <!-- Styles / Scripts -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
    <div class="wrap">
{{--        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">--}}
{{--            --}}
{{--        </header>--}}

        <section class="hero">
            <div class="hero-inner">
                <div>
                    <div class="badge mb-4">
                        <span style="width:8px;height:8px;border-radius:999px;background:color-mix(in oklab, var(--text) 45%, transparent);display:inline-block"></span>
                        Полиграфия «Splash» • печать • дизайн • наружная реклама
                    </div>

                    <h1>Мы печатаем красиво и быстро</h1>
                    <p>
                        Визитки, листовки, буклеты, наклейки, баннеры и другая полиграфия.
                        Поможем с макетом, согласуем тираж и сроки — без лишней бюрократии.
                    </p>

                    <div class="btns">
                        <a class="btn btn-primary" href="#order">Рассчитать заказ</a>
                        <a class="btn" href="#services">Услуги</a>
                        <a class="btn" href="#contacts">Контакты</a>
                    </div>

                    <div id="services" class="grid" aria-label="Услуги">
                        <div class="card">
                            <h3>Визитки</h3>
                            <p>Классические, премиум, выбор бумаги и ламинации.</p>
                        </div>
                        <div class="card">
                            <h3>Листовки и буклеты</h3>
                            <p>A6–A3, фальцовка, подбор плотности и покрытия.</p>
                        </div>
                        <div class="card">
                            <h3>Наклейки</h3>
                            <p>На листе/в рулоне, контурная резка, мат/глянец.</p>
                        </div>
                    </div>
                </div>

                <aside class="side">
                    <h3 style="margin:0 0 10px;font-size:16px">Почему мы</h3>
                    <ul class="list">
                        <li class="li">
                            <span class="dot"></span>
                            <div>
                                <strong>Сроки от 1 дня</strong>
                                <span>Оперативно печатаем популярные позиции.</span>
                            </div>
                        </li>
                        <li class="li">
                            <span class="dot"></span>
                            <div>
                                <strong>Поможем с дизайном</strong>
                                <span>Проверим макет и подскажем, как лучше подготовить.</span>
                            </div>
                        </li>
                        <li class="li">
                            <span class="dot"></span>
                            <div>
                                <strong>Контроль качества</strong>
                                <span>Цвет, рез, упаковка — всё проверяем перед выдачей.</span>
                            </div>
                        </li>
                    </ul>

                    <div id="order" style="margin-top:14px">
                        <h3 style="margin:0 0 10px;font-size:16px">Быстрый расчёт</h3>
                        <div class="card">
                            <p style="margin:0 0 10px">
                                Оставьте заявку — мы уточним детали и вернёмся с ценой.
                            </p>
                            <form action="#" style="display:grid;gap:10px">
                                <input
                                    name="name"
                                    placeholder="Ваше имя"
                                    style="padding:10px;border-radius:10px;border:1px solid var(--border);background:transparent;color:var(--text)"
                                />
                                <input
                                    name="phone"
                                    placeholder="Телефон / WhatsApp"
                                    style="padding:10px;border-radius:10px;border:1px solid var(--border);background:transparent;color:var(--text)"
                                />
                                <textarea
                                    name="details"
                                    rows="3"
                                    placeholder="Что печатаем? (например: визитки 1000 шт, 4+4, матовая ламинация)"
                                    style="padding:10px;border-radius:10px;border:1px solid var(--border);background:transparent;color:var(--text);resize:vertical"
                                ></textarea>
                                <button type="submit" class="btn btn-primary" style="cursor:pointer">
                                    Отправить
                                </button>
                                <div style="font-size:12px;color:var(--muted)">
                                    Нажимая “Отправить”, вы соглашаетесь на обработку данных.
                                </div>
                            </form>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <footer id="contacts" class="footer">
            <div>© {{ date('Y') }} Полиграфия «Splash» |
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}">
                            Админ.панель
                        </a>
                    @else
                        <a href="{{ route('login') }}">Вход для сотрудников</a>

                        {{--                        @if (Route::has('register'))--}}
                        {{--                            <a--}}
                        {{--                                href="{{ route('register') }}"--}}
                        {{--                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">--}}
                        {{--                                Register--}}
                        {{--                            </a>--}}
                        {{--                        @endif--}}
                    @endauth
                @endif
            </div>

            <div>
                Тел/WhatsApp: <a href="tel:+77072038734" style="text-decoration:none;">8 (707) 203‒87‒34</a>
                Email:
                <a href="mailto:zakaz@splash.kz" style="text-decoration:underline">zakaz@splash.kz</a>
            </div>
        </footer>
    </div>
    </body>
</html>
