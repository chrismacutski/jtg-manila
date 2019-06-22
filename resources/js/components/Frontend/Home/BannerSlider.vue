<template>
    <vueper-slides fade slide-content-outside="top" :touchable="false" :slide-ratio="0.3"
                   :fixed-height="fullheight"
                   :pauseOnHover="false"
                   :slide-content-outside="false"
                   autoplay>
        <i slot="arrowLeft" class="icon icon-chevron-left"></i>
        <i slot="arrowRight" class="icon icon-chevron-right"></i>

        <vueper-slide v-for="(img, i) in images"
                      :key="i"
                      v-lazy:background-image="img"
                      :style="'background-color: ' + ['#373a3e'][i % 2]">
            <div slot="slideContent">
                <div class="mouse2">
                    <a href="#" class="mouse-icon2">
                        <div class="mouse-wheel2"><i class="fa fa-chevron-circle-down"></i></div>
                    </a>
                </div>
            </div>
        </vueper-slide>
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

    .welcome-text {
        position: relative;
        z-index: 1;
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
                },

                fullheight: '0px'
            }
        },

        watch: {

        },

        computed: {

        },

        mounted() {
            this.fullheight = $(window).height() + 'px';
//            console.log($(window).height());
//            $(window).height()
            this.$nextTick(function() {
                window.addEventListener('resize', this.getWindowHeight);

                //Init
                this.getWindowHeight()
            })
        },

        methods: {
            getWindowHeight(event) {
                this.fullheight = $(window).height() + 'px';
            }
        }

    }
</script>