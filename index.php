<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1121405林翼成-首頁</title>
    <?php include "link.php"; ?>
    <style>
        .header-container {
            position: relative;
            text-align: center;
            color: white;
        }

        .header-container img {
            width: 100%;
            height: auto;
            opacity: 0.8;
        }

        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(51, 51, 51, .2);
        }

        .centered-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

        .search-box {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .search-box input {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .search-box button {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .navbar-nav .dropdown:hover .dropdown-menu {
            display: block;
        }

        .explore-city-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .city-card {
            width: 18%;
            margin: 0.5%;
            transition: transform 0.3s;
        }

        .city-card img {
            width: 100%;
            height: auto;
        }

        .city-card:hover {
            transform: scale(1.1);
        }

        .top-products {
            margin-top: 3rem;
        }

        .carousel-item .card {
            min-height: 300px;
        }
    </style>
</head>

<body class="bg-light" id="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="./index.php" class="navbar-brand">
            <img src="./images/lyc_logo.png" alt="LOGO" height="100">
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto" id="location-menu">
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        目的地
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <!-- 動態填充選單項目 -->
                        <a class="dropdown-item" v-for="location in locations" :key="location.id" :href="'./city.php?city=' + location.name">{{ location.name }}</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./search.php?search=住宿">交通住宿</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./search.php?search=門票">景點門票</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./search.php?search=伴手禮">伴手禮</a>
                </li>
            </ul>
        </div>
    </nav>

    <header>
        <div class="header-container">
            <img src="./images/header.jpg" alt="header" class="img-fluid">
            <div class="header-overlay"></div>
            <div class="centered-content">
                <h1>全世界最棒的旅遊體驗</h1>
                <p>帶你深入探索有趣又獨特的旅遊體驗行程</p>
                <div class="search-box mt-3">
                    <input type="text" class="form-control" placeholder="搜尋景點、地區或城市" v-model="query">
                    <button class="btn btn-primary" @click="performSearch"><span class="bi bi-search"></span></button>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <section class="explore-city-container" v-if="cities.length > 0">
            <div class="city-card" v-for="city in cities" :key="city.id">
                <a :href="'./city.php?city=' + city.name" class="nav-link">
                    <img :src="city.photo_url" alt="City image">
                    <h3>{{ city.name }}</h3>
                </a>
            </div>
        </section>

        <section class="top-products">
            <div v-if="topProducts.length > 0">
                <h2 class="mt-4">Top 10 熱門商品</h2>
                <div id="topProductsCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item" v-for="(productGroup, index) in paginatedTopProducts" :class="{ active: index === 0 }" :key="'products-' + index">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="product in productGroup" :key="product.id">
                                    <div class="card h-100">
                                        <a :href="'./product.php?product=' + product.id" class="nav-link">
                                            <img :src="product.photo_url" class="card-img-top" alt="Product image">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ product.name }}</h5>
                                                <p class="card-text">NT {{ product.ticket_price }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 mb-3" v-for="n in (itemsPerPage - productGroup.length)" :key="'product-placeholder-' + n">
                                    <div class="card h-100 placeholder"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#topProductsCarousel" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#topProductsCarousel" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </section>
    </div>

    <?php include "footer.php"; ?>

    <script>
        const app = Vue.createApp({
            data() {
                return {
                    query: '',
                    locations: [],
                    cities: [],
                    topProducts: [],
                    itemsPerPage: 3
                };
            },
            mounted() {
                this.fetchLocations();
                this.fetchTopProducts();
            },
            methods: {
                fetchLocations() {
                    fetch('https://echolyc.com/final/api/api.php/locations')
                        .then(response => response.json())
                        .then(data => {
                            this.locations = data;
                            this.cities = data;
                        })
                        .catch(error => {
                            console.error("There was an error fetching the locations:", error);
                        });
                },
                fetchTopProducts() {
                    fetch('https://echolyc.com/final/api/api.php/attractions')
                        .then(response => response.json())
                        .then(data => {
                            this.topProducts = this.getTopProductsByCity(data);
                        })
                        .catch(error => {
                            console.error("There was an error fetching the attractions:", error);
                        });
                },
                performSearch() {
                    fetch('https://echolyc.com/final/api/api.php/locations')
                        .then(response => response.json())
                        .then(data => {
                            const matchingLocation = data.find(location => location.name.toLowerCase() === this.query.toLowerCase());
                            if (matchingLocation) {
                                window.location.href = './city.php?city=' + matchingLocation.name;
                            } else {
                                window.location.href = './search.php?search=' + this.query;
                            }
                        });
                },
                getTopProductsByCity(attractions) {
                    const cityProductMap = {};
                    attractions.forEach(attraction => {
                        if (!cityProductMap[attraction.location_id]) {
                            cityProductMap[attraction.location_id] = attraction;
                        }
                    });
                    return Object.values(cityProductMap);
                }
            },
            computed: {
                paginatedTopProducts() {
                    const pages = [];
                    for (let i = 0; i < this.topProducts.length; i += this.itemsPerPage) {
                        pages.push(this.topProducts.slice(i, i + this.itemsPerPage));
                    }
                    return pages;
                }
            }
        });

        app.mount('#app');
    </script>
</body>

</html>
