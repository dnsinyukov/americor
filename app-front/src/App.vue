<script setup>
</script>

<template>
    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="https://americor.com/wp-content/uploads/2023/05/americor-logo.gif"
                 alt="" width="150">

            <h2>Test task</h2>
            <p class="lead">
                Creating a new client. <br>
                Changing information about an existing client. <br>
                Checking whether a loan can be issued. <br>
                Notify the client about loan disbursement (Email, SMS).
            </p>
        </div>

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <ul class="nav nav-pills nav-stacked">
                    <li role="presentation">
                        <RouterLink to="/">Clients</RouterLink>
                    </li>
                </ul>
            </div>
            <RouterView />
        </div>
    </div>
</template>

<style lang="css">
.router-link-active {
    color: #fff;
    background-color: #337ab7;
}
</style>