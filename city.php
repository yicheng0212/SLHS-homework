<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>城市頁面</title>
    <?php include "link.php"; ?>
    <style>
        .header-container {
            position: relative;
            text-align: center;
            color: white;
            height: 300px;
        }

        .header-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.8;
        }

        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .centered-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

        .placeholder {
            visibility: hidden;
        }

        .card {
            border: none;
        }

        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .card:hover img {
            transform: scale(1.1);
        }

        .card-body {
            text-align: left;
        }

        .card-title,
        .card-text {
            margin: 0;
            padding: 5px 0;
        }

        .carousel-item {
            display: none;
        }

        .carousel-item.active {
            display: block;
        }
    </style>
</head>

<body class="bg-light">
    <?php include "header.php"; ?>
    <header>
        <div class="header-container">
            <img src="" alt="header" class="img-fluid" id="headerImage">
            <div class="header-overlay"></div>
            <div class="centered-content">
                <h1 id="cityName">城市名稱</h1>
            </div>
        </div>
    </header>

    <div class="container mt-4" id="app">
        <div v-if="paginatedCards.length > 0">
            <h2>人氣 Top 10</h2>
            <div id="top10Carousel" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item" v-for="(cardGroup, index) in paginatedCards" :class="{ active: index === 0 }" :key="'top10-' + index">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="item in cardGroup" :key="item.id">
                                <div class="card h-100">
                                    <img :src="item.photo_url" class="card-img-top" alt="Card image">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ item.name }}</h5>
                                        <p class="card-text">NT {{ item.ticket_price }} 起</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="n in (itemsPerPage - cardGroup.length)" :key="'placeholder-' + n">
                                <div class="card h-100 placeholder"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#top10Carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#top10Carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div v-if="paginatedHotelCards.length > 0">
            <h2 class="mt-4">{{ city }} 住宿推薦</h2>
            <div id="hotelsCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item" v-for="(cardGroup, index) in paginatedHotelCards" :class="{ active: index === 0 }" :key="'hotels-' + index">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="hotel in cardGroup" :key="hotel.id">
                                <div class="card h-100">
                                    <img :src="hotel.photo_url" class="card-img-top" alt="Hotel image">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ hotel.name }}</h5>
                                        <p class="card-text">NT {{ hotel.ticket_price }} 起</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="n in (itemsPerPage - cardGroup.length)" :key="'hotel-placeholder-' + n">
                                <div class="card h-100 placeholder"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#hotelsCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#hotelsCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div v-if="paginatedThemeParkCards.length > 0">
            <h2 class="mt-4">景點門票</h2>
            <div id="themeParksCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item" v-for="(cardGroup, index) in paginatedThemeParkCards" :class="{ active: index === 0 }" :key="'themeParks-' + index">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="themePark in cardGroup" :key="themePark.id">
                                <div class="card h-100">
                                    <img :src="themePark.photo_url" class="card-img-top" alt="Theme park image">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ themePark.name }}</h5>
                                        <p class="card-text">NT {{ themePark.ticket_price }} 起</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="n in (itemsPerPage - cardGroup.length)" :key="'themePark-placeholder-' + n">
                                <div class="card h-100 placeholder"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#themeParksCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#themeParksCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <div v-if="paginatedSouvenirCards.length > 0">
            <h2 class="mt-4">伴手禮</h2>
            <div id="souvenirsCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item" v-for="(cardGroup, index) in paginatedSouvenirCards" :class="{ active: index === 0 }" :key="'souvenirs-' + index">
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="souvenir in cardGroup" :key="souvenir.id">
                                <div class="card h-100">
                                    <img :src="souvenir.photo_url" class="card-img-top" alt="Souvenir image">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ souvenir.name }}</h5>
                                        <p class="card-text">NT {{ souvenir.ticket_price }} 起</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="n in (itemsPerPage - cardGroup.length)" :key="'souvenir-placeholder-' + n">
                                <div class="card h-100 placeholder"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#souvenirsCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#souvenirsCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <?php include "footer.php"; ?>
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    city: '城市名稱',
                    headerImage: '',
                    top10: [],
                    hotels: [],
                    themeParks: [],
                    souvenirs: [],
                    currentSlide: 0,
                    currentHotelSlide: 0,
                    currentThemeParkSlide: 0,
                    currentSouvenirSlide: 0,
                    itemsPerPage: 3
                };
            },
            computed: {
                paginatedCards() {
                    let paginated = [];
                    for (let i = 0; i < this.top10.length; i += this.itemsPerPage) {
                        paginated.push(this.top10.slice(i, i + this.itemsPerPage));
                    }
                    return paginated;
                },
                paginatedHotelCards() {
                    let paginated = [];
                    for (let i = 0; i < this.hotels.length; i += this.itemsPerPage) {
                        paginated.push(this.hotels.slice(i, i + this.itemsPerPage));
                    }
                    return paginated;
                },
                paginatedThemeParkCards() {
                    let paginated = [];
                    for (let i = 0; i < this.themeParks.length; i += this.itemsPerPage) {
                        paginated.push(this.themeParks.slice(i, i + this.itemsPerPage));
                    }
                    return paginated;
                },
                paginatedSouvenirCards() {
                    let paginated = [];
                    for (let i = 0; i < this.souvenirs.length; i += this.itemsPerPage) {
                        paginated.push(this.souvenirs.slice(i, i + this.itemsPerPage));
                    }
                    return paginated;
                }
            },
            methods: {
                fetchData(city) {
                    fetch(`./api/api.php/locations`)
                        .then(response => response.json())
                        .then(locations => {
                            const cityData = locations.find(item => item.name === city);
                            if (cityData) {
                                this.city = cityData.name;
                                this.headerImage = cityData.photo_url;
                                this.fetchAttractions(cityData.id);
                            } else {
                                this.city = '未知城市';
                                this.headerImage = './images/default_header.jpg';
                            }
                            document.getElementById('cityName').innerText = this.city;
                            document.getElementById('headerImage').src = this.headerImage;
                        });
                },
                fetchAttractions(cityId) {
                    fetch(`./api/api.php/attractions`)
                        .then(response => response.json())
                        .then(data => {
                            this.top10 = data.filter(item => item.location_id === cityId && item.popularity <= 10);
                            this.hotels = data.filter(item => item.location_id === cityId && item.category_id === '2');
                            this.themeParks = data.filter(item => item.location_id === cityId && item.category_id === '3');
                            this.souvenirs = data.filter(item => item.location_id === cityId && item.category_id === '4');
                        });
                },
                prevSlide(category) {
                    if (category === 'top10' && this.currentSlide > 0) {
                        this.currentSlide--;
                    } else if (category === 'hotels' && this.currentHotelSlide > 0) {
                        this.currentHotelSlide--;
                    } else if (category === 'themeParks' && this.currentThemeParkSlide > 0) {
                        this.currentThemeParkSlide--;
                    } else if (category === 'souvenirs' && this.currentSouvenirSlide > 0) {
                        this.currentSouvenirSlide--;
                    }
                },
                nextSlide(category) {
                    if (category === 'top10' && this.currentSlide < this.paginatedCards.length - 1) {
                        this.currentSlide++;
                    } else if (category === 'hotels' && this.currentHotelSlide < this.paginatedHotelCards.length - 1) {
                        this.currentHotelSlide++;
                    } else if (category === 'themeParks' && this.currentThemeParkSlide < this.paginatedThemeParkCards.length - 1) {
                        this.currentThemeParkSlide++;
                    } else if (category === 'souvenirs' && this.currentSouvenirSlide < this.paginatedSouvenirCards.length - 1) {
                        this.currentSouvenirSlide++;
                    }
                }
            },
            mounted() {
                const urlParams = new URLSearchParams(window.location.search);
                const city = urlParams.get('city') || '台北';
                this.fetchData(city);
            }
        });

        app.mount('#app');
    </script>
</body>

</html>