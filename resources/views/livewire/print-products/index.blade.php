<div>
    <x-app-layout>
        <x-slot name="header" cl>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Печатная продукция') }}
            </h2>
        </x-slot>
        <div class="flex justify-center mt-6">
            <div class="flex flex-col lg:flex-row justify-center gap-8" x-data="calculator()">
                <!-- Левый блок-->
                <div class="p-6 bg-gray-100 space-y-6 w-full lg:w-[400px]">
                    <div class="flex flex-wrap gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Принтер</label>
                            <select x-model="selectedMachineId" @change="calculate"
                                    class="mt-1 w-full border rounded-md shadow-sm">
                                <option value="">Выберите принтер</option>
                                <template x-for="m in machines" :key="m.id">
                                    <option :value="m.id" x-text="m.name"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Формат -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Формат</label>
                            <select @change="calculate" x-model="formatPrice"
                                    class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
                                <option value="0">Выберите формат</option>
                                @foreach($paperFormat as $pf)
                                    <option value="{{ $pf->id }}" data-width="{{ $pf->width }}" data-height="{{ $pf->height }}">
                                        {{ $pf->name }}
                                    </option>
                                @endforeach
                                <option value="custom">Свой формат</option>
                            </select>
                            <div x-show="formatPrice === 'custom'" class="mt-2">
                                <label class="block text-sm font-medium text-gray-700">Ширина (мм)</label>
                                <input type="number" x-model="customWidth" @input="calculate" class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">

                                <label class="block text-sm font-medium text-gray-700 mt-2">Высота (мм)</label>
                                <input type="number" x-model="customHeight" @input="calculate" class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
                            </div>
                        </div>

                        <!--Цветность-->
                        <div class="space-y-2">
                            <p class="block text-sm font-medium text-gray-700">Цветность</p>
                            <!-- Лицевая сторона -->
                            <div class="flex gap-2">
                                <template x-for="(color, index) in front">
                                    <div
                                        class="w-6 h-6 rounded-full cursor-pointer border border-gray-300"
                                        :style="`background-color: ${color.selected ? color.hex : '#ccc'}`"
                                        @click="toggleColor('front', index)">
                                        <span class="block text-xs text-center text-white leading-[24px]" x-text="color.name"></span>
                                    </div>
                                </template>
                            </div>

                            <!-- Обратная сторона -->
                            <div class="flex gap-2">
                                <template x-for="(color, index) in back">
                                    <div
                                        class="w-6 h-6 rounded-full cursor-pointer border border-gray-300"
                                        :style="`background-color: ${color.selected ? color.hex : '#ccc'}`"
                                        @click="toggleColor('back', index)">
                                        <span class="block text-xs text-center text-white leading-[24px]" x-text="color.name"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-3 text-sm text-gray-600">
                                Выбрано: <strong x-text="getPrintMode()"></strong>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap md:flex-nowrap gap-4 items-end">
                        <!-- Категория бумаги -->
                        <div class="w-full md:w-1/2">
                            <label class="block text-sm font-medium text-gray-700">Тип бумаги</label>
                            <select x-model="selectedName" @change="filterDensities"
                                    class="mt-1 w-full border rounded-md shadow-sm">
                                <option value="">Выберите вид бумаги</option>
                                @foreach($paperType->pluck('name')->unique() as $name)
                                    <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Плотность бумаги -->
                        <div class="w-full md:w-1/2">
                            <label class="block text-sm font-medium text-gray-700">Плотность</label>
                            <select x-model="selectedType" @change="updatePaper"
                                    class="mt-1 w-full border rounded-md shadow-sm">
                                <template x-for="type in filteredDensities" :key="type.id">
                                    <option :value="type.id"
                                            x-text="type.density + ' г/м²'">
                                    </option>
                                </template>
                            </select>
                        </div>

                        <!-- Множитель бумаги -->
                        <div class=" hidden w-full md:w-1/2">
                            <label class="block text-sm font-medium text-gray-700">
                                Множитель бумаги
                            </label>

                            <input type="number"
                                   step="0.1"
                                   min="0"
                                   x-model="CFG.PAPER_MULTIPLIER"
                                   @input="updatePaper"
                                   class="mt-1 w-full border rounded-md shadow-sm px-2 py-1"
                                   placeholder="Напр. 2">
                        </div>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Заливка</label>
                        <div class="flex items-center gap-4 text-sm">
                            <label class="flex items-center space-x-1">
                                <input type="radio" x-model="coverage" value="none" @change="calculate">
                                <span>Обычная</span>
                            </label>
                            <label class="flex items-center space-x-1">
                                <input type="radio" x-model="coverage" value="medium" @change="calculate">
                                <span>Средняя</span>
                            </label>
                            <label class="flex items-center space-x-1">
                                <input type="radio" x-model="coverage" value="full" @change="calculate">
                                <span>Полная</span>
                            </label>
                        </div>
                    </div>

