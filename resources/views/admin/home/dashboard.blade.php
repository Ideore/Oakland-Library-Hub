@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Books Card -->
        <div class="bg-[#2bf8bd] rounded-lg shadow p-6 text-gray-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-800">Total Books</p>
                    <h3 class="text-3xl font-bold mt-2 text-gray-900">{{ $totalBooks }}</h3>
                </div>
                <div class="bg-teal-400 rounded-full p-3">
                    <svg class="w-8 h-8" fill="currentColor" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 470.721 470.722" xml:space="preserve">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <path
                                    d="M106.037,72.02V50.561c0-5.784-4.693-10.477-10.477-10.477c-5.787,0-10.471,4.693-10.471,10.477v212.805 c0,0.846,0.127,1.662,0.313,2.453c-0.012,17.449-0.018,34.909-0.023,51.524H77.94c-15.737,0-28.611,12.354-29.524,27.869 c0.012,0.946,0.024,1.661,0.036,2.128c0.006,0.284-0.042,0.55-0.059,0.828c0.636,15.77,13.63,28.406,29.548,28.406h7.457 c0.006,7.855,0.018,14.919,0.03,20.954h-9.073c-0.544,0-1.064-0.077-1.596-0.159c-26.403-1.649-47.393-23.59-47.393-50.407 c0-0.608,0.071-1.2,0.088-1.809c-0.319-31.114,0-267.743,0.039-293.496c-0.044-0.364-0.115-0.718-0.115-1.091 C27.376,22.683,50.062,0,77.946,0h16.742h254.048h2.56c5.786,0,10.479,4.69,10.479,10.477v40.164H156.949 C137.045,50.628,119.014,58.836,106.037,72.02z M130.035,418.399c0.012,0.945,0.023,1.667,0.035,2.128 c0,0.283-0.047,0.556-0.059,0.839c0.635,15.759,13.63,28.401,29.554,28.401h262.89v-28.957c0-5.792,4.693-10.479,10.48-10.479 c5.786,0,10.474,4.688,10.474,10.479v39.438c0,5.78-4.688,10.474-10.474,10.474H157.981c-0.553,0-1.073-0.077-1.599-0.166 c-26.4-1.649-47.393-23.59-47.393-50.401c0-0.608,0.074-1.205,0.092-1.814c-0.322-31.114,0-267.739,0.036-293.493 c-0.042-0.37-0.116-0.721-0.116-1.097c0-27.878,22.686-50.563,50.57-50.563h16.742h254.051h2.565 c5.786,0,10.474,4.69,10.474,10.477v296.114c0,5.78-4.688,10.474-10.474,10.474c-0.06,0-0.125-0.018-0.184-0.018 c-0.769,0.184-1.566,0.302-2.394,0.302H159.559C143.821,390.536,130.948,402.89,130.035,418.399z M166.708,336.553 c0,5.787,4.69,10.48,10.477,10.48c5.786,0,10.477-4.693,10.477-10.48V123.75c0-5.787-4.69-10.477-10.477-10.477 c-5.787,0-10.477,4.69-10.477,10.477V336.553z">
                                </path>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Borrowed Books Card -->
        <div class="bg-[#2bf8bd] rounded-lg shadow p-6 text-gray-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-800">Books Borrowed</p>
                    <h3 class="text-3xl font-bold mt-2 text-gray-900">{{ $totalUnreturnedBooks }}</h3>
                </div>
                <div class="bg-teal-400 rounded-full p-3">
                    <svg class="w-8 h-8" fill="currentColor" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 364.975 364.975" xml:space="preserve">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <g>
                                    <path
                                        d="M337.89,225.873c-21.191,1.306-49.055,22.477-75.928,34.648c-32.956,14.904-84.235,2.926-84.241,2.926 c7.927-3.715,40.072-11.371,46.543-14.222c34.411-15.134,31.479-46.698,15.095-46.433c-21.64,0.365-34.367,5.68-77.566,11.572 c-32.748,4.449-71.479,2.822-90.055,9.914c-26.223,10.02-68.445,77.412-68.445,77.412l65.293,63.283 c0,0,40.436-39.816,60.1-39.816c44.832,0,46.639-0.617,88.253-2.864c17.709-0.946,21.387-1.673,31.525-5.087 c53.957-18.24,111.883-66.817,112.949-72.664C363.866,231.012,349.065,225.177,337.89,225.873z">
                                    </path>
                                    <path
                                        d="M68.598,180.044c1.799,1.153,4.049,1.333,5.975,0.463c34.951-15.699,70.385-15.699,105.328,0 c1.639,0.722,3.521,0.722,5.161,0c34.946-15.699,70.385-15.699,105.326,0c0.805,0.361,1.695,0.55,2.559,0.55 c1.203,0,2.393-0.343,3.422-1.013c1.783-1.15,2.865-3.132,2.865-5.263V18.455c0-4.282-3.629-5.704-3.746-5.754 C276.745,4.276,257.513,0,238.339,0c-16.865,0-33.785,3.336-50.398,9.876v76.738c0,3.018-2.432,5.464-5.463,5.464 c-3.006,0-5.463-2.446-5.463-5.464V9.876C160.419,3.336,143.501,0,126.632,0C107.466,0,88.226,4.276,69.47,12.701 c-0.113,0.05-3.74,1.911-3.74,5.754v156.326C65.729,176.912,66.807,178.893,68.598,180.044z M78.282,145.092 c15.947-6.306,32.178-9.512,48.35-9.512c18.254,0,36.631,4.085,54.572,12.15c0.803,0.36,1.748,0.36,2.555,0 c17.943-8.065,36.318-12.15,54.58-12.15c16.164,0,32.396,3.206,48.338,9.512v20.295c-16.148-6.085-32.578-9.16-48.973-9.16 c-18.52,0-37.088,3.927-55.227,11.702c-18.129-7.776-36.697-11.702-55.227-11.702c-16.391,0-32.816,3.076-48.969,9.161 L78.282,145.092L78.282,145.092z">
                                    </path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Available Books Card -->
        <div class="bg-[#2bf8bd] rounded-lg shadow p-6 text-gray-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-800">Available Copies</p>
                    <h3 class="text-3xl font-bold mt-2 text-gray-900">{{ $availableBooks }}</h3>
                </div>
                <div class="bg-teal-400 rounded-full p-3">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Members Card -->
        <div class="bg-[#2bf8bd] rounded-lg shadow p-6 text-gray-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-800">Active Borrowers</p>
                    <h3 class="text-3xl font-bold mt-2 text-gray-900">{{ $activeMembers }}</h3>
                </div>
                <div class="bg-teal-400 rounded-full p-3">
                    <svg fill="currentColor" class="w-8 h-8" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" xml:space="preserve">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <style type="text/css">
                                .st0 {
                                    fill: none;
                                }
                            </style>
                            <path
                                d="M7.5,5C5.6,5,4,6.6,4,8.5S5.6,12,7.5,12S11,10.4,11,8.5S9.4,5,7.5,5z M16.5,5C14.6,5,13,6.6,13,8.5s1.6,3.5,3.5,3.5 S20,10.4,20,8.5S18.4,5,16.5,5z M7.5,14C2.6,14,1,18,1,18v2h13v-2C14,18,12.4,14,7.5,14z M16.5,14c-1.5,0-2.7,0.4-3.6,0.9 c1.4,1.2,2,2.6,2.1,2.7l0.1,0.2V20h8v-2C23,18,21.4,14,16.5,14z">
                            </path>
                            <rect class="st0" width="24" height="24"></rect>
                        </g>
                    </svg>
                </div>
            </div>
        </div>
    </div>


    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

        <!-- Pie Chart -->
        <div class="bg-gray-800 dark:bg-gray-800 bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold text-white dark:text-white text-gray-900">Book Activity Status</h3>
                    <p class="text-sm text-gray-400 dark:text-gray-400 text-gray-600 mt-1">Borrowed, overdue, returned late, and returned books</p>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="w-46 h-46 lg:w-86 lg:h-86 my-8">
                    <canvas id="pie-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="bg-gray-800 dark:bg-gray-800 bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-white dark:text-white text-gray-900">Borrowing Activity</h3>
                    <p class="text-sm text-gray-400 dark:text-gray-400 text-gray-600 mt-1">Books borrowed in the last 7 days</p>
                </div>
            </div>
            <div class="relative h-80 lg:h-96">
                <canvas id="bar-chart"></canvas>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to get text color based on current theme
            function getTextColor() {
                return document.documentElement.classList.contains('dark') ? '#ffffff' : '#1f2937';
            }

            // Function to get grid color based on current theme
            function getGridColor() {
                return document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb';
            }

            // Function to update chart colors
            function updateChartColors() {
                const textColor = getTextColor();
                const gridColor = getGridColor();
                
                // Update pie chart
                if (window.pieChart) {
                    window.pieChart.options.plugins.legend.labels.color = textColor;
                    window.pieChart.update();
                }
                
                // Update bar chart
                if (window.barChart) {
                    window.barChart.options.scales.y.ticks.color = textColor;
                    window.barChart.options.scales.x.ticks.color = textColor;
                    window.barChart.options.scales.y.grid.color = gridColor;
                    window.barChart.options.scales.x.grid.color = gridColor;
                    window.barChart.update();
                }
            }

            // ---------- Pie Chart ----------
            const pieCtx = document.getElementById('pie-chart').getContext('2d');

            // Book activity status breakdown - using exact same logic as Book Activity page
            const borrowedCount = {{ $borrowedBooks }}; // Not returned AND not past return date
            const overdueCount = {{ $overdueBooks }}; // Not returned AND past return date
            const returnedLateCount = {{ $returnedLateBooks }}; // Returned AND returned after return date
            const returnedCount = {{ $returnedBooks }}; // Returned AND returned on or before return date

            // Debug: Log the values to console
            console.log('Chart Data (matching Book Activity page):', {
                borrowed: borrowedCount,
                overdue: overdueCount,
                returnedLate: returnedLateCount,
                returned: returnedCount
            });

            // Filter out zero values and their corresponding labels/colors
            const chartData = [];
            const chartLabels = [];
            const chartColors = [];
            
            const allData = [
                { label: "Borrowed", value: borrowedCount, color: '#2bf8bd' },      // Primary teal - matches theme
                { label: "Overdue", value: overdueCount, color: '#f87171' },        // Soft coral red - less harsh
                { label: "Returned Late", value: returnedLateCount, color: '#fbbf24' }, // Warm amber - sophisticated
                { label: "Returned", value: returnedCount, color: '#34d399' }       // Emerald green - complements teal
            ];

            // Only show categories that have actual data (value > 0)
            const hasAnyData = allData.some(item => item.value > 0);
            
            if (hasAnyData) {
                // Only include categories with values greater than 0
                allData.forEach(item => {
                    if (item.value > 0) {
                        chartData.push(item.value);
                        chartLabels.push(item.label);
                        chartColors.push(item.color);
                    }
                });
            } else {
                // Show a message when no data is available at all
                chartData.push(1);
                chartLabels.push('No Activity Data');
                chartColors.push('#4b5563');
            }

            const pieData = {
                labels: chartLabels,
                datasets: [{
                    data: chartData,
                    backgroundColor: chartColors,
                    borderColor: 'transparent',
                    borderWidth: 0
                }]
            };

            window.pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: pieData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: getTextColor(),
                                font: { family: 'Inter, sans-serif', size: 14, weight: 400 },
                                padding: 20
                            }
                        },
                        tooltip: {
                            enabled: chartData.length > 1 || chartLabels[0] !== 'No Activity Data',
                            callbacks: {
                                label: function (context) {
                                    if (context.label === 'No Activity Data') {
                                        return 'No book activity data available';
                                    }
                                    
                                    // Since we only show categories with actual values, use the chart data directly
                                    return context.label + ': ' + context.raw;
                                }
                            }
                        }
                    }
                }
            });

            // ---------- Bar Chart ----------
            const barCtx = document.getElementById('bar-chart').getContext('2d');

            const barData = {
                labels: [
                    @foreach($last7Days as $day)
                        '{{ $day['date'] }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Books Borrowed',
                    data: [
                        @foreach($last7Days as $day)
                            {{ (int)$day['count'] }},
                        @endforeach
                    ],
                    backgroundColor: '#2bf8bd',
                    borderRadius: 8
                }]
            };

            window.barChart = new Chart(barCtx, {
                type: 'bar',
                data: barData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10
                        }
                    },
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { 
                                color: getTextColor(),
                                stepSize: 1,
                                padding: 10
                            },
                            grid: { color: getGridColor() }
                        },
                        x: {
                            ticks: { 
                                color: getTextColor(),
                                padding: 10
                            },
                            grid: { color: getGridColor() }
                        }
                    }
                }
            });

            // Listen for theme changes and update charts
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        updateChartColors();
                    }
                });
            });

            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        });
    </script>
@endpush