<div class="col-md-6">
    {{-- CARD MENU --}}
    <div class="bg-white rounded-3 shadow-sm menu-card">
        <div class="d-flex">
            <div class="flex-shrink-0">
                @php $menuImg = $menu->images->first()?->path; @endphp
                @if($menuImg)
                    <img src="{{ asset('storage/' . $menuImg) }}" alt="{{ $menu->name }}" class="rounded-start" style="width:180px;height:180px;object-fit:cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light rounded-start" style="width:180px;height:180px;font-size:55px;">🍽️</div>
                @endif
            </div>
            <div class="p-3 flex-grow-1 d-flex flex-column justify-content-between">
                <div>
                    <h6 class="fw-bold mb-1">{{ $menu->name }}</h6>
                    <p class="text-muted small mb-1">{{ Str::limit($menu->description,50) }}</p>
                    <p class="fw-bold text-orange mb-0">Rp {{ number_format($menu->price,0,',','.') }}</p>
                </div>
                @auth
                    @if($menu->status === 'tersedia')
                        @if($menu->variants->count())
                            <button class="btn btn-sm btn-orange rounded-3 w-100" onclick="toggleVarian({{ $menu->id }}, this)">Pilih Varian <i class="bi bi-chevron-down ms-1"></i></button>
                        @else
                            <div class="d-flex gap-2 mt-3">
                                <form method="POST" action="{{ route('cart.add',$menu) }}">@csrf<button class="btn btn-sm btn-outline-secondary rounded-3"><i class="bi bi-cart-plus"></i></button></form>
                                <form method="POST" action="{{ route('checkout.buy-now') }}">@csrf<input type="hidden" name="menu_id" value="{{ $menu->id }}"><button class="btn btn-sm btn-orange rounded-3 px-3">Beli</button></form>
                            </div>
                        @endif
                    @else
                        <span class="badge bg-secondary mt-3">Habis</span>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-orange rounded-3 mt-3">Login untuk beli</a>
                @endauth
            </div>
        </div>
    </div>
    {{-- PANEL VARIAN --}}
    @auth
        @if($menu->status === 'tersedia' && $menu->variants->count())
            <div id="varian-{{ $menu->id }}" class="bg-white shadow-sm rounded-bottom px-3" style="display:none;">
                @foreach($menu->variants as $variant)
                    <div class="d-flex justify-content-between align-items-center py-3 border-top">
                        <div>
                            <div class="fw-bold">{{ $variant->name }}</div>
                            <small class="text-orange">Rp {{ number_format($variant->price,0,',','.') }}</small>
                        </div>
                        <div class="d-flex gap-2">
                            <form method="POST" action="{{ route('cart.add',$menu) }}">@csrf<input type="hidden" name="variant_id" value="{{ $variant->id }}"><button class="btn btn-sm btn-outline-secondary rounded-3"><i class="bi bi-cart-plus"></i></button></form>
                            <form method="POST" action="{{ route('checkout.buy-now') }}">@csrf<input type="hidden" name="menu_id" value="{{ $menu->id }}"><input type="hidden" name="variant_id" value="{{ $variant->id }}"><button class="btn btn-sm btn-orange rounded-3">Beli</button></form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endauth
</div>