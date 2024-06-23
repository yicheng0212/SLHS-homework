<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>旅遊網後台管理</title>
    <?php include "link.php"; ?>
</head>

<body>
    <div id="app" class="container mt-4">
        <h1 class="mb-4">{{ title }}</h1>

        <!-- 切換資源類型 -->
        <div class="mb-4">
            <button class="btn btn-outline-primary" @click="changeResource('locations')">Locations</button>
            <button class="btn btn-outline-primary" @click="changeResource('categories')">Categories</button>
            <button class="btn btn-outline-primary" @click="changeResource('attractions')">Attractions</button>
        </div>

        <!-- 打開新增模態框的按鈕 -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#resourceModal" @click="openModal">
            新增 {{ resourceName }}
        </button>

        <!-- 模態框 -->
        <div class="modal fade" id="resourceModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- 模態框頭部 -->
                    <div class="modal-header">
                        <h4 class="modal-title">{{ modalTitle }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- 模態框主體 -->
                    <div class="modal-body">
                        <form @submit.prevent="submitResource">
                            <div class="form-group">
                                <label for="name">名稱:</label>
                                <input type="text" class="form-control" id="name" v-model="form.name" required>
                            </div>
                            <div class="form-group" v-if="resource === 'locations' || resource === 'attractions'">
                                <label for="photo_url">照片 URL:</label>
                                <input type="text" class="form-control" id="photo_url" v-model="form.photo_url">
                            </div>
                            <div class="form-group" v-if="resource === 'attractions'">
                                <label for="description">描述:</label>
                                <textarea class="form-control" id="description" v-model="form.description"></textarea>
                                <label for="location_id">地點:</label>
                                <select class="form-control" id="location_id" v-model="form.location_id">
                                    <option v-for="location in locations" :value="location.id">{{ location.name }}</option>
                                </select>
                                <label for="category_id">分類:</label>
                                <select class="form-control" id="category_id" v-model="form.category_id">
                                    <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                                </select>
                                <label for="popularity">人氣程度:</label>
                                <input type="number" class="form-control" id="popularity" v-model="form.popularity">
                                <label for="seo">SEO:</label>
                                <div class="seo-input">
                                    <div class="input-group">
                                        <input type="text" class="form-control" v-model="seoInput" @keyup.enter="addSEO">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="button" @click="addSEO">新增</button>
                                        </div>
                                    </div>
                                    <div class="seo-tags mt-2">
                                        <span class="badge badge-secondary" v-for="(tag, index) in form.seo" :key="index">
                                            {{ tag }} <a href="#" @click.prevent="removeSEO(index)">&times;</a>
                                        </span>
                                    </div>
                                </div>
                                <label for="address">地址:</label>
                                <input type="text" class="form-control" id="address" v-model="form.address">
                                <label for="contact_info">聯繫信息:</label>
                                <input type="text" class="form-control" id="contact_info" v-model="form.contact_info">
                                <label for="opening_hours">營業時間:</label>
                                <input type="text" class="form-control" id="opening_hours" v-model="form.opening_hours">
                                <label for="ticket_price">門票價格:</label>
                                <input type="text" class="form-control" id="ticket_price" v-model="form.ticket_price">
                            </div>
                            <button type="submit" class="btn btn-primary">提交</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 資源列表表格 -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th v-for="(header, index) in headers" :key="index">{{ header }}</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items" :key="item.id">
                    <td v-for="(header, index) in headers" :key="index">{{ truncate(item[header.toLowerCase()], 20) }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm m-1" @click="editResource(item)">編輯</button>
                        <button class="btn btn-danger btn-sm m-1" @click="deleteResource(item.id)">刪除</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        const app = Vue.createApp({
            data() {
                return {
                    resource: 'locations', // 當前資源類型
                    resourceName: '地點', // 資源名稱
                    items: [], // 資源列表
                    form: {
                        seo: []
                    }, // 表單數據
                    currentResource: null, // 當前編輯的資源
                    modalTitle: '新增地點', // 模態框標題
                    headers: ['ID', 'Name', 'Photo_url'], // 表格標題
                    locations: [], // 可用地點
                    categories: [], // 可用分類
                    seoInput: '' // SEO 輸入
                };
            },
            mounted() {
                this.initializeData();
            },
            methods: {
                changeResource(resource) {
                    this.resource = resource;
                    switch (resource) {
                        case 'locations':
                            this.resourceName = '地點';
                            this.headers = ['ID', 'Name', 'Photo_url'];
                            break;
                        case 'categories':
                            this.resourceName = '分類';
                            this.headers = ['ID', 'Name'];
                            break;
                        case 'attractions':
                            this.resourceName = '景點';
                            this.headers = [
                                'ID', 'Name', 'Description', 'Location_id', 'Category_id',
                                'Popularity', 'Seo', 'Address', 'Contact_info', 'Opening_hours',
                                'Ticket_price', 'Photo_url'
                            ];
                            break;
                    }
                    this.fetchResources();
                },
                async initializeData() {
                    try {
                        const [locations, categories] = await Promise.all([
                            this.fetchLocations(),
                            this.fetchCategories()
                        ]);
                        this.locations = locations;
                        this.categories = categories;
                        await this.fetchResources();
                    } catch (error) {
                        console.error('Error initializing data:', error);
                    }
                },
                async fetchResources() {
                    try {
                        const response = await fetch(`https://echolyc.com/final/api/api.php/${this.resource}`);
                        const data = await response.json();
                        this.items = data;
                    } catch (error) {
                        console.error('Error fetching resources:', error);
                    }
                },
                async fetchLocations() {
                    try {
                        const response = await fetch('https://echolyc.com/final/api/api.php/locations');
                        return await response.json();
                    } catch (error) {
                        console.error('Error fetching locations:', error);
                        return [];
                    }
                },
                async fetchCategories() {
                    try {
                        const response = await fetch('https://echolyc.com/final/api/api.php/categories');
                        return await response.json();
                    } catch (error) {
                        console.error('Error fetching categories:', error);
                        return [];
                    }
                },
                async submitResource() {
                    if (this.currentResource) {
                        await this.updateResource();
                    } else {
                        await this.addResource();
                    }
                },
                async addResource() {
                    try {
                        const response = await fetch(`https://echolyc.com/final/api/api.php/${this.resource}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(this.form)
                        });
                        await response.json();
                        await this.fetchResources();
                        this.resetForm();
                        $('#resourceModal').modal('hide');
                    } catch (error) {
                        console.error('Error adding resource:', error);
                    }
                },
                editResource(item) {
                    this.currentResource = item;
                    this.form = {
                        ...item,
                        seo: item.seo ? item.seo.split(' ') : []
                    };
                    this.modalTitle = `編輯 ${this.resourceName}`;
                    $('#resourceModal').modal('show');
                },
                async updateResource() {
                    try {
                        const response = await fetch(`https://echolyc.com/final/api/api.php/${this.resource}/${this.currentResource.id}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                ...this.form,
                                seo: this.form.seo.join(' ')
                            })
                        });
                        await response.json();
                        await this.fetchResources();
                        this.resetForm();
                        $('#resourceModal').modal('hide');
                    } catch (error) {
                        console.error('Error updating resource:', error);
                    }
                },
                async deleteResource(id) {
                    try {
                        const response = await fetch(`https://echolyc.com/final/api/api.php/${this.resource}/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json'
                            }
                        });
                        await response.json();
                        await this.fetchResources();
                    } catch (error) {
                        console.error('Error deleting resource:', error);
                    }
                },
                resetForm() {
                    this.form = {
                        seo: []
                    };
                    this.currentResource = null;
                    this.modalTitle = `新增 ${this.resourceName}`;
                },
                openModal() {
                    this.resetForm();
                    $('#resourceModal').modal('show');
                },
                addSEO() {
                    if (this.seoInput.trim() && !this.form.seo.includes(this.seoInput.trim())) {
                        this.form.seo.push(this.seoInput.trim());
                        this.seoInput = '';
                    }
                },
                removeSEO(index) {
                    this.form.seo.splice(index, 1);
                },
                truncate(text, length) {
                    if (!text) return '';
                    return text.length > length ? text.substring(0, length) + '...' : text;
                }
            }
        });

        app.mount('#app');
    </script>
</body>

</html>