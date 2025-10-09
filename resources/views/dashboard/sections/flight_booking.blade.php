<div class="space-y-4">
    <!-- Search Card -->
    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <h5 class="mb-1 d-flex align-items-center gap-2">✈️ Book Domestic Flights</h5>
            <p class="text-muted mb-4">Find and book flights across Bangladesh with the best airlines</p>

            <form action="{{ route('flights.search') }}" method="GET" class="">
                <!-- Trip Type -->
                <div class="d-flex gap-4 mb-3">
                    <label class="d-flex align-items-center gap-2">
                        <input type="radio" name="tripType" value="round-trip" checked>
                        <span>Round Trip</span>
                    </label>
                    <label class="d-flex align-items-center gap-2">
                        <input type="radio" name="tripType" value="one-way">
                        <span>One Way</span>
                    </label>
                </div>

                <!-- Grid -->
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label">From</label>
                        <select name="from" class="form-select form-control-soft">
                            <option value="">Select departure city</option>
                            <option value="DAC">Dhaka (DAC)</option>
                            <option value="CGP">Chittagong (CGP)</option>
                            <option value="ZYL">Sylhet (ZYL)</option>
                            <option value="JSR">Jessore (JSR)</option>
                            <option value="SPD">Saidpur (SPD)</option>
                            <option value="CXB">Cox's Bazar (CXB)</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label">To</label>
                        <select name="to" class="form-select form-control-soft">
                            <option value="">Select destination city</option>
                            <option value="DAC">Dhaka (DAC)</option>
                            <option value="CGP">Chittagong (CGP)</option>
                            <option value="ZYL">Sylhet (ZYL)</option>
                            <option value="JSR">Jessore (JSR)</option>
                            <option value="SPD">Saidpur (SPD)</option>
                            <option value="CXB">Cox's Bazar (CXB)</option>
                        </select>
                    </div>
                    <div class="col-6 col-lg-3">
                        <label class="form-label">Departure</label>
                        <input type="date" name="departure" class="form-control form-control-soft">
                    </div>
                    <div class="col-6 col-lg-3">
                        <label class="form-label">Return</label>
                        <input type="date" name="return" class="form-control form-control-soft">
                    </div>
                    <div class="col-12 col-lg-3">
                        <label class="form-label">Passengers</label>
                        <select name="passengers" class="form-select form-control-soft">
                            <option value="1">1 Passenger</option>
                            <option value="2">2 Passengers</option>
                            <option value="3">3 Passengers</option>
                            <option value="4">4 Passengers</option>
                            <option value="5">5+ Passengers</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary mt-3 btn-3d">
                    <span class="me-1">✈️</span> Search Flights
                </button>
            </form>
        </div>
    </div>

    <!-- Results Card -->
    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h6 class="mb-0">Available Flights</h6>
                    <small class="text-muted">4 flights found • Dhaka to Cox's Bazar</small>
                </div>
                <button class="btn btn-sm btn-light">Filter</button>
            </div>

            <div class="vstack gap-3">
            @foreach([
                ['id'=>1,'airline'=>'Biman Bangladesh Airlines','from'=>'DAC','to'=>'CXB','departure'=>'08:30','arrival'=>'09:45','duration'=>'1h 15m','price'=>8500,'rating'=>4.2,'aircraft'=>'Boeing 737','amenities'=>['Wifi','Meal','Entertainment']],
                ['id'=>2,'airline'=>'US-Bangla Airlines','from'=>'DAC','to'=>'CXB','departure'=>'14:15','arrival'=>'15:30','duration'=>'1h 15m','price'=>7800,'rating'=>4.0,'aircraft'=>'ATR 72','amenities'=>['Meal','Entertainment']],
                ['id'=>3,'airline'=>'NovoAir','from'=>'DAC','to'=>'CXB','departure'=>'18:00','arrival'=>'19:15','duration'=>'1h 15m','price'=>9200,'rating'=>4.4,'aircraft'=>'Embraer E145','amenities'=>['Wifi','Meal','Priority Boarding']],
                ['id'=>4,'airline'=>'Regent Airways','from'=>'DAC','to'=>'CGP','departure'=>'12:30','arrival'=>'13:30','duration'=>'1h 00m','price'=>6500,'rating'=>3.8,'aircraft'=>'Dash 8','amenities'=>['Meal']],
            ] as $flight)
                <div class="border rounded-3 p-3 hover-bg-soft">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:48px;height:48px;background:#e9f3ff;">✈️</div>
                            <div>
                                <div class="fw-semibold">{{ $flight['airline'] }}</div>
                                <div class="text-muted small">{{ $flight['aircraft'] }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-4 flex-grow-1 justify-content-center">
                            <div class="text-center">
                                <div class="fw-medium">{{ $flight['departure'] }}</div>
                                <div class="text-muted small">{{ $flight['from'] }}</div>
                            </div>
                            <div class="text-center">
                                <div class="text-muted small">{{ $flight['duration'] }}</div>
                                <div class="my-1 border-top" style="border-style:dashed !important;"></div>
                                <div class="text-muted small">Non-stop</div>
                            </div>
                            <div class="text-center">
                                <div class="fw-medium">{{ $flight['arrival'] }}</div>
                                <div class="text-muted small">{{ $flight['to'] }}</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fs-5 fw-bold text-success">৳{{ number_format($flight['price']) }}</div>
                            <div class="text-muted small mb-2">per person</div>
                            <button class="btn btn-success btn-sm">Select Flight</button>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>

    <!-- Popular Routes -->
    <div class="card border-0 shadow-3d">
        <div class="card-body p-4">
            <h6 class="mb-1">Popular Domestic Routes</h6>
            <small class="text-muted">Most traveled routes within Bangladesh</small>
            <div class="row g-3 mt-2">
            @foreach([
                ['route'=>"Dhaka ↔ Cox's Bazar", 'price'=>'৳8,500', 'time'=>'1h 15m'],
                ['route'=>"Dhaka ↔ Chittagong", 'price'=>'৳6,500', 'time'=>'1h 00m'],
                ['route'=>"Dhaka ↔ Sylhet", 'price'=>'৳7,200', 'time'=>'1h 10m'],
                ['route'=>"Dhaka ↔ Jessore", 'price'=>'৳5,800', 'time'=>'45m'],
                ['route'=>"Chittagong ↔ Cox's Bazar", 'price'=>'৳4,500', 'time'=>'35m'],
                ['route'=>"Dhaka ↔ Saidpur", 'price'=>'৳8,200', 'time'=>'1h 20m'],
            ] as $route)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="border rounded-3 p-3 hover-bg-soft">
                        <div class="fw-semibold">{{ $route['route'] }}</div>
                        <div class="d-flex justify-content-between text-muted small mt-1">
                            <span>{{ $route['time'] }}</span>
                            <span class="fw-semibold text-success">{{ $route['price'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
