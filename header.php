<div class="navbar navbar-light bg-light d-flex justify-content-between align-items-center">
    <a href="./index.php" class="navbar-brand d-flex align-items-center">
        <img src="./images/lyc_logo.png" alt="LOGO" height="100">
    </a>
    <div class="search-box d-flex align-items-center">
        <input type="text" class="form-control" placeholder="搜尋景點、地區或城市" v-model="query">
        <button class="btn btn-primary ml-2" @click="performSearch"><span class="bi bi-search"></span></button>
    </div>
</div>