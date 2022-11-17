<template>
    <div class="preloader"  :style="getMinWidth">
        <div class="fa-beat-fade" :class="sizeClass">
            {{ 'Loading..' }}
        </div>
    </div>
</template>

<style scoped>
.preloader {
    color: rgb(0, 0, 0);
    text-align: center;
}


.preloader-primary {
  color: #007bff;
  border-color: #007bff;
}

.preloader-primary:hover {
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}

.preloader-primary:focus,
.preloader-primary.focus {
  -webkit-box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
          box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
}

.preloader-primary.disabled,
.preloader-primary:disabled {
  color: #007bff;
  background-color: transparent;
}

.preloader-primary:not(:disabled):not(.disabled):active,
.preloader-primary:not(:disabled):not(.disabled).active,
.show > .preloader-primary.dropdown-toggle {
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}

.preloader-primary:not(:disabled):not(.disabled):active:focus,
.preloader-primary:not(:disabled):not(.disabled).active:focus,
.show > .preloader-primary.dropdown-toggle:focus {
  -webkit-box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
          box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
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
        },        
    },

    computed: {
        sizeClass () {
            return this.small ? 'preloader-primary' : 'fa-1x '
        },

        getMinWidth () {
            return {
            minWidth: this.minWidth + 'px '
            }
        },
    }
}
</script>