{{--                    <button @click="showServices = !showServices" class="w-full bg-gray-100 px-4 py-2 rounded-md border text-left hover:bg-gray-200">--}}
{{--                        Добавить услугу +--}}
{{--                    </button>--}}
{{--                    <div x-show="showServices" class="p-4 bg-white border rounded-md space-y-4 mt-2">--}}
{{--                        <div class="flex justify-between items-center">--}}
{{--                            <label>Биговка (1 биг = +5 тг):</label>--}}
{{--                            <input type="number" min="0" class="w-24 border rounded px-2 py-1" x-model.number="bigovka">--}}
{{--                        </div>--}}
{{--                        <div class="flex justify-between items-center">--}}
{{--                            <label>Перфорация (1 линия = +5 тг):</label>--}}
{{--                            <input type="number" min="0" class="w-24 border rounded px-2 py-1" x-model.number="perforation">--}}
{{--                        </div>--}}
{{--                        <div class="flex justify-between items-center">--}}
{{--                            <label>Скругление углов (+5 тг):</label>--}}
{{--                            <input type="checkbox" x-model="roundCorners">--}}
{{--                        </div>--}}
{{--                        <div class="flex justify-between items-center">--}}
{{--                            <label>Нумерация (+5 тг):</label>--}}
{{--                            <input type="checkbox" x-model="numeration">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="mt-2 text-sm">Доп. услуги: <span x-text="getExtrasPrice() + ' тг'"></span></div>--}}

                    <!-- Тираж -->
                <div class="flex items-center justify-center space-x-2">
                    <label class="text-sm text-dark-700">ТИРАЖ</label>
                    <input type="number" x-model="quantity" @input="calculate"
                           class="w-20 text-center border-b border-black focus:outline-none bg-transparent" min="1" value="1">
                    <span class="text-sm text-dark-700">ШТ.</span>
                </div>

                <div class="flex flex-wrap justify-center gap-3">
                    <button class="bg-[#0a0a0a] text-white px-4 py-2 rounded shadow">За 1 ед. - <span x-text="unitPrice"></span> тг.</button>
                    <button class="bg-[#0a0a0a] text-white px-4 py-2 rounded shadow" x-text="totalPrice + ' тг.'"></button>
                    <button class="w-full" @click="downloadPdf()">Выгрузить в PDF</button>
                </div>

                </div>
                <!--Правый блок-->
                <div class="border border-gray-400 p-4 bg-white dark:bg-gray-800 dark:text-gray-200 w-[360px]">
                    <h3 class="font-semibold text-center mb-2">Размещение на листе 320×450 мм</h3>
                    <div class="relative w-[320px] h-[450px] bg-gray-200 mx-auto" id="sheet-container"></div>
                    <div class="flex flex-col justify-center mt-2">
                        <div class="text-center text-sm mt-2">Форматов на листе: <span id="fit-count">0</span></div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 text-center">Между элементами (мм)</label>
                            <input type="number" x-model="gap" @input="calculate"
                                   class="w-full border rounded px-2 py-1 text-center shadow-sm dark:text-gray-600">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </x-app-layout>
