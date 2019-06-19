<template>
    <vueper-slides :visible-slides="3"
                   slide-multiple
                   :slide-ratio="1/4"
                   :arrows-outside="false"
                   :bullets="false"
                   :fade="true"
                   autoplay>
        <i slot="arrowLeft" class="icon icon-chevron-left"></i>
        <i slot="arrowRight" class="icon icon-chevron-right"></i>

        <vueper-slide v-for="(img, i) in images"
                      :key="i"
                      :image="'/' + img"></vueper-slide>
    </vueper-slides>
</template>

<style>
    .vueperslides__arrow {
        background: #fff !important;
        width: 2em !important;
        height: 2em !important;
        border-radius: 100% !important;
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        opacity: 1 !important;
        font-size: 2rem !important;
    }
</style>

<script>
    export default {
        props: [
            'images'
        ],

        data() {
            return {
                breakpoints: {
                    1200: {
                        slideRatio: 1 / 5
                    },
                    900: {
                        slideRatio: 1 / 3
                    },
                    600: {
                        slideRatio: 1 / 2,
                        arrows: false,
                        bulletsOutside: true
                    },
                    // The order you list breakpoints does not matter, Vueper Slides will sort them for you.
                    1100: {
                        slideRatio: 1 / 4
                    }
                }
            }
        }
    }
</script>