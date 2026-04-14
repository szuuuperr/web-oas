<x-dashboard-layout>
    <div class="p-6 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
        <!-- Header & Actions -->
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="font-headline text-xl font-extrabold text-on-surface">Manager Dashboard</h2>
                <p class="text-xs text-slate-500 font-medium">Ringkasan strategis dan pemantauan operasional</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('manager.export') }}" class="flex items-center gap-2 bg-surface-container-lowest border border-outline-variant px-4 py-2 rounded-lg text-primary text-xs font-bold uppercase tracking-widest hover:bg-surface-container-low transition-all">
                    <span class="material-symbols-outlined text-sm" data-icon="assessment">assessment</span>
                    Laporan
                </a>
                <a href="{{ route('manager.prediction') }}" class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-primary/90 transition-all">
                    <span class="material-symbols-outlined text-sm" data-icon="insights">insights</span>
                    Forecasting
                </a>
            </div>
        </div>

        <!-- Summary Statistics -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Total Nilai Inventori</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-primary">Rp {{ number_format($totalStockValue / 1000000, 1) }}M</span>
                        <span class="text-[11px] font-bold text-primary/60">IDR</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="payments">payments</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-slate-500 font-medium">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="inventory_2">inventory_2</span>
                    {{ number_format($totalStockUnits) }} TOTAL UNITS
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">POs Awaiting Approval</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-tertiary">{{ $pendingPO }}</span>
                        <span class="text-[11px] font-bold text-tertiary/60">PO</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="approval_delegation">approval_delegation</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-tertiary font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="payments">payments</span>
                    Rp {{ number_format($pendingPOValue / 1000000, 1) }}M VALUE
                </div>
            </div>
            <div class="bg-surface-container-lowest p-6 rounded-xl relative overflow-hidden group">
                <div class="flex flex-col">
                    <span class="text-[11px] font-headline font-extrabold uppercase tracking-[0.2em] text-slate-500 mb-2">Low Stock Alerts</span>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-headline font-black text-error">{{ $lowStockItems }}</span>
                        <span class="text-[11px] font-bold text-error/60">Items</span>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <span class="material-symbols-outlined text-8xl" data-icon="warning">warning</span>
                </div>
                <div class="mt-4 flex items-center text-[10px] text-error font-bold">
                    <span class="material-symbols-outlined text-xs mr-1" data-icon="error">error</span>
                    NEEDS ATTENTION
                </div>
            </div>
        </section>

        <!-- Main Analytics Section - Stock Flow Dynamics (Line Chart) -->
        <section class="bg-white rounded-[24px] overflow-hidden shadow-[0_2px_16px_-4px_rgba(0,0,0,0.05)] border border-slate-100/50">
            <div class="px-8 py-8 flex justify-between items-start">
                <div>
                    <h2 class="font-headline text-lg font-bold text-on-surface tracking-tight">Stock Flow Dynamics</h2>
                    <p class="text-sm text-slate-500 font-medium">Monthly comparison of inbound vs outbound units</p>
                </div>
                <div class="flex gap-5 mt-2">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#376891]"></span>
                        <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wide">Inbound</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-[#835E1D]"></span>
                        <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wide">Outbound</span>
                    </div>
                </div>
            </div>
            <div class="px-8 pb-10">
                @php
                    $maxValue = max(array_merge(array_column($monthlyData, 'in'), array_column($monthlyData, 'out'), [1])) * 1.15;
                    $count = count($monthlyData);
                    $stepX = $count > 1 ? 100 / ($count - 1) : 0;
                    
                    $pointsIn = [];
                    $pointsOut = [];
                    
                    foreach($monthlyData as $i => $data) {
                        $x = $count > 1 ? $i * $stepX : 50;
                        $yIn = $maxValue > 0 ? 100 - ($data['in'] / $maxValue) * 100 : 0;
                        $yOut = $maxValue > 0 ? 100 - ($data['out'] / $maxValue) * 100 : 0;
                        $pointsIn[] = [$x, $yIn];
                        $pointsOut[] = [$x, $yOut];
                    }
                    
                    $pathIn = '';
                    $pathOut = '';
                    
                    if (count($pointsIn) > 0) {
                        $pathIn = 'M ' . $pointsIn[0][0] . ',' . $pointsIn[0][1];
                        $pathOut = 'M ' . $pointsOut[0][0] . ',' . $pointsOut[0][1];
                        for ($i = 0; $i < count($pointsIn) - 1; $i++) {
                            $p0 = $pointsIn[$i];
                            $p1 = $pointsIn[$i+1];
                            $cx = ($p0[0] + $p1[0]) / 2;
                            $pathIn .= " C {$cx},{$p0[1]} {$cx},{$p1[1]} {$p1[0]},{$p1[1]}";
                            
                            $p0_o = $pointsOut[$i];
                            $p1_o = $pointsOut[$i+1];
                            $cx_o = ($p0_o[0] + $p1_o[0]) / 2;
                            $pathOut .= " C {$cx_o},{$p0_o[1]} {$cx_o},{$p1_o[1]} {$p1_o[0]},{$p1_o[1]}";
                        }
                        
                        $areaIn = $pathIn . " L {$pointsIn[count($pointsIn)-1][0]},100 L {$pointsIn[0][0]},100 Z";
                    } else {
                        $areaIn = "M 0,100 L 100,100 Z";
                    }
                @endphp
                <div class="h-64 relative mt-4">
                    <svg class="w-full h-full overflow-visible" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="gradIn" x1="0%" y1="0%" x2="0%" y2="100%">
                                <stop offset="0%" style="stop-color:#376891;stop-opacity:0.15" />
                                <stop offset="100%" style="stop-color:#376891;stop-opacity:0.0" />
                            </linearGradient>
                        </defs>
                        <!-- Thin Grid Lines -->
                        <line x1="0" y1="20" x2="100" y2="20" stroke="#f1f5f9" stroke-width="0.3" vector-effect="non-scaling-stroke" />
                        <line x1="0" y1="40" x2="100" y2="40" stroke="#f1f5f9" stroke-width="0.3" vector-effect="non-scaling-stroke" />
                        <line x1="0" y1="60" x2="100" y2="60" stroke="#f1f5f9" stroke-width="0.3" vector-effect="non-scaling-stroke" />
                        <line x1="0" y1="80" x2="100" y2="80" stroke="#f1f5f9" stroke-width="0.3" vector-effect="non-scaling-stroke" />
                        <line x1="0" y1="100" x2="100" y2="100" stroke="#f1f5f9" stroke-width="1" vector-effect="non-scaling-stroke" />
                        
                        <!-- Area & Smooth Paths -->
                        <path d="{{ $areaIn }}" fill="url(#gradIn)" />
                        <path d="{{ $pathIn }}" fill="none" stroke="#376891" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" vector-effect="non-scaling-stroke" />
                        <path d="{{ $pathOut }}" fill="none" stroke="#835E1D" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="8,5" vector-effect="non-scaling-stroke" />
                    </svg>
                    <!-- Y-Axis line overlay to prevent path bleed -->
                    <div class="absolute left-0 bottom-0 w-full flex justify-between mt-8 translate-y-8">
                        @foreach($monthlyData as $data)
                        <span class="text-[10px] font-bold text-slate-800 uppercase" style="transform: translateX(-50%); 
                            @if($loop->first) margin-left: 10px; @endif
                            @if($loop->last) margin-right: -10px; @endif">
                            {{ $data['month'] }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Inventory Segments & Recent Transactions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Inventory Segments (Square border ring chart) -->
            @php
                $categoryStats = \App\Models\Material::selectRaw('category_id, SUM(current_stock * unit_price) as total_value')
                    ->where('is_active', true)
                    ->whereNotNull('category_id')
                    ->groupBy('category_id')
                    ->with('category')
                    ->get();
                $totalValue = $categoryStats->sum('total_value') ?: 1;
                $colorCodes = ['#376891', '#835E1D', '#E3E6E8', '#CED4DA', '#64748B'];
                
                $segments = [];
                $idx = 0;
                $sortedStats = $categoryStats->sortByDesc('total_value');
                foreach($sortedStats as $cat) {
                    $pct = ($cat->total_value / $totalValue) * 100;
                    $segments[] = [
                        'name' => $cat->category->name ?? 'Unknown',
                        'pct' => $pct,
                        'color' => $colorCodes[$idx % count($colorCodes)]
                    ];
                    $idx++;
                }
            @endphp
            <div class="bg-white p-8 rounded-[24px] border border-slate-100/50 shadow-[0_2px_16px_-4px_rgba(0,0,0,0.05)]">
                <h3 class="font-headline text-lg font-bold text-on-surface tracking-tight">Inventory Segments</h3>
                <p class="text-[13px] text-slate-500 mb-8 max-w-[200px] leading-relaxed">Value distribution by raw material type</p>
                
                @if(count($segments) > 0)
                <div class="flex justify-center mb-8">
                    <div class="relative w-48 h-48">
                        <svg class="w-full h-full transform" viewBox="0 0 100 100">
                            @php
                                $baseOffset = 75; // Path starts at bottom-left corner
                                $accumOffset = 0;
                            @endphp
                            @foreach($segments as $seg)
                            <rect x="10" y="10" width="80" height="80" rx="8" ry="8" 
                                fill="none" 
                                stroke="{{ $seg['color'] }}" 
                                stroke-width="10" 
                                pathLength="100"
                                stroke-dasharray="{{ $seg['pct'] }} {{ 100 - $seg['pct'] }}"
                                stroke-dashoffset="{{ - ($baseOffset + $accumOffset) }}" 
                                stroke-linecap="butt" class="transition-all duration-700" />
                            @php $accumOffset += $seg['pct']; @endphp
                            @endforeach
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-bold text-slate-900">{{ count($segments) }}</span>
                            <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-1">Main Sectors</span>
                        </div>
                    </div>
                </div>
                <div class="space-y-4 px-2">
                    @foreach($segments as $i => $seg)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $seg['color'] }}"></div>
                            <span class="text-xs font-medium text-slate-700">{{ $seg['name'] }}</span>
                        </div>
                        <span class="text-xs font-medium text-slate-900">{{ number_format($seg['pct'], 0) }}%</span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center text-slate-400 py-8 text-sm">No category data</div>
                @endif
            </div>

            <!-- Recent Transactions -->
            <div class="lg:col-span-2 bg-surface-container-lowest p-8 rounded-2xl overflow-hidden">
                <div class="flex flex-col md:flex-row justify-between md:items-center mb-8 gap-4">
                    <div>
                        <h3 class="font-headline text-lg font-bold text-on-surface tracking-tight">Recent Transactions</h3>
                        <p class="text-sm text-on-surface-variant">Latest stock movements</p>
                    </div>
                    <a href="{{ route('manager.export') }}" class="text-xs font-bold text-primary hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-surface-container-low/50">
                            <tr>
                                <th class="px-4 py-3 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Date</th>
                                <th class="px-4 py-3 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Type</th>
                                <th class="px-4 py-3 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">Material</th>
                                <th class="px-4 py-3 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em] text-right">Qty</th>
                                <th class="px-4 py-3 text-[10px] font-headline font-extrabold text-slate-500 uppercase tracking-[0.2em]">User</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-container-low">
                            @forelse($recentTransactions as $tx)
                            <tr class="hover:bg-surface-bright transition-colors">
                                <td class="px-4 py-3 text-xs text-slate-400">{{ $tx->transaction_date->format('d M') }}</td>
                                <td class="px-4 py-3">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded-full {{ $tx->type === 'in' ? 'text-primary' : 'text-error' }}">
                                        {{ $tx->type === 'in' ? 'IN' : 'OUT' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-xs font-medium text-on-surface">{{ $tx->material->material_name ?? '-' }}</td>
                                <td class="px-4 py-3 text-xs font-medium text-right {{ $tx->type === 'in' ? 'text-primary' : 'text-error' }}">
                                    {{ $tx->type === 'in' ? '+' : '-' }}{{ number_format($tx->quantity) }}
                                </td>
                                <td class="px-4 py-3 text-xs text-slate-400">{{ $tx->user->name ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-slate-400 text-sm">No recent transactions</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Top 10 Barang Paling Banyak Keluar & Aktivitas Terakhir -->
        <section class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Top 10 Barang Paling Banyak Keluar -->
            <div class="lg:col-span-8 bg-surface-container-lowest p-8 rounded-2xl shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h4 class="text-xl font-headline font-bold text-on-surface">Top 10 Barang Paling Banyak Keluar</h4>
                        <p class="text-sm text-slate-400">Distribusi volume pengeluaran berdasarkan SKU</p>
                    </div>
                </div>
                <div class="space-y-4">
                    @forelse($topOutgoingItems as $index => $item)
                    @php 
                        $maxValue = $topOutgoingItems->max('total_outgoing');
                        $percentage = $maxValue > 0 ? ($item->total_outgoing / $maxValue) * 100 : 0;
                    @endphp
                    <div class="relative">
                        <div class="flex justify-between text-[10px] font-bold text-slate-500 mb-1">
                            <span>{{ $item->material_name }}</span>
                            <span>{{ number_format($item->total_outgoing) }} {{ $item->unit }}</span>
                        </div>
                        <div class="h-3 w-full bg-surface-container-high rounded-full overflow-hidden">
                            <div class="h-full bg-error rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 py-8">Tidak ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Aktivitas Terakhir -->
            <div class="lg:col-span-4 bg-surface-container-low p-8 rounded-2xl">
                <h4 class="text-xl font-headline font-bold text-on-surface mb-6">Aktivitas Terakhir</h4>
                <div class="space-y-6">
                    @forelse($recentActivity as $activity)
                    <div class="flex gap-4">
                        <div class="w-2 h-10 bg-primary rounded-full"></div>
                        <div>
                            <p class="text-xs font-medium text-on-surface">{{ $activity->description }}</p>
                            <p class="text-[10px] text-slate-400">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-slate-400 text-sm">Tidak ada aktivitas terbaru</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</x-dashboard-layout>