</div>

<script>
    const colorModePrices = @json($colorModes->pluck('price', 'name'));
    const machines = @json($machines);

    function calculator() {
        return {
            // =========================
            // CONFIG
            // =========================
            CFG: {
                // бумага
                PAPER_MULTIPLIER: 2,

                // CMY логика
                CMY_SET: 3,        // комплект C+M+Y (для "цены за единицу" CMY)
                MULTICOLOR: 3,     // доп. ×3 (мультицвет) в цветной базе для toner_cmy + baraban_cmy

                // ставки по базе
                BW_RATE_MULT: 10,     // bwBase * 10
                COLOR_RATE_MULT: 5,   // colorBase * 5

                // округление итоговой ставки (за 1 изделие с учетом сторон)
                ROUND_BW_TO: 5,       // ч/б вверх до 5
                ROUND_COLOR_TO: 10,   // цвет вверх до 10

                // заливка
                COVERAGE_MULTIPLIERS: {
                    none: 1,
                    medium: 1.25,
                    full: 1.5,
                },
                // Тираж коэффиценты
                TIRAGE_MULTIPLIERS: [
                    { from: 1,   to: 49,  k: 1.2 },
                    { from: 50,  to: 99,  k: 1.0 },
                    { from: 100, to: 299, k: 0.9 },
                    { from: 300, to: Infinity, k: 0.8 },
                ],

                // доп услуги
                EXTRA_PRICE_PER_UNIT: 5,
            },

            // =========================
            // Printer calc outputs
            // =========================
            bwRate: 0,      // bwBase * BW_RATE_MULT
            colorRate: 0,   // colorBase * COLOR_RATE_MULT

            machineBwBase: 0,     // 2.43
            machineColorBase: 0,  // 23.24

            // =========================
            // Data
            // =========================
            machines: machines,
            selectedMachineId: "",

            // =========================
            // UI state
            // =========================
            formatPrice: 0,
            typePrice: 0,
            paperName: '',
            colorPrice: 0,
            coverage: 'none',
            quantity: 1,
            margin: 0,
            gap: 2,
            unitPrice: 0,
            totalPrice: 0,
            customWidth: 0,
            customHeight: 0,

            showServices: false,
            bigovka: 0,
            perforation: 0,
            roundCorners: false,
            numeration: false,

            // =========================
            // Helpers
            // =========================
            round2(n) {
                const x = parseFloat(n);
                return isNaN(x) ? 0 : Math.round(x * 100) / 100;
            },

            roundUp(value, step) {
                const v = parseFloat(value) || 0;
                const s = parseFloat(step) || 1;
                return Math.ceil(v / s) * s;
            },

            toFixedPrice(value) {
                const number = parseFloat(value);
                return isNaN(number) ? '0.00' : number.toFixed(2);
            },

            // =========================
            // Extras
            // =========================
            getExtrasPrice() {
                const p = this.CFG.EXTRA_PRICE_PER_UNIT;
                return (this.bigovka + this.perforation) * p + (this.roundCorners ? p : 0) + (this.numeration ? p : 0);
            },

            // Получить множитель тиража
            getTirageMultiplier(qty) {
                for (const row of this.CFG.TIRAGE_MULTIPLIERS) {
                    if (qty >= row.from && qty <= row.to) {
                        return row.k;
                    }
                }
                return 1;
            },

            // =========================
            // Colors (existing logic)
            // =========================
            front: [
                { name: 'C', hex: '#00FFFF', selected: false },
                { name: 'M', hex: '#FF00FF', selected: false },
                { name: 'Y', hex: '#FFFF00', selected: false },
                { name: 'K', hex: '#000000', selected: true }
            ],
            back: [
                { name: 'C', hex: '#00FFFF', selected: false },
                { name: 'M', hex: '#FF00FF', selected: false },
                { name: 'Y', hex: '#FFFF00', selected: false },
                { name: 'K', hex: '#000000', selected: false }
            ],

            toggleColor(side, index) {
                const color = this[side][index];
                const colorKeys = ['C', 'M', 'Y'];

                if (side === 'front' && color.name === 'K') return;

                if (color.name === 'K') {
                    const kSelected = color.selected;
                    const anyColorOn = this[side].some(c => colorKeys.includes(c.name) && c.selected);

                    if (kSelected && anyColorOn) {
                        this[side] = this[side].map(c => ({ ...c, selected: false }));
                        if (side === 'front') {
                            this[side] = this[side].map(c => c.name === 'K' ? { ...c, selected: true } : c);
                        }
                    } else {
                        color.selected = !color.selected;
                    }
                } else {
                    const anyColorOn = this[side].some(c => colorKeys.includes(c.name) && c.selected);

                    if (!anyColorOn) {
                        this[side] = this[side].map(c => colorKeys.includes(c.name) ? { ...c, selected: true } : c);
                        if (!this[side].find(c => c.name === 'K')?.selected) {
                            this[side] = this[side].map(c => c.name === 'K' ? { ...c, selected: true } : c);
                        }
                    } else {
                        this[side] = this[side].map(c => colorKeys.includes(c.name) ? { ...c, selected: false } : c);
                    }
                }

                this.calculate();
            },

            getPrintMode() {
                const count = list => list.filter(c => c.selected).length;
                return `${count(this.front)}+${count(this.back)}`;
            },

            // =========================
            // Machine
            // =========================
            getSelectedMachine() {
                return this.machines.find(m => String(m.id) === String(this.selectedMachineId));
            },

            // База ч/б и база цвет
            getMachineBases() {
                const machine = this.getSelectedMachine();
                if (!machine) return { bwBase: 0, colorBase: 0 };

                const links = machine.machine_consumables || [];

                let bwBase = 0;
                let colorBase = 0;

                const { CMY_SET, MULTICOLOR } = this.CFG;

                for (const mc of links) {
                    const price = parseFloat(mc.price) || 0;
                    const resource = parseFloat(mc.resource) || 0;
                    if (price <= 0 || resource <= 0) continue;

                    const applies = (mc.consumable?.applies_to || "all").toLowerCase();
                    const code = mc.consumable?.code || "";

                    const raw = price / resource;

                    // "цена за единицу": для CMY считаем комплект (×3) и округляем до 2 знаков
                    const perUnit = (code === "toner_cmy" || code === "baraban_cmy")
                        ? this.round2(raw * CMY_SET)
                        : this.round2(raw);

                    // ч/б база: bw + all
                    if (applies === "bw" || applies === "all") {
                        bwBase += perUnit;
                    }

                    // цветная база: все позиции входят, CMY позиции дополнительно ×MULTICOLOR
                    if (code === "toner_cmy" || code === "baraban_cmy") {
                        colorBase += perUnit * MULTICOLOR;
                    } else {
                        colorBase += perUnit;
                    }
                }

                return { bwBase: this.round2(bwBase), colorBase: this.round2(colorBase) };
            },

            syncMachineRates() {
                const { bwBase, colorBase } = this.getMachineBases();

                this.machineBwBase = bwBase;
                this.machineColorBase = colorBase;

                this.bwRate = bwBase * this.CFG.BW_RATE_MULT;
                this.colorRate = colorBase * this.CFG.COLOR_RATE_MULT;
            },

            getSidesByType() {
                const sideType = (side) => {
                    const k = side.find(c => c.name === 'K')?.selected ?? false;
                    const cmy = side.some(c => ['C','M','Y'].includes(c.name) && c.selected);
                    if (cmy) return "color";
                    if (k) return "bw";
                    return "none";
                };

                const frontType = sideType(this.front);
                const backType  = sideType(this.back);

                const bwSides = (frontType === "bw" ? 1 : 0) + (backType === "bw" ? 1 : 0);
                const colorSides = (frontType === "color" ? 1 : 0) + (backType === "color" ? 1 : 0);

                return { bwSides, colorSides };
            },

            getFinalBwPrice() {
                const { bwSides } = this.getSidesByType();
                if (bwSides === 0) return 0;
                const total = this.bwRate * 2 * bwSides;
                return this.roundUp(total, this.CFG.ROUND_BW_TO);
            },

            getFinalColorPrice() {
                const { colorSides } = this.getSidesByType();
                if (colorSides === 0) return 0;
                const total = this.colorRate * 2 * colorSides;
                return this.roundUp(total, this.CFG.ROUND_COLOR_TO);
            },

            getFinalMachinePricePerItem() {
                return this.getFinalBwPrice() + this.getFinalColorPrice();
            },

            // =========================
            // Paper types
            // =========================
            paperTypes: {!! json_encode($paperType->map(function($pt) {
                return [
                  'id' => $pt->id,
                  'name' => $pt->name,
                  'density' => $pt->density,
                  'price' => $pt->price,
                  'sheets' => $pt->sheets,
                ];
            })->values()) !!},

            selectedName: '',
            filteredDensities: [],
            selectedType: 0,

            filterDensities() {
                this.filteredDensities = this.paperTypes.filter(p => p.name === this.selectedName);

                if (this.filteredDensities.length > 0) {
                    this.selectedType = this.filteredDensities[0].id;
                    this.updatePaper();
                } else {
                    this.selectedType = 0;
                    this.typePrice = 0;
                    this.calculate();
                }
            },

            updatePaper() {
                const selected = this.paperTypes.find(p => p.id == this.selectedType);
                this.paperName = selected ? `${selected.name} ${selected.density} г/м²` : '';

                const price = parseFloat(selected?.price) || 0;
                const sheets = parseFloat(selected?.sheets) || 1;
                const basePaperPrice = sheets > 0 ? (price / sheets) : 0;

                this.typePrice = basePaperPrice * this.CFG.PAPER_MULTIPLIER;

                this.calculate();
            },

            // =========================
            // Main calc
            // =========================
            calculate() {
                const type   = parseFloat(this.typePrice) || 0;
                const color  = 0;

                const qty = parseInt(this.quantity) || 1;

                let width, height;
                if (this.formatPrice === 'custom') {
                    width = parseInt(this.customWidth) || 0;
                    height = parseInt(this.customHeight) || 0;
                } else {
                    const selected = document.querySelector('select[x-model="formatPrice"] option:checked');
                    width = parseInt(selected?.getAttribute('data-width')) || 0;
                    height = parseInt(selected?.getAttribute('data-height')) || 0;
                }

                // ЗАЩИТА от деления на 0
                if (!width || !height) {
                    this.totalPrice = 0;
                    this.unitPrice = this.toFixedPrice(0);
                    return;
                }

                const sheetW = 320, sheetH = 450;
                const margin = parseFloat(this.margin) || 0;
                const gap    = parseFloat(this.gap) || 0;

                const usableW = sheetW - 2 * margin;
                const usableH = sheetH - 2 * margin;

                let fitX = Math.floor((usableW + gap) / (width + gap));
                let fitY = Math.floor((usableH + gap) / (height + gap));
                let count = fitX * fitY;

                let fitXAlt = Math.floor((usableW + gap) / (height + gap));
                let fitYAlt = Math.floor((usableH + gap) / (width + gap));
                let altCount = fitXAlt * fitYAlt;

                if (altCount > count) count = altCount;

                const fitPerSheet  = count > 0 ? count : 1;
                const sheetPrice   = type + color;
                const sheetsNeeded = Math.ceil(qty / fitPerSheet);

                const paperTotal  = sheetPrice * sheetsNeeded;
                const extrasTotal = this.getExtrasPrice() * qty;

                this.syncMachineRates();

                const machinePricePerItem  = this.getFinalMachinePricePerItem();
                const machinePricePerSheet = machinePricePerItem * fitPerSheet;
                const machineTotal         = machinePricePerSheet * sheetsNeeded;

                const baseTotal = (sheetPrice * sheetsNeeded) + machineTotal + (this.getExtrasPrice() * qty);

                const tirageMultiplier = this.getTirageMultiplier(qty);
                const totalWithTirage = this.roundUp(baseTotal * tirageMultiplier, 5);

                const coverageMultiplier = this.CFG.COVERAGE_MULTIPLIERS[this.coverage] ?? 1;
                const rawTotalPrice = Math.round(totalWithTirage * coverageMultiplier);
                const rawUnitPrice  = this.roundUp(rawTotalPrice / qty, 5);

                // DEBUG
                console.log("====== DEBUG ======");
                console.log("fitPerSheet:", fitPerSheet);
                console.log("sheetsNeeded:", sheetsNeeded);
                console.log("qty:", qty);

                console.log("machinePricePerItem:", machinePricePerItem);
                console.log("machinePricePerSheet:", machinePricePerSheet);
                console.log("machineTotal:", machineTotal);

                console.log("paperTotal:", paperTotal);
                console.log("extrasTotal:", extrasTotal);

                console.log("baseTotal:", baseTotal);
                console.log("tirageMultiplier:", tirageMultiplier);
                console.log("totalWithTirage:", totalWithTirage);
                console.log("coverageMultiplier:", coverageMultiplier);
                console.log("FINAL:", rawTotalPrice);
                console.log("===========================");

                this.totalPrice = rawTotalPrice;
                this.unitPrice  = this.toFixedPrice(rawUnitPrice);

                drawSheet(width, height, margin, gap);
            },
        }
    }

    function drawSheet(formatW, formatH) {
        const sheetW = 320;
        const sheetH = 450;
        const container = document.getElementById('sheet-container');
        container.innerHTML = '';

        if (!formatW || !formatH) return;

        const scale = 1;
        const margin = parseFloat(document.querySelector('[x-model="margin"]')?.value || 0);
        const gap = parseFloat(document.querySelector('[x-model="gap"]')?.value || 0);

        const usableW = sheetW - 2 * margin;
        const usableH = sheetH - 2 * margin;

        let fitX = Math.floor((usableW + gap) / (formatW + gap));
        let fitY = Math.floor((usableH + gap) / (formatH + gap));
        let count = fitX * fitY;

        const altFitX = Math.floor((usableW + gap) / (formatH + gap));
        const altFitY = Math.floor((usableH + gap) / (formatW + gap));
        const altCount = altFitX * altFitY;

        if (altCount > count) {
            fitX = altFitX;
            fitY = altFitY;
            count = altCount;
            [formatW, formatH] = [formatH, formatW];
        }

        const totalBlockW = fitX * formatW + (fitX - 1) * gap;
        const totalBlockH = fitY * formatH + (fitY - 1) * gap;

        const offsetX = Math.max(0, (sheetW - totalBlockW) / 2);
        const offsetY = Math.max(0, (sheetH - totalBlockH) / 2);

        document.getElementById('fit-count').innerText = count;

        for (let y = 0; y < fitY; y++) {
            for (let x = 0; x < fitX; x++) {
                const block = document.createElement('div');
                block.style.width = formatW * scale + 'px';
                block.style.height = formatH * scale + 'px';
                block.style.position = 'absolute';
                block.style.left = (offsetX + x * (formatW + gap)) + 'px';
                block.style.top = (offsetY + y * (formatH + gap)) + 'px';
                block.style.border = '1px solid #000';
                block.style.boxSizing = 'border-box';
                block.style.backgroundColor = 'rgba(255,255,255,0.6)';
                container.appendChild(block);
            }
        }
    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

