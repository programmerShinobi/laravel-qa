<template>
    <div class="spinner" :style="getMinWidth">
        <em class="fa-solid fa-spinner fa-spin" :class="sizeClass"></em>
    </div>
</template>

<style scoped>
.spinner {
    color: #ddd;
    text-align: center;
}

</style>

<script>
export default {
    props: {
        small: {
            type: Boolean,
            default: false
        },

        minWidth: {
            type: Number,
            default: 109.46
        }        
    },

    computed: {
        sizeClass () {
            return this.small ? '' : 'fa-5x'
        },

        getMinWidth () {
            return {
            minWidth: this.minWidth + 'px'
            }
        }
    }
}
</script>