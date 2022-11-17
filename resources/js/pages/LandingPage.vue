<template>
    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-4">Laravel Q/A</h1>
            <p class="lead">Welcome to Laravel Q/A</p>
            <hr class="my-4">
            <router-link :to="{ name: 'questions' }" class="btn btn-primary btn-lg">Go to questions page</router-link>
        </div>
    </div>
</template>