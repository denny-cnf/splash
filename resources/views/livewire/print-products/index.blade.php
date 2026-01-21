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
                        <!-- Формат -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Формат</label>
                            <select @change="calculate" x-model="formatPrice"
                                    class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 focus:border-blue-500">
                                <option value="0">Выберите формат</option>
                                @foreach($paperFormat as $pf)
                                    <option value="{{ $pf->price }}" data-width="{{ $pf->width }}" data-height="{{ $pf->height }}">
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

                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Заливка</label>
                        <div class="flex items-center gap-4 text-sm">
                            <label class="flex items-center space-x-1">
                                <input type="radio" x-model="coverage" value="none" @change="calculate">
                                <span>Обычная</span>
                            </label>
                            <label class="flex items-center space-x-1">
                                <input type="radio" x-model="coverage" value="medium" @change="calculate">
                                <span>Средняя (+30%)</span>
                            </label>
                            <label class="flex items-center space-x-1">
                                <input type="radio" x-model="coverage" value="full" @change="calculate">
                                <span>Полная (+60%)</span>
                            </label>
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
                            <template x-for="(type, index) in filteredDensities" :key="type.id">
                                <option :value="type.price"
                                        :selected="selectedType == type.price"
                                        x-text="type.density + ' г/м² (' + type.price + ' тг)'">
                                </option>
                            </template>
                        </select>
                    </div>
                </div>

                    <button @click="showServices = !showServices" class="w-full bg-gray-100 px-4 py-2 rounded-md border text-left hover:bg-gray-200">
                        Добавить услугу +
                    </button>
                    <div x-show="showServices" class="p-4 bg-white border rounded-md space-y-4 mt-2">
                        <div class="flex justify-between items-center">
                            <label>Биговка (1 биг = +5 тг):</label>
                            <input type="number" min="0" class="w-24 border rounded px-2 py-1" x-model.number="bigovka">
                        </div>
                        <div class="flex justify-between items-center">
                            <label>Перфорация (1 линия = +5 тг):</label>
                            <input type="number" min="0" class="w-24 border rounded px-2 py-1" x-model.number="perforation">
                        </div>
                        <div class="flex justify-between items-center">
                            <label>Скругление углов (+5 тг):</label>
                            <input type="checkbox" x-model="roundCorners">
                        </div>
                        <div class="flex justify-between items-center">
                            <label>Нумерация (+5 тг):</label>
                            <input type="checkbox" x-model="numeration">
                        </div>
                    </div>
                    <div class="mt-2 text-sm">Доп. услуги: <span x-text="getExtrasPrice() + ' тг'"></span></div>

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
    function calculator() {
        return {
            formatPrice: 0,
            typePrice: 0,
            paperName: '',
            colorPrice: 0,
            coverage: 'none', // 'none', 'medium', 'full'
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

            getExtrasPrice() {
                return (this.bigovka + this.perforation) * 5 + (this.roundCorners ? 5 : 0) + (this.numeration ? 5 : 0);
            },

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

                // Запретить выключение K на лицевой стороне
                if (side === 'front' && color.name === 'K') {
                    return;
                }

                if (color.name === 'K') {
                    const kSelected = color.selected;
                    const anyColorOn = this[side].some(c => colorKeys.includes(c.name) && c.selected);

                    if (kSelected && anyColorOn) {
                        // Если K выключается при активных CMY — сбросить всё
                        this[side] = this[side].map(c => ({ ...c, selected: false }));

                        // Если это front — сразу вернуть K
                        if (side === 'front') {
                            this[side] = this[side].map(c =>
                                c.name === 'K'
                                    ? { ...c, selected: true }
                                    : c
                            );
                        }
                    } else {
                        color.selected = !color.selected;
                    }
                } else {
                    const anyColorOn = this[side].some(c => colorKeys.includes(c.name) && c.selected);

                    if (!anyColorOn) {
                        this[side] = this[side].map(c =>
                            colorKeys.includes(c.name)
                                ? { ...c, selected: true }
                                : c
                        );

                        if (!this[side].find(c => c.name === 'K')?.selected) {
                            this[side] = this[side].map(c =>
                                c.name === 'K'
                                    ? { ...c, selected: true }
                                    : c
                            );
                        }
                    } else {
                        this[side] = this[side].map(c =>
                            colorKeys.includes(c.name)
                                ? { ...c, selected: false }
                                : c
                        );
                    }
                }

                this.calculate();
            },

            getPrintMode() {
                const count = list => list.filter(c => c.selected).length;
                return `${count(this.front)}+${count(this.back)}`;
            },

            getColorPrice() {
                if (!Array.isArray(this.front) || !Array.isArray(this.back)) return 0;

                const classify = (side) => {
                    const k = side.find(c => c.name === 'K')?.selected ?? false;
                    const color = side.some(c => ['C', 'M', 'Y'].includes(c.name) && c.selected);
                    return { k, color };
                };

                const f = classify(this.front);
                const b = classify(this.back);
                const val = (s) => s.color ? 4 : (s.k ? 1 : 0);
                const key = `${val(f)}+${val(b)}`;

                return parseFloat(colorModePrices[key]) || 0;
            },

            paperTypes: {!! json_encode($paperType->map(function($pt) {
                return [
                    'id' => $pt->id,
                    'name' => $pt->name,
                    'density' => $pt->density,
                    'price' => $pt->price,
                ];
            })->values()) !!},

            selectedName: '',
            filteredDensities: [],
            selectedType: 0,

            filterDensities() {
                this.filteredDensities = this.paperTypes.filter(p =>
                    p.name === this.selectedName
                );

                if (this.filteredDensities.length > 0) {
                    this.selectedType = this.filteredDensities[0].price;
                    this.updatePaper();
                } else {
                    this.selectedType = 0;
                    this.typePrice = 0;
                    this.calculate();
                }
            },

            updatePaper() {
                const selected = this.paperTypes.find(p => p.price == this.selectedType);
                this.paperName = selected?.name + ' ' + selected?.density + ' г/м²' || '';
                this.typePrice = parseFloat(this.selectedType) || 0;
                this.calculate();
            },

            toFixedPrice(value) {
                const number = parseFloat(value);
                return isNaN(number) ? '0.00' : number.toFixed(2);
            },

            calculate() {
                const format = parseFloat(this.formatPrice) || 0;
                const type = parseFloat(this.typePrice) || 0;
                let color = this.getColorPrice();

                let multiplier = 1;
                if (this.coverage === 'medium') multiplier = 1.3;
                if (this.coverage === 'full') multiplier = 1.6;
                color = Math.round(color * multiplier);
                this.colorPrice = color;

                const qty = parseInt(this.quantity) || 1;

                let width, height;
                if (this.formatPrice === 'custom') {
                    width = parseInt(this.customWidth) || 0;
                    height = parseInt(this.customHeight) || 0;
                } else {
                    const selected = document.querySelector('select[x-model="formatPrice"] option:checked');
                    width = parseInt(selected.getAttribute('data-width')) || 0;
                    height = parseInt(selected.getAttribute('data-height')) || 0;
                }

                const sheetW = 320, sheetH = 450;
                const margin = parseFloat(this.margin);
                const gap = parseFloat(this.gap);

                const usableW = sheetW - 2 * margin;
                const usableH = sheetH - 2 * margin;

                let fitX = Math.floor((usableW + gap) / (width + gap));
                let fitY = Math.floor((usableH + gap) / (height + gap));
                let count = fitX * fitY;

                let fitXAlt = Math.floor((usableW + gap) / (height + gap));
                let fitYAlt = Math.floor((usableH + gap) / (width + gap));
                let altCount = fitXAlt * fitYAlt;

                if (altCount > count) count = altCount;

                const fitPerSheet = count > 0 ? count : 1;
                const sheetPrice = format + type + color;
                const sheetsNeeded = Math.ceil(qty / fitPerSheet);

                const rawTotalPrice = sheetPrice * sheetsNeeded + this.getExtrasPrice() * qty;
                const rawUnitPrice = rawTotalPrice / qty;

                this.totalPrice = rawTotalPrice;
                this.unitPrice = this.toFixedPrice(rawUnitPrice);

                drawSheet(width, height, margin, gap);
            },

            downloadPdf() {
                const { jsPDF } = window.jspdf;
                const fontBase64 = ""

                // Define the custom font
                const customFont = {
                    data: fontBase64,
                    name: "CustomFont",
                    encoding: "WinAnsiEncoding",
                    isBase64: true
                };

                const doc = new jsPDF();

                // Add custom font to jsPDF
                doc.addFileToVFS('CustomFont.ttf', customFont.data);
                doc.addFont('CustomFont.ttf', 'CustomFont', 'normal');

                // Use custom font in PDF
                doc.setFont('CustomFont');

                doc.setFontSize(16);
                doc.text("Расчет печатной продукции", 10, 10);

                const format = parseFloat(this.formatPrice) || 0;
                const type = parseFloat(this.typePrice) || 0;
                const color = parseFloat(this.colorPrice) || 0;
                const qty = parseInt(this.quantity) || 1;
                const sheetPrice = format + type + color;

                let width, height;
                if (this.formatPrice === 'custom') {
                    width = parseInt(this.customWidth) || 0;
                    height = parseInt(this.customHeight) || 0;
                } else {
                    const selected = document.querySelector('select[x-model="formatPrice"] option:checked');
                    width = parseInt(selected.getAttribute('data-width')) || 0;
                    height = parseInt(selected.getAttribute('data-height')) || 0;
                }

                let coverageLabel = 'Обычная';
                if (this.coverage === 'medium') coverageLabel = 'Средняя (+30%)';
                if (this.coverage === 'full') coverageLabel = 'Полная (+60%)';

                const sheetW = 320, sheetH = 450;
                const margin = parseFloat(this.margin);
                const gap = parseFloat(this.gap);

                const usableW = sheetW - 2 * margin;
                const usableH = sheetH - 2 * margin;

                let fitX = Math.floor((usableW + gap) / (width + gap));
                let fitY = Math.floor((usableH + gap) / (height + gap));
                let count = fitX * fitY;

                let fitXAlt = Math.floor((usableW + gap) / (height + gap));
                let fitYAlt = Math.floor((usableH + gap) / (width + gap));
                let altCount = fitXAlt * fitYAlt;

                if (altCount > count) {
                    count = altCount;
                }

                const fitPerSheet = count > 0 ? count : 1;
                const sheetsNeeded = Math.ceil(qty / fitPerSheet);

                doc.setFontSize(12);
                doc.text(`Формат: ${width} × ${height} мм`, 10, 20);
                doc.text(`Тип бумаги: ${this.paperName}`, 10, 25);
                doc.text(`Цветность: ${this.getPrintMode()}`, 10, 30);
                doc.text(`Цена цвета: ${this.toFixedPrice(color)} тенге`, 10, 35);
                doc.text(`Тип заливки: ${coverageLabel}`, 10, 40);
                doc.text(`Цена листа: ${this.toFixedPrice(sheetPrice)} тенге`, 10, 50);

                doc.text(`Количество копий: ${qty} шт`, 10, 70);
                doc.text(`На 1 листе: ${fitPerSheet} шт`, 10, 80);
                doc.text(`Всего листов: ${sheetsNeeded} шт`, 10, 90);

                doc.setFontSize(14);
                doc.text(`Цена за штуку: ${this.unitPrice} тенге`, 10, 120);
                doc.text(`Итоговая цена: ${this.totalPrice} тенге`, 10, 110);

                doc.save("calculation.pdf");
            }
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

        let rotated = false;
        if (altCount > count) {
            [fitX, fitY] = [altFitX, altFitY];
            [formatW, formatH] = [formatH, formatW];
            rotated = true;
            count = altCount;
        }

        // Общий размер блока с учётом всех форматов и промежутков
        const totalBlockW = fitX * formatW + (fitX - 1) * gap;
        const totalBlockH = fitY * formatH + (fitY - 1) * gap;

        // Центровка внутри листа
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

