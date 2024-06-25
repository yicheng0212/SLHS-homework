<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1121405林翼成-搜尋頁面</title>
    <?php include "link.php"; ?>
    <style>
        .header-container {
            position: relative;
            text-align: center;
            color: white;
            height: 150px;
        }

        .centered-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

        .card-horizontal {
            display: flex;
            flex-direction: row;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            height: 200px;
        }

        .card-horizontal img {
            width: 200px;
            height: 100%;
            object-fit: cover;
        }

        .card-body {
            flex: 1;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-title,
        .card-text {
            margin: 0;
            padding: 5px 0;
        }

        .card-subtitle {
            color: #6c757d;
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
    </style>
</head>

<body class="bg-light" id="app">
    <?php include "header.php"; ?>

    <header>
        <div class="header-container">
            <div class="centered-content">
                <h1 style="color: #6c757d;">{{ searchQuery }} 的搜尋結果</h1>
            </div>
        </div>
    </header>

    <div class="container mt-4">
        <div v-if="searchResults.length > 0">
            <div class="card-horizontal" v-for="result in searchResults" :key="result.id">
                <img :src="result.photo_url" class="card-img-top" alt="Card image">
                <div class="card-body">
                    <h5 class="card-title">{{ result.name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ result.location }}</h6>
                    <p class="card-text">{{ result.description }}</p>
                    <p class="card-text"><small class="text-muted">{{ result.city }}</small></p>
                    <p class="card-text">NT {{ result.ticket_price }} 起</p>
                </div>
            </div>
        </div>
        <div v-else>
            <p>沒有找到相關的結果</p>
        </div>
    </div>

    <?php include "footer.php"; ?>
    <script>
        const app = Vue.createApp({
            data() {
                return {
                    query: '',
                    searchQuery: '',
                    searchResults: [],
                    locations: []
                };
            },
            mounted() {
                const urlParams = new URLSearchParams(window.location.search);
                this.searchQuery = urlParams.get('search') || '';
                this.query = this.searchQuery;
                this.performSearch();
                this.fetchLocations();
            },
            methods: {
                fetchLocations() {
                    fetch('https://echolyc.com/final/api/api.php/locations')
                        .then(response => response.json())
                        .then(data => {
                            this.locations = data;
                        })
                        .catch(error => {
                            console.error("There was an error fetching the locations:", error);
                        });
                },
                performSearch() {
                    fetch('https://echolyc.com/final/api/api.php/attractions')
                        .then(response => response.json())
                        .then(data => {
                            this.searchResults = data.filter(item => {
                                const seo = item.seo || '';
                                const category = item.category || '';
                                const name = item.name || '';
                                const description = item.description || '';
                                
                                return seo.toLowerCase().includes(this.query.toLowerCase()) ||
                                    category.toLowerCase().includes(this.query.toLowerCase()) ||
                                    name.toLowerCase().includes(this.query.toLowerCase()) ||
                                    description.toLowerCase().includes(this.query.toLowerCase());
                            }).map(item => ({
                                id: item.id,
                                name: item.name,
                                location: item.location,
                                description: item.description,
                                city: item.city,
                                photo_url: item.photo_url,
                                ticket_price: item.ticket_price
                            }));
                        })
                        .catch(error => {
                            console.error("There was an error fetching the search results:", error);
                        });
                }
            }
        });

        app.mount('#app');
    </script>
</body>

</html>
