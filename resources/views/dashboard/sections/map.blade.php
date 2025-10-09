<div class="container-fluid py-2">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-3d">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="mb-1">Bangladesh Travel Map</h5>
                            <small class="text-muted">Explore top destinations across the country</small>
                        </div>
                        <span class="badge bg-light text-dark">Interactive Map</span>
                    </div>

                    <div id="bdMap" class="w-100 rounded-3 border" style="height:560px; min-height:420px; border-style:dashed !important;"></div>

                    <div id="destDetails" class="mt-3 p-3 bg-light rounded-3 d-none">
                        <div class="d-flex gap-3 align-items-center">
                            <img id="destImage" src="" class="rounded-3" style="width:80px; height:80px; object-fit:cover;" alt="">
                            <div class="flex-grow-1">
                                <div id="destName" class="fw-semibold"></div>
                                <div id="destDivision" class="text-muted small mb-1"></div>
                                <div class="text-warning small d-flex align-items-center gap-2">
                                    <i class="bi bi-star-fill"></i>
                                    <span id="destRating"></span>
                                    <span id="destReviews" class="text-muted"></span>
                                </div>
                            </div>
                            <button class="btn btn-success btn-sm">View Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-3d">
                <div class="card-body p-4">
                    <h6 class="mb-1 fw-semibold">Destinations</h6>
                    <small class="text-muted">Popular places to visit in Bangladesh</small>
                    <input type="text" id="destSearch" class="form-control mt-3" placeholder="Search destinations...">
                    <div id="destList" class="mt-3" style="max-height:380px; overflow:auto;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet CSS/JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const destinations = [
            { id:1, name:"Cox's Bazar", division:'Chittagong', coordinates:[21.4272, 92.0058], image:'https://images.unsplash.com/photo-1658076798013-654fb97e3111?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080', description:"World's longest natural beach stretching 120km along the Bay of Bengal", rating:4.6, reviews:2840, category:'Beach' },
            { id:2, name:'Sundarbans', division:'Khulna', coordinates:[21.9497, 89.1833], image:'https://images.unsplash.com/photo-1746959197922-3c097c0a4e6e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080', description:'UNESCO World Heritage mangrove forest, home to Royal Bengal Tigers', rating:4.8, reviews:1650, category:'Wildlife' },
            { id:3, name:'Sylhet', division:'Sylhet', coordinates:[24.8949, 91.8687], image:'https://images.unsplash.com/photo-1667120205301-a2a3a886886e?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080', description:'Land of tea gardens, hills, and spiritual heritage', rating:4.5, reviews:1980, category:'Hill Station' },
            { id:4, name:'Rangamati', division:'Chittagong', coordinates:[22.6533, 92.1786], image:'https://images.unsplash.com/photo-1613508999265-2acab7209645?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=1080', description:'Lake district with indigenous culture and stunning landscapes', rating:4.4, reviews:1320, category:'Lake' }
        ];

        const map = L.map('bdMap').setView([23.685, 90.3563], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(map);

        const details = {
            wrap: document.getElementById('destDetails'),
            image: document.getElementById('destImage'),
            name: document.getElementById('destName'),
            division: document.getElementById('destDivision'),
            rating: document.getElementById('destRating'),
            reviews: document.getElementById('destReviews'),
        };

        function showDestination(dest){
            details.wrap.classList.remove('d-none');
            details.image.src = dest.image;
            details.name.textContent = dest.name;
            details.division.textContent = dest.division + ' Division';
            details.rating.textContent = dest.rating;
            details.reviews.textContent = '(' + dest.reviews + ' reviews)';
        }

        // Markers
        const markers = [];
        destinations.forEach(dest => {
            const marker = L.marker(dest.coordinates).addTo(map);
            marker.on('click', () => {
                map.setView(dest.coordinates, 10);
                showDestination(dest);
            });
            markers.push(marker);
        });

        // List
        const listEl = document.getElementById('destList');
        function renderList(filter=''){
            listEl.innerHTML = '';
            destinations.filter(d =>
                d.name.toLowerCase().includes(filter.toLowerCase()) ||
                d.division.toLowerCase().includes(filter.toLowerCase()) ||
                d.category.toLowerCase().includes(filter.toLowerCase())
            ).forEach(dest => {
                const item = document.createElement('div');
                item.className = 'p-2 rounded border d-flex gap-2 align-items-center mb-2';
                item.innerHTML = `
                    <img src="${dest.image}" style="width:40px;height:40px;object-fit:cover;" class="rounded"/>
                    <div class="flex-grow-1">
                        <div class="fw-medium">${dest.name}</div>
                        <div class="text-muted small">${dest.division} Division</div>
                        <span class="text-warning fw-semibold">${dest.rating} ★</span>
                        <span class="text-muted">(${dest.reviews})</span>
                    </div>
                `;
                item.onclick = () => {
                    map.setView(dest.coordinates, 10);
                    showDestination(dest);
                };
                listEl.appendChild(item);
            });
        }
        renderList();
        document.getElementById('destSearch').addEventListener('input', (e)=> renderList(e.target.value));

        // Fix map sizing when section becomes visible
        window.addEventListener('travix:map:show', () => {
            setTimeout(() => { map.invalidateSize(); }, 0);
        });
    });
</script>
